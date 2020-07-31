<?php 
require_once "../../base_config/Connection.php";
require_once "../../base_config/ResentOtpMsg91.php";
$response = array("error"=>false);
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // @$otp = $_POST['otp'];
    // if(empty($otp)){
    //     $response['error'] = TRUE; 
    //     $response['msg'] = "OTP is required";
    // }
}

?>