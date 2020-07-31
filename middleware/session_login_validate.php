<?php 
if(isset($_SESSION)&& isset($_SESSION['fodLoggedIn']) && isset($_SESSION['fodUserLoggedIn'])){
  
}else{
    header('Location:?view=login');
}
?>