<!-- Modal for House keeping create -->
<div class="modal" tabindex="-1" role="dialog" id="houseKeepingReq" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">House keeping Request</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form class="" id="new_request_house_keeping_form" method="post">
          <div class='form-group'>
            <select class="form-control h-4" name="booking">
                <option value="" hidden>Select Your booking </option>
                <?php

                $bill =97 ;
                $internetCharge =($bill *2.5)/100 ;
                $internetCharge = (int)$internetCharge;
                if($internetCharge<10){
                  $internetCharge ="0{$internetCharge}";
                }
                $u = @$userId;
                $total =$bill + $internetCharge;
                $query = "SELECT *FROM booking where booking_user='{$u}' && booking_status='2'";
                $res = mysqli_query($connection , $query);
                  while($data = mysqli_fetch_assoc($res)){
                    $propertyId =  $data['booking_property'];
                    $PROPERTY = getProperty($propertyId , $connection);
                    $ROOM =getRoom($data['booking_room'] , $connection);
                    // var_dump($PROPERTY);
                    $propertyName =@$PROPERTY['property_name'];
                    echo "
                      <option value='{$data['booking_id']}'>{$data['booking_number']} - {$propertyName} - {$ROOM['room_number']}</option>
                    ";
                  }
                 ?>
            </select>

          </div>
          <div class="form-group">
            <label for="">Select date <i class='fa fa-calendar'></i> </label>
            <?php
                $date =date('Y-m-d');
                $date=  getNextDate($date);
               ?>
               <select class="form-control h-4" name="date" id='date_selector_house_keeping'>
                  <option value="" hidden>Select date </option>
                    <option value="<?php echo $date ?>"><?php echo $date ?></option>
                  <?php
                    for($i=0; $i<6;$i++){
                      $date = getNextDate($date);
                      echo "<option value='{$date}'>{$date}</option>";
                    }
                   ?>
               </select>
          </div>
          <div class="form-group">
            <label for="">Select time slot <i class='fa fa-clock'></i></label>
            <select class="form-control h-4" name="time" id="time_slot">
                <option value="" hidden>Select time slot</option>
            </select>
          </div>
          <div class="form-group">
              <div class="bg-light p-2">

                <div class="row">
                  <div class="col-lg-6">
                    Bill
                  </div>
                  <div class="col-lg-6 text-right">
                    Rs. <?php echo $bill ?>
                  </div>

                </div>
                <div class="row">
                  <div class="col-lg-6">
                    Internet handling charge
                  </div>
                  <div class="col-lg-6 text-right">
                    Rs. <?php echo $internetCharge ?>
                  </div>

                </div>
                <div class="row">
                  <div class="col-lg-6">
                    Total
                  </div>
                  <div class="col-lg-6 text-right">
                    Rs. <?php echo $total ?>
                  </div>

                </div>

              </div>

          </div>
          <input type="text"  name="amount" value="<?php echo $total ?>" hidden>
          <input type="text" name="user" id="user" value="<?php echo @$userUid ?>" hidden>
          <div class="form-group">
            <button type="submit" name="button" class='btn btn-primary'>Pay now</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
<!-- End here -->

<footer class="main-footer">
    <div class="container p-4">
       <div class="row clearfix">
           <div class="col-lg-4">
               <div class="logo-holder">
                   <p>
                    <img src="panel/assets/images/logo.png" alt="">
                   </p>
                   <ul>
                       <li><a href="#">About us</a></li>
                       <li><a href="#">Careers</a></li>
                       <li><a href="?view=contact">Contact</a></li>
                   </ul>
               </div>
           </div>
           <div class="col-lg-4">
               <div class="logo-holder">
                   <p>Quick links</p>
                   <ul>
                       <li><a href="?view=rent">Pay your rent</a></li>
                       <li><a href="?view=privacy-policy">Privacy policy</a></li>
                       <li><a href="?view=terms">Terms and conditions</a></li>
                   </ul>
               </div>
           </div>
           <div class="col-lg-4">
                <div class="social-logo-holder">
                    <ul>
                            <li>
                                <a href="https://www.facebook.com/flatsondemand/?src=webpagae_footer" target="_blank" class="fb-icon"><i class="fab fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/flatsondemand/" target="_blank" class="insta-icon"><i class="fab fa-instagram"></i></a>
                            </li>
                            <li>
                                <a href="https://api.whatsapp.com/send?phone=919501909482" target="_blank" class="whatsapp-icon"><i class="fab fa-whatsapp"></i></a>
                            </li>
                            <li>
                                <a href="tel:09501909482" class="phone-icon" target="_blank"><i class="fa fa-phone"></i></a>
                            </li>
                            <li>
                                <a href="" class="mail-icon"><i class="fa fa-envelope"></i></a>
                            </li>
                    </ul>

                </div>
           </div>
       </div>
       <div class="footer-credits d-lg-flex justify-content-lg-between align-items-center">
            <div class="text-small"> This website is designed and developed  with <i class="fa fa-heart text-danger" aria-hidden="true"></i> by <a href="#" target="_blank"><strong>Hackdroid</strong></a></div>

            <div class="text-small">Copyright © <script>document.write(new Date().getFullYear());</script>  All Rights Reserved to Flatsondemand</div>
        </div>

    </div>
</footer>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- Script before login user -->
<script src="assets/js/app.js"></script>
<script src="assets/js/wow.js"></script>
<script>
  new WOW().init();
</script>

</body>
</html>
