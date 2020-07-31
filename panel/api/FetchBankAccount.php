<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../model/Property.php";
require_once "../controller/Utils.php";
$response = array("error"=>true) ; 
class FetchBankAccount{
    private $connection  , $property  ; 
    public $admin  ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
        $this->property = new Property();
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $header = getallheaders() ; 
    @$authToken = $header['auth-token'] ; 
    if(empty($authToken)){
        $response['error'] = true ; 
        $response['msg'] = "Please refresh page and try again" ; 
        echo json_encode($response);
        return;  
    }
    $object = new FetchBankAccount() ; 
    $flag = $object->admin->validateSession($authToken) ; 
    if(!$flag){
        $response['error'] = true ; 
        $response['msg'] = "Please refresh page and try again" ; 
        echo json_encode($response);
        // return; 
        return ; 
    }
    @$property  = $_POST['property'] ; 
    if(empty($partner)){
        return; 
    }



}else{
    //No GET METHOD IS PERMISSABLE
}
?>