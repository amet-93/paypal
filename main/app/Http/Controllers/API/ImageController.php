<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\URL;

use App\Http\Controllers\Controller;

use DB;

class ImageController extends Controller
{
    public function show($id)
    {
        $data = $this->get_level_image($id);
        if(!empty($data)){
            if(array_key_exists('expire_date', $data)){
                if($_SERVER['SERVER_NAME'] == 'localhost'){
                    $path = URL::to('/').'/images/cert_img/certification-expire.jpeg';
                }else{
                    $path = "https://".$_SERVER['SERVER_NAME']."/images/cert_img/certification-expire.jpeg";
                }
                $image_file = explode(' ',  $data['product']);
                $expire_date = $data['expire_date'];
            }else{
                $image_file = explode(' ',  $data['product']);
                if($_SERVER['SERVER_NAME'] == 'localhost'){
                     $path = URL::to('/').'/images/cert_img/bcc_'.strtolower($image_file[0]).'_click.jpg'; 
                }else{
                     $path = 'https://'.$_SERVER['SERVER_NAME'].'/images/cert_img/bcc_'.strtolower($image_file[0]).'_click.jpg'; 
                }
                
                $expire_date = '';
            }
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $im = imagecreatefromjpeg($base64);
            if(!empty($expire_date)){
                $text1 = 'On '.$expire_date;
                $text = strtoupper($image_file[0]);
                if($_SERVER['SERVER_NAME'] == 'localhost'){
                    $font = $_SERVER['DOCUMENT_ROOT'].'/micc/images/cert_img/font/Raleway-ExtraBold.ttf';
                    $font1 = $_SERVER['DOCUMENT_ROOT'].'/micc/images/cert_img/font/Raleway-Regular.ttf';
                }else{
                    $font = $_SERVER['DOCUMENT_ROOT'].'/images/cert_img/font/Raleway-ExtraBold.ttf';
                    $font1 = $_SERVER['DOCUMENT_ROOT'].'/images/cert_img/font/Raleway-Regular.ttf';
                }
                $black = imagecolorallocate($im, 70, 70, 70);
                $black1 = imagecolorallocate($im, 0, 0, 0);
                imagettftext($im, 150, 0, 480, 600, $black, $font, $text);
                imagettftext($im, 70, 0, 220, 1240, $black1, $font1, $text1);
            }
            imagealphablending($im, false);
            imagesavealpha($im, true);
            header('Content-Type: image/png');
            imagepng($im);
            imagedestroy($im);die();
        }
    }
    public function get_level_image($id){
        $client_id = substr($id, 4, -4);
        $result = DB::table('client_users')->where('client_id',$client_id)->first();
        if(!empty($result)){
            $level_data = DB::table('payment_details')
                ->where('user_id', $result->id)
                ->orderBy('id', 'DESC')
                ->where('status','2')
                ->first();
            $company_info = DB::table('clients_info')->where('client_id',$client_id)->first();
            $current_date = date('Y-m-d');
            $expire_date = date('Y-m-d',strtotime($company_info->certification_date));
            $renew_date = date('Y-m-d',strtotime($company_info->certification_renewal_date ));
            $arr = array();
            if($current_date > $renew_date){
                $arr['expire_date'] = date('M d Y H:i:s',strtotime($company_info->certification_renewal_date ));
                $arr['product'] = $level_data->product;
            }else{
                $arr['product'] = $level_data->product;
            }
            return $arr;
        }else{
            return array();
        }
    }

    public function getImageUrl(Request $request,$id){
        $referrer = $request->referrer;
        $client_id = substr($id, 4, -4);
        $company_info = DB::table('clients_info')->where('client_id',$client_id)->first();
        $current_date = date('Y-m-d');
        $expire_date = date('Y-m-d',strtotime($company_info->certification_date));
        $renew_date = date('Y-m-d',strtotime($company_info->certification_renewal_date ));
        $url = URL::to('/').'/user/showdetail/'.$id.'?referrer='.$referrer;
        // $type = 'text/html; charset=utf-8';
        header('Content-Type: text/html; charset=utf-8');
        // print_r($url);die;
        return response($url, 200)->header('Content-Type', 'text/html');
        // return response($url)
            // ->header('Content-Type', $type);
        //echo $url;
        // if($current_date > $renew_date){
        //     // echo str_replace($url,"javascript:void(0)",$url);
        //     echo 'javascript:void(0)';
        // }else{
        //     echo $url;
        // }
    }
}
