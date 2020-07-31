<?php 
require_once "../../base_config/Connection.php";
require_once "../../base_config/VeriffyOtpMsg91.php";
require_once "../../panel/model/User.php";
require_once "../../panel/controller/Utils.php";
$response = array("error"=>true) ; 
class Verify{
    private $connection , $bookings  ; 
    public $user ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->user = new User();
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
    $object = new Verify();
    $flag = $object->verifyUser($mobile , $otp);
    if($flag){
        $flag = json_decode($flag);
        $type =$flag->type;
        if($type=="success"){
            session_start();
            $userData = $object->user->getUserDataByMobile($mobile); 
            $_SESSION['fodLoggedIn']=true ; 
            $_SESSION['fodUserLoggedIn']=$userData ; 
            $response['error'] = false   ; 
            $response['msg'] = "Login success";
            $response['error-code'] =0;
            $response['user']=$userData;
            echo json_encode($response);
            return ;
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