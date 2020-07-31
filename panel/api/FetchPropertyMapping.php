<?php 
require_once "../../base_config/Connection.php";
require_once "../model/Admin.php";
require_once "../controller/Utils.php";
class FetchPropertyMapping{
    private $connection  ; 
    public $admin ;  
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->admin = new Admin();
    }
    // function fetch($partner){
    //     $query = "Select * from partner_mapping where partner_mapping_partner='{$partner}'" ;

    // }
    function isMapped($partner , $property){
        $query ="Select * from partner_mapping where partner_mapping_partner='{$partner}'
        && partner_mapping_property='{$property}'" ; 
        $res = mysqli_query($this->connection  , $query); 
        $count = mysqli_num_rows($res) ;
        if($count==1) return true ; 
        return false;
    }
    function fetch($partner){
        $query = "Select * from property order by property_name" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $response['records'] = array(); 
        
        while($data = mysqli_fetch_assoc($res)){
            //
            $propertyId = $data['property_id'] ; 
            $flag = $this->isMapped($partner , $propertyId) ; 
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
    $object =new FetchPropertyMapping();
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

    @$partner =$_POST['partner'];
    // var_dump($partner);
    if(empty($partner)){
        $response['error'] = true ;
        $response['msg'] = "Please Select Partner First" ; 
        $response['error-code'] = 908 ; //No auth-token not valid
        echo json_encode($response) ; 
        return;
    }

    $object->fetch($partner);
}else{
    
}
?>