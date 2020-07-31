<?php 
require_once "../../base_config/Connection.php";
require_once "../../panel/model/User.php";
require_once "../../panel/model/Bookings.php";
require_once "../../panel/model/HouseKeeping.php";
require_once "../../panel/model/Property.php";
require_once "../../panel/model/Complaints.php";
$response = array("error"=>true) ;
class CreateComplaints{
    private $connection   ;
    public $user  , $house , $bookings , $property  ,$complaints ;
    function __construct(){
        $conn = new Connection();
        $this->connection = $conn->getConnect();
        $this->user = new User();
        $this->bookings = new Bookings();
        $this->house  = new HouseKeeping();
        $this->property = new Property() ;
        $this->complaints = new Complaints();
    }
    function insertNew($category , $subCategory , $bookingId , $date , $remarks){
        $flag = $this->complaints->create($category,  $subCategory , $bookingId , $date, $remarks);
        return $flag;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $HEADERS = getallheaders();
    @$authToken = $HEADERS['auth-token'] ; 
    @$userUid = $HEADERS['client-token']; 
    if(empty($authToken)||empty($userUid)){
        return ; 
    }
    /**
     * booking=7&category=4&subCategory=11&date=2020-07-20&
     * remarks=Pg%20is%20not%20clean&user=3GiZcODLkBYatk7OHwHhmzBwNAF3
     */
    $user = @$_POST['user']; // FormData UserUid
    $bookingId = @$_POST['booking'];
    $category =@$_POST['category'];
    $subCategory =@$_POST['subCategory'];
    $date=@$_POST['date'];
    $remarks =@$_POST['remarks'];


    if(empty($user)){return ;}
    if(empty($bookingId)){
        $response['error']  = TRUE ; 
        $response['msg'] = "Booking is required";
        $response['error-code']=404 ; 
        echo json_encode($response);
        return ; 
    }
    if(empty($category)){
        $response['error']  = TRUE ; 
        $response['msg'] = "Please select Category";
        $response['error-code']=404 ; 
        echo json_encode($response);
        return ; 
    }
    if(empty($subCategory)){
        $response['error']  = TRUE ; 
        $response['msg'] = "Please select sub category";
        $response['error-code']=404 ; 
        echo json_encode($response);
        return ; 
    }
    if(empty($date)){
        $response['error']  = TRUE ; 
        $response['msg'] = "Date is required";
        $response['error-code']=404 ; 
        echo json_encode($response);
        return ; 
    }

    $object =new CreateComplaints();
    //User data
    $USERDATA = $object->user->getUserDataByUid($user);
    // var_dump($USERDATA);
    if(empty($USERDATA)||$USERDATA==null){
        $response['error']  = TRUE ; 
        $response['msg'] = "Please refresh the page the try again";//USer token is missing
        $response['error-code']=404 ; 
        echo json_encode($response);
        return ;
    }

    $flag = $object->insertNew($category , $subCategory , $bookingId , $date ,$remarks);
    // var_dump($flag);
    if($flag){
        $response['error']=FALSE ; 
        $response['msg'] = "Your request has been saved";
        $response['error-code'] = 0;
        echo json_encode($response);
        return;
    }









}

?>