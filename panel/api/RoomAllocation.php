<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../controller/Utils.php";
$response =array("error"=>true);
class RoomAllocation{
    private $connection  ; 
    public $admin ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
    }

    function create($room  , $property , $meter ){
        $query = "Insert into room(room_number , room_initial_reading , room_ref)
        values('{$room}' , '{$meter}' ,'{$property}') ";
        // echo $query;
        $res = mysqli_query($this->connection   ,$query) ;
        return $res  ; 
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
    @$roomlist  =$_POST['roomname'] ; 
    @$metercount = $_POST['metercount']  ; 
    $i=0;
    @$property = $_POST['property'] ; 
    $obj = new RoomAllocation() ;
    $arrayLength = sizeof($roomlist) ;  
    foreach($roomlist as $a){
        // var_dump($a);
        $roomNumber = $a ;
        $meter = $metercount[$i];
        $flag = $obj->create($roomNumber , $property , $meter) ; 
        // $i++;
        if($flag) $i++ ; 
    }
    // var_dump($i);
    if($i==$arrayLength){
        $response['error'] = false ; 
        $response['msg'] = "Room has been added {$i}";
        echo json_encode($response) ; 
        return  ; 
    }

}else{

}
?>