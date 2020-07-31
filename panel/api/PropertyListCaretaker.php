<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../model/Property.php";
require_once "../model/Caretaker.php";
require_once "../controller/Utils.php";
$response = array("error"=>true) ; 
class PropertyListCaretaker{
    private $connection  , $property  ; 
    public $admin , $caretaker  ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection=$conn->getConnect();
        $this->admin = new Admin();
        $this->property = new Property();
        $this->caretaker = new Caretaker();
    }
    function ismapped($caretaker , $propertyId){
        $query = "Select * from caretaker_mapping where caretaker_mapping_caretaker='{$caretaker}'&& caretaker_mapping_property='{$propertyId}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $count = mysqli_num_rows($res)    ;
        if($count==1) return TRUE ; 
        return FALSE ; 
    }
    function fetch($caretaker){
        $query = "Select * from property order by property_name" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $response['records'] = array(); 
        
        while($data = mysqli_fetch_assoc($res)){
            //
            $propertyId = $data['property_id'] ; 
            $flag = $this->isMapped($caretaker , $propertyId) ; 
            $item =array("id"=>$propertyId ,
            "name"=>"{$data['property_name']}" ,
            "uid"=>$data['property_uid'] , "mapped"=>$flag) ;
           array_push($response['records'] , $item) ;

        }
        $response['error'] = false ; 
        $response['error-code'] = 0;
        echo json_encode($response);
        return;

    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // var_dump($_POST);
    $headers = getallheaders() ;
    @$authToken = $headers['auth-token'] ; 
    if(empty($authToken)){
        $response['error'] = true; 
        $response['msg'] = "auth token not found" ; 
        echo json_encode($response) ; 
        return ; 
    }
    $object = new PropertyListCaretaker() ; 
    $flag = $object->admin->validateSession($authToken) ; 
    // var_dump($flag);
    if(!$flag){
        $response['error'] = true ; 
        $response['msg'] = "auth token missmatch refresh the page" ; 
        echo json_encode($response);
        return ; 
    }
    @$caretaker = $_POST['id'];
    if(empty($caretaker)){
        return ; 
    }
    $object->fetch($caretaker);
}else{
    $response['error'] = true ; 
    $response['msg'] = "No /Get method defined" ; 
    echo json_encode($response);
    return ; 
}
?>
