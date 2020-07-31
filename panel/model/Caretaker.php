<?php 
class Caretaker{
    private $connection  ;
    private $option = array("cost"=>12) ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
    }
    function getMaxId(){
        $query= "Select MAX(caretaker_id) as MAX_ID from caretaker" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_array($res) ; 
        return $data['MAX_ID']  +1 ; 
    }
    function generateUid($id){
        $uid = "FOD" ; 
        $temp  =mt_rand(1000 , 9999) ; 
        $uid ="{$uid}{$temp}{$id}" ; 
        return $uid ; 
    }
    function newcaretaker($mobile , $email , $name , $id){
        $query = "Insert into caretaker (caretaker_id , caretaker_name , 
        caretaker_email ,caretaker_mobile,caretaker_uid )VALUES('{$id}' ,'{$name}' ,'{$email}' ,
         '{$mobile}'  , '{$this->generateUid($id)}')" ;
        $res = mysqli_query($this->connection , $query) ; 
        return $res ;  
    }
    function newpassword(){
        $temp = "Fod!@#" ; 
        $random = mt_rand(10000 , 99999) ; 
        $temp = "{$temp}{$random}"  ; 
        return $temp ;         
    }
    function ispasswordExist($id){
        $query = "Select * from caretaker_login where caretaker_login_ref='{$id}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $count = mysqli_num_rows($res) ; 
        if($count==1){
            return TRUE ; 
        }
        return FALSE;  
    }
    function insertpassword($password , $id){
        $flag = $this->ispasswordExist($id) ;
        $query = NULL ; 
        if($flag){
            $query="Update  caretaker_login set caretaker_login_password='{$password}' where caretaker_login_ref='{$id}'" ; 
        }else{
            $query = "Insert into caretaker_login(caretaker_login_password , caretaker_login_ref)
            VALUES('{$password}' , '{$id}')" ; 
        }
        $res = mysqli_query($this->connection , $query) ; 
        return $res; 
    }
    function hashStrBcrypt($str){
        return password_hash($str, PASSWORD_BCRYPT, $this->option);
    }
    function ismobileused($mobile){
        $query= "Select * from  caretaker where caretaker_mobile='{$mobile}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $count = mysqli_num_rows($res) ;
        if($count==1) return TRUE ; 
        return FALSE ; 
    }
    function newPropertyMapping($property , $caretaker , $mappedBy){
        $query = "Insert into caretaker_mapping (caretaker_mapping_property , caretaker_mapping_caretaker , caretaker_mapping_added_by)VALUES
        ('{$property}' ,'{$caretaker}' ,'{$mappedBy}')" ;
        $res = mysqli_query($this->connection ,$query) ; 
        return $res ;  
    }
    function mappingRevoke($property , $caretaker){
        $query = "DELETE from caretaker_mapping where caretaker_mapping_property='{$property}' && caretaker_mapping_caretaker='{$caretaker}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        return $res ; 
    }
    function getCaretkerById($id){
        $query = "SELECT * from caretaker where caretaker_id='{$id}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_assoc($res) ; 
        return @$data;
    }
    function getCaretkerByUid($uid){
        $query = "SELECT * from caretaker where caretaker_uid='{$uid}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_assoc($res) ; 
        return @$data;
    }
}
?>