<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../controller/Utils.php";
/**
 * This end point id for new password reset 
 * it required uid  , otp and password
 */
$response = array("error"=>true) ;
class NewPassword{
    private $connection  ; 
    public $admin ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
    }
    function validate($otp  , $hashToken  , $admin){
        $flag = $this->admin->validateHash($otp , $hashToken) ; 
        // var_dump($flag);
        return $flag  ; 
    }
    function update($password , $admin , $device){
        $flag = $this->admin->updatePassword($password , $admin) ; 
        $this->admin->deleteToken($admin);
        $token = mt_rand(100000,9999999 ) ; 
        $temp = base64_encode($token)  ;
        $token = md5($token) ; 
        $token = "{$token}{$temp}";
        $this->admin->insertSession($admin , $device , $token );
        return $flag;
    }

}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $header = getallheaders();
    $device = $header['User-Agent'];
    $device = "Update password @ {$device}";
   @ $uid = $_POST['uid'] ; 
   @ $otp = $_POST['otp'] ; 
   @ $password = $_POST['password'] ;
   if(empty($otp)){
       $response['error'] = true ; 
       $response['msg'] = "OTP is required" ; 
       $response['error-code'] = 101 ; 
       echo json_encode($response);  
    return ; 
   }
   if(is_numeric($otp)==false){
    $response['error'] = true ; 
    $response['msg'] = "OTP should be nemric" ; 
    $response['error-code'] = 102 ; 
    echo json_encode($response);  
    return ;
   }

   if(empty($uid)){
    $response['error'] = true ; 
    $response['msg'] = "Please refresh the page" ; 
    $response['error-code'] = 103 ; 
    echo json_encode($response);  
    return ; 
   }
   if(empty($password)){
    $response['error'] = true ; 
    $response['msg'] = "Please refresh the page" ; 
    $response['error-code'] = 104 ; 
    echo json_encode($response);  
    return ; 
   }
   if(!validPassword($password)){
    $response['error'] = true ; 
    $response['msg'] = "Password format is not valid" ; 
    $response['error-code'] = 104 ; 
    echo json_encode($response);  
    return ;
   }
   $object = new NewPassword();
   $adminData = $object->admin->validUid($uid) ; 
    //    var_dump($adminData);
   if(empty($adminData) || $adminData == null){
    $response['error'] = true ; 
    $response['msg'] = "Please try again ,try to refresh the page" ; 
    $response['error-code'] = 104 ; 
    echo json_encode($response);  
    return ;
   }
  @ $adminId = $adminData['admin_id'] ;
   $hashTokenData = $object->admin->getToken($adminId) ; 
//    var_dump($hashTokenData);
    if(empty($hashTokenData)){
        $response['error'] = true ; 
        $response['msg'] = "OTP verification failed" ; 
        $response['erro-code'] = 108 ; 
        echo json_encode($response);
        return ; 
    }
    $hashToken = $hashTokenData['admin_token_val'];
    $flag = $object->validate($otp , $hashToken  , $adminId); 
    // var_dump($flag);
    if(!$flag){
        $response['error'] = true ; 
        $response['msg'] = "Invalid OTP eneterd" ; 
        $response['error-code'] = 202 ; 
        echo json_encode($response);
        return ; 
    }
    $hashPassword = $object->admin->hashStr($password) ;
    // var_dump($hashPassword);
    $flag = $object->update($hashPassword  , $adminId , $device);
    // var_dump($flag);
    if($flag){
        $response['error']= false ;
        $response['msg'] = "Password has been reset successfully" ;
        $response['erro-code'] = 0 ; 
        echo json_encode($response) ; 
        return;   
    }

}else{

}
?>