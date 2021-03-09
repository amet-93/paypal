<?php

namespace App\Http\Controllers;

use App\clients;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Session;
use Redirect;
use DB;

class ClientsController extends Controller
{
    # Private key
    public static $salt = 'Lu70K$i3pu5xf7*I8tNmd@x2oODwwDRr4&xjuyTh';

    public function __construct(){
        $this->modal = new clients();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client_data = $this->get_clients();
        return \View::make('clients.clients_list')->with(array('client_data' => $client_data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $level_data = DB::table('levels')->get();
        $data = array('level_data' => $level_data);
        return \View::make('clients.add_client')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request){
            $inputs = Input::all();
            $first_name                     = $inputs['first_name'];
            $last_name                      = $inputs['last_name'];
            $password                       = $inputs['password'];
            $email_provider                 = $inputs['email_provider'];
            $email_id                       = $inputs['email_id'];
            $email_notes                    = $inputs['email_notes'];
            $company_name                   = $inputs['company_name'];
            // $certification_level            = $inputs['certification_level'];
            $certification_date             = date('Y-m-d H:i:s');
            // $certification_renewal_date     = date("Y-m-d H:i:s", strtotime("+1 year", strtotime($certification_date)));
            // $terms_of_use_acceptance_date   = $inputs['terms_of_use_acceptance_date'];
            // $privacy_policy_acceptance_date = $inputs['privacy_policy_acceptance_date'];
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $company = str_replace(' ','',$inputs['company_name']);
            $client_id = md5($company.strtotime(date('H:i')));
            $time = strtotime(date('Y-m-d H:i:s'));
            $password_expiration = date("Y-m-d H:i:s", strtotime("+1 month", $time));
            
            // $client_id = $this->generatePassword('8',''.strtotime(date('H:i')).'',$company);
           $validator = \Validator::make(
                [
                    'first_name'                     => $first_name,
                    'last_name'                      => $last_name,
                    'password'                       => $password,
                    'email_provider'                 => $email_provider,
                    'email_id'                       => $email_id,
                    'company_name'                   => $company_name
                ],
                [
                    'first_name'                     => 'required',
                    'last_name'                      => 'required',
                    'password'                       => 'required|min:8',
                    'email_provider'                 => 'required',
                    'email_id'                       => 'required|email|unique:client_users',
                    'company_name'                   => 'required'
                ]
            );
            if($validator->fails()){
                return redirect('admin/addClients')->withErrors($validator)->withInput();
            }else{
                $data = array(
                    'first_name'          => $first_name,
                    'last_name'           => $last_name,
                    'password'            => $password_hash,
                    'password_expiration' => $password_expiration,
                    'client_id'           => $client_id,
                    'email_provider'      => $email_provider,
                    'email_id'            => $email_id,
                    'email_notes'         => $email_notes,
                    'verified'            => 1
                );
                $userdata = \DB::table('client_users')->insert($data);
                $last_insert_id = \DB::getPdo()->lastInsertId();
                if($last_insert_id){
                    $client_users_data = DB::table('client_users')->where('id', $last_insert_id)->first();
                    $key_id = $this->generatePassword('32',''.strtotime(date('H:i')).'',$company);
                    $guid = $this->generatePassword('32',''.strtotime(date('H:i')).'',$company);
                    $company_data = array(
                        'company_name'        => $company_name,
                        'primary_id'          => $last_insert_id,
                        'client_id'           => $client_users_data->client_id,
                        'keyid'               => $key_id,
                        'guid'                => $guid,
                        // 'certification_level' => $certification_level,
                        'certification_date'  => $certification_date
                        // 'certification_renewal_date'     => $certification_renewal_date,
                        // 'terms_of_use_acceptance_date'   => $terms_of_use_acceptance_date,
                        // 'privacy_policy_acceptance_date' => $privacy_policy_acceptance_date
                    );

                    $userdata1 = \DB::table('clients_info')->insert($company_data);
                    if($userdata1 == true){
                        $request->session()->flash('alert-success', 'Client Registeration Successfully.');
                        return redirect('/admin/addClients');
                    }
                }
            
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function show(clients $clients, $id)
    {
        // $ip_info = $this->modal->get_ip_data($id);
        $client_data = $this->get_clients($id);
        $process_info = $this->get_process_info_data($id);
        return view('clients.certification_details',['client_data' => $client_data[0],'process_info' => $process_info]);
    }

    public function showUserDetails(clients $clients, $id)
    {
        // $ip_info = $this->modal->get_ip_data($id);
        $client_data = $this->get_clients($id);
        $process_info = $this->get_process_info_data($id);
        // dd($client_data);
        // return view('clients.certification_details',['client_data' => $client_data[0],'process_info' => $process_info]);
        return view('clients.certification_user_details',['client_data' => $client_data[0],'process_info' => $process_info]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function edit(clients $clients, $id)
    {
        
        // $publicKey = $this->genRandString(32);
        // $encryptedData = $this->encrypt('5ff0ea5e91863724b56fde65020239a8c822347285fa088642b8f1984af96c05��⤚Χ��C񇻨ݶ\���ۑ[�VF 5F)', $publicKey);
        // $decryptedData = $this->decrypt($encryptedData, $publicKey);
        // echo $encryptedData;
        // echo $decryptedData;
        // die;
        $payment_data = DB::table('payment_details')
            ->where('user_id',$id)
            ->where('status',2)
            ->orderby('id','DESC')
            ->first();
        $payment_id = !empty($payment_data)?$payment_data->id:'';
        $client_info_data = $this->get_clients($id);
        $user_client_data = $this->get_clients($id,$payment_id);

        $level_name = !empty($client_info_data[0]->level_name)?$client_info_data[0]->level_name:'';
        $level_data = DB::table('levels')->where('level_name',$level_name)->first();

        if(!empty($level_data)){
            $level_id_arr = array();
            for ($i=1; $i <= $level_data->id; $i++) { 
                $level_id_arr[] = $i;
            }
            $process_action_id = DB::table('level_features')->whereIn('level_id',$level_id_arr)->pluck('id')->toArray();
            $process_info_id = DB::table('certification_process_action')->whereIn('level_feature_id',$process_action_id)->pluck('level_feature_id')->toArray();

            // $process_info = $this->get_process_info_feature_data($id,$process_info_id,'process_info_log');
            // $process_log_info = $this->get_process_info_feature_data($id,$process_info_id,'certification_process_info');

            $process_info = $this->get_process_info_feature_data($id,$process_info_id,'certification_process_info');
            $process_log_info = $this->get_process_info_feature_data($id,$process_info_id,'certification_process_info');
        }else{
            $process_info = '';
            $process_log_info = '';
        }
        // print_r($process_info); die;
        $process_info_status = !empty($process_log_info)?'1':'2';
        $payment_log = get_payment_info($id);
        $payment_status = !empty($payment_data)?$payment_data->status:NULL;
        $data = array('level_data' => $level_data,'clients_data' => $client_info_data[0],'awarded_user' => $user_client_data[0],'process_info' => $process_info,'process_info_status' => $process_info_status,'payment_log'=> $payment_log,'payment_status' => $payment_status);
        return \View::make('clients.editClient')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, clients $clients,$id)
    {
        if($request){
            $inputs = Input::all();
            $first_name                     = $inputs['first_name'];
            $last_name                      = $inputs['last_name'];

            // $email_provider                 = $inputs['email_provider'];
            // $email_id                       = $inputs['email_id'];
            // $email_notes                    = $inputs['email_notes'];
            $company_name                      = $inputs['company_name'];
            // $certification_date             = $inputs['certification_date'];
            $certification_award_date     = array_key_exists('certification_status',$inputs)?date("Y-m-d H:i:s"):NULL;
            $certification_renewal_date     = array_key_exists('certification_status',$inputs)?date("Y-m-d H:i:s", strtotime("+1 years",  strtotime(date('Y-m-d H:i:s')))):NULL;

            // $terms_of_use_acceptance_date   = $inputs['terms_of_use_acceptance_date'];
            // $privacy_policy_acceptance_date = $inputs['privacy_policy_acceptance_date'];
            
            if(array_key_exists("password",$inputs)){
                $password = $inputs['password'];
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
                $validator = \Validator::make(
                    [
                        'first_name'                     => $first_name,
                        'last_name'                      => $last_name,
                        'password'                       => $password,
                        'company_name'                   => $company_name
                    ],
                    [
                        'first_name'                     => 'required',
                        'last_name'                      => 'required',
                        'password'                       => 'required|min:8',
                        'company_name'                   => 'required'
                    ]
                );
                 $data = array(
                    'first_name'          => $first_name,
                    'last_name'           => $last_name,
                    'password'            => $password_hash
                );
            }else{
                $validator = \Validator::make(
                    [
                        'first_name'                     => $first_name,
                        'last_name'                      => $last_name,
                        'company_name'                   => $company_name
                    ],
                    [
                        'first_name'                     => 'required',
                        'last_name'                      => 'required',
                        'company_name'                   => 'required'
                    ]
                );
                $data = array(
                    'first_name'          => $first_name,
                    'last_name'           => $last_name
                );
            }
            
            if($validator->fails()){
                return redirect('/admin/editClient/'.$id)->withErrors($validator)->withInput();
            }else{
                $payment_res = \DB::table('payment_details')->where(array('user_id' =>$id,'status' => '1'))->orderby('id','DESC')->first();
                $process_log_id = \DB::table('process_info_log')->where('client_id',$id)->get()->toArray();
                
                $userdata = \DB::table('client_users')->where('id', $id)->update($data);
                $client_status_data = \DB::table('clients_info')->where('primary_id', $id)->first();
                $certification_status = $client_status_data->certification_status;
                if(array_key_exists('certification_status',$inputs) && $inputs['certification_status'] == 2){
                    $certification_level = '2';
                    $payment_status = '2';
                }else if(!array_key_exists('certification_status',$inputs) && ($certification_status == 2 || $certification_status == 1)){
                    $certification_level = '1';
                    $payment_status = '1';
                }else{
                   $certification_level = NULL; 
                   $payment_status = NULL;
                }
                
                // $certification_level = array_key_exists('certification_status',$inputs)?$inputs['certification_status']:NULL;
                $award_date = $client_status_data->certification_award_date;
                $renewal_date = $client_status_data->certification_renewal_date;
                $start_date = !empty($payment_res)?$payment_res->date:NULL;
                $payment_stats = array_key_exists('payment_stats', $inputs)?$inputs['payment_stats']:NULL;

                $certificate_award_date = ((array_key_exists('certification_status',$inputs) || !array_key_exists('certification_status',$inputs)) && $award_date != NULL)?$award_date:$certification_award_date;
                $certificate_renewal_date = ((array_key_exists('certification_status',$inputs) || !array_key_exists('certification_status',$inputs)) && $renewal_date != NULL)?$renewal_date:$certification_renewal_date;
                $certificate_start_date = (array_key_exists('certification_status',$inputs) && $start_date != NULL && $payment_stats == 2)?$start_date:$client_status_data->certification_date;
                if($payment_stats == 2){
                    $certificate_awarded_date = $certification_award_date;
                    $certificate_renewed_date = $certification_renewal_date;
                }else{
                    $certificate_awarded_date = $certificate_award_date;
                    $certificate_renewed_date = $certificate_renewal_date;
                }
                
                $info_data = DB::table('certification_process_info')->where('client_id',$id)->get()->toArray();
                // echo $certification_renewal_date;die;
                $company_data = array(
                    'company_name'        => $company_name,
                    'certification_date'  => $certificate_start_date,
                    'certification_award_date' => $certificate_awarded_date,
                    'certification_renewal_date'     => $certificate_renewed_date
                );
               
                if($certification_level != NULL){
                    $company_data['certification_status'] = $certification_level;
                }
               
                $userdata1 = \DB::table('clients_info')->where('primary_id',$id)->update($company_data);
                
                if($payment_status != NULL && !empty($payment_res)){
                    DB::table('payment_details')->where('id',$payment_res->id)->update(array('status' => $payment_status));
                    // DB::table('process_info_log')->where('id',$process_log_id)->update(array('status' => $payment_status));
                }
                if(!empty($process_log_id) && array_key_exists('certification_status',$inputs)){
                    if(empty($info_data)){
                        foreach ($process_log_id as $process_val) {
                            $process_arr = array(
                                'client_id'     => $process_val->client_id,
                                'plan_id'       => $process_val->plan_id,
                                'who_action'    => $process_val->who_action,
                                'where_action'  => $process_val->where_action,
                                'notes'         => $process_val->notes,
                                'date'          => $process_val->date
                            );
                            DB::table('certification_process_info')->insert($process_arr);
                        } 
                    }else{
                        foreach ($info_data as $key => $info_val) {
                            $process_arr = array(
                                'who_action'    => $process_log_id[$key]->who_action,
                                'where_action'  => $process_log_id[$key]->where_action,
                                'notes'         => $process_log_id[$key]->notes,
                                'date'          => $process_log_id[$key]->date
                            );
                            DB::table('certification_process_info')->where('id',$info_val->id)->update($process_arr);
                            $key++;
                        }
                    }
                    // DB::table('process_info_log')->truncate();
                }
                
                
                $request->session()->flash('alert-success', 'Client details has been updated successfully.');
                return redirect('/admin/editClient/'.$id);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,clients $clients)
    {
        $input = $request->all();
        $id = $input['id'];
        if(!empty($id)){
            $client_info = \DB::table('clients_info')->where('primary_id',$id)->delete();
            if($client_info == true){
                $client = \DB::table('client_users')->where('id', $id)->delete(); 
                echo json_encode(array('success' => true,'message' => 'Client details has been deleted successfully'));die;
                // return redirect('admin/Clients'); 
            }
                       
        }
        
    }

    public function get_clients($id = null,$payment_id=null){
        if(!empty($id)){
            $client_users_data = DB::table('client_users AS a')
            ->leftJoin('clients_info AS b', 'a.id', '=', 'b.primary_id')
            ->select('a.*', 'b.*')
            ->where('a.id',$id)
            ->orderBy('a.id', 'DESC')
            ->get();
        }else{
            $client_users_data = DB::table('client_users AS a')
            ->leftJoin('clients_info AS b', 'a.id', '=', 'b.primary_id')
            ->select('a.*', 'b.*')
            ->orderBy('a.id', 'DESC')
            ->get();
        }

        $client_users_arr = array();
        $i = 0;
        foreach ($client_users_data as $key => $user_val) {
            if(!empty($payment_id)){
                $payment_data = DB::table('payment_details')
                ->where('id',$payment_id)
                ->where('user_id', $user_val->primary_id)
                ->orderBy('id', 'DESC')
                ->first();
            }else{
                $payment_data = DB::table('payment_details')
                ->where('user_id', $user_val->primary_id)
                ->orderBy('id', 'DESC')
                ->first();
            }

            if(!empty($payment_data)){
                $level_data = DB::table('levels')->where('id',$payment_data->level)->first();
                $user_val->level_name = !empty($level_data)?$level_data->level_name:'';
            }
            $user_val->pay_id = !empty($payment_data)?$payment_data->id:'';
            $user_val->payer_id = !empty($payment_data)?$payment_data->payer_id:'';
            $user_val->paypal_payment_id = !empty($payment_data)?$payment_data->paypal_payment_id:'';
            $user_val->payer_email_id = !empty($payment_data)?$payment_data->payer_email_id:'';
            $user_val->amount = !empty($payment_data)?$payment_data->amount:'';
            $user_val->product = !empty($payment_data)?$payment_data->product:'';
            $user_val->name = !empty($payment_data)?$payment_data->name:'';
            $user_val->currency = !empty($payment_data)?$payment_data->currency:'';
            $user_val->create_date = !empty($payment_data)?$payment_data->date:'';
            $user_val->payment_status = !empty($payment_data)?$payment_data->status:'';
            $client_users_arr[] = $user_val;
        }
        // print_r($client_users_arr);die();
        return $client_users_arr;
    }

    public function get_process_info_data($id){
        $process_info = DB::table('certification_process_info')->where('client_id',$id)->get();
        if(count($process_info) !=0){
            $process_info1 = array();
            foreach ($process_info as $val) {
                $action_name = DB::table('certification_process_action')->where('id',$val->plan_id)->first();
                $val->action_name = !empty($action_name)?$action_name->certification_process:'';
                $process_info1[] = $val;
            }
            return $process_info1;
        }
        
    }
    public function get_process_info_feature_data($id,$process_info_id,$table_name){
        // DB::enableQueryLog();
        $process_info = DB::table($table_name)
        ->where('client_id',$id)
        ->whereIn('plan_id',$process_info_id)
        ->where('who_action','!=',NULL)
        ->where('where_action','!=',NULL)
        ->where('date','!=',NULL)
        ->get();
        // print_r($process_info); die;
        // $query = DB::getQueryLog();
        if(count($process_info) !=0){
            $plan_id = array();
            foreach ($process_info as $process_val) {
                $plan_id[] = $process_val->plan_id;
            }

            if(count($plan_id) == count($process_info_id)){
                $action_name = DB::table('certification_process_action')
                    ->whereIn('id',$plan_id)
                    ->distinct()->get(['level_feature_id'])->toArray();

                $level_feature_id = array();      
                foreach ($action_name as $action_val) {
                    $feature_process_action = DB::table('certification_process_action')
                    ->where('level_feature_id',$action_val->level_feature_id)
                    ->get()->toArray();
                    $total_level = array();
                    foreach ($process_info as $key => $level) {
                        $level_data = DB::table('certification_process_action')
                        ->where('id',$level->plan_id)
                        ->where('level_feature_id',$action_val->level_feature_id)
                        ->first();
                        if(!empty($level_data)){
                            $total_level[] = $level_data;
                        }
                      
                    }

                    if(count($feature_process_action) == count($total_level)){
                        $level_feature_id[] = $action_val->level_feature_id;
                    }

                }
                $level_feature_res =  DB::table('level_features')
                    ->whereIn('id',$level_feature_id)
                    ->get()->toArray();
                foreach ($level_feature_res as $level_feature_val) {
                   $certification_allow_data = DB::table('certification_process_action AS a')
                    ->leftJoin(''.$table_name.' AS b', 'a.id', '=', 'b.plan_id')
                    ->select('b.date')
                    ->where('a.level_feature_id',$level_feature_val->id)
                    ->where('a.feature_award_allow', '1')
                    ->where('b.client_id',$id)
                    ->first();
                    $level_feature_val->certification_process_date = !empty($certification_allow_data)?$certification_allow_data->date:'';
                    $level_feature_data[] = $level_feature_val;
                }
                $sort = array();
                foreach ($level_feature_data as $key => $feature_val) {
                   $sort[$key] = strtotime($feature_val->certification_process_date);
                }
                array_multisort($sort, SORT_ASC, $level_feature_data);
                return $level_feature_data;
            }
        }
    }

    public function get_ip_data(Request $request, clients $clients, $id){
        $number_of_page = $request->input('draw');
        $length = $request->input('length');
        $start = $request->input('start');
        $order_by = $request->input('order')[0]['dir'];
        $search_val = $request->input('search')['value'];
        $ip_info = $this->modal->get_ip_data($id,$order_by,$length,$start,$search_val);
        if(empty($search_val)){
            $total = $this->modal->get_ip_data($id,$order_by); 
        }else{
            $total = $ip_info;
        }
        
        $data = array(
            "draw"=> $number_of_page,
            "recordsTotal" => count($total),
            "recordsFiltered" => count($total),
            'data'=> $ip_info
        );

        // SQL server connection information
        echo json_encode($data);
    }

    # Encrypt a value using AES-256.
    public static function encrypt($plain, $key, $hmacSalt = null) {
        self::_checkKey($key, 'encrypt()');
 
        if ($hmacSalt === null) {
            $hmacSalt = self::$salt;
        }
 
        $key = substr(hash('sha256', $key . $hmacSalt), 0, 32); # Generate the encryption and hmac key
 
        $algorithm = MCRYPT_RIJNDAEL_128; # encryption algorithm
        $cipher="AES-128-CBC";
        $mode = MCRYPT_MODE_CBC; # encryption mode
        $ivSize = openssl_cipher_iv_length($cipher); # Returns the size of the IV belonging to a specific cipher/mode combination
        // $ivSize = mcrypt_get_iv_size($algorithm, $mode); # Returns the size of the IV belonging to a specific cipher/mode combination
        $iv = mcrypt_create_iv($ivSize, MCRYPT_DEV_URANDOM); # Creates an initialization vector (IV) from a random source

        $ciphertext = $iv . openssl_encrypt($algorithm, $key, $mode); # Encrypts plaintext with given parameters
        // $ciphertext = $iv . mcrypt_encrypt($algorithm, $key, $plain, $mode, $iv); # Encrypts plaintext with given parameters
        $hmac = hash_hmac('sha256', $ciphertext, $key); # Generate a keyed hash value using the HMAC method
        return $hmac . $ciphertext;
    }
    # Check key
    protected static function _checkKey($key, $method) {
        if (strlen($key) < 32) {
            echo "Invalid public key $key, key must be at least 256 bits (32 bytes) long."; die();
        }
    }

    # Decrypt a value using AES-256.
    public static function decrypt($cipher, $key, $hmacSalt = null) {
        self::_checkKey($key, 'decrypt()');
        if (empty($cipher)) {
            echo 'The data to decrypt cannot be empty.'; die();
        }
        if ($hmacSalt === null) {
            $hmacSalt = self::$salt;
        }
 
        $key = substr(hash('sha256', $key . $hmacSalt), 0, 32); # Generate the encryption and hmac key.
 
        # Split out hmac for comparison
        $macSize = 64;
        $hmac = substr($cipher, 0, $macSize);
        $cipher = substr($cipher, $macSize);
 
        $compareHmac = hash_hmac('sha256', $cipher, $key);
        if ($hmac !== $compareHmac) {
            return false;
        }
 
        $algorithm = MCRYPT_RIJNDAEL_128; # encryption algorithm
        $mode = MCRYPT_MODE_CBC; # encryption mode
        $ivSize = mcrypt_get_iv_size($algorithm, $mode); # Returns the size of the IV belonging to a specific cipher/mode combination
 
        $iv = substr($cipher, 0, $ivSize);
        $cipher = substr($cipher, $ivSize);
        $plain = mcrypt_decrypt($algorithm, $key, $cipher, $mode, $iv);
        return rtrim($plain, "\0");
    }

    #Get Random String - Usefull for public key
    public function genRandString($length = 0) {
        $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $str = '';
        $count = strlen($charset);
        while ($length-- > 0) {
            $str .= $charset[mt_rand(0, $count-1)];
        }
        return $str;
    }

    public  function generatePassword($length,$consonants,$vowels){
        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) 
        {
            if ($alt == 1) 
            {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } 
            else 
            {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }
}
