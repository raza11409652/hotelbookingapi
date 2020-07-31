<!-- Modal for House keeping create -->
<div class="modal" tabindex="-1" role="dialog" id="complaintsView" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Complaints and maintanance</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form class="" id="complaints_form" method="post">
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
                $total =$bill + $internetCharge;
                $query = "SELECT *FROM booking where booking_user='{$userId}' && booking_status='2'";
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

          <div class='form-group'>
            <label for="">Select Category <i class="fa fa-cogs"></i> </label>
            <select class="form-control h-4" name="category" id="category_selector">
              <option value="" hidden>Select category </option>
              <?php
              $sql = "SELECT * from complaints_issue order by complaints_issue_topic";
              $res = mysqli_query($connection , $sql) ;
              while($topic = mysqli_fetch_assoc($res)){
                echo "
                  <option value='{$topic['complaints_issue_id']}'>{$topic['complaints_issue_topic']}</option>
                ";
              }
               ?>
            </select>
          </div>
          <div class="form-group">
              <label for="">Select Sub Category</label>
              <select class="form-control h-4" name="subCategory" id='subCat'>
                  <option value="" hidden>Select sub category </option>
              </select>
          </div>
          <div class="form-group">
            <label for="">Select date <i class='fa fa-calendar'></i> </label>
            <?php
                $date =date('Y-m-d');
                $date=  getNextDate($date);
               ?>
               <select class="form-control h-4" name="date" >
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
              <textarea class='form-control' placeholder="Remarks" name="remarks"></textarea>

          </div>
          


          <input type="text" name="user" id="user" value="<?php echo $userUid ?>" hidden>
          <div class="form-group">
            <button type="submit" name="button" class='btn btn-primary-theme'>Submit</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
<!-- End here -->
