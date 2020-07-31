<?php 
    function getPropertyType($id , $connection){
        $query = "SELECT * from property_type where property_type_id='{$id}'" ;
        $res = mysqli_query($connection , $query);
        $data = mysqli_fetch_assoc($res);
        return $data;
    }
    function removespecialChar($str){
      $str =   str_replace("'",'' ,$str);
      $str = str_replace('/','',$str);

        return $str;
    }


    function getpropertyData($property , $connection){
        $property = mysqli_real_escape_string($connection , $property);
        $query = "SELECT * FROM property where property_uid ='{$property}'";
        $res = mysqli_query($connection , $query);
        $data = mysqli_fetch_assoc($res);
        return $data;
    }
?>  