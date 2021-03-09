<?php

namespace App\Http\Controllers;

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
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('User.register');
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
            $inputs = $request->all();
            $first_name             = $inputs['first_name'];
            $last_name              = $inputs['last_name'];
            $password               = $inputs['user_password'];
            $email_id               = $inputs['email'];
            $confirm_user_password  = $inputs['confirm_user_password'];
            $company_name           = $inputs['company_name'];
            $password_hash = password_hash($password ,PASSWORD_BCRYPT );
            $company = str_replace(' ','',$inputs['company_name']);
            $client_id = md5($company.strtotime(date('H:i')));
            $time = strtotime(date('Y-m-d H:i:s'));
            $password_expiration = date("Y-m-d H:i:s", strtotime("+1 month", $time));
            $validator = \Validator::make(
                [
                    'first_name'                     => $first_name,
                    'last_name'                      => $last_name,
                    'password'                       => $password,
                    'email_id'                       => $email_id,
                    'company_name'                   => $company_name
                    //'confirm_user_password'          => $confirm_user_password
                ],
                [
                    'first_name'                     => 'required',
                    'last_name'                      => 'required',
                    'password'                       => 'required|min:8',
                    'email_id'                       => 'required|email|unique:client_users',
                    'company_name'                   => 'required'
                    //'confirm_user_password'          => 'required|min:8',
                ]
            );
            if($validator->fails()){
                return redirect('user/register')->withErrors($validator)->withInput();
            }else{
                $email_data = DB::table('client_users')->where('email_id', md5($email_id))->first();
                if(empty($email_data)){
                    $data = array(
                        'first_name'          => $first_name,
                        'last_name'           => $last_name,
                        'password'            => $password_hash,
                        'password_expiration' => $password_expiration,
                        'client_id'           => $client_id,
                        'email_id'            => $email_id,
                    );
                   
                    $client_users = \DB::table('client_users')->insert($data);
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
                            'certification_date'  => date('Y-m-d H:i:s')
                        );

                        $userdata1 = \DB::table('clients_info')->insert($company_data);
                        if($userdata1 == true){
                        
                        $verifyUser_data = array(
                             'user_id'       =>$last_insert_id,
                            'token'          => str_random(40)
                          );   
                          $url = URL::to('/').'/user/verify/'.$verifyUser_data['token'];
                          $content = $url;
                           $data_text = array('name'=>$first_name,'content'=>$content);
                           $email = $email_id;
                           $first_name = $first_name;
                           
                              // Mail::send(['html'=>'Mail.mail'], $data_text,function($message) use ($email,$first_name,$url) {
                              //    $message->to( $email, $first_name )->subject
                              //       ('Profile Activation Email');
                              //    $message->from('avinashmishra.vll@gmail.com','BCC');
                              // });
                            $user_name = $first_name;
                            $to = $email_id;
                                $subject = "User Registration";

                                $message = '<center style="width: 100%; background: #fcf3f0;padding: 20px;"><table align="center" border="1" cellpadding="0" cellspacing="0" width="600" style="border:none;background: #ffffff;padding: 21px;">
                                     <tr>
                                      <td style="border: none;border-bottom: 1px solid grey;">
                                      <h2 style="color: #6a6060;">Hello '.$user_name.',</h2>
                                      </td>
                                     </tr>
                                     <tr>
                                     <td>
                                     </td>      
                                     </tr>
                                     <tr>
                                     <td style="border: none;">
                                     <p style="font-size: 16px;color: #590f66;">Thank you for registering with Business Cybersecurity Certification</p>
                                     </td>      
                                     </tr>
                                     <tr>
                                      <td style="border: none;">
                                      <p style="font-size: 16px;color: #590f66;"> To complete the activation of your account, please click this link:</p><p style="font-size: 16px;"><a href="'.$url.'" style="color: #FF5722;">'.$url.'</a></p>
                                      </td>
                                     </tr>

                                    </table></center>';

                                // Always set content-type when sending HTML email
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                                // More headers
                                $headers .= 'From: <support@bizcybercert.us>' . "\r\n";
                                // $headers .= 'Cc: myboss@example.com' . "\r\n";

                                mail($to,$subject,$message,$headers);
                                $verifyUser = \DB::table('verify_users')->insert($verifyUser_data); 

                            $request->session()->flash('alert-success', 'Thank you for registering with BCC. A confirmation email has been sent to the email address you provided. Please confirm receipt by clicking on the link in our email to you. Your account will then be active.');
                            // $request->session()->flash('alert-success', ' Thank you for the registration. We have sent an email to authenticate. Please verify your account.');
                           return redirect('user/register');
                        }
                    }
                }else{
                    $request->session()->flash('alert-danger', 'This email id has already been registered by another user.');
                    return redirect('user/register');
                }
            }
        }
    }
     public function verifyuser($token)
    {
        
        $verifyUser = DB::table('verify_users')->where('token', $token)->select('user_id')->first();
        if(isset($verifyUser) ){
            $user = $verifyUser->user_id;
            if($user!='') {
                $client_users = \DB::table('client_users')->where('id', $user)
            ->update(['verified' => 1]);
             $token_del =  DB::table('verify_users')->where('token',$token)->delete();
                $status = "Your e-mail is verified. You can now login.";
            }else{
                $status = "Your e-mail is already verified. You can now login.";
            }
        }else{
            return redirect('/user/login')->with('warning', "Sorry your email cannot be identified.");
        }
 
         return view('auth.confirmation');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    public function show()
    {
        $client_data = $this->get_clients(10);
        return view('User.user_dashboard',['client_data' => $client_data[0]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if($request){
          $input = $request->all();
          $id = $input['id'];

          if(array_key_exists('password', $input) && empty($input['password'])){
            echo json_encode(array('error'=> true,'data'=> 'Password field is required.'));die;
          }else if(array_key_exists('password', $input) && isset($input['password']) && strlen($input['password']) < 8){
            echo json_encode(array('error'=> true,'data'=> 'Please enter password at least 8 characters.'));die;
          }else{
            if(array_key_exists('password', $input) && isset($input['password'])){
              $password = password_hash($input['password'] ,PASSWORD_BCRYPT );
            }else{
              $password = '';
            }
            
            $user_data = array(
              'first_name' => $input['firstname'],
              'last_name'  => $input['lastname'],
              'email_id'   => $input['email'],
            );
            if(!empty($password)){
              $user_data['password'] = $password;
            }

            $companyname = $input['companyname'];
            DB::table('client_users')->where('id',$id)->update($user_data);
            $res = DB::table('clients_info')->where('primary_id',$id)->update(array('company_name' => $companyname));
            $result = $this->get_clients($id);
            echo json_encode(array('success'=> true,'data'=> $result[0]));die;
          }
        }
    }
    public function certification_dashboard(){
      return view('User.certification_level_dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function get_clients($id = null){
        if(empty($id)){
            $client_info_data = DB::table('clients_info')->get();
        }else{
            $client_info_data = DB::table('clients_info')->where('primary_id',$id)->get();
        }
       
        $client_array = array();
        foreach ($client_info_data as $client_val) {
            $client_users_data = DB::table('client_users')->where('id', $client_val->primary_id)->first();
            $user_name = $client_users_data->first_name.' '.$client_users_data->last_name;
            $client_val->user_name = $user_name;
            $client_val->first_name = !empty($client_users_data)?$client_users_data->first_name:'';
            $client_val->last_name = !empty($client_users_data)?$client_users_data->last_name:'';
            $client_val->password = $client_users_data->password;
             $client_val->password = !empty($client_users_data)?$client_users_data->password:'';
            $client_val->email_provider = !empty($client_users_data)?$client_users_data->email_provider:'';
            $client_val->email_id = !empty($client_users_data)?$client_users_data->email_id:'';
            $client_val->email_notes = !empty($client_users_data)?$client_users_data->email_notes:'';
            $client_val->registered_at = !empty($client_users_data)?$client_users_data->registered_at:'';
            $client_array[] = $client_val;
        }
        return $client_array;
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
    public function paymentsignup(Request $request){
      if($request){
            $inputs = $request->all();
            $amount               = $inputs['amount'];
            $description          = $inputs['description'];
            $first_name             = $inputs['first_name'];
            $last_name              = $inputs['last_name'];
            $password               = $inputs['user_password'];
            $email_id               = $inputs['email'];
            $confirm_user_password  = $inputs['confirm_user_password'];
            $company_name           = $inputs['company_name'];
            $level                  = $inputs['level'];
            $password_hash = password_hash($password ,PASSWORD_BCRYPT );
            $company = str_replace(' ','',$inputs['company_name']);
            $client_id = md5($company.strtotime(date('H:i')));
            $time = strtotime(date('Y-m-d H:i:s'));
            $password_expiration = date("Y-m-d H:i:s", strtotime("+1 month", $time));
            $validator = \Validator::make(
                 [
                    'first_name'                     => $first_name,
                    'last_name'                      => $last_name,
                    'password'                       => $password,
                    'email_id'                       => $email_id,
                    'company_name'                   => $company_name
                    //'confirm_user_password'          => $confirm_user_password
                ],
                [
                    'first_name'                     => 'required',
                    'last_name'                      => 'required',
                    'password'                       => 'required|min:8',
                    'email_id'                       => 'required|email|unique:client_users',
                    'company_name'                   => 'required'
                    //'confirm_user_password'          => 'required|min:8',
                ]
            );
            if($validator->fails()){
                // $messages = $validator->errors()->first('email_id');
                // $rule = $validator->failed();
                // // $key = $validator->errors()->keys();
                // if(array_key_exists("Unique",$rule['email_id'])){
                //   $request->session()->flash('already_register', 'yes');
                //   //$request->session()->flash('alert-success', ' Thank you for the registration. We have sent an email to authenticate. Please verify your account.');
                //   Session::put('email',$email_id);
                //   $request->session()->flash('alert-danger', 'This email id has already been registered by another user.');
                //   return redirect('certification-levels');
                // }else{
                  Session::put('email',$email_id);
                  return redirect('certification-levels')->withErrors($validator)->withInput();
                // }
                
            }else{
                $email_data = DB::table('client_users')->where('email_id', md5($email_id))->first();
                if(empty($email_data)){
                    $data = array(
                        'first_name'          => $first_name,
                        'last_name'           => $last_name,
                        'password'            => $password_hash,
                        'password_expiration' => $password_expiration,
                        'client_id'           => $client_id,
                        'email_id'            => $email_id,
                    );
                   
                    $client_users = \DB::table('client_users')->insert($data);
                    $last_insert_id = \DB::getPdo()->lastInsertId();
                    if($last_insert_id){
                        $client_users_data = DB::table('client_users')->where('id', $last_insert_id)->first();
                        $key_id = $this->generatePassword('32',''.strtotime(date('H:i')).'',$company);
                        $guid = $this->generatePassword('32',''.strtotime(date('H:i')).'',$company);
                        $date = date("Y-m-d H:i:s");
                        $company_data = array(
                            'company_name'        => $company_name,
                            'primary_id'          => $last_insert_id,
                            'client_id'           => $client_users_data->client_id,
                            'keyid'               => $key_id,
                            'guid'                => $guid,
                            'certification_status' => '1',
                            'certification_date'  => $date,
                            // 'certification_renewal_date' => date("Y-m-d H:i:s", strtotime("+1 year", strtotime($date))),
                            'privacy_policy_acceptance_date' => $date,
                            'terms_of_use_acceptance_date' => $date

                        );

                        $userdata1 = \DB::table('clients_info')->insert($company_data);
                        if($userdata1 == true){
                        
                        $verifyUser_data = array(
                             'user_id'       =>$last_insert_id,
                            'token'          => str_random(40)
                          );   
                          $url = URL::to('/').'/user/verify/'.$verifyUser_data['token'];
                          $content = $url;
                           $data_text = array('name'=>$first_name,'content'=>$content);
                           $email = $email_id;
                           $first_name = $first_name;
                           
                              // Mail::send(['html'=>'Mail.mail'], $data_text,function($message) use ($email,$first_name,$url) {
                              //    $message->to( $email, $first_name )->subject
                              //       ('Profile Activation Email');
                              //    $message->from('avinashmishra.vll@gmail.com','BCC');
                              // });
                            $user_name = $first_name;
                            $to = $email_id;
                                $subject = "User Registration";

                                $message = '<center style="width: 100%; background: #fcf3f0;padding: 20px;"><table align="center" border="1" cellpadding="0" cellspacing="0" width="600" style="border:none;background: #ffffff;padding: 21px;">
                                     <tr>
                                      <td style="border: none;border-bottom: 1px solid grey;">
                                      <h2 style="color: #6a6060;">Hello '.$user_name.',</h2>
                                      </td>
                                     </tr>
                                     <tr>
                                     <td>
                                     </td>      
                                     </tr>
                                     <tr>
                                     <td style="border: none;">
                                     <p style="font-size: 16px;color: #590f66;">Thank you for registering with Business Cybersecurity Certification</p>
                                     </td>      
                                     </tr>
                                     <tr>
                                      <td style="border: none;">
                                      <p style="font-size: 16px;color: #590f66;"> To complete the activation of your account, please click this link:</p><p style="font-size: 16px;"><a href="'.$url.'" style="color: #FF5722;">'.$url.'</a></p>
                                      </td>
                                     </tr>

                                    </table></center>';

                                // Always set content-type when sending HTML email
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                                // More headers
                                $headers .= 'From: <support@bizcybercert.us>' . "\r\n";
                                // $headers .= 'Cc: myboss@example.com' . "\r\n";

                                mail($to,$subject,$message,$headers);
                                $verifyUser = \DB::table('verify_users')->insert($verifyUser_data); 

                            //$request->session()->flash('alert-success', ' Thank you for the registration. We have sent an email to authenticate. Please verify your account.');
                      $paymentdata = array('amount' => $amount, 'description' => $description, 'userid' => $last_insert_id,'level_id' => $level);
                      // add private policy data into database
                      $policyCurrdate = date("Y-m-d H:i:s");
                      $response = DB::table('clients_info')
									->where('primary_id', $last_insert_id)
									->update(array('privacy_policy_acceptance_date' => $policyCurrdate,
												   'terms_of_use_acceptance_date' 	=> $policyCurrdate));
                        Session::put('payment_detail', $paymentdata);
                        return redirect('paypalregister');
                        }
                    }
                }else{
                    $request->session()->flash('already_register', 'yes');
                    //$request->session()->flash('alert-success', ' Thank you for the registration. We have sent an email to authenticate. Please verify your account.');
                    $request->session()->flash('alert-danger', 'This email id has already been registered by another user.');
                    return redirect('certification-levels');
                }
            }
        }
    }
    public function forgotPassword(){
      return view('User.forgot_password');
    }
    
    public function TermsAndConditionAgree() {
    	$userInfo = Session::get('user');
    	$id = $userInfo->id;
    	$date = date("Y-m-d H:i:s");
    	if ($id) {
    	$response = DB::table('clients_info')
					->where('primary_id', $id)
					->update(array('privacy_policy_acceptance_date' => $date, 'terms_of_use_acceptance_date' => $date));
		echo 1;
		} else {
		echo 0;
		}
	}

}
