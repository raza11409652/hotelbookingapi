<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../model/Property.php";
require_once "../model/Bookings.php";
require_once "../model/Payments.php";
require_once "../controller/Utils.php";
$response = array("error"=>true) ; 
class GetPaymentHistory{
    private $connection  , $property ; public $payments  ; 
    public $admin  , $bookings ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
        $this->property = new Property();
        $this->payments = new Payments();
        $this->bookings  = new Bookings();
    }
    function fetch($id){
        @$data = $this->payments->getPaymentHistory($id) ; 
        // var_dump($data);
       if($data!=NULL){
           $roomId = @$data['booking_pay_room'] ; 
           $propertyId = $this->payments->getPropertyIdFromRoom($roomId) ; 
           $propertyName = $this->payments->getPrpoertyName($propertyId) ; 
        $response['error'] = FALSE ; 
        $response['electricity'] = @$data['booking_pay_elec'] ; 
        $response['room'] = "{$propertyName} / " .   $this->payments->getRoomNumber( $roomId ); 
        $response['booking']  = $this->bookings->getBookingByID(  @$data['booking_pay_ref'] ); 
        $response['rent'] =     @$data['booking_pay_rent'] ; 
        $response ['others'] = @$data['booking_pay_others'] ; 
        $response['period'] = @$data['booking_pay_period'] ; 
        $response['ispaid'] = @$data['booking_pay_is_paid'] ; 
        $response['mode'] = @$data['booking_pay_mode'] ; 
        $response['msg'] = "Fetching payment history for {$id}" ;
        $response['ref'] = @$data['booking_pay_mode_ref']; 
        $response['submit-date'] = @$data['booking_pay_submit_date'] ; 
        $response['submittedon']=@$data['booking_pay_submitted_on'] ; 
        $response['generatedon'] = @$data['booking_pay_time'] ; 
        $response['electricityref'] =@$data['booking_pay_elect_ref'] ; 
        $response['bookingpaytoken']   = $data['booking_pay_token'];
        $response['payments'] = $this->payments->getPaymentData($id) ; 
        $response['total'] = @$data['booking_pay_elec'] + @$data['booking_pay_rent'] + @$data['booking_pay_others'] ;
        return $response  ;
       } else{
           return NULL ; 
       }
         
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $header = getallheaders() ; 
    @$authToken = $header['auth-token'] ; 
    //  var_dump($_POST);
    // var_dump($authToken);
    if(empty($authToken) || $authToken ==null){
        $response['error'] = true ;
        $response['msg'] = "Please refresh the page and try again" ; 
        $response['error-code'] = 908 ; //No Auth token found
        echo json_encode($response) ; 
        return;
    }
    $object = new GetPaymentHistory();
    $flag = $object->admin->validateSession($authToken);
    if(!$flag){
        $response['error'] = true ;
        $response['msg'] = "Please refresh the page and try again" ; 
        $response['error-code'] = 908 ; //No Auth token found
        echo json_encode($response) ; 
        return;
    }
    @$bookingPayId = $_POST['bookingPay'] ; 
    if(empty($bookingPayId)){
        $response['error'] = true ;
        $response['msg'] = "Please refresh the page and try again" ; 
        $response['error-code'] = 101;
        echo json_encode($response) ; 
        return;
    }

    $res = $object->fetch($bookingPayId);
    echo json_encode($res);
    return ; 




}else{

}

?>