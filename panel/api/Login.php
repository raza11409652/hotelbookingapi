<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../controller/Utils.php";
$resposne = array("error" =>true ) ;
session_start();
class Login{
    private $connection  ; 
    public $admin ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
    }
    function verify($password , $hashPassword){
        $flag = $this->admin->validateHash($password , $hashPassword)  ;
        return $flag;
    }

}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $object = new Login(); 
    $header = getallheaders();
    @$device = $header['User-Agent'];
    $device = "Login @ {$device}";
    // var_dump($object->admin);
    @ $email = $_POST['email'] ; 
    @ $password = $_POST['password']  ; 
    if(empty($email)){
        return ; 
    }
    if(empty($password)){
        return ; 
    }

    //validate email 
    if(!validEmail($email)){
        $resposne['error']  =true ; 
        $resposne['msg'] = "Not valid email" ; 
        $resposne['error-code'] = 909 ; 
        echo json_encode($resposne) ; 
        return ; 
    }
    //now validate is email is Valid ADmin
    $flag = $object->admin->isValidAdmin($email) ; 
    // var_dump($flag);
    if(!$flag){
        $resposne['error'] = true ; 
        $resposne['error-code'] = 404 ; 
        $resposne['msg'] = "Auth failed" ; 
        echo json_encode($resposne) ; 
        return;
    }
    /***
     * Check is Active Or not
     */
    $flag = $object->admin->isActiveAdmin($email) ; 
    // var_dump($flag);
    if(!$flag){
        $resposne['error'] = true ; 
        $resposne['error-code'] = 404 ; 
        $resposne['msg'] = "Auth failed, contact support for help" ; 
        echo json_encode($resposne) ; 
        return;
    }
    $adminData = $object->admin->getAdmin($email);
    $adminId = $adminData['admin_id'];
    $hashPassword = $object->admin->getAdminPassword($adminId) ; 
    // var_dump($hashPassword);
    $flag = $object->verify($password , $hashPassword) ; 
    // var_dump($flag);
    if($flag){
        $token = mt_rand(100000,9999999 ) ; 
        $temp = base64_encode($token)  ;
        $token = md5($token) ; 
        $token = "{$token}{$temp}";
        $object->admin->insertSession($adminId , $device , $token);
        $_SESSION['isLoggedIn'] =true  ; 
        $_SESSION['loggedInEmail'] = $email ; 
        $_SESSION['loggedInToken'] = $token;
        $resposne['token'] = $token;
        $resposne['error'] = false ; 
        $resposne['msg'] = "Login success" ;
        $resposne['error-code'] = 0;
        echo json_encode($resposne); 
    }else{
        $resposne['error'] = true ; 
        $resposne['error-code'] = 404 ; 
        $resposne['msg'] = "Auth failed, Invalid cradentials" ; 
        echo json_encode($resposne) ; 
        return;
    }


    

}else{
   
}
?>