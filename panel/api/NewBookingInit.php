<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../controller/Utils.php";
require_once "../model/Property.php";
require_once "../model/User.php";
require_once "../model/Bookings.php";
require_once "../model/Payments.php";
$response =array("error"=>true);
session_start();
class NewBookingInit{
    private $connection  ; 
    public $admin , $property  , $user , $booking , $payment;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
        $this->property = new Property();
        $this->user = new User();
        $this->booking = new Bookings();
        $this->payment =new Payments();
    }
    function init( $id,$userId , $propertyId , $startDate , $endDate , $bookingNo , $roomId , $amount){
        $totaldays = totalnumberdays($startDate , $endDate) ; 
        $query = "Insert into booking (booking_id ,  booking_user , booking_number , 
        booking_start_date , booking_end_date , booking_total_days , 
        booking_property , booking_room  , booking_amount , booking_status)VALUES('{$id}' ,  '{$userId}' , '{$bookingNo}' , '{$startDate}' , '{$endDate}' , 
        '{$totaldays}' ,'{$propertyId}' , '{$roomId}' , '{$amount}' ,'2')" ;
        // echo $query;
        $res = mysqli_query($this->connection , $query) ; 
        return $res ;  


    }
    function createSecurity($bookingId , $amount , $ref , $mode){
        $query = "Insert into security_deposite (security_deposite_amount , security_deposite_ref ,security_deposite_mode) VALUES
        ('{$amount}' , '{$bookingId}' , '{$mode}')" ; 
        $res  = mysqli_query($this->connection , $query) ; 
        return $res  ; 
    }
    function _roomoccupied($roomId){ 
        $query = "Update room set room_is_vacant='1' where room_id='{$roomId}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        return $res ; 
    }
    
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $header = getallheaders() ; 
    @$authToken = $header['auth-token'] ; 
//   var_dump($_POST);
    // var_dump($authToken);
    if(empty($authToken) || $authToken ==null){
        $response['error'] = true ;
        $response['msg'] = "Please refresh the page and try again" ; 
        $response['error-code'] = 908 ; //No Auth token found
        echo json_encode($response) ; 
        return;
    }
  
    // var_dump($_POST);

    @$userMobile = $_POST['usermobile'] ; 
    @$propertyUid = $_POST['propertyuid'] ; 
    @$startDate  =$_POST['startDate'] ; 
    @$endDate  =$_POST['endDate']  ; 
    @$roomId = $_POST['room'] ;
    @$bookingamount = $_POST['bookingamount'] ; 
    @$securityDeposite = $_POST['amount'] ;
    @$securityRef = $_POST['ref'] ;


   
    // var_dump($todate);
    if(empty($userMobile)){
        $response['error'] = true ; 
        $response['msg'] = "Please enter user mobile number" ; 
        echo json_encode($response) ;
        return ; 
    }

    if(empty($propertyUid)){
        $response['error']  =true ; 
        $response['msg'] = "Please select property first" ; 
        echo json_encode($response) ; 
        return ; 
    }
    if(empty($startDate)){
        $response['error']  =true ; 
        $response['msg'] = "Please select booking start date" ; 
        echo json_encode($response) ; 
        return ;   
    }
    if(empty($endDate)){
        $response['error']  =true ; 
        $response['msg'] = "Please select booking end date" ; 
        echo json_encode($response) ; 
        return ;
    }


    $isValidStartdate = isvalidstartdate($startDate);
    if(!$isValidStartdate){
        $response['error'] = true ; 
        $response['msg'] = "Start date invalid" ; 
        echo json_encode($response) ;
        return ; 
    }
    $isValidEndDate = isvalidEndDate($startDate , $endDate) ; 
    // var_dump($isValidEndDate);
    if(!$isValidEndDate){
        $response['error'] = true ; 
        $response['msg'] = "End Date invalid" ; 
        echo json_encode($response) ;
        return ;  
    }
    if(empty($bookingamount) || $bookingamount<1){
        $response['error'] = true ; 
        $response['msg'] = "Please enter booking amount" ; 
        echo json_encode($response) ;
        return ;   
    }
    if($securityDeposite<0){
        $response['error'] = true ; 
        $response['msg'] = "Enter security deposite" ; 
        echo json_encode($response) ;
        return ;   
    }
    if(empty($securityRef)){
        $response['error'] = true ; 
        $response['msg'] = "Enter security reference" ; 
        echo json_encode($response) ;
        return ;  
    }
    /**
     * Now validate user mobile , property and room combination
     */
    // var_dump($userMobile);
    $object = new NewBookingInit() ; 
    $userData = $object->user->_userdata($userMobile) ; 
    // var_dump($userData);
    if(empty($userData)){
        $response['error'] = true ; 
        $response['msg'] = "Please validate user mobile" ; 
        echo json_encode($response) ;
        return ;  
    }
    $propertyData = $object->property->getPropertyByUid($propertyUid) ; 
    // var_dump($propertyData);
    if(empty($propertyData)){
        $response['error'] = true ; 
        $response['msg'] = "Please validate property" ; 
        echo json_encode($response) ;
        return ; 
    }
    $propertyId = $propertyData['property_id'];
    $flag = $object->property->validateroom($roomId , $propertyId) ; 
    if(!$flag){
        $response['error'] = true ; 
        $response['msg'] = "Please select room " ; 
        echo json_encode($response) ;
        return ; 
    }
    $userId = $userData['user_id'];
    $bookingId = $object->booking->getBookingId();
    $bookingNo = $object->booking->generateBookingUid($bookingId) ; 
    $flag = false ; 
    @$loggedInEmail = $_SESSION['loggedInEmail']  ; 
    $flag = $object->init($bookingId ,  $userId ,$propertyId ,$startDate ,$endDate ,$bookingNo, $roomId , $bookingamount) ; 
    if($flag){
        $object->createSecurity($bookingId , $securityDeposite , $securityRef , "MODE OFFLINE COLLECTION Account {$loggedInEmail}"  ) ; 
        $object->_roomoccupied($roomId);
        //Create First month payment
        $month =getMonth($startDate);
        $year = getYear($startDate);
        $day = getDay($startDate);
        $d=cal_days_in_month(CAL_GREGORIAN ,$month,$year);
        // var_dump($d);
        $remainingDays = $d - $day ; 
        $perDayBill = $bookingamount /30  ;
        // var_dump($perDayBill);
        $rent = $perDayBill  * $remainingDays ;
        $nextMonth  ="{$year}/{$month}/{$d}";
        $paymentPeriod = "{$startDate}  -TO- {$nextMonth}" ;
        $paymentStartDate = $startDate ; 
        $paymentEndDate = $nextMonth ;  
        $electricity = 0 ; 

        $object->payment->paymentInit($paymentStartDate, $paymentEndDate , $paymentPeriod , $electricity , $roomId ,$bookingId , $rent) ; 

        $response['error'] = false ;
        $response['msg'] = "Booking has been created" ; 
        echo json_encode($response); 
        return ;
    }


      
}

?>