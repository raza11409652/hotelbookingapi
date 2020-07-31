<?php
    require "middleware/session_login_validate.php";
    $userQuery = "SELECT * from user where user_id='{$userId}'";
    $userRes =mysqli_query($connection ,$userQuery);
    $userData=mysqli_fetch_assoc($userRes);
    // var_dump($userData);
    $profileImage=@$userData['user_profile_image'];
    $userName =@$userData['user_name'];
    $imgclass =null;
    if(empty($profileImage)){
        $profileImage ="assets/svg/icon4.svg";
        $imgclass ="p-4 ";
    }
?>
<div class="side-menu">
<div class="profileholder">
<img src="<?php echo $profileImage?>" alt="" class="profile-image <?php echo "{$imgclass}" ;?>">
<p class="text-center mt-2 mb-1"><?php echo $userName ?></p>
</div>
<div class="url-holder">
<div class="url-item">
<a href="?view=profile" class="url-link">
<img src="assets/icon/user.svg" alt="">
My Account</a>
</div>
<div class="url-item">
<a href="?view=mybooking" class="url-link">
<img src="assets/icon/clipboard.svg" alt="">
My Booking</a>
</div>
<div class="url-item">
<a href="?view=documents" class="url-link">
<img src="assets/icon/file.svg" alt="">
My Documents</a>
</div>
<div class="url-item">
<a href="" class="url-link">
<img src="assets/icon/bookmark.svg" alt="">
My Tours</a>
</div>
<div class="url-item">
<a href="?view=complaints" class="url-link">
<img src="assets/icon/settings.svg" alt="">
complaints & Maintaince</a>
</div>
<div class="url-item">
<a href="?view=housekeeping" class="url-link">
<img src="assets/icon/umbrella.svg" alt="">
House keeping</a>
</div>
<div class="dropdown url-item">
<a class="dropdown-toggle url-link" href="#" role="button" id="paymentLinks" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<img src="assets/icon/credit-card.svg" alt="" srcset=""> Payments
</a>

<div class="dropdown-menu" aria-labelledby="paymentLinks">
<a class="dropdown-item" href="?view=pendingpayments">Pending payments</a>
<a class="dropdown-item" href="?view=paymenthistory">Payment History</a>
<a class="dropdown-item" href="#">Credit</a>
</div>
</div>
<div class="url-item">
<a href="?view=logout" class="url-link">
<img src="assets/icon/power.svg" alt="">
Logout</a>
</div>

</div>
</div>
