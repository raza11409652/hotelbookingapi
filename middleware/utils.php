<?php

function getProperty($id , $connection){
  $query = "SELECT * from property where property_id='{$id}'";
  $res = mysqli_query($connection , $query);
  $data = mysqli_fetch_assoc($res) ;
  return $data;
}
function getBookingStatus($id ,$connection){
  $query = "SELECT * from booking_status where booking_status_id='{$id}'";
  $res = mysqli_query($connection , $query);
  $data = mysqli_fetch_assoc($res) ;
  return $data;
}
function getRoom($id , $connection){
  $query = "SELECT * from room where room_id='{$id}'";
  $res = mysqli_query($connection , $query);
  $data = mysqli_fetch_assoc($res) ;
  return $data;
}

function getNextDate($date){
    $endDate = date('Y-m-d', strtotime('+1 day', strtotime($date)));
    return $endDate;
}

function getHouseKeeping($id , $connection){
  $query = "SELECT * from house_keeping where house_keeping_id='{$id}' ";
  // echo $query;
  $res = mysqli_query($connection , $query) ;
  $data = mysqli_fetch_assoc($res);
  return $data;
}
function markHouseKeepingPaymentSuccess($id , $amount , $mode , $desc , $user , $connection){
    $f = createPaymentHistory($amount , $user ,$mode , $desc , $connection) ;
    $query = "UPDATE house_keeping set house_keeping_is_paid='1' where house_keeping_id='{$id}'";
    $res = mysqli_query($connection , $query) ;
    return $res ;

}
function createPaymentHistory($amount , $user ,$mode , $desc , $connection ){
    $query = "INSERT  into payment_user_history (payment_user_history_amount ,
     payment_user_history_mode , payment_user_history_desc , payment_user_history_user)
     VALUES('$amount' ,'{$mode}' ,'{$desc}' , '{$user}') " ;
     $res = mysqli_query($connection , $query) ;
     return $res ;
}

function getAllBookingByUserId($user , $connection){
  $query  =  "SELECT * from booking where booking_user='{$user}'";
  $res = mysqli_query($connection , $query);
  $item  =array();
  while($data = mysqli_fetch_assoc($res)){
    array_push($item , $data);
  }
  return $item;
}

function getAllComplaintsByBooking($booking , $connection){
  $query = "SELECT * from complaints where complaints_booking='{$booking}' order by complaints_date";
  $res = mysqli_query($connection , $query);
  $item  =array();
  while($data = mysqli_fetch_assoc($res)){
    array_push($item , $data);
  }
  return $item;
}

function getCategory($category , $connection){
  $query = "SELECT *FROM complaints_issue where complaints_issue_id='{$category}'";
  $res = mysqli_query($connection , $query);
  $data = mysqli_fetch_array($res);
  return $data['complaints_issue_topic'];
}
function getSubCategory($id  ,$connection){
  $query = "SELECT * FROM complaints_sub_issue where complaints_sub_issue_id='{$id}'";
  // echo $query;
  $res = mysqli_query($connection , $query);
  $data = mysqli_fetch_array($res);
  // var_dump($data);
  return @$data['complaints_sub_issue_topic'];
}

function getComplaintsStatus($id , $connection){
  $query = "SELECT * from complaints_status where complaints_status_id='{$id}'";
   // echo $query;
   $res = mysqli_query($connection , $query);
   $data = mysqli_fetch_array($res);
   // var_dump($data);
   return @$data['complaints_status_val'];
}
?>
