<?php 
session_start();
$path = null ;
function isPathExist($path){
    if(file_exists($path)){
        // var_dump($path);
        require_once $path ; 
    }else{
        require_once "views/error.php";
    }
}
if(isset($_REQUEST['view'])){
    $path = "views/{$_REQUEST['view']}.php";
}else{
    $path = "views/home.php"  ;
}
isPathExist($path);
// var_dump($path);
?>