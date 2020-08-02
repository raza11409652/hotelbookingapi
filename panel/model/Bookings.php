<?php 
class Bookings{
    private $connection  ;
    private $option = array("cost"=>12) ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
    }
    function getBookingId(){
        $query = "Select MAX(booking_id) as MAX_ID from booking " ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_array($res) ; 
        return $data['MAX_ID'] +1  ;
    }
    function totalnumberdays($startDate , $endDate){
        $strStart =strtotime($startDate)  ; 
        $strEnd = strtotime($endDate) ; 
        $diff  =($strEnd - $strStart) ; 
        return abs(round($diff / 86400)); ; 
    }
    function getBookingByID($id){
        $query = "SELECT * from booking where booking_id='{$id}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_assoc($res) ; 
        return $data ;
    }
    function getBookingByNumber($number){
        $query="SELECT * from booking where booking_number='{$number}'" ; 
        $res = mysqli_query($this->connection  ,$query) ; 
        $data = mysqli_fetch_assoc($res) ; 
        return $data ;
    }
    function generateBookingUid($id){
        $temp = null ;
        $year = date('Y') ; 
        $month = date('m') ; 
        $date = date('d') ; 
        if($id<10){
             //Add four zero
             $temp = "0000{$id}" ; 
        }else if($id>9 && $id<100){
            //Add three zero
            $temp ="000{$id}" ; 
        }else if($id>99 && $id<1000){
            //Add two zero
            $temp ="00{$id}" ;
        }else if($id>999 && $id<10000){
            //Add one zero
            $temp ="0{$id}" ;
        }else{
            
            $temp = $id;
        }
        $bookingNo  = "{$year}{$month}{$date}{$temp}" ; 
        return  $bookingNo ; 

        
    }
    function getproperty($propertyID){
        $query = "Select * from property where property_id='{$propertyID}' " ; 
        $res = mysqli_query($this->connection , $query) ; 
        @$data = mysqli_fetch_array($res) ; 
       return $data ; 
    }

    function createNew($property , $user , $start ,$end){
        $bookingId  =$this->getBookingId(); 
        $bookingUid= $this->generateBookingUid($bookingId);
        $numberDays  = $this->totalnumberdays($start , $end) ; 
        if($numberDays<1){
            $numberDays =1 ; 
        }
        $propertyData = $this->getproperty($property)  ;
        $price = $propertyData['property_price'] ; 
        $amount = $numberDays *$price ; 
        $query= "insert into booking(booking_id , booking_number, booking_user , booking_property , booking_start_date , 
        booking_end_date , booking_amount,booking_total_days )
        VALUES('{$bookingId}' , '{$bookingUid}','{$user}','{$property}'  , '{$start}' , '{$end}' , '{$amount}','{$numberDays}') " ;
        //echo $query;
        $res = mysqli_query($this->connection , $query) ; 
        return $res ; 
    }
    function totalbookingByProperty($property){
        $query = "Select * from booking where  booking_property='{$property}' order by booking_status" ; 
        $res = mysqli_query($this->connection ,$query) ; 
        $response = array() ; 
        while($data = mysqli_fetch_array($res)){
            $item   =array(
                "id"=>$data['booking_id'] , 
                "date"=>$data['booking_booked_on']  , 
                "user"=>$data['booking_user'] , 
                "number"=>$data['booking_number'] , 
                "timestamp"=>$data['booking_time'] , 
                "startdate"=>$data['booking_start_date']  , 
                "enddate"=>$data['booking_end_date']  , 
                "totaldays"=>$data['booking_total_days'] , 
                "status"=>$data['booking_status']  , 
                "property"=>$data['booking_property']  , 
                "room"=>$data['booking_room'] , 
                "amount"=>$data['booking_amount']
            ) ; 
            array_push($response , $item);
        }
        return $response ; 
    }
    function getbookingStatus($id){
        $query = "Select * from booking_status where booking_status_id='{$id}'" ; 
        $res  = mysqli_query($this->connection ,$query) ; 
        $data = mysqli_fetch_array($res) ; 
        return @$data['booking_status_val'];
    }
    function isBookingExistForProperty($propertyID){
        $query = "Select booking_id from booking where booking_property='{$propertyID}'" ; 
        $res  =mysqli_query($this->connection , $query) ;
        $count = mysqli_num_rows($res) ;
        if($count>0) return TRUE ; 
        return FALSE ;
    }
    function getBookingsId($propertyID){
        $query = "Select booking_id from booking where booking_property='{$propertyID}'" ; 
        $res  =mysqli_query($this->connection , $query) ;
        $records  =array();
        while($data=mysqli_fetch_array($res)){
            $item = array("booking"=>$data['booking_id']) ; 
            if($this->isBookingExistForProperty($propertyID)){
              array_push($records , $item) ; 
            }
        }
        return $records ;
    }

    //  /**
    //  * GET ALL BOOKINGS FOR PROPETIES ARRAY
    //  */
    // function getallBookingsForPropties($propetyArray){;
    //     $records  =array(); 
    //     foreach($propetyArray as $a=>$b){
    //         $propertyID =$b['property'] ;
    //         if($this->isBookingExistForProperty($propertyID)){
    //             $bookings = $this->getBookingsId($propertyID);
    //             array_push($records  ,$bookings) ;
    //         }
    //     }
    //     return $records ; 
    // }



    /**
     * Get All booking for user only Active bookings
     * @param $user is user ID
     */
    function getAllBookingForUser($user){
        $query = "SELECT * from booking WHERE  booking_user='{$user}' 
         && booking_status='2' " ; 
        $res = mysqli_query($this->connection , $query);
        // echo $query;
        $records = array(); 
        while($data = mysqli_fetch_assoc($res)){
            array_push($records , $data) ; 
        }
        return $records ; 
    }
}
?>