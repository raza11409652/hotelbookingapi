<?php 
// $isLoggedIn = false ;
if(isset($_SESSION)&& isset($_SESSION['fodLoggedIn']) && isset($_SESSION['fodUserLoggedIn'])){
    header('Location:?view=pendingpayments');
    // var_dump(getallheaders());
}
?>