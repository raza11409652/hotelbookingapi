<?php 
if(isset($_SESSION)&& isset($_SESSION['fodLoggedIn']) && isset($_SESSION['fodUserLoggedIn'])){
   
    header('Location:?view=profile');
    // var_dump($_SESSION['fodUserLoggedIn']);
}
?>