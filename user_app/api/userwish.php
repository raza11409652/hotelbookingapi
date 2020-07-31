<?php 
require_once "../../base_config/Connection.php";
require_once "../../panel/model/User.php";
require_once "../../panel/controller/Utils.php";
require_once "../../panel/model/Wishlist.php";
require_once "../../panel/model/Property.php";
$response = array("error"=>true) ;
class UserWish{
    private $connection ,$wishlist  , $property  ; 
    public $user ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->user = new User();
        $this->property = new Property();
        $this->wishlist = new Wishlist();
    }
    function toggle($property , $userUid){
        $userData = $this->user->getUserDataByUid($userUid) ; 
        $userId = @$userData['user_id'] ; 
        $flag = $this->wishlist->wishlistToggle($property , $userId) ;
        // var_dump($flag);
        if($flag){
            $response['error'] = FALSE ; 
            $response['msg'] = "Wishlist modified" ; 
            echo json_encode($response); 
            return ; 
        }

            $response['error'] = TRUE ; 
            $response['msg'] = "Error while handling request" ; 
            echo json_encode($response); 
            return ; 
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $HEADERS = getallheaders();
    @$authToken = $HEADERS['auth-token'] ; 
    @$property = $_POST['property'] ; 
    @$status = $_POST['status'] ; 
    // var_dump($_POST);

    if(empty($authToken)){
        return ; 
    }
    if(empty($property)) {
        return ; 
    }
    $obj = new UserWish(); 
    $obj->toggle($property , $authToken);



}else{
    
}
?>