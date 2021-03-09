<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/clear-cache', function() {
    return Artisan::call('cache:clear');
    // return what you want
});
Route::get('user/logout', 'Auth\UserLoginController@logout');
Route::group(['middleware' => 'AuthenticateUser'], function() {
   Route::get('user/login', 'Auth\UserLoginController@showLoginForm');
});

Route::post('user_login', 'Auth\UserLoginController@login');
$this->post('user/verify/{id}','UserController@verifyuser')->name('user_verify');

$this->post('user/registers','UserController@store')->name('user_signup');
//$this->get('logout', 'Auth\LoginController@logout')->name('logout');
$this->get('login', 'Auth\LoginController@showLoginForm')->name('user_login');
$this->post('login', 'Auth\LoginController@login');
$this->post('admin/create', 'ClientsController@store')->name('add_client');
$this->post('admin/edit/{id}','ClientsController@update')->name('edit_client');
$this->post('admin/add_process/{id}','ProcessController@update')->name('save_process');
$this->post('admin/deleteClient/{id}','ClientsController@destroy');
// $this->get('admin/deleteClient/{id}','ClientsController@destroy');
$this->post('user/savedisclaimer','generatecode\generatecode@save_disclaimer')->name('disclaimer_signup');

Route::post('user_logout', 'Auth\UserLoginController@logout');

Route::group(['middleware' => 'UserAuth'], function() {
    Route::get('user/certification-details/{id}/',['as' =>'user.certification_details' ,'uses'=>'ClientsController@showUserDetails']);
    Route::get('user/dashboard', 'Auth\UserLoginController@dashboard');
    Route::get('user', 'Auth\UserLoginController@dashboard');
    Route::get('user/certification-level-dashboard','UserController@certification_dashboard');
    Route::get('blog',function(){
        return view('blog');
    });
    Route::post('user/getIpData/{id}/','ClientsController@get_ip_data');
});
Route::post('user/update-user','UserController@update');

// Route::get('admin/dashboard',['as' => 'dashboard']);


Route::get('/', function () {
    return view('home');
});

Route::get('/admin', function () {
    return redirect('admin/dashboard');
});

Route::group(['middleware' => 'AdminAuth'], function() {
    Route::get('/admin/login', function () {
        return view('auth.login');
    });
});

Route::group(['middleware' => 'verifyuser'], function() {
    Route::get('admin/dashboard', function ()    {
        return view('dashboard');
    });
    Route::get('/admin/addClients', ['as' => 'clients.addClient', 'uses' => 'ClientsController@create']);
    Route::get('/admin/editClient/{id}', ['as' => 'clients.editClient', 'uses' => 'ClientsController@edit']);
    Route::get('/admin/Clients', ['as' => 'clients.clients_list', 'uses' => 'ClientsController@index']);
    
    Route::get('/admin/certification-details/{id}',['as' =>'clients.certification_details' ,'uses'=>'ClientsController@show']);
    Route::get('/admin/add-process-info/{id}', ['as' => 'process.add_process', 'uses' => 'ProcessController@create']);
    Route::post('admin/getIpData/{id}/','ClientsController@get_ip_data');
});
Auth::routes();
        


Route::get('user/register',['uses' => 'UserController@create']);
Route::get('/user/verify/{token}', 'UserController@verifyUser');

Route::get('user/register',['as' => 'User.register','uses' => 'UserController@create']);
//Route::get('user/dashboard',['uses' => 'Auth\UserLoginController@dashboard']);


// Route::get('/home', 'HomeController@index')->name('home');
Route::post('/payment', 'paypal\payment@index');
Route::any('/success', 'paypal\payment@success');
Route::get('/cancel', function () {
    return view('paypal.cancel');
});
Route::get('/thankyou', function () {
    return view('paypal.thankyou');
});
Route::get('certification-levels',function(){
	return view('certification_levels');
});
Route::get('paywithpaypal', array('as' => 'addmoney.paywithpaypal','uses' => 'AddMoneyController@payWithPaypal',));
Route::post('paypal', array('as' => 'addmoney.paypal','uses' => 'AddMoneyController@postPaymentWithpaypal',));
Route::get('paypal', array('as' => 'payment.status','uses' => 'AddMoneyController@getPaymentStatus',));

Route::get('paypalregister', array('as' => 'addmoney.paypal','uses' => 'AddMoneyController@postPaymentWithpaypal',));
Route::post('user/register','UserController@paymentsignup')->name('user_payment_signup');
Route::post('payuser/login','Auth\UserLoginController@paymentlogin');




/*For image encode*/
Route::get('user/generatecode','generatecode\generatecode@verify_user');
Route::get('user/showdetail/{id}',['as' => 'cart.disclaimer','uses'=> 'generatecode\generatecode@create_disclaimer']);
Route::get('user/certification-detail/{id}','generatecode\generatecode@showdetail');
Route::get('user/certification-auth/{id}','generatecode\generatecode@authdetail');
// Route::get('user/getimg/{id}','ImageController@show');
// Route::post('user/getimg/{id}', function()({
//     die('dkdkd');
// });
// Route::post('user/getimg/{id}','ImageController@show');

Route::get('user/termsconfirmation','UserController@TermsAndConditionAgree');
// 'UserController@TermsAndConditionAgree'