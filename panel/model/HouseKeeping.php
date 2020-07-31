<?php
class HouseKeeping{
    private $connection  ;
    // private $option = array("cost"=>12) ;
    function __construct(){
        $conn = new Connection();
        $this->connection = $conn->getConnect();
    }
    function getMaxHouseKeepingId(){
        $query  = "SELECT MAX(house_keeping_id) as MAX_ID from house_keeping" ;
        $res = mysqli_query($this->connection , $query) ;
        $data = mysqli_fetch_array($res) ;
        return @$data['MAX_ID']+1 ;
    }
    function newHouseKeeping($id , $user , $booking , $date , $timeRef , $timeSlot , $amount ) {
        $query = "Insert into house_keeping (house_keeping_id , house_keeping_user ,
         house_keeping_booking , house_keeping_date , house_keeping_time_ref ,
          house_keeping_timing , house_keeping_amount , house_keeping_is_paid)VALUES( '{$id}' , '{$user}' ,
           '{$booking}' , '{$date}' , '{$timeRef}' , '{$timeSlot}' , '{$amount}' , '1')";
        $res = mysqli_query($this->connection , $query) ;
        return $res ;
    }
    function newHouseKeepingWeb($id , $user , $booking , $date , $timeRef , $timeSlot , $amount ) {
        $query = "Insert into house_keeping (house_keeping_id , house_keeping_user ,
         house_keeping_booking , house_keeping_date , house_keeping_time_ref ,
          house_keeping_timing , house_keeping_amount , house_keeping_is_paid)VALUES( '{$id}' , '{$user}' ,
           '{$booking}' , '{$date}' , '{$timeRef}' , '{$timeSlot}' , '{$amount}' , '0')";
        $res = mysqli_query($this->connection , $query) ;
        return $res ;
    }
    function getTimeslot($timeRef){
        $query = "SELECT * from time_slot where time_slot_id='{$timeRef}'";
        $res = mysqli_query($this->connection , $query) ;
        $data = mysqli_fetch_array($res) ;
        return @$data['time_slot_timing'] ;
    }
}



?>
