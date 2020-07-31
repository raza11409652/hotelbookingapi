<?php 
require_once "../../base_config/Connection.php";
require_once "../../panel/model/User.php";
require_once "../../panel/model/Bookings.php";
$response = array("error"=>true) ; 
class ActiveBookings{
    private $connection , $bookings  ; 
    public $user ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
        $this->user = new User();
        $this->bookings = new Bookings();
    }
    /**
     * @param $id is USER ID
     */
    function list($id){
        $records = $this->bookings->getAllBookingForUser($id) ; 
        // var_dump($records);
        return $records ; 
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $HEADERS = getallheaders();
    @$authToken = $HEADERS['auth-token'] ; 
    @$userUid = $HEADERS['client-token']; 
    /**
     * TODO 
     * API SESSION HANDLE GOES HERE
     */

    if(empty($userUid)){
        $response['error'] = TRUE ; 
        $response['msg']="Invalid request" ; 
        $response['error-code'] = 404 ;
        echo json_encode($response);   
        return ; 
    }
// var_dump($userUid); 
    $object = new ActiveBookings();
    $USER_DATA = $object->user->getUserDataByUid($userUid) ; 
    if(empty($USER_DATA)){
        $response['error'] = TRUE ; 
        $response['msg']="Invalid request" ; 
        $response['error-code'] = 404 ;
        echo json_encode($response); 
        return ; 
    }
    // var_dump($USER_DATA);
    @$userId = $USER_DATA['user_id'] ; 
    
    $BOOKING_DATA = $object->list($userId) ; 
    $response['error'] = false ; 
    $response['msg'] = sizeof($BOOKING_DATA) ." records found" ; 
    $response['records'] = $BOOKING_DATA ; 
    $response['error-code'] = 0; 
    echo json_encode($response) ; 
    return ; 


}else{
    $response['error'] = TRUE ; 
    $response['msg'] = "Invalid /GET Request " ; 
    $response['error-code'] = 707 ; 
    echo json_encode($response) ; 
}

?>