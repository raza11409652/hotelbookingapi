<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../controller/Utils.php";
$resposne = array("error" =>true ) ;
class Reset{
    private $connection  ; 
    public $admin ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
    }


}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // var_dump($_POST);
    @ $email =   $_POST['email'] ;
    if(empty($email)){
        $resposne['error'] = true ;
        $resposne['msg']  = "Email is required" ; 
        $resposne['error-code'] = 101;
        echo json_encode($resposne);
        return ; 
    }
    $object = new Reset(); 
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

    $adminData = $object->admin->getAdmin($email) ; 
    // var_dump($adminData);
    @$adminID = $adminData['admin_id'] ; 
    //FOR PRODUCTION
    // $token = mt_rand(100000, 999999);
    $token = "123456"; // FOR DEVELOPMENT

    $flag = $object->admin->insertToken($adminID , $token) ; 
    if($flag){
        //OTP Token should be sent to registered mobile number
        $resposne['email'] = $email ; 
        $resposne['uid'] = $adminData['admin_uid'];
        $resposne['error'] = false ; 
        $resposne['msg'] = "OTP has been sent to your email {$email}" ;
        $resposne['error-code'] = 0;
        echo json_encode($resposne) ; 
        return; 
    }


}else{

}
?>