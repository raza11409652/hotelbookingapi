<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../controller/Utils.php";
require_once "../model/Property.php";
$response =array("error"=>true);
class GetVacantRoomByUid{
    private $connection  ; 
    public $admin , $property ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
        $this->property = new Property();
    }
    function getVacantRoom($propertyData){
        $propertyId  = $propertyData['property_id'] ; 
        // var_dump($propertyId);
        $propertyName = $propertyData['property_name'] ;
        $price = $propertyData['property_price'] ;  
        $query = "Select * from room where room_ref='{$propertyId}'" ; 
        $res  = mysqli_query($this->connection , $query); 
        $response['records'] =array() ; 
        while($data = mysqli_fetch_array($res)){
            $item = array("id"=>$data['room_id'] , "status"=>$data['room_is_vacant'] ,
            "number"=>$data['room_number'] ) ;
            array_push($response['records'] , $item); 
        }
        $response['price'] = $price; 
        $response['property'] = $propertyName;
        $response['error'] =false ; 
        $response['msg']  = "Found data";
        echo json_encode($response);
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // var_dump($_POST);
    @$uid = $_POST['propertyuid'] ; 
    if(empty($uid)){
        $response['error'] = true ; 
        $response['msg'] = "/Get Property UID " ; 
        echo json_encode($response);
        return ; 
    }
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
    $obj = new GetVacantRoomByUid() ; 
    $propertyData = $obj->property->getPropertyByUid($uid) ;
    if(empty($propertyData)){
        $response['error'] = true ; 
        $response['msg'] = "Not valid Property UID" ; 
        echo json_encode($response);
        return;
    } 
    // var_dump($propertyData);
    $obj->getVacantRoom($propertyData);


}else{
    
}
?>