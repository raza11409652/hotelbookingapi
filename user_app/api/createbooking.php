<?php
require_once "../../base_config/Connection.php";
require_once "../../base_config/SendOtpMsg91.php";
require_once "../../panel/model/User.php";

require_once "../../panel/model/Bookings.php";

$response = array("error"=>true) ; 
class CreateBooking{
    private $connection , $bookings  ; 
    public $user ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->user = new User();
        $this->bookings = new Bookings();
    }
    function create($property , $user , $start , $endDate){
        $res = $this->bookings->createNew($property ,$user  , $start , $endDate ) ; 
        return $res ; 
    }

}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $HEADERS = getallheaders();
    @$authToken = $HEADERS['auth-token'] ; 
    @$userUid = $HEADERS['client-token']; 
    if(empty($authToken) || empty($userUid)){
        return ; 
    }
    $mobile = @$_POST['mobile'] ; 
    if(empty($mobile)) return ; 
    $obj = new CreateBooking() ; 
    $userData = $obj->user->getUserDataByUid($userUid) ; 
    if(empty($userData) ||$userData ==null){
        //create user profile
        $mobile = str_replace('+91' , ''  , $mobile) ; 
        $userFlag = $obj->user->createNewUser($userUid  ,$mobile ) ; 
    }
    $userData = $obj->user->getUserDataByUid($userUid) ; 
    $userId =@ $userData['user_id'] ;
    //  var_dump($userId); 
    // var_dump($_POST);
    $property = @$_POST['property'] ; 
    $start = @$_POST['start'] ; 
    $endDate =@ $_POST['end'] ; 


    $flag = $obj->create($property , $userId ,$start , $endDate) ; 
    if($flag){
        $otp = mt_rand(100000 ,999999)  ;
        sendotp($mobile ,$otp) ; 
        $response['error']  =false ; 
        $response['msg'] = "Booking has been scheduled for {$start} - {$endDate}" ; 
        echo json_encode($response) ; 
        return ; 
    }
    $response['error']  =true ; 
    $response['msg'] = "Booking failed" ; 
    echo json_encode($response) ; 
    return ; 

   

}
?>