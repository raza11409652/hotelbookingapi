<?php 
require_once "../../base_config/Connection.php";
require_once "../../base_config/VeriffyOtpMsg91.php";
require_once "../../panel/model/User.php";
require_once "../../panel/model/Bookings.php";
require_once "../../panel/controller/Utils.php";
$response = array("error"=>true) ; 
class Verify{
    private $connection   ; 
    public $user, $bookings ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->user = new User();
        $this->bookings = new Bookings();
    }

    function verifyUser($mobile , $otp){
        $flag = verify($mobile , $otp);
        return $flag; 
    }
    function update($booking){
        $query = "UPDATE booking set booking_is_checked='1' where booking_id='{$booking}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        return $res ; 
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    @$otp = $_POST['otp'] ; 
    @$booking = $_POST['booking'] ; 
    // @$mobile = $_POST['mobile'];
    if(empty($otp)){
        $response['error'] =true ; 
        $response['msg'] = "Otp is required" ;
        $response['error-code'] = 505 ; 
        echo json_encode($response) ; 
        return ;
    }
   if(empty($booking)){
       return ; 
   }
     $object = new Verify();
    @$BOOKINGDATA = $object->bookings->getBookingByID($booking) ; 
    @$userId = $BOOKINGDATA['booking_user'] ; 
    $USERDATA = $object->user->getUserDataById($userId) ; 
    @$mobile = $USERDATA['user_phone'] ; 
    if(!validMobile($mobile) || empty($mobile)){
        $response['error'] =true ; 
        $response['msg'] = "Invalid request " ;
        $response['error-code'] = 506 ; // mobile number if not in valid format 
        echo json_encode($response) ; 
        return ;
    }
  
    $flag = $object->verifyUser($mobile , $otp);
    if($flag){
        $flag = json_decode($flag);
        $type =$flag->type;
        if($type=="success"){
            $object->update($booking);
            $response['msg'] = "OTP VERIFIED";
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