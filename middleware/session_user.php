<?php 
$isLoggedIn = false ;
if(isset($_SESSION)&& isset($_SESSION['fodLoggedIn']) && isset($_SESSION['fodUserLoggedIn'])){
    // header('Location:?view=profile');
    // var_dump($_SESSION['fodUserLoggedIn']);

    $USER_DATA = @$_SESSION['fodUserLoggedIn'] ; 
    $userEmail =@$USER_DATA['user_email'];
    $userPhone =@$USER_DATA['user_phone'];
    @$userUid =@$USER_DATA['user_uid'];
    @$userId = @$USER_DATA['user_id'];
    $isLoggedIn=true ; 

}
?>