<?php 
require_once "base_config/Connection.php" ;
$conn = new Connection();
$connection =$conn->getConnect();
require_once "middleware/session_user.php" ;
$err = true ; 
$msg = null  ;
$bookingNumber = null ; 
$bill  =null ; 
if(isset($_GET['billfor'])&& isset($_GET['bill'])){
    $err = FALSE  ; 
    $bookingNumber = $_GET['billfor'];
    $bookingNumber = base64_decode($bookingNumber);
    $bill = $_GET['bill'];
    $bill = base64_decode($bill);
}else{
    $err = TRUE ;
    $msg = "URL is broken";
    exit(0); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill For <?php echo "{$bookingNumber}|{$bill}||FOD Living by Flatsondemand" ?> </title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/theme.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
   
</head>
<body>
