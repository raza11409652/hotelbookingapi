<?php

function Resned($mobile){
    $api = MSG_API_KEY ; ;
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.msg91.com/api/v5/otp/retry?mobile={$mobile}&authkey={$api}",
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
    
    // if ($err) {
    //   echo "cURL Error #:" . $err;
    // } else {
    //   echo $response;
    // }
    if ($err) {
        return false   ; 
    } else {
        return true;
    }
}
?>