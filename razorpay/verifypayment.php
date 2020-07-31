<?php 
require '../../vendor/autoload.php';
use Razorpay\Api\Api;
use Razorpay\Api\Errors\BadRequestError ;
// $api_key = "rzp_test_WUdRvYwRyXmnJs" ;
// $api_secret = "9QaTJ2nHITqGfYm4ADTH3jpP";
// $api = new Api($api_key, $api_secret);
// $payment = $api->payment->fetch("pay_EsnwPN3PbIutFP");
// @$payment_method = $payment->method ; 
// @$bank = $payment->bank ; 
// // var_dump($payment_method);  
// var_dump($payment);
// $error_code = $payment->error_code;
// if($error_code==null  ){
//     echo "Payment SUCCESS {$payment_method } {$bank}";
// }
class VerifyPayment{
    private $api  ;
   function __construct(){
    $this->api = new Api(RAZOR_PAY_API_KEY, RAZOR_PAY_SECRET_TOKEN);
   }
   function isPaymentIdExist($paymentId){
       try{
        @$payment = $this->api->payment->fetch($paymentId);
        return true ; 
       }catch(BadRequestError $e){
           return false ; 
       }
       return false ; 
   }
   function isPaymentFailed($paymentId){
     $flag = $this->isPaymentIdExist($paymentId);
     if($flag){
        @$payment = $this->api->payment->fetch($paymentId);
        $error_code = $payment->error_code;
        // var_dump($error_code);
        if($error_code == null) return false ; 
        return true ;
     }
     return true ; 
   }
   function getPaymentData($paymentId){
     @$payment = $this->api->payment->fetch($paymentId);
    //  var_dump($payment);
     @$bank = $payment->bank ;
     @$payment_method = $payment->method  ; 
     return "{$bank} {$payment_method}" ; 
   }
}
?>