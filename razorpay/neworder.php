<?php
require '../vendor/autoload.php';
require '../base_config/Config.php';
use Razorpay\Api\Api;

$api = new Api(RAZOR_PAY_API_KEY, RAZOR_PAY_SECRET_TOKEN);

// var_dump($_POST);
$response =array("error"=>TRUE) ;
@$orderId = $_POST['orderId'];
@$amount = $_POST['amount'];
if(empty($orderId)|| empty($amount)) {
    $response['error'] =true ; 
    $response['msg'] = "Error during payment init from server side" ; 
    echo json_encode($response) ; 
    return ; 
} ; 
$order = $api->order->create(array(
    'receipt' => $orderId,
    'amount' => $amount,
    'payment_capture' => 1,
    'currency' => 'INR'
));
$orderId = $order->id ; 
$response['error'] =false ; 
$response['RAZORPAY_ORDER_TOKEN'] = $orderId ; 
echo json_encode($response) ; 
return ; 


?>