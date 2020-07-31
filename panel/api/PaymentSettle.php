<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../model/Property.php";
require_once "../model/Payments.php";
require_once "../controller/Utils.php";
$response = array("error"=>true) ; 
class PaymentSettle{
    private $connection  , $property  ; 
    public $admin , $payment  ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
        $this->property = new Property();
        $this->payment = new Payments();

    }
    function isValidLogin($adminId  , $password){
        $adminPassword  = $this->admin->getAdminPassword($adminId) ; 
        $flag = $this->admin->validateHash($password , $adminPassword) ; 
        return $flag ; 
    }
    function insertData($admin , $mode , $payment){
        $flag = $this->payment->insertSettleData($admin , $mode , $payment) ; 
        return $flag ; 
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
    $object = new PaymentSettle();
    $flag = $object->admin->validateSession($authToken);
    if(!$flag){
        $response['error'] = true ;
        $response['msg'] = "Please refresh the page and try again" ; 
        $response['error-code'] = 908 ; //No Auth token found
        echo json_encode($response) ; 
        return;
    } 
    $SESSION_DATA  = $object->admin->sessionData($authToken) ; 
    //  var_dump($SESSION_DATA);
    @$adminId = $SESSION_DATA['admin_session_ref'] ; 
    // var_dump($_POST);
    /**
     * STEP VALIDATE PAYMENT ID
     * 
     */
    @$payment = $_POST['payment'] ; 
    if(empty($payment)){
        $response['error'] = true ;
        $response['msg'] = "Error required is missing" ; 
        $response['error-code'] = 101 ; //Required field is missing 
        echo json_encode($response) ; 
        return; 
    }
    @$password = $_POST['password'] ; 
    if(empty($password)){
        $response['error'] = true ;
        $response['msg'] = "Please enter password" ; 
        $response['error-code'] = 101 ; //Required field is missing 
        echo json_encode($response) ; 
        return; 
    }
    @$mode = $_POST['ref'] ; 
    if(empty($mode)){
        $response['error'] = true ;
        $response['msg'] = "Error required is missing" ; 
        $response['error-code'] = 101 ; //Required field is missing 
        echo json_encode($response) ; 
        return; 
    }
    $mode = "{$mode} , Settlement processed by FOD_PANEL_{$adminId} " ; 
    $flag = $object->isValidLogin($adminId , $password);
    // var_dump($flag);
    if(!$flag){
        $response['error'] = true ;
        $response['msg'] = "Auth failed , please enter valid password" ; 
        $response['error-code'] = 105 ; //Required field is missing 
        echo json_encode($response) ; 
        return;
    }
    
    $PAYMENT_DATA = $object->payment->validatePaymentSettle($payment);
    // var_dump($PAYMENT_DATA); 
    if(empty($PAYMENT_DATA) || $PAYMENT_DATA == null){
        $response['error'] =TRUE ; 
        $response['msg'] = "Error  , Invalid request for payment DATA" ; 
        $response['error-code'] = 101 ; //Required field is missing 
        echo json_encode($response) ; 
        return; 
    }

    $flag = $object->insertData($adminId , $mode , $payment) ; 
    // var_dump($flag);
    if($flag){
        $object->payment->markSettled($payment) ; 
        $response['error'] = FALSE ; 
        $response['msg'] = "Payment has been settled" ; 
        $response['error-code'] = 0; 
        echo json_encode($response) ; 
        return ;
    }


    

}else{

}
?>