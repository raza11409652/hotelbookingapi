<?php 
require_once "../../base_config/Connection.php";
require_once "../../panel/model/User.php";
require_once "../../panel/model/Bookings.php";
require_once "../../panel/controller/Utils.php";
$response = array("error"=>true) ; 
class FetchRent{
    private $connection  ; 
    public $user ,$bookings ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->user = new User();
        $this->bookings = new Bookings();
    }
    function isPendingPayment($user ,$booking , $bookingNumber){
        $query = "SELECT * from booking_pay where booking_pay_ref='{$booking}' && booking_pay_is_paid='0'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $count = mysqli_num_rows($res) ;
        if($count<1){
            $response['error'] = true ; 
            $response['msg'] ="No Pending payment found";
            $response['error-code'] = 0 ; 
            echo json_encode($response);
            return ; 
            
        }
        $hash = sha1($user);
        $userBaseCode= base64_encode($user) ; 
        $bookingIdBaseCode =base64_encode($booking);
        $bookingNumber =base64_encode($bookingNumber);
        $response['error']=false  ; 
        $response['url']="?view=pending&SESSION_HASH={$hash}&user={$userBaseCode}&booking={$bookingIdBaseCode}&number={$bookingNumber}";
        $response['error-code']= 0 ;
        echo json_encode($response);
        return;


    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $HEADERS = getallheaders();
    @$authToken = $HEADERS['auth-token'] ; 
    @$userUid = $HEADERS['client-token'];
    
    @$booking   = $_POST['booking'] ; 
    @$mobile = $_POST['mobile'];
    if(empty($mobile)){
        $response['error'] = true ;
        $response['msg'] = "Mobile number is required" ;
        $response['error-code'] = 0; 
        echo json_encode($response);
        return ; 
    }
    if(empty($booking)){
        $response['error'] = true ;
        $response['msg'] = "Booking number is required" ;
        $response['error-code'] = 0; 
        echo json_encode($response);
        return ;
    }
    if(!validMobile($mobile)){
        $response['error'] = true ;
        $response['msg'] = "Mobile  number is not in valid format" ;
        $response['error-code'] = 505; 
        echo json_encode($response);
        return ;
    }
    $object = new FetchRent();
    $BOOKING_DATA = $object->bookings->getBookingByNumber($booking);
    $USER_DATA = $object->user->getUserDataByMobile($mobile);
    if(empty($USER_DATA) || $USER_DATA==null){
        $response['error'] = true ;
        $response['msg'] = "No booking found" ;
        $response['error-code'] = 505; 
        echo json_encode($response);
        return ;
    }
    if(empty($BOOKING_DATA) || $BOOKING_DATA==null){
        $response['error'] = true ;
        $response['msg'] = "Invalid Booking number" ;
        $response['error-code'] = 505; 
        echo json_encode($response);
        return ;
    }
    $bookingId = @$BOOKING_DATA['booking_id'];

   
    $bookingUser = @$BOOKING_DATA['booking_user']; 
    $userId = @$USER_DATA['user_id'];
  
    if($bookingUser ==$userId){
        $object->isPendingPayment($userId , $bookingId , $booking);
        return ; 
    }
    $response['error']  = true ; 
    $response['error-code']=404 ; 
    $response['msg']="No data found, validate entered details";
    echo json_encode($response);
    return;

}else{

}
?>