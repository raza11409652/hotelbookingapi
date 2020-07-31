<?php 

class Partner{
    private $connection  ;
    private $option = array("cost"=>12) ; 
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
    }
    function isMobileUsed($mobile){
        $query = "Select * from partner where partner_mobile='{$mobile}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $count =mysqli_num_rows($res) ; 
        if($count==1) return true ;
        return false ;
    }
    function isEmailUsed($email){
        $query = "Select * from partner where partner_email='{$email}'" ; 
        $res = mysqli_query($this->connection , $query) ; 
        $count =mysqli_num_rows($res) ; 
        if($count==1) return true ;
        return false ;
    }
    function getMaxId(){
        $query = "Select max(partner_id) as MAX_ID from partner" ;
        $res = mysqli_query($this->connection  , $query) ; 
        $data = mysqli_fetch_array($res) ; 
        return $data['MAX_ID']  +1; 
    }
    function generateUID($id , $str){
        $str  = strtoupper($str) ; 
        $str = str_replace(' ' , '' , $str) ; 
        if(strlen($str)<3){
            $str = "ZERT{$str}";
        }
        $str = substr(str_shuffle($str), 0, 3) ; 
        $str ="FOD{$str}" ; 
        $year = date('Y') ; 
        $month = date('m') ; 
        $date = date('d') ; 
        $temp = "{$str}{$year}{$month}{$date}{$id}" ; 
        return $temp;
    }
    function generateNewPassword(){
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $fix="Fd@4" ; 
        $str = substr(str_shuffle($permitted_chars), 0, 6) ; 
        $str = strtolower($str) ; 
        $str = str_replace(' ' , '' , $str);
        $number = mt_rand(10000 , 99999)  ; 
        $password= "{$fix}{$str}{$number}";
        return $password;
    }
    function hashStrBcrypt($str){
        return password_hash($str, PASSWORD_BCRYPT, $this->option);
    }
}
?>