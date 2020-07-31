<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../controller/Utils.php";
$response =array("error"=>true);
class GetProperty{
    private $connection  ; 
    public $admin ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
    } 
    function getproperty($str){
        $query = "Select * from property where property_name LIKE '%$str%' OR property_uid LIKE '%$str%'" ;
        $res = mysqli_query($this->connection , $query) ; 
        $response['records']  =array() ;
        while($data = mysqli_fetch_array($res)) {
            // var_dump($data);
            $item= array("id"=>$data['property_id'] , 
            "uid"=>$data['property_uid'] , 
            "name"=>$data['property_name']) ;
            array_push($response['records'] , $item) ;  
        } 
        $response['error'] = false   ; 
        $response['msg'] = "Property found";
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
    @$str = $_POST['property'] ; 
    if(empty($str)){
        return ; 
    }
    $obj = new GetProperty() ; 
    $obj->getproperty($str);


}
?>