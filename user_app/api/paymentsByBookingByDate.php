<?php 
require_once "../../base_config/Connection.php";
require_once "../../panel/model/User.php";
require_once "../../panel/model/Bookings.php";
require_once "../../panel/model/Payments.php";
require_once "../../panel/controller/Utils.php";
$response = array("error"=>true) ; 
class paymentsByBookingByDate{
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
        // $booking = mysqli_real_escape_string($this->connection , $booking);
        // $records = $this->payments->getAllPaymentByBookingId($booking) ; 
        // return $records ; 
        $query   = "SELECT distinct(booking_pay_submit_date) as date from booking_pay where booking_pay_ref='$booking' " ; 
        // echo $query;
        $response['records'] = array();
        $res = mysqli_query($this->connection , $query)  ;
        while($data = mysqli_fetch_assoc($res) ){
            // var_dump($data['date']);
           
            $paymentDate = $data['date'];
            
            $record = $this->payments->getBookingForDateAndBooking($booking , $paymentDate) ; 
            $item =array("date"=>formatDate($paymentDate) , "payments"=>$record) ; 
            array_push($response['records'] , $item);
        }
        return $response['records'] ;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
   
     // var_dump($_POST);
     $object= new paymentsByBookingByDate();
     $HEADERS = getallheaders();
     /**
      * API SESSIONA HANDLE GOES HERE
      */
     @$userUid = $HEADERS['client-token']; 
     @$booking = $_POST['booking']; 
     if(empty($booking)){
         $response['error'] = TRUE ; 
         $response['msg'] = "Required parameter is missing" ; 
         $response['error-code'] = 707 ; 
         echo json_encode($response) ; 
         return ; 
     }
 
     $BOOKINGS = $object->listAllPayment($booking);
     $response['error'] = FALSE ; 
     $response['booking'] =$booking;
     $response['msg'] = sizeof($BOOKINGS)." RECORDS  FOUND" ;
     $response['records'] = $BOOKINGS;
     echo json_encode($response); 
    
}else{

}

?>
