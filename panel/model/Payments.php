<?php 

class Payments{
    private $connection  ;
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
    }
   
    function getBookingStatus($id){
        $query= "Select * from payment_status where payment_status_id='{$id}'" ; 
        $res  = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_array($res) ; 
        return @ $data['payment_status_val'];  
    }
    function getRoomNumber($room){
        $query = "Select * from room where room_id='{$room}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data =  mysqli_fetch_assoc($res) ; 
        return @$data['room_number'] ; 
    }
    function getPrpoertyName($propertyId){
        $query = "Select * from property where property_id='{$propertyId}'" ; 
        $res = mysqli_query($this->connection , $query)   ; 
        $data = mysqli_fetch_array($res ); 
        return @$data['property_name'];
    }
    function getPropertyIdFromRoom($roomId){
        $query = "SELECT * from room where room_id='{$roomId}'" ;
        $res   = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_array($res) ; 
        return @$data['room_ref'] ; 
    }
    function getAfterTenDays($date){
        $endDate = date('Y-m-d', strtotime('+10 days', strtotime($date)));
        return $endDate;
    }
     /**
     * @param $startDate Payment StartDate 
     * @param $endDate Payment End
     * @param $electricity =0 
     * @param $booking
     * @param $room
     * This Init Function is used for first 
     * Payment Start @ booking Init
     */
    function paymentInit($startDate , $endDate , $period , $electricity , $room ,$booking , $rent ){
        $query = "Insert into booking_pay (booking_pay_startdate , booking_pay_enddate , 
        booking_pay_elec , booking_pay_room , booking_pay_ref , booking_pay_rent ,
         booking_pay_period)VALUES('{$startDate}' , '{$endDate}' , '{$electricity}' , '{$room}',
         '{$booking}' , '{$rent}' , '{$period}')" ; 
        // echo $query;
         $res = mysqli_query($this->connection , $query) ; 
         return $res ;
    }
    function getAllPaymentByBookingId($bookingId){
        $bookingId = mysqli_real_escape_string($this->connection , $bookingId) ; 
        $query = "Select * from booking_pay where booking_pay_ref='{$bookingId}' order by booking_pay_status" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $records = array();
        while($data = mysqli_fetch_array($res)){
            $paidFlag = $data['booking_pay_is_paid'] ; 
            $roomId = $data['booking_pay_room'] ; 
            $propertyId = $this->getPropertyIdFromRoom($roomId) ; 
            $bookingId = $data['booking_pay_ref'] ; 
            $roomNumber = $this->getRoomNumber($roomId) ; 
            $propertyName = $this->getPrpoertyName($propertyId) ;
            $flag = FALSE ; 
            if($paidFlag==1){
                $flag  =TRUE ; 
            }else{
                $flag = FALSE ; 
            }
            $electricity = $data['booking_pay_elec'] ; 
            $rent = $data['booking_pay_rent'] ; 
            $others = $data['booking_pay_others'] ;
            $fine = 0 ;  
            $total = $electricity + $others + $rent + $fine ;

            $item =array(
                "id"=>$data['booking_pay_id'] , 
                "time"=>$data['booking_pay_time'] , 
                "startdate"=>$data['booking_pay_startdate'] , 
                "enddate"=>$data['booking_pay_enddate']  , 
                "electricity"=>$data['booking_pay_elec']  ,
                "elecref"=>$data['booking_pay_elect_ref'] , 
                "rent"=>$data['booking_pay_rent'] , 
                "others"=>$data['booking_pay_others'] , 
                "status"=>$this->getBookingStatus( $data['booking_pay_status'] ), 
                "ispaid"=>$flag ,
                "submittedOn"=>$data['booking_pay_submitted_on'] , 
                "paymode"=>$data['booking_pay_mode'],
                "paymodeRef"=>$data['booking_pay_mode_ref'] , 
                 "room"=>"{$propertyName} {$roomNumber}" , 
                 "total"=>$total , 
                 "fine"=>$fine,
                 "dueDate"=>$this->getAfterTenDays($data['booking_pay_startdate']) 
                ) ; 
            array_push($records , $item);
        }
        return $records;
    }
    function getPaymentById($id){
         $query = "Select * from booking_pay  where booking_pay_id='{$id}'"  ; 
         $res = mysqli_query($this->connection , $query) ;
         $data = mysqli_fetch_array($res) ; 
         return $data;
    }
    function getPaymentsForBookings($bookingArray){
        var_dump($bookingArray) ; 
    }
    function isValidPayment($id){
        $id = mysqli_real_escape_string($this->connection , $id) ; 
        $query = "SELECT * from booking_pay where booking_pay_id='{$id}'" ; 
        $res = mysqli_query($this->connection , $query) ;
        $count = mysqli_num_rows($res) ; 
        if($count==1) return TRUE ; 
        return FALSE ; 
    }
    function isPaymentDue($id){
        $id = mysqli_real_escape_string($this->connection , $id) ; 
        $query = "SELECT * from booking_pay where booking_pay_id='{$id}' && booking_pay_is_paid='0'" ; 
        $res = mysqli_query($this->connection , $query) ;
        $count = mysqli_num_rows($res) ; 
        if($count==1) return TRUE ; 
        return FALSE ; 
    }
    function getPaymentToken($id){
        $t = time();
        $temp = mt_rand(10000 , 99999) ; 
        $temp = md5($temp) ; 
        $temp  = $temp ."/T/{$t}/" .  base64_encode($id) ;   
        return $temp ; 
    }
   
    function createUnsettledPayments($token , $amount , $id , $caretaker){
        $query = "INSERT into payments (payments_token , payments_amount , payments_ref , 
        payments_caretaker)VALUES('{$token}' ,'{$amount}' ,'{$id}' , '{$caretaker}')" ;
        $res = mysqli_query($this->connection , $query) ; 
        return $res ;  
    }
     /**
     * This submit payment for Caretaker App
     * @param $caretaker caretaker ID
     */
    function submitPayment($id ,$mode , $ref , $caretaker , $amount ){
        $timeStamp = date("Y-m-d h:m:s");
        $today =date("Y-m-d") ;
        $token = $this->getPaymentToken($id) ;  
        $id = mysqli_real_escape_string($this->connection , $id); 
        $query = "UPDATE booking_pay set booking_pay_mode='{$mode}' , 
        booking_pay_mode_ref='{$ref}' ,booking_pay_submitted_on='{$timeStamp}' ,
        booking_pay_submit_date='{$today}'  , booking_pay_is_paid='1' , booking_pay_status='2' , 
        booking_pay_token='{$token}'  WHERE booking_pay_id='{$id}'" ;
        // echo $query; 
        $res = mysqli_query($this->connection , $query) ; 
        $this->createUnsettledPayments($token ,$amount , $id , $caretaker);
        return $res ; 
    }

    function getPaymentHistory($id){
        $query = "SELECT * from booking_pay where booking_pay_id='{$id}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_array($res) ; 
        return $data;
    }
    function getPaymentData($id){
        $query = "SELECT * from payments where payments_ref='{$id}'" ; 
        $res = mysqli_query($this->connection  , $query) ; 
        $data = mysqli_fetch_assoc ($res);
        return $data ; 
    }

    function validatePaymentSettle($paymentId){
        $paymentId = mysqli_real_escape_string($this->connection , $paymentId) ; 
        $query = "SELECT * FROM payments where payments_id='{$paymentId}' && payments_status='0'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data  = mysqli_fetch_array($res) ; 
        return $data ; 
    }
    function isSettleDataPresent($id){
        $query = "SELECT * from  payments_settle WHERE payments_settle_ref='{$id}'" ; 
        $res  = mysqli_query($this->connection  , $query) ; 
        $count = mysqli_num_rows($res) ; 
        if($count ==1) return TRUE ; 
        return FALSE ; 
    }
    function insertSettleData($by , $mode , $paymentId){
        $paymentId = mysqli_real_escape_string($this->connection , $paymentId) ; 
        $mode = mysqli_real_escape_string($this->connection , $mode);
        if($this->isSettleDataPresent($paymentId)) return FALSE ; 
        $query = "INSERT INTO payments_settle (payments_settle_by , payments_settle_mode , payments_settle_ref)VALUES
        ('{$by}' , '{$mode}' , '{$paymentId}')" ;
        $res = mysqli_query($this->connection , $query) ; 
        return $res ;  
    }
    function markSettled($paymentId){
        $query = "UPDATE payments set payments_status='1' where payments_id='{$paymentId}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        return $res ; 
    }
    
    /**
     * Create UnSettledpayment  for ONLINE PAYMENT
     */
    function createUnsettledPaymentsForOnLine($token , $amount , $id ){
        $query = "INSERT into payments (payments_token , payments_amount , payments_ref , payments_mode)VALUES('{$token}' ,'{$amount}' ,'{$id}' , 'ONLINE')" ;
        echo $query;
        $res = mysqli_query($this->connection , $query) ; 
        return $res ;  
    }

    /**
     * This submit payment for Caretaker App
     * 
     */
    function submitPaymentOnline($id ,$mode , $ref ){
        $timeStamp = date("Y-m-d h:m:s");
        $today =date("Y-m-d") ;
        $token = $this->getPaymentToken($id) ;  
        $id = mysqli_real_escape_string($this->connection , $id); 
        $query = "UPDATE booking_pay set booking_pay_mode='{$mode}' , 
        booking_pay_mode_ref='{$ref}' ,booking_pay_submitted_on='{$timeStamp}' ,
        booking_pay_submit_date='{$today}'  , booking_pay_is_paid='1' , booking_pay_status='2' , 
        booking_pay_token='{$token}'  WHERE booking_pay_id='{$id}'" ;
        // echo $query; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = $this->getPaymentById($id) ; 
        $electricity = $data['booking_pay_elec'] ; 
        $rent = $data['booking_pay_rent'] ; 
        $others = $data['booking_pay_others'] ;
        $fine = 0 ;  /** TODO FINE SHOULD BE DYNAMIC  */ 
        $total = $electricity + $others + $rent + $fine ;
        $this->createUnsettledPaymentsForOnLine($token ,$total  , $id );
        return $res ; 
    }

    /**
     * Create payment history for user
     * table name payment_user_history
     */
    function createPaymentHistory($amount , $user ,$mode , $desc ){
        $query = "INSERT  into payment_user_history (payment_user_history_amount ,
         payment_user_history_mode , payment_user_history_desc , payment_user_history_user)
         VALUES('$amount' ,'{$mode}' ,'{$desc}' , '{$user}') " ;
         $res = mysqli_query($this->connection , $query) ; 
         return $res ; 
    }

    function getBookingForDateAndBooking($booking , $date){
        $query = "SELECT * from booking_pay where booking_pay_ref='{$booking}' && booking_pay_submit_date='{$date}' && booking_pay_is_paid='1'" ; 
        $res = mysqli_query($this->connection  , $query) ; 
        $records = array();
        while($data = mysqli_fetch_assoc($res)){
            array_push($records , $data) ; 
        }
        return $records  ;

    }


}
?>