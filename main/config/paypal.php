<?php
return array(
/** set your paypal credential **/
'client_id' =>'AeqIJ0ycC3Kped1w-_IwYvZ7jq6UQTsL_57apwN0uMb4MaNbneJIhoKWDyGc-NkAC6YFeZklhz1Atoro',
'secret' => 'EB3j49gkNRfUSz2LJFGRZIQC04_E__UhNGzrQ_7LqU0FYXRlnNttDYbryg8vUY2PLpko6FBWkFFqKnSV',
//Sandbox
// 'client_id' =>'Afw8VHJXdldTWglr0KyskgscZYVl3GJFBQ_i2PxlaWKp0itevsW6ssM_b2ncUUSYuZJSwKGNLg56QrU-',
// 'secret' => 'EB9wVFyAUgSzmDxxv2cGoijhmYzmv8xjmffTRJBapUi-hpGUO-yW6dnGFkNlFMNgb-Piyk7erLm6mg59',
/**
* SDK configuration 
*/
'settings' => array(
/**
* Available option 'sandbox' or 'live'
*/
'mode' => 'live',
/**
* Specify the max request time in seconds
*/
'http.ConnectionTimeOut' => 1000,
/**
* Whether want to log to a file
*/
'log.LogEnabled' => true,
/**
* Specify the file that want to write on
*/
'log.FileName' => storage_path() . '/logs/paypal.log',
/**
* Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
*
* Logging is most verbose in the 'FINE' level and decreases as you
* proceed towards ERROR
*/
'log.LogLevel' => 'FINE'
),
);

?>