<?php
require_once "../../base_config/Connection.php";
require_once "../../panel/model/User.php";
require_once "../../panel/model/Bookings.php";
require_once "../../panel/model/HouseKeeping.php";
require_once "../../panel/model/Property.php";
require_once "../../panel/model/Payments.php";
$response = array("error"=>true) ;
class CreateHouseKeeping{
    private $connection   ;
    public $user  , $house , $bookings , $property , $payment;
    function __construct(){
        $conn = new Connection();
        $this->connection = $conn->getConnect();
        $this->user = new User();
        $this->bookings = new Bookings();
        $this->house  = new HouseKeeping();
        $this->property = new Property() ;
        $this->payment  = new Payments();
    }
    function insert($user , $booking ,$roomNumber ,$propertyName  , $date , $time   , $amount){
        $houseKeepingId = $this->house->getMaxHouseKeepingId();
        //($id , $user , $booking , $date , $timeRef , $timeSlot , $amount )
        $timeSlot =$this->house->getTimeslot($time) ;
        $temp = $timeSlot ;
        $timeSlot = "{$propertyName} - {$roomNumber}  , {$timeSlot} , REF ::
        FOD_PAY_{$time}{$date}" ;
        $flag = $this->house->newHouseKeepingWeb($houseKeepingId , $user ,$booking  , $date , $time ,
         $timeSlot , $amount) ;
        if($flag){
            //($amount , $user ,$mode , $desc )
            // $desc = "Payment made for Housekeeping service {$houseKeepingId} , {$timeSlot}" ;
            // $f = $this->payment->createPaymentHistory($amount , $user ,$paymentMode , $desc) ;
            $response['error'] = FALSE ;
            $response['msg'] = "House keeping service  created " ;
            $response['id']=$houseKeepingId;
            $response['error-code'] = 0;
            echo json_encode($response);
            return ;
        }
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $HEADERS = getallheaders();
    @$authToken = $HEADERS['auth-token'] ;
    @$clientToken = $HEADERS['client-token'];
    if(empty($authToken)){
        return ;

    }

    if(empty($clientToken)){
        return ;
    }
    /**
     * TODO
     * API SESSION HANDLE GOES HERE
     */
    // if(empty($authToken)){
    //     $response['error'] = TRUE ;
    //     $
    // }
    /*
        ["date"]=>
      string(10) "2020-06-22"
      ["booking"]=>
      string(1) "1"
      ["amount"]=>
      string(5) "102.5"
      ["paymentMode"]=>
      string(18) "pay_F5IKwNHsSTM106"
      ["time"]=>
      string(1) "1"
      ["user"]=>
      string(28) "nLUlFKXtMcaryhnqBKSg2iJ7AeA3"
     */


    // var_dump($_POST);

    @$amount  = $_POST['amount'] ;
    @$date = $_POST['date'];
    @$time = $_POST['time'] ;
    @$user = $_POST['user'] ; // It holds user uid
    @$booking = $_POST['booking'] ; //booking Id
    if(empty($booking)){
      $response['msg']="Select your booking";
      $response['error']=true ;
      echo json_encode($response);
      return;
    }
    if(empty($date)){
      $response['msg']="Date is required";
      $response['error']=true ;
      echo json_encode($response);
    return;
    }
    if(empty($time)){
      $response['msg']="Time slot is required";
      $response['error']=true ;
      echo json_encode($response);
      return;
    }
    $object = new CreateHouseKeeping();

    $BOOKING_DATA = $object->bookings->getBookingByID($booking) ;
    // var_dump($BOOKING_DATA) ;
    $propertyId = @$BOOKING_DATA['booking_property'] ;
    $room =@$BOOKING_DATA['booking_room'] ; //ROOM ID

    $PROPERTY_DATA = $object->property->getproperty($propertyId) ;
    $propertyName = @$PROPERTY_DATA['property_name'] ;


    $roomNumber =$object->property->getRoomNumber($room) ;
    // var_dump($propertyName);
    $USER_DATA = $object->user->getUserDataByUid($user) ;
    // var_dump($USER_DATA) ;
    $userId =@$USER_DATA['user_id'] ;
    $object->insert($userId ,$booking ,$roomNumber ,$propertyName ,$date ,$time  ,$amount);





}else{

}

?>
