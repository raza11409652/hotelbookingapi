<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../model/Property.php";
require_once "../model/Caretaker.php";
require_once "../controller/Utils.php";
$response = array("error"=>true) ; 
class NewCareTaker{
    private $connection  , $property  ; 
    public $admin , $caretaker  ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection=$conn->getConnect();
        $this->admin = new Admin();
        $this->property = new Property();
        $this->caretaker = new Caretaker();
    }
    function caretakerRegistration($name , $email , $mobile , $id ,$password){
        $flag = $this->caretaker->newcaretaker($mobile ,$email , $name , $id) ; 
        if($flag){
            //NEW Password
            $flag = $this->caretaker->insertpassword($password , $id);  
        }
        return $flag ; 
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $headers = getallheaders() ; 
    @$authToken = $headers['auth-token'] ; 
    if(empty($authToken)){
        $response['error'] = true ; 
        $response['msg'] = "Auth failed" ; 
        echo json_encode($response) ; 
        return ; 
    }

    $object  =new NewCareTaker() ; 
    $flag  =$object->admin->validateSession($authToken) ; 
    // var_dump($flag);
    if(!$flag){
        $response['error'] = true ; 
        $response['msg'] = "Auth failed , Please refresh the page" ; 
        echo json_encode($response) ; 
        return ;
    }
    @$name = $_POST['name'] ; 
    @$email = $_POST['email'] ; 
    @$mobile = $_POST['mobile'] ;
    if(empty($name)){
        $response['error'] = true ; 
        $response['msg'] = "Name is required" ; 
        echo json_encode($response) ; 
        return ; 
    }
    if(!validName($name)){
        $response['error'] = true ; 
        $response['msg'] = "Name is invalid" ; 
        echo json_encode($response) ; 
        return ; 
    }
    if(empty($mobile)){
        $response['error'] = true ; 
        $response['msg'] = "Mobile is required" ; 
        echo json_encode($response) ; 
        return ;
    }
    if(!validMobile($mobile)){
        $response['error'] = true ; 
        $response['msg'] = "Only indain mobile number is allowed" ; 
        echo json_encode($response) ; 
        return ;
    }
    if($object->caretaker->ismobileused($mobile)){
        $response['error'] = true ; 
        $response['msg'] = "{$mobile} is already used" ; 
        echo json_encode($response) ; 
        return ;
    }
    /**
     * After successful registration 
     * generate new password for User and 
     * Send to user mobile number
     **/
    $id = $object->caretaker->getMaxId(); 
    $password = $object->caretaker->newpassword();
    $hashpassword =$object->caretaker->hashStrBcrypt($password) ; 
    $flag = $object->caretakerRegistration($name ,$email , $mobile ,$id , $hashpassword) ; 
    // var_dump($flag);
    if($flag){
        //SEND MSG to $mobile
        $msg ="Hello, {$name} your mobile number {$mobile} is successfully registred with FOD Care app your login password is  {$password}" ; 
        $response['error'] = false ;
        $response['msg'] = "{$msg}" ;
        echo json_encode($response) ; 
        return ;   
        
    }else{
        //Error while communicating with Server
    }


    




}
?>