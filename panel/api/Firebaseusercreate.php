<?php 
require_once "../model/Admin.php";
require_once "../model/User.php";
require_once "../../base_config/Connection.php";
require_once "../firebase/api/createuser.php";
require_once "../controller/Utils.php";
$response = array("error"=>false);
class FirebaseUserCreate{
    public $admin  , $user; 
    private $connection  , $usercreate; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->usercreate = new UserCreation() ;
        $this->admin = new Admin();
        $this->user=new User(); 
    }
    function create($mobile , $email){
        $response = $this->usercreate->createuserByMobileEmail($mobile , $email) ; 
        return $response ; 
    }
    function insertnewuser($uid , $mobile , $email , $name , $father){
        $query = "Insert into user (user_uid , user_phone , user_email , 
        user_name , user_father)values('{$uid}' ,'{$mobile}' ,'{$email}' ,
        '{$name}' ,'{$father}')" ;
        $res = mysqli_query($this->connection , $query) ; 
        return $res ;  
    }




    



}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //  var_dump($_POST);
    $header = getallheaders() ; 
    @$authToken = $header['auth-token'] ;

    if(empty($authToken) || $authToken ==null){
        $response['error'] = true ;
        $response['msg'] = "Please refresh the page and try again" ; 
        $response['error-code'] = 908 ; //No Auth token found
        echo json_encode($response) ; 
        return;
    }

    $obj = new FirebaseUserCreate() ; 

    if(!$obj->admin->validateSession($authToken)){
        $response['error'] = true ;
        $response['msg'] = "Please refresh the page and try again" ; 
        $response['error-code'] = 909 ; // auth-token not valid
        echo json_encode($response) ; 
        return;
    }

    @$email = $_POST['email'] ; 
    @$name  =$_POST['name'] ; 
    @$father = $_POST['father'] ; 
    @$mobile = $_POST['mobile'] ; 
    
    if(empty($mobile)){
        //mobile number is required
        $response['error'] = true ; 
        $response['msg'] = "Mobile number is required";
        echo json_encode($response);
        return ; 
    }
    if(empty($email)){
        $response['error'] = true ; 
        $response['msg'] = "User email is required";
        echo json_encode($response);
        return ; 
    }
    if(empty($name)){
        $response['error'] = true ; 
        $response['msg'] ="User name is required" ; 
        echo json_encode($response)  ;
        return ; 
    }
    if(empty($father)){
        $response['error'] = true ; 
        $response['msg'] = "Father name Or C/O required" ; 
        echo json_encode($response)  ;
        return ; 
    }

    //Required

    if($obj->user->_isemailused($email)){
        $response['error'] = true ; 
        $response['msg'] ="Email is already used" ; 
        echo json_encode($response) ; 
        return ; 
    }
    if(!validMobile($mobile))  {
        //Only Indian mobile number is allowed
        $response['error'] = true ; 
        $response['msg'] = "Only indian mobile number is allowed";
        echo json_encode($response);
        return ;
    }
    //now add country code +91 to mobile
    $mobilewithstd = "+91{$mobile}";
   
    $response = $obj->create($mobilewithstd , $email) ; 
    $error = $response['error'] ; 
    if($error){
        echo json_encode($response)  ;
        return ; 
    }
    $uid = $response['uid'] ; 
    // var_dump($uid);
    $flag = $obj->insertnewuser($uid , $mobile ,$email ,$name ,$father) ; 
    if($flag){
        $response['error'] = false ; 
        $response['msg'] = "User has been created" ; 
        echo json_encode($response ) ;
        return ; 
    }


        $response['error'] = true ; 
        $response['msg'] = "Data base erro" ; 
        echo json_encode($response ) ;
        return ; 

    return ; 



}else{
$response['error'] = true ; 
$response['msg'] ="No Get Method Found";
echo json_encode($response) ; 
return ; 
}
?>