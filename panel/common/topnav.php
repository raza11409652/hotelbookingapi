<?php 
require_once "middleware/SessionHandler.php";
require_once "middleware/TokenValidator.php";

?>
<nav class="navbar navbar-expand-lg navbar-dark theme-navbar fixed-top  ">

<a class="navbar-brand d-flex " href="./">

<!-- <img src="logo/logo_small.png" alt="DElsto" class="logo_company"> -->

<div class="text_company">Flats<span class="text-theme-color">ondemand</span></div> 

</a>

<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

<span class="fa fa-bars"></span>

</button>



<div class="collapse navbar-collapse" id="navbarSupportedContent">

<ul class="navbar-nav ml-auto">

<li class="nav-item">

<a class="nav-link " href="?view=partners">Partner</a>

</li>

<li class="nav-item">

<a class="nav-link " href="?view=bookings">Bookings</a>

</li>





<li class="nav-item">

<a class="nav-link btn  btn-primary-theme text-white" href="?view=logout">

<i class="fas fa-sign-out-alt"></i>  

Logout</a>

</li>



</ul>





</div>

</nav>