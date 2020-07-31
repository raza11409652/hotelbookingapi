<?php
/**
 * Validate payment
 */
function isValidPayment($id , $connection){
    $id = mysqli_real_escape_string($connection , $id) ; 
    $query = "SELECT * from booking_pay where booking_pay_id='{$id}' && booking_pay_is_paid='0'" ; 
    $res = mysqli_query($connection , $query) ;
    $count = mysqli_num_rows($res) ; 
    // echo $query;
    // echo $count;
    if($count==1) return TRUE ; 
    return FALSE ; 
}
/**
 * Create UnSettledpayment  for ONLINE PAYMENT
 */
function createUnsettledPaymentsForOnLine($token , $amount , $id , $connection ){
    $query = "INSERT into payments (payments_token , payments_amount , payments_ref , payments_mode)VALUES('{$token}' ,'{$amount}' ,'{$id}' , 'ONLINE')" ;
    // echo $query;
    $res = mysqli_query($connection , $query) ; 
    return $res ;  
}
/**
 * Payment token
 */
function getPaymentToken($id){
    $t = time();
    $temp = mt_rand(10000 , 99999) ; 
    $temp = md5($temp) ; 
    $temp  = $temp ."/T/{$t}/" .  base64_encode($id) ;   
    return $temp ; 
}
function getbookingPayData($id  ,$connection){
    $query= "SELECT * from booking_pay where booking_pay_id='{$id}'";
    $res = mysqli_query($connection , $query);
    $data  = mysqli_fetch_assoc($res);
    return $data;
}

/**
 * Submit online
 */
function submitPaymentOnline($id ,$mode , $ref , $connection ){
    $timeStamp = date("Y-m-d h:m:s");
    $today =date("Y-m-d") ;
    $token = getPaymentToken($id) ;  
    $id = mysqli_real_escape_string($connection , $id); 
    $query = "UPDATE booking_pay set booking_pay_mode='{$mode}' , 
    booking_pay_mode_ref='{$ref}' ,booking_pay_submitted_on='{$timeStamp}' ,
    booking_pay_submit_date='{$today}'  , booking_pay_is_paid='1' , booking_pay_status='2' , 
    booking_pay_token='{$token}'  WHERE booking_pay_id='{$id}'" ;
    // echo $query; 
    $res = mysqli_query($connection , $query) ; 
    $data = getbookingPayData($id , $connection) ; 
    $electricity = $data['booking_pay_elec'] ; 
    $rent = $data['booking_pay_rent'] ; 
    $others = $data['booking_pay_others'] ;
    $fine = 0 ;  /** TODO FINE SHOULD BE DYNAMIC  */ 
    $total = $electricity + $others + $rent + $fine ;
    createUnsettledPaymentsForOnLine($token ,$total  , $id  ,$connection);
    return $res ; 
}

?>