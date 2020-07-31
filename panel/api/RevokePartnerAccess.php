<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../controller/Utils.php";
$response =array("error"=>true);
class RevokePartnerAccess{
    private $connection  ; 
    public $admin ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
    }
    function revoke($partner , $property){
        $query = "Delete from partner_mapping where partner_mapping_property='{$property}'&& partner_mapping_partner='{$partner}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
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
    $object =new RevokePartnerAccess();
    if(!$object->admin->validateSession($authToken)){
        $response['error'] = true ;
        $response['msg'] = "Please refresh the page and try again" ; 
        $response['error-code'] = 908 ; //No auth-token not valid
        echo json_encode($response) ; 
        return;
    }

    @$partner = $_POST['partner'] ; 
    @$property = $_POST['property']; 
    if(empty($property) || empty($partner)){
        return ; 
    }
    $flag = $object->revoke($partner , $property) ;
    // var_dump($flag);
    if($flag){
        $response['error'] = false ;
        $response['msg'] = "Access revoked" ;
        $response['error-code'] = 0; 
        echo json_encode($response);
        return; 
    }

}
?>