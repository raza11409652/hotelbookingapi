<?php
require_once "../../base_config/Connection.php";
require_once "../../panel/model/User.php";
require_once "../../panel/model/Bookings.php";
$response = array("error"=>true) ;
class GetFreeTimeSlot{
    private $connection , $bookings  ;
    public $user ;
    function __construct(){
        $conn = new Connection();
        $this->connection = $conn->getConnect();
        $this->user = new User();
        $this->bookings = new Bookings();
    }
    function getFreeTimeSlot($date , $max){
        // $query  = "SELECT count(house_keeping_time_ref) as time from house_keeping where house_keeping_date='{$date}' ";
        // $res  = mysqli_query($this->connection , $query) ;
        // while($data = mysqli_fetch_array($res)){
        //     $time = $data['time'] ;
        //     var_dump($time);


        // }
        $query = "SELECT * from time_slot " ;
        $res = mysqli_query($this->connection , $query) ;
        $response['records'] =array();
        while($data = mysqli_fetch_array($res)){
            // var_dump($data);
            $timeSlotId = $data['time_slot_id'] ;
            $flag = $this->isTimeSlotFree($date , $timeSlotId , $max);
            $item = array("id"=>$data['time_slot_id'] ,
             "timing"=>$data['time_slot_timing'] , "status"=>$flag) ;
            array_push($response['records'] , $item);
        }
       $response['error'] = FALSE ;
       $response['msg']="Time slot" ;
       echo json_encode($response);

    }
    function isTimeSlotFree($date , $timeSlotId , $max){
        $query = "SELECT count(house_keeping_time_ref) as time from house_keeping where house_keeping_date='{$date}' &&house_keeping_is_paid='1' &&  house_keeping_time_ref='{$timeSlotId}'" ; 
        $res  = mysqli_query($this->connection , $query) ;
        $data = mysqli_fetch_array($res)  ;
        $timeSlotUsed = $data['time'] ;
        if($timeSlotUsed<$max) return TRUE ;
        return FALSE ;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $HEADERS = getallheaders();
    @$authToken = $HEADERS['auth-token'] ;
    /**
     * TODO
     * API SESSION HANDLE GOES HERE
     */
    // if(empty($authToken)){
    //     $response['error'] = TRUE ;
    //     $
    // }

    @$date = $_POST['date'] ;
    if(empty($date)){
        $response['error'] = TRUE ;
        $response['msg'] = "Date is required" ;
        $response['error-code'] = 404 ;
        echo json_encode($response) ;
        return ;
    }

    // var_dump(TOTAL_NUMBER_WORKFORCE);
    /**
     * 1room time taken 30 min
     * in 1 hr 2 room
     * in hr 2 room *2
     */
    $totalRoomMax = 2 * (TOTAL_NUMBER_WORKFORCE) ;

    $object = new GetFreeTimeSlot();
    $object->getFreeTimeSlot($date , $totalRoomMax );



}else{

}
?>
