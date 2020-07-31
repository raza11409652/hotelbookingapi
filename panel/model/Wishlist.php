<?php

class Wishlist{
    private $connection  ;
    function __construct(){
        $conn = new Connection(); 
        $this->connection = $conn->getConnect();
    }

    function isPropertyMapped($property  , $user){
        $query = "SELECT * FROM user_wishlist where user_wishlist_user='{$user}' && 
        user_wishlist_property='{$property}'" ; 
        // echo $query;
        $res = mysqli_query($this->connection , $query) ; 
        $count = mysqli_num_rows ($res) ; 
        if($count==1) return TRUE ; 
        return FALSE ; 
    }
    function wishlistToggle($property  ,$user ){
        $flag = $this->isPropertyMapped($property  , $user);
        // var_dump($flag);
        if(!$flag){
            $res = $this->insertMap($property , $user);
            return $res  ;
        }else{
            $res = $this->deleteMap($property , $user);
            return $res ; 
        }
    }
    function insertMap($property , $user){
        $query = "INSERT INTO user_wishlist (user_wishlist_property , user_wishlist_user)VALUES('{$property}' , '{$user}')";
        $res = mysqli_query($this->connection , $query);
        return $res ; 
    }
    function deleteMap($property , $user){
        $query = "DELETE  FROM user_wishlist where user_wishlist_property='{$property}' &&
        user_wishlist_user='{$user}'" ;
        // echo $query; 
        $res = mysqli_query($this->connection , $query);
        return $res ; 
    }

}
?>