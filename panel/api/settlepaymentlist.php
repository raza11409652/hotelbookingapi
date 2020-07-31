<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../model/Property.php";
require_once "../controller/Utils.php";
require_once "../model/Payments.php";
$response = array("error"=>true) ; 
class Settlepaymentlist{
    private $connection  , $property  ; 
    public $admin , $payment  ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
        $this->property = new Property();
        $this->payment = new Payments();
    }
    function isValidLogin($adminId , $password){
        $adminPassword  = $this->admin->getAdminPassword($adminId) ; 
        $flag = $this->admin->validateHash($password , $adminPassword) ; 
        return $flag ; 
    }
    function insertData($admin , $mode , $payment){
        $flag = $this->payment->insertSettleData($admin , $mode , $payment) ; 
            $this->payment->markSettled($payment) ; 
        return $flag ; 
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $headers = getallheaders( ) ;
   //  var_dump($headers);
       @$authToken = $headers['auth-token'] ; 
       if(empty($authToken)){
           $response['error'] = true ; 
           $response['msg'] = "Invalid request please refresh page and try again" ; //
           echo json_encode($response) ; 
           return ; 
       }

    $object = new Settlepaymentlist() ; 
    $flag = $object->admin->validateSession($authToken) ; 
    if(!$flag){
        $response['error'] = true ; 
        $response['msg'] = "Invalid request please refresh page and try again" ; //
        echo json_encode($response) ; 
        return ; 
    }
   @$remarks = $_POST['remarks'] ;
   @$payment = $_POST['paymentId'] ; 
   $password = $_POST['password'] ; 
   if(empty($password)){
    $response['error'] = TRUE ; 
    $response['msg'] = "Please enter password"  ;
    echo json_encode($response);
    return ; 
   }
   $SESSION_DATA  = $object->admin->sessionData($authToken) ; 
   //  var_dump($SESSION_DATA);
   @$adminId = $SESSION_DATA['admin_session_ref'] ; 
   $flag = $object->isValidLogin($adminId , $password);
   if(!$flag){
    $response['error'] = TRUE ; 
    $response['msg'] = "Auth failed , please enter valid password"  ;
    echo json_encode($response);
    return ; 
   }
   if(empty($payment)){
       $response['error'] = TRUE ; 
       $response['msg'] = "Please select atleast one payment"  ;
       echo json_encode($response);
       return ; 
   }
   $index = 0 ; 
   $total  = sizeof($payment) ; 
   foreach($payment as $a =>$id){
        $paymentId = $id ; 
        $remarksSingle =$remarks[$index] . " , Settlement processed by FOD_PANEL_{$adminId}"; 
        $object->insertData($adminId ,$remarksSingle ,$paymentId) ; 
    $index ++ ;
   }
   if($index == $total){
    $response['error'] = FALSE ; 
    $response['msg'] = "{$total} payment has been settled"  ;
    echo json_encode($response);
    return ;
   }



}else{


}

?>