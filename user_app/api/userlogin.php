<?php 
require_once "../../base_config/Connection.php";
require_once "../../base_config/SendOtpMsg91.php";
require_once "../../panel/model/User.php";
require_once "../../panel/model/Bookings.php";
require_once "../../panel/controller/Utils.php";
$response = array("error"=>true) ; 
class UserLogin{
    private $connection , $bookings  ; 
    public $user ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->user = new User();
        $this->bookings = new Bookings();
    }
    function sendOtp($mobile){
        $otp =mt_rand(100000 , 999999);
        $flag = sendotp($mobile , $otp);
        return $flag  ;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $HEADERS = getallheaders();
    @$authToken = $HEADERS['auth-token'] ; 
    @$userUid = $HEADERS['client-token']; 
    @$mobile = $_POST['mobile'] ; 
    if(empty($mobile)){
        $response['error'] = true ; 
        $response['msg'] = "Mobile number is required" ; 
        $response['error-code'] =404 ; 
        echo json_encode($response) ; 
        return ; 
    }
    if(!validMobile($mobile)){
        $response['error'] = true ; 
        $response['msg'] = "Mobile number is not in valid format" ; 
        $response['error-code'] =404 ; 
        echo json_encode($response) ; 
        return ;
    }
    $object =new UserLogin();
    $USER_DATA = $object->user->getUserDataByMobile($mobile);
    if(empty($USER_DATA) || $USER_DATA == null){
        $response['error'] = true ; 
        $response['msg'] = "You don't have any active booking " ; 
        $response['error-code'] =404 ; 
        echo json_encode($response) ; 
        return ;
    }
    // var_dump($mobile);
    // var_dump($USER_DATA);
    $flag = $object->sendOtp($mobile);
    // var_dump($flag);
    if($flag){
        $response['error'] = FALSE ; 
        $response['msg'] = "OTP has been sent to {$mobile}";
        $response['error-code']=0; 
        $response['mobile']=$mobile;
        echo json_encode($response);
        return;
    }else{
        $response['error'] = true ; 
        $response['msg'] = "servre side problem with vendor ";
        $response['error-code']=101; 
        echo json_encode($response);
        return;
    }



}else{

}
?>