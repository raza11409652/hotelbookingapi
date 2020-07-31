<?php 

class User{
    private $connection  ;
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
    }
    function _isemailused($email){
        $query = "Select * from user where user_email='{$email}'" ;
        $res = mysqli_query($this->connection , $query) ; 
        $count = mysqli_num_rows($res) ; 
        if($count==1) return true ; 
        return false ;  
    }
    function _userdata($mobile){
        $query = "Select * from user where user_phone='{$mobile}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_array($res) ; 
        return $data;  
    }
    function getUserDataById($id){
        $query = "Select * from user where user_id='{$id}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_assoc($res) ; 
        return $data;  
    }
    function getPersonalData($user){
        $query = "Select * from user_profile where user_profile_ref='{$user}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_array($res) ;
        return $data;
    }
    function kycDone($user){
        $query = "UPDATE user set user_is_verified='1' where user_id='{$user}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        return $res ;
    }
    function updateprofileImage($image  ,$id){
        $query=  "UPDATE user set user_profile_image='{$image}' WHERE user_id='{$id}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        return $res ;

    }   
    function uploadDocument($type , $image , $user   , $createdBy){
        $query = "Insert into user_document (user_document_type , user_document_url ,
        user_document_ref , user_document_by)VALUES('{$type}' ,'{$image}', '{$user}' , '{$createdBy}')" ; 
        $res = mysqli_query($this->connection , $query) ; 
        return $res ;
    }
    function isProfileExist($id){
        $query = "Select * from user_profile where user_profile_ref='{$id}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $count = mysqli_num_rows($res) ; 
        if($count==1) return TRUE ; 
        return FALSE ; 
    }
    function createProfileData($address , $city  , $country , $zipcode ,$resContact , $passport , $visa ,$id , $createdBy){
        $query= NULL ; 
        $flag =$this->isProfileExist($id) ; 
        
        if($flag){
            $query = "UPDATE user_profile set user_profile_address='{$address}' ,
             user_profile_city='{$city}' , user_profile_country='{$country}' ,
             user_profile_zipcode='{$zipcode}' , user_profile_res_contact='{$resContact}' , 
             user_profile_visa_number='{$visa}' , user_profile_passport_number='{$passport}' , user_profile_created_by='{$createdBy}'
             WHERE user_profile_ref='{$id}'" ; 
        }else{
            $query = "INSERT INTO user_profile(user_profile_address ,user_profile_city , user_profile_country ,
             user_profile_zipcode ,user_profile_res_contact ,user_profile_visa_number ,  user_profile_passport_number
             ,user_profile_created_by , user_profile_ref)VALUES('{$address}' ,'{$city}' ,
             '{$country}' , '{$zipcode}' , '{$resContact}'  , '{$visa}' , '{$passport}' , '{$createdBy}' , '{$id}')" ; 
        }
        // echo $query;
        $res = mysqli_query($this->connection , $query) ; 
        return $res ;

    }
    function updatePersonalDetails($name , $fathername ,$id){
        $query = "UPDATE user set user_name='{$name}'  , user_father='{$fathername}' where user_id='{$id}'" ; 
        $res  = mysqli_query($this->connection , $query) ;
        return $res ; 
    }

    function getUserProfileImage($user){
        $query = "SELECT user_profile_image from user where user_id='{$user}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_array($res) ; 
        // var_dump($data);
        return @$data['user_profile_image'] ; 
    }

    function getUserDataByUid($uid){
        $query = "Select * from user where user_uid='{$uid}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_array($res) ; 
        return $data;  
    }
    function getUserDataByMobile($mobile){
        $query = "Select * from user where user_phone='{$mobile}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_assoc($res) ; 
        return $data;  
    }
    function isUserNew($userUid){
        $query = "SELECT * from user where user_uid='{$userUid}'"  ; 
        // echo $query;
        $res = mysqli_query($this->connection , $query) ; 
        $count = mysqli_num_rows($res) ; 
        // var_dump($count);
        if($count>0) return false ; 
        return TRUE; 
    }
    function createNewUser($userUid , $mobile){
        $query = "Insert into user (user_uid , user_phone ,  
        user_name)values('{$userUid}' ,'{$mobile}' ,
        'FOD USER' )" ;
        // echo $query;
        $res = mysqli_query($this->connection , $query) ; 
        return $res ;  
    }
}

?>