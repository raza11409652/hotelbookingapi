<?php
require_once "base_config/Connection.php" ;
require_once "middleware/utils.php";
$conn = new Connection();
$connection =$conn->getConnect();
require_once "middleware/session_user.php" ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#f05a28">
    <meta name="msapplication-TileColor" content="#f05a28" />
    <meta name="apple-mobile-web-app-status-bar-style" content="#f05a28">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="hackdroidbykhan@gmail.com">
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index" />
    <meta name="googlebot-news" content="noindex" />
    <meta name="distribution" content="global" />
    <meta name="copyright" content="Flatsondemand is copyright 2017-2020" />
    <meta property='og:title' content='Fod living by Flatsondemand' data-dynamic='true' />
    <meta property='og:site_name' content='Flatsondemand' data-dynamic='true' />
    <meta property='og:url' content='https://www.flatsondemand.in' />
    <meta property='og:description' content='Easiest way to rent a home'  data-dynamic='true' />
    <meta property='og:type' content='website'  data-dynamic='true' />
    <meta property='og:image' content='https://res.cloudinary.com/flatsondemand/image/upload/v1594811953/Screenshot_2020-07-15_at_4.37.24_PM_zjsmk2.png' />
    <meta property='og:image:type' content='image/png' data-dynamic='true'>
    <meta property='og:image:width' content='1200'  data-dynamic='true' />
    <meta property='og:image:height' content='630'  data-dynamic='true' />
    <meta property="og:locale" content="en_US" />
    <meta name="twitter:card" content="Flatsondemand , Easiest way to rent a home">
    <meta name="google-site-verification" content="Site verification" />
    <link rel="canonical" href="http://myfod.in/" />
    <link rel="icon" href="panel/assets/images/logo.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="panel/assets/images/logo.png" />
    <meta name="msapplication-TileImage" content="hpanel/assets/images/logo.png" />
    <meta name="google-site-verification" content="gggZUgd_gLB2qp2NGNJ3s7j6bBB-Zb_5HB9pNpu6YTc" />
    <title>FOD living By Flatsondemand || Home</title>
    <meta name="description" content="
    Flatsondemand , FOD | Easiest way to rent a home , Pg rental , Flat , 2BHK , 3BHK , 1BHK , Flats On Demand in Chehru, Phagwara is a top company in the category Estate Agents For Residential Rental, also known for Estate Agents, Paying Guest Accommodations, Paying Guest Accommodations For Men, Paying Guest Accommodations For Women, Estate Agents For Land and much more.Flats On Demand, Chehru, Phagwara.">
    <meta name="keywords" content="Pg near Lovely professional university, Flats On Demand Phagwara, Home Rent in Jalandahr, Flats On Demand Chehru, Boys PG in Jalandhar ,Pg in Jalandhar ,Pg in Law gate ,Pg near LPU ,1 BHK Flat near LPU">
    <!-- Bootstrap Core css -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Theme Css By Hackdroid  -->
    <link rel="stylesheet" href="assets/css/theme.css">
      <!-- Animate css -->
    <link rel="stylesheet" href="assets/css/animate.css"/>
    <!-- Responsive Handling css -->
    <link rel="stylesheet" href="assets/css/responsive.css">
  
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.0/dist/sweetalert2.all.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light fixed-top white ">
        <a class="navbar-brand " href="./">
        Flats<span class="text-theme-color">ondemand</span>
        </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="fa fa-bars"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                  <a class="nav-link" href="./">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link " href="?view=rent">Rent payment</a>
                </li>

                <?php
                  if($isLoggedIn){
                    ?>
                    <li class="dropdown nav-item">
                <a class="dropdown-toggle nav-link" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-user"></i> Your profile
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="?view=profile">My Account</a>
                  <a class="dropdown-item" href="?view=mybooking">My Booking</a>
                  <a class="dropdown-item" href="#">My Shortlist</a>
                  <a class="dropdown-item" href="#">My Tour</a>
                  <a class="dropdown-item" href="?view=logout">Logout</a>
                </div>
                  </li>
                    <?php
                  }else{
                    ?>
                    <li class="nav-item al-center">
                      <a class="nav-link btn  btn-c btn-gradient" href="?view=login">
                      <i class="fa fa-lock"></i>
                      login</a>
                    </li>
                    <?php
                  }
                ?>
    </ul>

  </div>
</nav>
<div id="overlay" style="display:none;">
    <div class="spinner"></div>
    <br/>
    Please wait...
</div>
