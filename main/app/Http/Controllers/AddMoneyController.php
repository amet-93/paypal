<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use DB;
/** All Paypal Details class **/
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
class AddMoneyController extends HomeController
{
    private $_api_context;
    public $amount='';
    public $description='';
    public $product='';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //parent::__construct();
	$this->middleware('auth',['except' => ['payWithPaypal','postPaymentWithpaypal','getPaymentStatus']]);
        /** setup PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    /**
     * Show the application paywith paypalpage.
     *
     * @return \Illuminate\Http\Response
     */
    public function payWithPaypal(Request $request)
    {
        $inputs = Input::all();
        $data = '';
        if(isset($inputs['data'])){
            $data = $inputs['data'];
        }
        return view('paypal.thankyou',['data'=>$data]);
    }
    /**
     * Store a details of payment with paypal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPaymentWithpaypal(Request $request)
    {
        $data = Session::get('payment_detail');
        $inputs = Input::all();
        if(isset($inputs['id'])){
			$data['userid'] = $inputs['id'];
			$data['amount'] = $inputs['amount'];
			$data['description'] = $inputs['description'];
            $data['level_id'] = $inputs['level']; 
		}
        $price = $data['amount'];
        $description = $data['description'];
        $userid = $data['userid'];
        $level_id = $data['level_id'];
        $data = Session::put('payment_id',$userid);
        $level_data = Session::put('level_id',$level_id);
        Session::forget('payment_detail');

        $this->amount=$price;
        $this->description=$description;
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName($description) /** item name **/
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($price); /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($price);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($description);
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('payment.status')) /** Specify return URL **/
            ->setCancelUrl(URL::route('payment.status'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
            /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error','Connection timeout');
                return Redirect::route('addmoney.paywithpaypal');
                /** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/
                /** $err_data = json_decode($ex->getData(), true); **/
                /** exit; **/
            } else {
                \Session::put('error','Some error occur, sorry for inconvenient');
                return Redirect::route('addmoney.paywithpaypal');
                /** die('Some error occur, sorry for inconvenient'); **/
            }
        }
        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if(isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        \Session::put('error','Unknown error occurred');
        return Redirect::route('addmoney.paywithpaypal');
    }
    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        //print_r(Input::get());
        //die;
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('error','Payment failed');
            return Redirect::route('addmoney.paywithpaypal');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary **/
        /** to execute a PayPal account payment. **/
        /** The payer_id is added to the request query parameters **/
        /** when the user is redirected from paypal back to your site **/
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        /** dd($result);exit; /** DEBUG RESULT, remove it later **/
        if ($result->getState() == 'approved') {
            $res_data = array('payer_id' => Input::get('PayerID'),
                            'paypal_payment_id' => Input::get('token'),
                            'payer_email_id' => $result->payer->payer_info->email,
                            'amount' => $result->transactions[0]->amount->total,
                            'product' => $result->transactions[0]->description,
                            'name' => $result->payer->payer_info->first_name.' '.$result->payer->payer_info->last_name,
                            'currency' => 'USD',
                            'responce_json' => serialize($result),
                            'user_id' => Session::get('payment_id'),
                            'level' => Session::get('level_id'),
                            'date' => date('Y-m-d H:i:s')
                            );
            $certification_status = array('certification_status' => '1');
            $primary_id = Session::get('payment_id');
            $send_data = array('payer_id' => Input::get('PayerID'),
                            'paypal_payment_id' => Input::get('token'),
                            'payer_email_id' => $result->payer->payer_info->email,
                            'amount' => $result->transactions[0]->amount->total,
                            'product' => $result->transactions[0]->description,
                            'name' => $result->payer->payer_info->first_name.' '.$result->payer->payer_info->last_name,
                            'currency' => 'USD'
                            );
            DB::table('payment_details')->insert($res_data);
            DB::table('clients_info')->where('primary_id',$primary_id)->update($certification_status);
             // DB::table('process_info_log')->where('client_id', $primary_id)->delete();
            
            /** it's all right **/
            /** Here Write your database logic like that insert record or value in database if you want **/
            \Session::put('success','Payment success');
            return Redirect::route('addmoney.paywithpaypal',['data' => $send_data]);
        }
        \Session::put('error','Payment failed');
        return Redirect::route('addmoney.paywithpaypal');
    }
  }
  ?>