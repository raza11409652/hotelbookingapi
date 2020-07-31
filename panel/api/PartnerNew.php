<?php
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../model/Partner.php";
require_once "../controller/Utils.php";
$resposne = array("error" =>true ) ;
class PartnerNew{
    private $connection  ; 
    public $admin ,$partner ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
        $this->partner = new Partner();
    }
    function create($id , $uid , $name , $email , $mobile , $admin){
        $query = "Insert into partner (partner_id , partner_uid , partner_name , partner_email  , partner_mobile , partner_created_by)
        VALUES('{$id}' , '{$uid}' ,'{$name}' ,'{$email}' , '{$mobile}' , '{$admin}')" ; 
        // echo $query;
        $res = mysqli_query($this->connection , $query) ; 
        return $res ;
    }
    function savePassword($partner , $password){
        $query ="Insert into partner_login(partner_login_val , partner_login_ref) values
        ('{$password}' , '{$partner}')" ;
        $res = mysqli_query($this->connection , $query) ; 
        return $res ; 
    }
   
    
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $header = getallheaders() ; 
    @$authToken = $header['auth-token'] ; 
    // var_dump($authToken);
    if(empty($authToken) || $authToken ==null){
        $response['error'] = true ;
        $response['msg'] = "Please refresh the page and try again" ; 
        $response['error-code'] = 908 ; //No Auth token found
        echo json_encode($response) ; 
        return;
    }
    $object =new PartnerNew();
    if(!$object->admin->validateSession($authToken)){
        $response['error'] = true ;
        $response['msg'] = "Please refresh the page and try again" ; 
        $response['error-code'] = 908 ; //No auth-token not valid
        echo json_encode($response) ; 
        return;
    }
    $admin = $object->admin->getIdFromToken($authToken) ; 
    // var_dump($admin);
    @$adminId = $admin['admin_session_ref'];
    @$mobile = $_POST['mobile'] ; 
    @$name = $_POST['name'] ; 
    @$email = $_POST['email'];


    if(empty($mobile)){
        $response['error'] = true ;
        $response['msg'] = "Mobile number required" ; 
        $response['error-code'] = 101 ; //mobile number required
        echo json_encode($response) ; 
        return; 
    }

    if(empty($name)){
        $response['error'] = true ;
        $response['msg'] = "Name required" ; 
        $response['error-code'] = 101 ; //mobile number required
        echo json_encode($response) ; 
        return; 
    }
    if(empty($email)){
        $response['error'] = true ;
        $response['msg'] = "Email required" ; 
        $response['error-code'] = 101 ; //mobile number required
        echo json_encode($response) ; 
        return;
    }
    if(!validMobile($mobile)){
        $response['error'] = true ;
        $response['msg'] = "Mobile number invalid" ; 
        $response['error-code'] = 102; //Only indian Mobile number
        echo json_encode($response) ; 
        return; 
    }
    if(!validName($name)){
      
        $response['error'] = true ;
        $response['msg'] = "Name invalid" ; 
        $response['error-code'] = 102; //Name is invalid 
        echo json_encode($response) ; 
        return; 
    }
    if(!validEmail($email)){
        $response['error'] = true ;
        $response['msg'] = "Email is invalid" ; 
        $response['error-code'] = 102; //Email is invalid
        echo json_encode($response) ; 
        return; 
    }

    /**
     * check if mobile number is used
     * is email userd
     */
    $flag = $object->partner->isMobileUsed($mobile) ; 
    if($flag){
        $response['error'] = true ;
        $response['msg'] = "{$mobile} is already registered" ; 
        $response['error-code'] = 103; //Email is invalid
        echo json_encode($response) ; 
        return; 
    }
    $flag = $object->partner->isEmailUsed($email) ; 
    
    if($flag){
        $response['error'] = true ;
        $response['msg'] = "{$email} is already registered" ; 
        $response['error-code'] = 103; //Email is invalid
        echo json_encode($response) ; 
        return; 
    }
    $partnerId = $object->partner->getMaxId();
    // var_dump($partnerId);
    $uid  = $object->partner->generateUID($partnerId , $name);
    $flag = $object->create($partnerId , $uid , $name , $email , $mobile , $adminId);
   
    $password =$object->partner->generateNewPassword() ; 
    // var_dump($password);
    $hashPassword =  $object->partner->hashStrBcrypt($password);
    // var_dump($hashPassword);
    if(!$flag){
        return ; 
    }
    $flag = $object->savePassword($partnerId , $hashPassword) ; 
    if($flag){
        $response['error'] =false ; 
        $response['msg'] = "{$name} has been created with UID {$uid}" ; 
        $response['error-code'] = 0; 
        echo json_encode($response) ;
        return;
    }
    
}else{
    
}

?>