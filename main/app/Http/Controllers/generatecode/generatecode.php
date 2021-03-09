<?php

namespace App\Http\Controllers\generatecode;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Mail\VerifyMail;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Mail\Mailer;
use Mail;
use Session;
use Redirect;
use DB;
use URL;

class generatecode extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('AuthenticateUser');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function verify_user()
    {
      $user_id = Session::get('user');
      if(!empty($user_id)){
        $users_data =  DB::table('client_users AS a')
            ->leftJoin('clients_info AS b', 'a.id', '=', 'b.primary_id')
            ->select('a.*', 'b.*')
            ->where('a.id',$user_id->id)
            ->where('a.verified', '1')
            ->orderBy('a.id', 'DESC')
            ->get()->toArray();
         $verify = DB::table('payment_details')
            ->where('user_id', $user_id->id)
            ->where('status','2')
            ->orderBy('id', 'DESC')
            ->first();
  
        if(!empty($users_data) && ($users_data[0]->certification_status == 2 || !empty($verify))){
          $users = $users_data[0];
          $current_date = date('Y-m-d');

          $expire_date = date('Y-m-d',strtotime($users->certification_date));
          $renew_date = date('Y-m-d',strtotime($users->certification_renewal_date ));
          
          if(!empty($users->certification_date) && (($current_date >= $expire_date) && ($current_date <= $renew_date))){
           
            if(!empty($verify)){
                 $client_id = $users->client_id;
                 $mixed_client_key= substr(uniqid('', true), -4).$client_id.substr(uniqid('', true), -4);
                 $data = array('users_key'=>$client_id, 'mixed'=>$mixed_client_key, 'plan_name'=>'SILVER LEVEL', 'plan_id'=> 1, 'data'=>'');
                 return view('cart_share.create',$data);
            } else {
                 return view('cart_share.create',['data'=>'Please purchase one of the available plans prior to generating a code for an BCC seal']);
            }
          }else{
            return view('cart_share.create',['data'=>'Please purchase one of the available plans prior to generating a code for an BCC seal']);
          }
        }else{
          return view('cart_share.create',['data'=>'Please purchase one of the available plans prior to generating a code for an BCC seal']);
        }
      }else{
        return redirect('user/login');
      }
    }

  public function authdetail($id){
    $client_id = substr($id, 4, -4);
    $result = DB::table('client_users')->where('client_id',$client_id)->first();
    $company_data = DB::table('clients_info')->where('primary_id',$result->id)->first();
    return view('cart_share.user_level_details_html');
  }
  public function showdetail($id){
    $client_id = substr($id, 4, -4);
    $result = DB::table('client_users')->where('client_id',$client_id)->first();
    $company_data = DB::table('clients_info')->where('primary_id',$result->id)->first();
    
    
    // $level_data = DB::table('payment_details')->where('user_id',$result->id)->first();
    $level_data =  DB::table('payment_details')
            ->where('user_id', $result->id)
            ->where('status','2')
            ->orderBy('id', 'DESC')
            ->first();
    $disclaimer_data = DB::table('disclaimer')->where('client_id',$client_id)->first();
    $image_name = $level_data->product;
    $image_file = explode(' ',  $image_name);
    $current_date = date('Y-m-d');
    $expire_date = date('Y-m-d',strtotime($company_data->certification_date));
    $renew_date = date('Y-m-d',strtotime($company_data->certification_renewal_date ));
    if($current_date > $renew_date){
      if($_SERVER['SERVER_NAME'] == 'localhost'){
        $path = URL::to('/').'/images/cert_img/certification-expire.jpeg';
      }else{
        $path = 'https://'.$_SERVER['SERVER_NAME'].'/images/cert_img/certification-expire.jpeg';
      }
      $cert_type = 'expired';
      $expired_date =  date('M d Y H:i:s',strtotime($company_data->certification_renewal_date ));
    }else{
      if($_SERVER['SERVER_NAME'] == 'localhost'){
        $path = URL::to('/').'/images/cert_img/certifications_'.strtolower($image_file[0]).'.jpg';
      }else{
        $path = 'https://'.$_SERVER['SERVER_NAME'].'/images/cert_img/certifications_'.strtolower($image_file[0]).'.jpg';
      }
      $cert_type = 'earned';
      $expired_date =  '';
    }
    $color = strtolower($image_file[0]);
    if($color == 'bronze'){
      $color_code = '#EACAAB';
    }else if($color == 'gold'){
      $color_code = '#D4AF37';
    }else if($color == 'platinum'){
      // $color_code = '#008000';
      $color_code = '#E5E4E2';
    }else{
      $color_code = '#C0C0C0';
    }
    $levels = DB::table('levels')->where('id',$level_data->level)->first();
    // $levels = DB::table('levels')->where('level_name',strtolower($image_file[0]))->first();
    if(!empty($levels)){
      $total_level = $levels->id+1;
      $level_id_arr = array();
      for($i=1; $i < $total_level; $i++){
        $level_id_arr[] = $i;
      }
      $certification_feature = DB::table('level_features')->whereIn('level_id',$level_id_arr)->get()->toArray();
      $process_action_id = DB::table('level_features')->whereIn('level_id',$level_id_arr)->pluck('id')->toArray();
      $process_info_id = DB::table('certification_process_action')->whereIn('level_feature_id',$process_action_id)->pluck('level_feature_id')->toArray();
  
      $level_feature_data = get_process_level_feature_data($result->id,$process_info_id);
     //  dd( $level_feature_data );
    }else{
        $level_feature_data = '';
    }
    $payment_status = !empty($level_data)?$level_data->status:NULL;
    // $level_feature_data = get_process_level_feature_data($result->id);
    // print_r($level_feature_data);die();
    return view('cart_share.user_level_details',['user_level' => $result,'company_data' => $company_data,'image_file' => $path,'level_color' => $color_code,'certification_feature' => $certification_feature, 'level_name' => $color,'disclaimer_data' =>$disclaimer_data,'level_feature_data' => $level_feature_data,'payment_status' => $payment_status,'cert_type' => $cert_type,'expired_date' => $expired_date]);
  }
  public function create_disclaimer($id){
    $client_id = substr($id, 4, -4);
    $address = $_REQUEST['referrer'];
    if($_SERVER['SERVER_NAME'] == $_REQUEST['referrer']){
      return $this->showdetail($id);
    }else{
      $ipaddress = $this->get_client_ip();
      $this->visit_disclaimer($client_id,$address,$ipaddress);
      $user_data = DB::table('clients_info')->where('client_id',$client_id)->first();
      return view('cart_share.disclaimer',['user_data' => $user_data]);
    }
  }
  public function save_disclaimer(Request $request){
    if($request){
      $input = $request->all();
      $url = $input['url'];
      $ip_address = $this->get_client_ip();
      
      $result_data = $this->get_disclaimer($input['client_id'],$url,$ip_address);
      if(empty($result_data)){
        $data = array(
          'client_id' => $input['client_id'],
          'url' => $url,
          'ip_address' => $ip_address
        );
        $save_data = DB::table('disclaimer')->insert($data);
        $response = true;
      }else{
        $data = array(
          'client_id' => $input['client_id'],
          'url' => $url,
          'ip_address' => $ip_address,
          'status' => '2'
        );
        $save_data = DB::table('disclaimer')->where('id',$result_data->id)->update($data);
        $response = true;
      }
      if($response == true){
        return redirect('user/certification-detail/'.$input['id']);
        // return $this->showdetail($input['id']);
      }
    }
  }
  
  public function visit_disclaimer($client_id,$url,$ip){
    $result = $this->get_disclaimer($client_id,$url,$ip);
    $data = array(
      'client_id' => $client_id,
      'url' => $url,
      'ip_address' => $ip
    );
    if(empty($result)){
      $save = DB::table('disclaimer')->insert($data);
      return $save;
    }
  }
  public function get_disclaimer($client_id,$url,$ip){
    $result = DB::table('disclaimer')
    ->where('client_id',$client_id)
    ->where('url',$url)
    ->where('ip_address',$ip)
    ->where('status','1')
    ->first();
    return $result;
  }

  function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }

}
