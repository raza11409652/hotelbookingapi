<div class="modal fade" id="paymentRcvFilterModal" tabindex="-1" role="dialog" aria-labelledby="bookingfiltermodal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Booking Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" id="filterPaymentRcv">
      <div class="modal-body">
       <div class="form-group">
       <label for="">
        <i class="fa fa-calendar"></i> Select starting date</label>
        <input type="text" class="form-control datepicker" name="start" 
        placeholder="Booking Start Date" id='datePickerStart'>

       </div>
       <div class="form-group">
       <label for="">
        <i class="fa fa-calendar"></i> Select Ending date</label>
        <input type="text" class="form-control datepicker" name="end" 
        placeholder="Booking End Date" id='datePickerEnd'>

       </div>
       <div class="form-group">
        <button type="submit" class="btn btn-primary">Apply</button>

       </div>
      </div>
      
      </form>
      
    </div>
  </div>
</div>