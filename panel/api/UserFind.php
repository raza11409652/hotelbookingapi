<?php
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../controller/Utils.php";
$response =array("error"=>true);
class UserFind{
    private $connection  ; 
    public $admin ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
    }
    function finduser($mobilenumber){
        $response['records']=array(); 
        $response['error'] =false ; 
        $response['msg'] = "Found data" ; 
        $query ="Select * from user where user_phone LIKE '%{$mobilenumber}%'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        while($data = mysqli_fetch_array($res)){
            // var_dump($data);
            $item = array("id"=>$data['user_id'] , 
            "uid"=>$data['user_uid'] , "name"=>$data['user_name'] , 
            "mobile"=>$data['user_phone']) ;
            array_push($response['records'] , $item) ;  
        }
        echo json_encode($response);
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $header = getallheaders() ; 
    @$authToken = $header['auth-token'] ; 
    //  var_dump($_POST);
    // var_dump($authToken);
    if(empty($authToken) || $authToken ==null){
        $response['error'] = true ;
        $response['msg'] = "Please refresh the page and try again" ; 
        $response['error-code'] = 908 ; //No Auth token found
        echo json_encode($response) ; 
        return;
    }

    // var_dump($_POST);
    $mobilenumber = $_POST['mobile'] ; 
    if(empty($mobilenumber)) {
        $response['error'] = true ;
        $response['msg'] = "Mobile number required" ; 
        // $response['error-code'] = 908 ; //No Auth token found
        echo json_encode($response) ; 
        return;
    }

    $obj =new UserFind() ; 
    $obj->finduser($mobilenumber);




    
}else{

}

?>