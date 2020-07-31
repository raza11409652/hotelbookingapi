<?php 
   if(isset($_SESSION) &&  isset($_SESSION['isLoggedIn']) 
   && $_SESSION['loggedInEmail'] 
   && $_SESSION['loggedInToken']){
       if($_SESSION['isLoggedIn'] == true){
           header('Location:?view=home');
       }
   }
   

  

?>