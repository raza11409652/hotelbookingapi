<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../model/Property.php";
require_once "../controller/Utils.php";
$response = array("error"=>true) ; 
class BookingSearch{
    private $connection  , $property  ; 
    public $admin  ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
        $this->property = new Property();
    }
    function getRoom($id){
        $query = "Select * from room where room_id='{$id}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_array($res) ; 
        return $data['room_number'];
    }

    function search($str){
        $query = "Select * from booking where booking_number LIKE '%{$str}%'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $response['records'] = array() ;
        $response['error'] = false ;  
        //  echo $query;
        while($data = mysqli_fetch_array($res)){
            $propertyId = $data['booking_property'] ; 
            $propertyData = $this->property->getproperty($propertyId)   ; 

            $roomId = $data['booking_room'] ; 
            
            $item =array("id"=>$data['booking_id'] , 
            "number"=>$data['booking_number'] , 
            "property"=>$propertyData['property_name']  , 
            "room"=>$this->getRoom($roomId)
            ) ;
            array_push($response['records'] , $item) ;  
        }
        echo json_encode($response);
    }


}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
 $headers = getallheaders( ) ;
//  var_dump($headers);
    @$authToken = $headers['auth-token'] ; 
    if(empty($authToken)){
        $response['error'] = true ; 
        $response['msg'] = "Invalid request please refresh page and try again" ; //
        echo json_encode($response) ; 
        return ; 
    }
    // var_dump($authToken);
    $object = new BookingSearch(); 
    $flag = $object->admin->validateSession($authToken);
    // var_dump($flag);
    if(!$flag){
        $response['error'] = true ; 
        $response['msg'] = "Invalid request please refresh page and try again" ; 
        /**
         * Invalid Login Auth Token
         */
        echo json_encode($response) ; 
        return ; 
    }

    // var_dump($_POST);
    @$query = $_POST['query'] ; 
    if(empty($query)){
        return ; 
    }

    $object->search($query);




}else{

}
?>