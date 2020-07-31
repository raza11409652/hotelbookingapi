<?php 
$token = null ;
 if(isset($_SESSION) &&  isset($_SESSION['isLoggedIn']) 
 && $_SESSION['loggedInEmail'] 
 && $_SESSION['loggedInToken']){
  $token = $_SESSION['loggedInToken'] ; 
  $email = $_SESSION['loggedInEmail'] ; 
//   var_dump($email);
$sql = "Select admin_id from admin where admin_email='{$email}'" ; 
$res = mysqli_query($connection , $sql) ; 
// var_dump($res);
$data = mysqli_fetch_array($res); 
@$adminId = $data['admin_id'];
$query = "Select * from admin_session where admin_session_val='{$token}' && admin_session_ref='{$adminId}'" ; 
$res = mysqli_query($connection , $query); 
// var_dump($res);
$count = mysqli_num_rows($res) ; 
if($count!=1){
    header("Location:?view=logout");
}
}

?>