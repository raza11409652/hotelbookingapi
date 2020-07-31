<?php 
require_once "../base_config/Connection.php";
$conn = new Connection();
$connection = $conn->getConnect();
// var_dump($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="googlebot" content="noindex" />
    <meta name="googlebot-news" content="noindex" />
    <meta name="googlebot" content="noindex" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Flatsondemand || ManagePortal ERP By hackdriod</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/theme.css">
    <link rel="stylesheet" href="assets/datepicker/default.css">
    <link rel="stylesheet" href="assets/datepicker/default.date.css">
    <link rel="stylesheet" href="assets/datepicker/default.time.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.0/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.0/dist/sweetalert2.all.min.js"></script>
</head>
<body>  
<div id="overlay" style="display:none;">
    <div class="spinner"></div>
    <br/>
    Please wait...
</div> 

    
