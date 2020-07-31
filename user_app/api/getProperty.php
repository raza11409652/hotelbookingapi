<?php 
require_once "../../base_config/Connection.php";
require_once "../utils/distance.php";
$response = array("error"=>true) ; 
class GetProperty{
    private $connection , $bookings  ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
    }
    function getPropertyType($type){
        $query = "SELECT * from property_type where property_type_id='{$type}'";
        $res = mysqli_query($this->connection , $query) ;
        $data = mysqli_fetch_assoc($res) ;
        return @$data['property_type_val'];
    }
    function getProperty($userlocation){
        $query = "SELECT * from property where property_status='1' order by property_name ";
        $res = mysqli_query($this->connection , $query) ;
        $response['records'] =array();
        while($data = mysqli_fetch_assoc($res)){
            // var_dump($data);
            $latitiude = $data['property_lat'] ; 
            $longitude =$data['property_long'];
            $propertyLocation = array($latitiude , $longitude);
            $distance  = distance($userlocation , $propertyLocation);
            // var_dump($distance);
            if($distance<30){
                $item =array("id"=>$data['property_id'] , 
                "uid"=>$data['property_uid'] ,
                "name"=>$data['property_name'] , 
                "lat"=>$data['property_lat'],
                "lng"=>$data['property_long'],
                "price"=>$data['property_price']  ,
                "address"=>$data['property_address'] , 
                "imgae"=>$data['property_cover_image'] ,
                "propertyType"=>$this->getPropertyType($data['property_type']),
                "type"=>$data['property_type']
                );
                array_push($response['records'] , $item);
            }

        }
        $response['error'] = false ; 
        $response['msg'] = sizeof($response['records']); 
        $response['error-code']=0; 
        echo json_encode($response);
    }

}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //This will require lat and lng
    @$latitiude = $_POST['latitude']; 
    @$longitude = $_POST['longitude'] ; 
    $object = new GetProperty();
    // var_dump($_POST);
    $userLocation =array($latitiude , $longitude) ;
    $object->getProperty($userLocation);


}
?>
