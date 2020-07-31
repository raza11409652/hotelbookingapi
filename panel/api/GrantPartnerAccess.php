<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../controller/Utils.php";
require_once "../model/Property.php" ;
$response = array("error" =>true );
class GrantPartnerAccess{
    private $connection  ; 
    public $admin  , $property;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
        $this->property=new Property();
    }
    function grant($partner , $property , $admin , $propertyName){
        $query = "Insert into partner_mapping (partner_mapping_property ,partner_mapping_partner , 
        partner_mapping_added_by , partner_mapping_property_name)VALUES('{$property}'  , '{$partner}' ,'{$admin}' , '{$propertyName}')";
    //    echo $query;
        $res  = mysqli_query($this->connection , $query) ;
        return $res; 
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $header = getallheaders() ; 
    @$authToken = $header['auth-token'] ; 
    // var_dump($authToken);
    if(empty($authToken) || $authToken ==null){
        $response['error'] = true ;
        $response['msg'] = "Please refresh the page and try again" ; 
        $response['error-code'] = 908 ; //No Auth token found
        echo json_encode($response) ; 
        return;
    }
    $object =new GrantPartnerAccess();
    if(!$object->admin->validateSession($authToken)){
        $response['error'] = true ;
        $response['msg'] = "Please refresh the page and try again" ; 
        $response['error-code'] = 908 ; //No auth-token not valid
        echo json_encode($response) ; 
        return;
    }
    $admin = $object->admin->getIdFromToken($authToken) ; 
    // var_dump($admin);
    @$adminId = $admin['admin_session_ref'];
    // var_dump($adminId);

    @$partner = $_POST['partner'] ; 
    @$property = $_POST['property'] ; 
    
    if(empty($partner)){
        $response['error'] = true ;
        $response['msg'] = "Please select partner  first" ; 
        $response['error-code'] = 908 ; //Partner Id is missing
        echo json_encode($response) ; 
        return;
    }
    if(empty($property)){
        $response['error'] = true ;
        $response['msg'] = "Please select property  first" ; 
        $response['error-code'] = 908 ; //Partner Id is missing
        echo json_encode($response) ; 
        return;
    }
    @$propertyData = $object->property->getproperty($property) ; 
    @$propertyName = $propertyData['property_name'];
    $flag = $object->grant($partner , $property , $adminId , $propertyName ) ;
    // var_dump($flag);
    if($flag){
        $response['error'] = false ;
        $response['msg'] = "Access Granted" ;
        $response['error-code'] = 0; 
        echo json_encode($response);
        return; 
    }

}

?>