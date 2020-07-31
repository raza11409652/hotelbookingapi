<?php 
require_once "../base_config/Connection.php";
$conn = new Connection();
$connection = $conn->getConnect();
// var_dump($connection);
$time = time();
?>
<?php 
require_once "middleware/SessionHandler.php";
require_once "middleware/TokenValidator.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRINT_FOD_<?php echo $time  ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/theme.css">
    <style>
        body{
            background:#FFFFFF  !important ; 
        }
    </style>
</head>
<body>
