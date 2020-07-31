<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../controller/Utils.php";
$response =array("error"=>true);
class GetVacantRoom{
    private $connection  ; 
    public $admin ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
    }
    function getpropertyname($property){
        $query = "Select * from property where property_id='{$property}'"  ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_array($res) ; 
        return  @$data['property_name'] ; 
    }
    function getroomDetails($property){
        $query = "Select * from room where room_ref='{$property}'" ; 
        $res = mysqli_query($this->connection , $query) ;
        $response['records'] = array();
        // $item= array(); 
        while($data = mysqli_fetch_array($res)){
            $flag = $data['room_is_vacant'] ; 
            // $status = NULL ; 
            // if($flag==1) {
            //     $status = "Occupied" ; 
            // }else{
            //     $status  
            // }
            $item = array("id"=>$data['room_id'] , 
            "room"=>$data['room_number'] ,
            "status"=>$flag , 

            ) ; 
            array_push($response['records'] , $item) ; 

        }
        $response['property'] = $this->getpropertyname($property);
        $response['error'] = false ; 
        $response['msg'] = "found";
        echo json_encode($response)  ;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    @$property = $_POST['property'] ;
    if(empty($property)){
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
    $obj = new GetVacantRoom() ; 
    $obj->getroomDetails($property);
}else{

}

?>