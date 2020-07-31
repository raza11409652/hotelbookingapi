<?php 
require_once "../../base_config/Connection.php";
require "../../razorpay/verifypayment.php";
require_once "../../panel/model/User.php";
require_once "../../panel/model/Bookings.php";
require_once "../../panel/model/Payments.php";
/**
 * This end point is  
 */
class UpdatePaymentStatus{
    public $verifyPayment; 
    private $connection , $payment; 
    public $user,$bookings ; 
    function __construct(){
        $this->verifyPayment = new VerifyPayment();
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->user = new User();
        $this->bookings = new Bookings();
        $this->payment  = new Payments();
       }
       function isValidPayment($paymentID){
           $flag = $this->payment->isValidPayment($paymentID) ; 
           return $flag; 
        }
        function isDue($paymentID){
            $flag = $this->payment->isPaymentDue($paymentID) ; 
            return $flag;
        }
        function submit($id  , $mode , $ref){
            $flag = $this->payment->submitPaymentOnline($id , $mode , $ref); 
            var_dump($flag);
        }

}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    /**
     * User session verification
     */
    @$razoprPayPaymentId =$_POST['razor_pay_payment_id'] ;
    @$paymentID =  $_POST['payment'] ; 
    $paymentMode = $razoprPayPaymentId ; 
    $paymentModeRef = "RAZORPAY Payment Interface" ; 
    if(empty($razoprPayPaymentId)){
        $response['error'] = TRUE ; 
        $response['msg'] = "Razorpay payment error" ; 
        $response['error-code']=707 ; 
        echo json_encode($response) ; 
        return  ; 
    } 
    if(empty($paymentID)){
        $response['error'] = TRUE ; 
        $response['msg'] = "Required parameter is missing" ; 
        $response['error-code']=707 ; 
        echo json_encode($response) ; 
        return  ; 
    }


    $object = new UpdatePaymentStatus();
    /**
     * Validate Payment ID
     */
    $flag = $object->isValidPayment($paymentID);
    if(!$flag){
        $response['error'] = TRUE ; 
        $response['msg'] = "Payment data error" ; 
        $response['error-code']=707 ; 
        echo json_encode($response) ; 
        return  ; 
    }
    $flag = $object->isDue($paymentID) ; 
    if(!$flag){
        $response['error'] = TRUE ; 
        $response['msg'] = "Payment data error , payment is already paid" ; 
        $response['error-code']=707 ; 
        echo json_encode($response) ; 
        return  ;  
    }
    /**
     * Validate Payment from Razorpay Server
     */
    $flag = $object->verifyPayment->isPaymentFailed($razoprPayPaymentId) ;

    // var_dump($flag);
    if($flag){
        $response['error'] = TRUE ; 
        $response['msg'] = "Razorpay Payment Server marked this payment as failed" ; 
        $response['error-code']=709 ; 
        echo json_encode($response) ; 
        return  ;  
    }
    $PAYMENTDATA = $object->verifyPayment->getPaymentData($razoprPayPaymentId);
    $paymentModeRef = "{$paymentModeRef} , {$PAYMENTDATA}";
    // var_dump($paymentModeRef);
    $flag = $object->submit($paymentID , $paymentMode , $paymentModeRef);
    


}else{

}
?>