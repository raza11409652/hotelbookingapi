<?php 
require_once "../../base_config/Connection.php";
require_once "../../panel/model/User.php";
require_once "../../panel/model/Bookings.php";
$response = array("error"=>true) ; 
class CheckUserStatus{
    private $connection , $ookings  ; 
    public $user ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->user = new User();
        $this->bookings = new Bookings();
    }
    function check($userUid){
        $flag = $this->user->isUserNew($userUid); 
        return $flag; 
    }
    function createUser($mobile , $uid){
        $flag = $this->user->createNewUser($uid , $mobile);
        return $flag;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $HEADERS = getallheaders();
    @$authToken = $HEADERS['auth-token'] ; 
    @$userUid = $HEADERS['client-token'];  // This will hold user uid
    @$mobile = $_POST['mobile'] ; 
    if(empty($userUid) || empty($mobile)){
        return ; 
    }
    $mobile = str_replace('+91','',$mobile);
    $object = new CheckUserStatus();
    $status = $object->check($userUid) ; 
    // var_dump($status);
    if($status){
        //create user
       $res =  $object->createUser($mobile , $userUid);
    //    var_dump($res);
        $response['error'] = false ; 
        $response['msg'] = "{$mobile} is created with {$userUid}" ; 
        $response['error-code'] =203 ; //old user
        echo json_encode($response) ;
        return ;
    }else{
        $response['error'] = false ; 
        $response['msg'] = "This is returning user" ; 
        $response['error-code'] =203 ; //old user
        echo json_encode($response) ;
        return ;
    }
    
}
?>