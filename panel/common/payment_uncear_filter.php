<!-- Modal for Payment unclear filter details -->
<div class="modal" tabindex="-1" role="dialog" id="payment-unclear-filter" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Filter</h5>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="query-filter-form" method="POST">
        <div class="form-group">
          <label for="">Payment Mode</label>
          <select name="mode" id="payment-mode-selector" class="form-control">
            <option value="null">Select </option>
            <option value="ONLINE">Online </option>
            <option value="OFFLINE">Offline </option>
          </select> 
        </div>
        <div class="form-group">
          <label for="">Caretaker</label>
          <select name="caretaker" id="caretaker-selector" class="form-control">
            <option value="null">Select </option>
            <?php 
              $q = "SELECT * from caretaker order by caretaker_id " ; 
              $r = mysqli_query($connection , $q) ; 
              while($d  = mysqli_fetch_assoc($r)){
                echo "<option value='{$d['caretaker_uid']}'>{$d['caretaker_name']} - {$d['caretaker_uid']}</option>" ; 
              }
            ?>
          </select> 
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-danger">Search</button>
        </div>
        </form>
      </div>
      
    </div>
  </div>
</div>