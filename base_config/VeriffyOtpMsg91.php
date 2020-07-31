<?php

function verify($mobile  , $otp){
    $curl = curl_init();
    $api = MSG_API_KEY ; 
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.msg91.com/api/v5/otp/verify?mobile={$mobile}&otp={$otp}&authkey={$api}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

    if ($err) {
       return NULL;
    } else {
        return $response;
    }
}
?>