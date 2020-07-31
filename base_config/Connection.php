<?php
require_once "Config.php";
class Connection{
    protected $connect;
    private $ip, $userAgent;
    function __construct(){
        $this->userAgent=$_SERVER['HTTP_USER_AGENT'];
        // print($this->userAgent);
    }
    function getConnect(){
        $this->connect=new mysqli(server , user,password , dbName );
        if($this->connect){
           return $this->connect;
        }else{
          return null;
            // var_dump ("Error in Connection");
        }
    
    }
}

?>
