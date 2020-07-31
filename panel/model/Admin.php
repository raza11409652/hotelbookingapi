<?php 
require_once "../../base_config/Connection.php";
class Admin{
    private $connection  ;
    private $option = array("cost"=>12) ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
    }
    function getAdmin($email){
        $query ="Select * from admin where admin_email='{$email}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data  = mysqli_fetch_array($res) ; 
        return $data;  
    }
    function isValidAdmin($email){
        $query = "Select * from admin where admin_email='{$email}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $count = mysqli_num_rows($res) ; 
        // var_dump($count);
        if($count==1) return true ; 
        return false ; 
    }

    function isActiveAdmin($email){
        $query = "Select * from admin where admin_email='{$email}'&& admin_status='1'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        // $data = mysqli_fetch_array($res) ; 
        $count =mysqli_num_rows($res) ; 
        if($count==1) return true ; 
        return false ;
    }
    /**
     * Check for is OTP send Token exist
     */
    function isTokenExist($admin){
        $query = "Select * from admin_token where admin_token_ref='{$admin}'" ; 
        $res  =mysqli_query($this->connection , $query) ;
        $count =mysqli_num_rows($res) ;
        if($count==1){
            return true ;
        }
        return false ; 
    }
    function insertToken($admin , $token){
        $token = $this->hashStr($token);
        $flag = $this->isTokenExist($admin) ; 
        $query =null ; 
        if($flag){
            $query = "Update admin_token set admin_token_val='{$token}' where admin_token_ref='{$admin}' " ; 

        }else{
            $query = "Insert into admin_token (admin_token_val , admin_token_ref) 
            values('{$token}' ,'{$admin}')";
        }
        $res = mysqli_query($this->connection  , $query) ; 
        return $res; 
    }
    function hashStr($str){
        return password_hash($str, PASSWORD_BCRYPT, $this->option);
    }
    function isSessionExist($admin){
        $query = "Select * from admin_session where admin_session_ref='{$admin}'" ; 
        $res  =mysqli_query($this->connection , $query) ;
        $count =mysqli_num_rows($res) ;
        if($count==1){
            return true ;
        }
        return false ; 
    }
    function validUid($uid){
        $uid = mysqli_real_escape_string($this->connection , $uid) ; 
        $query= "Select * from admin where admin_uid ='{$uid}'" ; 
        $res = mysqli_query($this->connection , $query) ;
        $data = mysqli_fetch_array($res) ; 
        return  $data ; 
    }
    function getToken($admin){
        $flag = $this->isTokenExist($admin) ; 
        if($flag) {
            $query = "Select * from admin_token where admin_token_ref='{$admin}'" ; 
            $res = mysqli_query($this->connection  , $query) ; 
            $data = mysqli_fetch_array($res) ; 
            return $data;  
        }
        return null;
    }
    function validateHash($str , $hashStr){
        if(password_verify($str , $hashStr)){
          return true;
        }
        return false;
    }
    function updatePassword($password , $admin){
        $query = "Update admin_login set admin_login_val='{$password}' where admin_login_ref='{$admin}'" ; 
        $res =mysqli_query($this->connection , $query) ;
        return $res ; 
    }
    function deleteToken($admin){
        $query = "Delete from admin_token where admin_token_ref='{$admin}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        return $res ; 
    }
    function getAdminPassword($admin){
        $query = "Select * from admin_login where admin_login_ref='{$admin}'" ;
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_array($res) ; 
        @ $password = $data['admin_login_val']  ; 
        return $password ; 
    }
    function insertSession($admin , $device , $token ){
        $flag = $this->isSessionExist($admin) ; 
        $query =null ;
        if($flag){
            $query = "Update admin_session set admin_session_val='{$token}' ,
            admin_session_device='{$device}' where admin_session_ref='{$admin}'" ; 
        }
        else{
            $query = "Insert into admin_session(admin_session_val , admin_session_device , 
            admin_session_ref)values('{$token}' ,'{$device}'  , '{$admin}')" ; 
        }
        $res = mysqli_query($this->connection , $query) ; 
        return $res; 
    }
    function validateSession($token){
        $query = "Select * from admin_session where admin_session_val='{$token}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $count = mysqli_num_rows($res) ; 
        if($count==1) return true ;
        return false ;
    }
    function sessionData($token){
        $query = "Select * from admin_session where admin_session_val='{$token}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_array($res) ; 
        return $data ; 
    }
    function getIdFromToken($token){
        $query = "Select * from admin_session where admin_session_val='{$token}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $data = mysqli_fetch_array($res) ; 
        return $data;
    }
}




?>