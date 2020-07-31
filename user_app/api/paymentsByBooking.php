<?php
require_once "../../base_config/Connection.php";
require_once "../../panel/model/User.php";
require_once "../../panel/model/Bookings.php";
require_once "../../panel/model/Payments.php";
$response = array("error"=>true) ; 
class PaymentsByBooking{
    private $connection , $bookings  , $payments ; 
    public $user ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->user = new User();
        $this->bookings = new Bookings();
        $this->payments =new Payments();
    }
    function listAllPayment($booking){
        $booking = mysqli_real_escape_string($this->connection , $booking);
        $records = $this->payments->getAllPaymentByBookingId($booking) ; 
        return $records ; 
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //  var_dump($_POST);
    $object= new PaymentsByBooking();
    $HEADERS = getallheaders();
    /**
     * API SESSIONA HANDLE GOES HERE
     */
    @$userUid = $HEADERS['client-token']; 
    @$booking = $_POST['booking'] ; 
    if(empty($booking)){
        $response['error'] = TRUE ; 
        $response['msg'] = "Required parameter is missing" ; 
        $response['error-code'] = 707 ; 
        echo json_encode($response) ; 
        return ; 
    }

    $BOOKINGS = $object->listAllPayment($booking);
    $response['error'] = FALSE ; 
    $response['msg'] = sizeof($BOOKINGS)." RECORDS  FOUND" ;
    $response['records'] = $BOOKINGS;
    echo json_encode($response); 
}else{

}
?>