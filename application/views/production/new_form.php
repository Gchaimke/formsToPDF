<main role="main">
      <div class="jumbotron">
            <div class="container">
                  <center>
                        <h2 class="display-3">New Form</h2>
                  </center>
            </div>
      </div>
      <div class="container">
      <div id="form-messages" class='alert hidden' role='alert'></div>
            <center>
                  <?php
                  if (validation_errors()) {
                        echo "<div class='alert alert-danger' role='alert'>" . validation_errors() . "</div>";
                  }
                  ?>
                  
                  <?php echo form_open("production/add_form", 'class=user-create'); ?>
                  <input type='text' class="form-control " name='company' placeholder="Company" value="<?php echo $_GET['company']?>" hidden>
                  <label>date</label>
                  <input type='date' class="form-control" name='date' value="<?php echo date("Y-m-d"); ?>"></br>
                  <label>client_num</label>
                  <input type='text' class="form-control " name='client_num' placeholder="client_num"></br>
                  <label>issue_num</label>
                  <input type='text' class="form-control " name='issue_num' placeholder="issue_num"></br>
                  <label>client_name</label>
                  <input type='text' class="form-control " name='client_name' placeholder="client_name"></br>
                  <label>issue_kind</label>
                  <input type='text' class="form-control " name='issue_kind' placeholder="issue_kind"></br>
                  <label>place</label>
                  <input type='text' class="form-control " name='place' placeholder="place"></br>
                  <label>start_time</label>
                  <input type='time' class="form-control " name='start_time' placeholder="start_time"></br>
                  <label>end_time</label>
                  <input type='time' class="form-control " name='end_time' placeholder="end_time"></br>
                  <label>manager</label>
                  <input type='text' class="form-control " name='manager' placeholder="manager"></br>
                  <label>contact_name</label>
                  <input type='text' class="form-control " name='contact_name' placeholder="contact_name"></br>
                  <label>activity_text</label>
			<textarea class="form-control" name="activity_text" cols="40" rows="5"></textarea>
                  <label>checking_text</label>
                  <textarea class="form-control" name="checking_text" cols="40" rows="5"></textarea>
                  <label>summary_text</label>
                  <textarea class="form-control" name="summary_text" cols="40" rows="5"></textarea>
                  <label>remarks_text</label>
                  <textarea class="form-control" name="remarks_text" cols="40" rows="5"></textarea>
                  <label>recommendations_text</label>
                  <textarea class="form-control" name="recommendations_text" cols="40" rows="5"></textarea>
                  <label>trip_start_time</label>
                  <input type='time' class="form-control " name='trip_start_time' placeholder="trip_start_time"></br>
                  <label>trip_end_time</label>
                  <input type='time' class="form-control " name='trip_end_time' placeholder="trip_end_time"></br>
                                   
                  <input type='submit' class="btn btn-info btn-block" name='submit' value='Submit'>
                  <?php echo form_close(); ?>
            </center>
      </div>
</main>