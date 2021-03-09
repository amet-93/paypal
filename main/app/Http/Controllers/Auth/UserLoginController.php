<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

//Class needed for login and Logout logic
use Illuminate\Foundation\Auth\AuthenticatesUsers;

//Auth facade
use Auth;
use App\Http\Requests;
use Session;
use Redirect;
use DB;
use URL;



class UserLoginController extends Controller
{

   protected $redirectTo = '/user_home';

   use AuthenticatesUsers;

    protected function guard()
    {
      return Auth::guard('user');
    }

    public function showLoginForm()
   {
       return view('User.login');
   }
   public function logout(){
     Session::forget('user');
     return redirect('/user/login');
   }
    public function login(Request $request)
   {
       if($request){
            $input = Input::all();
            $email = $input['email'];
            $password = $input['password'];
            $rememberme = !empty($input['check_remember'])?$input['check_remember']:'';
            $validator = \Validator::make(
                [
                    'email' => ''.$input['email'].'',
                    'password' => ''.$input['password'].''
                ],
                [
                    'email'  => 'required',
                    'password' => 'required|min:6'
                ]
            );
            if($validator->fails()){
                // $request->session()->flash('alert-danger', 'Please Check all the field.');
                return redirect('user/login')->withErrors($validator)->withInput();
            }else{
              $users = DB::table('client_users')->where('email_id', ''.$input['email'].'')->first();
              
              if(!empty($users)){
                if(password_verify($password,$users->password)){

                      $users = DB::table('client_users')
                          ->where('email_id', ''.$input['email'].'')
                          ->where('verified', 1)
                          ->first();
                      if(!empty($users)){
                          Session::put('user', $users);
                          $request->session()->flash('alert-success', 'User Logged in successfully.');
                          return redirect('/user/dashboard');
                      }else{
                        
                          $request->session()->flash('alert-danger', 'Check your credentials or check your email if not verified yet.');
                          return redirect('/user/login');
                      }
                  }else{
                     $request->session()->flash('alert-danger', 'Invalid email or password.');
                          return redirect('/user/login');
                  }
                }else{
                  $request->session()->flash('alert-danger', 'Your email does not exist!');
                          return redirect('/user/login');
                }

            }
        }
   }

  public function dashboard(){
    $user_data = Session::get('user');
    $user_id = $user_data->id;
    $client_data = $this->get_clients($user_id);
    $level_name = !empty($client_data[0]->level_name)?$client_data[0]->level_name:'';
    $level_data = DB::table('levels')->where('level_name',$level_name)->first();

    if(!empty($level_data)){
        $level_id_arr = array();
        for ($i=1; $i <= $level_data->id; $i++) { 
            $level_id_arr[] = $i;
        }
    
        $process_action_id = DB::table('level_features')->whereIn('level_id',$level_id_arr)->pluck('id')->toArray();
        $process_info_id = DB::table('certification_process_action')->whereIn('level_feature_id',$process_action_id)->pluck('id')->toArray();
        $process_info = $this->get_process_info_feature_data($user_id,$process_info_id);
        
    }else{
        $process_info = '';
    }
    if(empty($level_name)){
      $levels = DB::table('payment_details')
        ->where('user_id',$user_id)
        ->where('status',1)
        ->first();

      if(!empty($levels)){
        $level_action= $levels->product;
        $level_id_arr = array();
        for ($i=1; $i <= $levels->level; $i++) { 
            $level_id_arr[] = $i;
        }
        $features_data = DB::table('level_features')->whereIn('level_id',$level_id_arr)->get()->toArray();
        $level_features_arr= array();
        foreach ($features_data as $features_val) {
            $features_val->date = '';
            $features_val->complete_process = 'uncomplete';
           $level_features_arr[] = $features_val;
        }
        if(!empty($this->get_complete_level_feature($user_id,$level_id_arr))){
          $level_features_data = $this->get_complete_level_feature($user_id,$level_id_arr);
        }else{
          $level_features_data = $level_features_arr;
        }
      }else{
        $level_features_data = array();
        $level_action= '';
      }
    }else{
      $level_features_data = array();
      $level_action= '';
    }

    // $process_info = $this->get_process_info_data($user_id);
    // $process_info = $this->get_process_info_feature_data($user_id);
    $payment_data = DB::table('payment_details')
      ->where('user_id',$user_id)
      ->where('status',2)
      ->orderBy('id','DESC')
      ->first();
    $payment_log = get_payment_info($user_id);
    $payment_status = !empty($payment_data)?$payment_data->status:NULL;
    
    return view('User.user_dashboard',['client_data' => $client_data[0],'process_info' => $process_info,'payment_log'=>$payment_log,'payment_status'=>$payment_status, 'level_features' =>$level_features_data,'level_action' => $level_action]);
  }


    public function get_clients($id = null){
       $client_users_data = DB::table('client_users AS a')
            ->leftJoin('clients_info AS b', 'a.id', '=', 'b.primary_id')
            ->select('a.*', 'b.*')
            ->where('a.id',$id)
            ->where('a.verified', '1')
            ->orderBy('a.id', 'DESC')
            ->get();
        $client_users_arr = array();
        foreach ($client_users_data as $user_val) {
          $payment_data = DB::table('payment_details')
            ->where('user_id', $user_val->primary_id)
            ->where('status','2')
            ->orderBy('id', 'DESC')
            ->first();
          if(!empty($payment_data)){
            $level_data = DB::table('levels')->where('id',$payment_data->level)->first();
            $user_val->level_name = !empty($level_data)?$level_data->level_name:'';
          }
          $user_val->who_id     = !empty($process_info)?$process_info->id:''; 
          $user_val->who_action = !empty($process_info)?$process_info->who_action:''; 
          $user_val->where_action = !empty($process_info)?$process_info->where_action:''; 
          $user_val->date        = !empty($process_info)?$process_info->date:''; 
          $user_val->pay_id = !empty($payment_data)?$payment_data->id:'';
          $user_val->payer_id = !empty($payment_data)?$payment_data->payer_id:'';
          $user_val->paypal_payment_id = !empty($payment_data)?$payment_data->paypal_payment_id:'';
          $user_val->payer_email_id = !empty($payment_data)?$payment_data->payer_email_id:'';
          $user_val->amount = !empty($payment_data)?$payment_data->amount:'';
          $user_val->product = !empty($payment_data)?$payment_data->product:'';
          $user_val->name = !empty($payment_data)?$payment_data->name:'';
          $user_val->currency = !empty($payment_data)?$payment_data->currency:'';
          $client_users_arr[] = $user_val;
        }
        // die;
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
  public function get_process_info_feature_data($id,$process_info_id){
    // DB::enableQueryLog();
    $process_info = DB::table('certification_process_info')
    ->where('client_id',$id)
    ->whereIn('plan_id',$process_info_id)
    ->where('who_action','!=','NULL')
    ->where('where_action','!=','NULL')
    ->where('date','!=','NULL')
    ->get();
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
            ->leftJoin('certification_process_info AS b', 'a.id', '=', 'b.plan_id')
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
  public function get_complete_level_feature($id,$feature_id){
    // DB::enableQueryLog();
    $process_info = DB::table('process_info_log')
    ->where('client_id',$id)
    ->where('who_action','!=','NULL')
    ->where('where_action','!=','NULL')
    ->where('date','!=','NULL')
    ->get();
// $query = DB::getQueryLog();
    if(count($process_info) !=0){
      $plan_id = array();
      foreach ($process_info as $process_val) {
        $plan_id[] = $process_val->plan_id;
      }
      $action_name = DB::table('certification_process_action')
      ->whereIn('id',$plan_id)
      ->distinct()->get(['level_feature_id'])->toArray();

      $level_feature_id = array();
      // foreach ($action_name as $action_val) {
      //   $level_feature_id[] = $action_val->level_feature_id;
      // }
      
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
      $features_data =  DB::table('level_features')
      ->whereIn('level_id',$feature_id)
      ->get()->toArray();
      $level_feature_data = array();
      foreach ($features_data as $features_val) {
        if(in_array($features_val->id,$level_feature_id)){
          $features_val->complete_process = 'complete';
          $certification_allow_data = DB::table('certification_process_action AS a')
            ->leftJoin('process_info_log AS b', 'a.id', '=', 'b.plan_id')
            ->select('b.date')
            ->where('a.level_feature_id',$features_val->id)
            ->where('a.feature_award_allow','1')
            ->where('b.client_id',$id)
            ->first();

            $features_val->date = !empty($certification_allow_data)?$certification_allow_data->date:'';
        }else{
          $features_val->complete_process = 'uncomplete';
          $features_val->date = '';
        }
        $level_feature_data[] = $features_val;
      }
      return $level_feature_data;
    }
  }

   public function paymentlogin(Request $request)
   {
    
       if($request){
            $input = Input::all();
            $amount   = $input['amount'];
            $description  = $input['description'];
            $email = $input['email'];
            $password = $input['password'];
            $level = $input['level'];
            $rememberme = !empty($input['check_remember'])?$input['check_remember']:'';
            $validator = \Validator::make(
                [
                    'email' => ''.$input['email'].'',
                    'password' => ''.$input['password'].''
                ],
                [
                    'email'  => 'required',
                    'password' => 'required|min:6'
                ]
            );
            if($validator->fails()){
                return redirect('certification-levels')->withErrors($validator)->withInput();
            }else{
              $users = DB::table('client_users')->where('email_id', ''.$input['email'].'')->first();
              
              if(!empty($users)){
                if(password_verify($password,$users->password)){

                      $users = DB::table('client_users')
                          ->where('email_id', ''.$input['email'].'')
                          ->where('verified', 1)
                          ->first();
                      if(!empty($users)){
                          Session::put('user', $users);
                          $paymentdata = array('amount' => $amount, 'description' => $description, 'userid' => $users->id,'level_id' => $level);
                    Session::put('payment_detail', $paymentdata);
                          return redirect('paypalregister');
                      }else{
                          $request->session()->flash('alert-danger', 'Check your credentials or check your email if not verified yet.');
                          return redirect('certification-levels');
                      }
                  }else{
                         $request->session()->flash('already_register', 'yes');
                     $request->session()->flash('alert-danger', 'Invalid email or password.');
                         return redirect('certification-levels');
                  }
                }else{
                  $request->session()->flash('already_register', 'yes');
                  $request->session()->flash('alert-danger', 'Invalid email or password!');
                  return redirect('certification-levels');
                }

            }
        }
   }
}
