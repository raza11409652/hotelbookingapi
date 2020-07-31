<noscript>
<div class="noScriptContainer">
<section class="noScriptErrorContainer alert alert-warning">
<span class="noScriptErrorText">The sandbox is too restrictive and preventing correct functioning.</span>
</section>
<p class="text-info">
 <i class="fa fa-exclamation"></i>   
Your Javascript is disabled please enable it and refresh the page </p>
</div>
</noscript>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/datepicker/default.js"></script>
<script src="assets/datepicker/default.time.js"></script>
<script src="assets/datepicker/default.date.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/app.min.js"></script>

<?php 
    if(isset($_SESSION) && isset($_SESSION['isLoggedIn'])){
echo "<script src='assets/js/panel.js'></script>
<script src='assets/js/caretaker.js'></script>
";        
    }
?>
</body>
</html>