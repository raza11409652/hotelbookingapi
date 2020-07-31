<?php
require_once "../../base_config/Connection.php";
$response = array("error"=>true);
class Location{
    private $connection  ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
    }
    function getlocation(){
        $query = "SELECT * FROM location order by location_val " ; 
        $res = mysqli_query($this->connection , $query) ; 
        $response['records'] = array();
        while($data = mysqli_fetch_assoc($res)){
          
            array_push($response['records'] , $data);
        }
        $response['error'] = false ; 
        $response['msg'] = sizeof($response['records']) . " found" ;
        echo json_encode($response);
        return ; 
    }
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $HEADERS = getallheaders();
    @$authToken = $HEADERS['auth-token'] ; 
    @$userUid = $HEADERS['client-token']; 

    if(empty($authToken)){
        return ; 
    }

    $obj = new Location();
    $obj->getlocation();


}else{

}

?>