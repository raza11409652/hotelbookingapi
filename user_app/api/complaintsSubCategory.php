<?php 
require_once "../../base_config/Connection.php";
// require_once "../../panel/model/User.php";
// require_once "../../panel/model/Bookings.php";
$response = array("error"=>true) ;  
class ComplaintsSubCategory{
    private $connection , $bookings  ; 
    // public $user ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
    }
    function getallSubCat($id){
        $query = "SELECT * from complaints_sub_issue where complaints_sub_issue_ref='{$id}' order by complaints_sub_issue_topic " ; 
        $res = mysqli_query($this->connection , $query) ; 
        $response['records'] =array();
        while($data = mysqli_fetch_assoc($res)){
            // var_dump()
            array_push($response['records'] , $data) ; 
        }
        $response['error'] = false ; 
        $response['msg'] = sizeof($response['records']) . " Records found" ; 
        echo json_encode($response);
        return;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $HEADERS = getallheaders();
    @$authToken = $HEADERS['auth-token'] ; 
    @$userUid = $HEADERS['client-token']; 

    /**
     * Session Handling goes herer
     */
    @$categoryId = $_POST['category'] ; 

    $object = new ComplaintsSubCategory();
    $object->getallSubCat($categoryId);
    


    



}else{
    $response['error'] = TRUE ; 
    $response['msg'] = "No Get method registered" ; 
    $response['error-code'] = 404 ; 
    echo    json_encode($response) ; 

}


?>