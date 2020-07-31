<?php 
require_once "../../base_config/Connection.php";
require_once "../../panel/model/User.php";
require_once "../../panel/controller/Utils.php";
require_once "../../panel/model/Wishlist.php";
require_once "../../panel/model/Property.php";
$response = array("error"=>true) ;
class SearchProperty{
    private $connection ,$wishlist  , $property  ; 
    public $user ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->user = new User();
        $this->property = new Property();
        $this->wishlist = new Wishlist();
    }
    function getproperty($location , $nearby , $userUid){
        $query ="SELECT * from property where property_status='1' &&
         property_address LIKE '%$location%' OR property_address LIKE '%{$nearby}%' ";
        $res = mysqli_query($this->connection , $query) ; 
        // echo    $query ; 
        $response['records'] =array() ; 
        $USERDATA = $this->user->getUserDataByUid($userUid) ; 
        $userId = @$USERDATA['user_id']; 
        while($data = mysqli_fetch_assoc($res)){
            // var_dump($data);
            $propertyName = $data['property_name'] ; 
            $propertyImage = $data['property_cover_image'] ; 
            //getTotal number of room 
            $propertyPrice= $data['property_price']; 
            $propertyId = $data['property_id'] ;
            $totalRoom =$this->property->gettotalvacant($propertyId);   
            $mapped = $this->wishlist->isPropertyMapped($propertyId , $userId)  ; 
            $propertyTypeId = $data['property_type']  ; 
            $item =array(
            "id"=> $propertyId  , 
            "name"=>$propertyName , 
            "price"=>$propertyPrice ,
            "image" =>$propertyImage , 
            "mapped"=>$mapped , "room"=>$totalRoom , 
            "address" =>$data['property_address'] , 
            "type" =>$this->property->getPropertyType($propertyId),
            "lat" =>$data['property_lat'] ,
            "lng"=>$data['property_long']
            ) ;
            array_push($response['records'] , $item) ; 

        }
        $response['error'] = false ; 
        $response['msg'] = sizeof($response['records']) .  " Property found at {$location}";
        echo json_encode($response);

        return ; 
    }

}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $HEADERS = getallheaders();
    @$authToken = $HEADERS['auth-token'] ; 
    // @$userUid = $HEADERS['client-token']; 
    @$location = $_POST['location'] ; 
    @$nearby = $_POST['nearby'] ; 
    if(empty($authToken)){
        return ; 
    }
    if(empty($location)){
        $response['error'] = true ; 
        $response['msg'] = "query parameter missing" ; 
        echo json_encode($response);  
        return ; 
    }

    $obj = new SearchProperty();
    $obj->getproperty($location , $nearby , $authToken) ; 



}else{

}
?>