<?php 
class Property{
    private $connection  ;
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
    }
    function getMaxId(){
       $query = "Select max(property_id) as max_id from property "  ; 
       $res = mysqli_query($this->connection , $query)  ;
       $data = mysqli_fetch_array($res) ;
    //    var_dump($data);
       return $data['max_id']  +1 ; 
    }
    function generateUid($id){
        $year = date('Y') ; 
        return "FOD{$year}{$id}";
    }
    function getproperty($propertyID){
        $query = "Select * from property where property_id='{$propertyID}' " ; 
        $res = mysqli_query($this->connection , $query) ; 
        @$data = mysqli_fetch_array($res) ; 
       return $data ; 
    }
    function getPropertyByUid($str){
        $query = "Select * from property where property_uid='{$str}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_array($res) ; 
        return $data;  
    }
    function validateroom($roomId , $propertyID){
        $query = "Select * from room where room_id='{$roomId}' && room_ref='{$propertyID}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $count =mysqli_num_rows($res);
        if($count!=1) return false ; 
        return true ; 
    }
    function gettotalroom($propertyID){
        $query = "Select * from room where room_ref='{$propertyID}'" ; 
        $res  = mysqli_query($this->connection , $query) ; 
        $count =mysqli_num_rows($res) ; 
        return $count ; 
    }
    function gettotalvacant($propertyID){
        $query = "Select * from room where room_ref='{$propertyID}' && room_is_vacant='0'"; 
        $res  = mysqli_query($this->connection , $query) ; 
        $count =mysqli_num_rows($res) ; 
        return $count ;
    }
    function totalnumberofbooking($propertyID){
        $query= "Select * from booking where booking_property='{$propertyID}'" ; 
        $res  = mysqli_query($this->connection , $query) ; 
        $count =mysqli_num_rows($res) ; 
        return $count ;
    }
    function getRoomNumber($id){
        $query = "SELECT * from room where room_id='{$id}'" ; 
        $res = mysqli_query($this->connection ,$query) ; 
        $data = mysqli_fetch_array($res) ;
        return @$data['room_number'];  
    }
    function getpropertyIDFromRoom($roomId){
        $query = "SELECT * from room where room_id='{$roomId}' " ;
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_array($res);
        return @$data['room_ref'] ; 

    }
    function getRoomData($roomId){
        $query = "SELECT * from room where room_id='{$roomId}'" ; 
        // echo $query ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_assoc($res) ; 
        return $data ;
    }


    function getPropertyType($id){
        $query = "SELECT * FROM property_type where property_type_id='{$id}'" ; 
        // echo $query;
        $res = mysqli_query($this->connection , $query) ; 
        $data =  mysqli_fetch_assoc($res) ;
        return @$data['property_type_val']; 
    }
   
    
}
?>