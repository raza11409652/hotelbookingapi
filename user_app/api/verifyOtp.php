<?php
require_once "../../base_config/Connection.php";
require_once "../../base_config/VeriffyOtpMsg91.php";
require_once "../../panel/model/User.php";
require_once "../../panel/controller/Utils.php";
require_once "../../panel/firebase/api/createuserforcareapp.php";
$response = array("error"=>true) ; 
class VerifyOtp{
    private $connection , $bookings  ; 
    public $user , $userCreation ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->user = new User();
        $this->userCreation = new UserCreation();
    }

    function verifyUser($mobile , $otp){
        $flag = verify($mobile , $otp);
        return $flag; 
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    @$otp = $_POST['otp'] ; 
    @$mobile = $_POST['mobile'];
    if(empty($otp)){
        $response['error'] =true ; 
        $response['msg'] = "Otp is required" ;
        $response['error-code'] = 505 ; 
        echo json_encode($response) ; 
        return ;
    }
    if(empty($mobile)){
        return ; 
    }

    if(!validMobile($mobile)){
        $response['error'] =true ; 
        $response['msg'] = "Invalid request " ;
        $response['error-code'] = 506 ; // mobile number if not in valid format 
        echo json_encode($response) ; 
        return ;
    }
    $object = new VerifyOtp();
    $USER_DATA= $object->user->getUserDataByMobile($mobile) ; 
    
    $flag = $object->verifyUser($mobile , $otp);
    if($flag){
        $flag = json_decode($flag);
        $type =$flag->type;
        if($type=="success"){
           if($USER_DATA == null || empty($USER_DATA)){
               //User deatil is not found new user 
               $mobileWithSTD = "+91{$mobile}";
               $email = mt_rand(1000000 , 9999999) ;
               $email = "AB_{$email}@fod.in";
               $res = $object->userCreation->createuserByMobileEmail($mobileWithSTD ,$email );
               $error = $res['error'] ; 
               if($error){
                   echo json_encode($res)  ;
                   return ; 
               }
               $uid = $res['uid'] ; 
               $flag = $object->user->createNewUser($uid , $mobile);
               $USER_DATA= $object->user->getUserDataByMobile($mobile) ; 
               $response['error'] = false ; 
               $response['msg'] = "Login sucecss" ; 
               $response['user'] =$USER_DATA ;
               echo json_encode($response);
               return ; 
            }else{
               $response['error'] = false ; 
               $response['msg'] = "Login sucecss" ; 
               $response['user'] =$USER_DATA ;
               echo json_encode($response);
               return ; 
           }
        }else{
        $response['error'] = true   ; 
        $response['msg'] = $flag->message;
        $response['error-code'] = 909 ; //Couldn't verify from MSG91 Server
        echo json_encode($response);
        return ;  
        }
        
    }else{
        $response['error'] = true   ; 
        $response['msg'] = "Invalid OTP";
        $response['error-code'] = 909 ; //Couldn't verify from MSG91 Server
        echo json_encode($response);
        return ; 
    }
}
?>