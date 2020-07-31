<!-- Modal for Payment settled Process for single -->
<div class="modal" tabindex="-1" role="dialog" id="paymentsettle" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title"> Payment settlement process </h5>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           <div class="row">
                <div class="col-lg-6">
                    <div class="result"></div>
                   </div>
               <div class="col-lg-6">
                   <form action="" method="post" id="paymentsettle-form">
                       <input type="text" id="paymentsettle-id" name="payment" hidden>
                   <div class="form-group">
                        <input type="text" name="ref" required class="input-control" placeholder="Payment Ref">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" required class="input-control" placeholder="Enter Your password">
                    </div>
                   
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary-theme float-right">Settle</button>
                    </div>
                   </form>
               </div>
               
           </div>
      </div>
      
    </div>
  </div>
</div>