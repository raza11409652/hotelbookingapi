<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../model/Property.php";
require_once "../model/Caretaker.php";
require_once "../controller/Utils.php";
$response = array("error"=>true) ; 
class RevokeAccessCaretaker{
    private $connection  , $property  ; 
    public $admin , $caretaker  ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection=$conn->getConnect();
        $this->admin = new Admin();
        $this->property = new Property();
        $this->caretaker = new Caretaker();
    }
    function revoke($property , $caretaker){
        $flag = $this->caretaker->mappingRevoke($property , $caretaker) ; 
        return $flag;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $headers  = getallheaders() ; 
    @$authToken = $headers['auth-token'] ; 
    if(empty($authToken)){
        $response['error']  = true ; 
        $response['msg'] = "Auth token not found" ; 
        echo json_encode($response) ; 
        return ; 
    }
    $object  = new RevokeAccessCaretaker(); 
    $flag = $object->admin->validateSession($authToken) ; 
    // var_dump($flag);
    if(!$flag){
        $response['error'] = true ; 
        $response['msg'] = "Please refresh the page and try again" ;
        echo json_encode($response)  ; 
        return ;  
    }
    @$admin = $object->admin->getIdFromToken($authToken) ; 
    $adminId = $admin['admin_session_ref'] ; 
    if(empty($adminId)) return ; 
    @$property = $_POST['property'] ; 
    @$caretaker = $_POST['caretaker'] ; 
    if(empty($property) || empty($caretaker)) return  ;
    // var_dump($adminId);
    $flag = $object->revoke($property , $caretaker);
    //  var_dump($flag);
    if($flag){
        $response['error'] = false ; 
        $response['msg'] = "Caretaker mapping revoke successfull" ; 
        echo json_encode($response) ; 
        return ; 
    }else{
        $response['error'] = TRUE ; 
        $response['msg'] = "Caretaker mapping failed" ; 
        echo json_encode($response) ; 
        return ;
    }

}else{

}
?>