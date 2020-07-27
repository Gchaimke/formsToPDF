<main role="main">
      <div class="jumbotron">
            <div class="container">
                  <center>
                        <h2 class="display-3">Form <?php echo $_GET['issue']; ?> </h2>
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
                  <?php if (isset($form_data)) {
                        $form_data = $form_data[0];
                  ?>

                        <?php echo form_open("admin/update_form", 'id=ajax-form', 'class=user-create'); ?>
                        <input type='num' class="form-control" name='id' value="<?php echo $form_data['id'] ?>" hidden>
                        <label>date</label>
                        <input type='date' class="form-control" name='date' value="<?php echo $form_data['date'] ?>">
                        <label>start_time</label>
                        <input type='time' class="form-control" name='start_time' placeholder="start_time" value="<?php echo $form_data['start_time'] ?>">
                        <label>end_time</label>
                        <input type='time' class="form-control" name='end_time' placeholder="end_time" value="<?php echo $form_data['end_time'] ?>"></br>
                        
                        <label>client_num</label>
                        <input type='text' class="form-control" name='client_num' placeholder="client_num" value="<?php echo $form_data['client_num'] ?>">
                        <label>issue_num</label>
                        <input type='text' class="form-control" name='issue_num' placeholder="issue_num" value="<?php echo $form_data['issue_num'] ?>">
                        <label>client_name</label>
                        <input type='text' class="form-control" name='client_name' placeholder="client_name" value="<?php echo $form_data['client_name'] ?>"></br>

                        <label>issue_kind</label>
                        <input type='text' class="form-control" name='issue_kind' placeholder="issue_kind" value="<?php echo $form_data['issue_kind'] ?>">
                        <label>place</label>
                        <input type='text' class="form-control" name='place' placeholder="place" value="<?php echo $form_data['place'] ?>"></br>
                        <label>manager</label>
                        <input type='text' class="form-control" name='manager' placeholder="manager" value="<?php echo $form_data['manager'] ?>"></br>
                        <label>contact_name</label>
                        <input type='text' class="form-control" name='contact_name' placeholder="contact_name" value="<?php echo $form_data['contact_name'] ?>"></br>
                        <label>activity_text</label>
                        <textarea class="form-control" name="activity_text" cols="10" rows="3"><?php echo $form_data['activity_text'] ?></textarea>
                        <label>checking_text</label>
                        <textarea class="form-control" name="checking_text" cols="10" rows="3"><?php echo $form_data['checking_text'] ?></textarea>
                        <label>summary_text</label>
                        <textarea class="form-control" name="summary_text" cols="10" rows="3"><?php echo $form_data['summary_text'] ?></textarea>
                        <label>remarks_text</label>
                        <textarea class="form-control" name="remarks_text" cols="10" rows="3"><?php echo $form_data['remarks_text'] ?></textarea>
                        <label>recommendations_text</label>
                        <textarea class="form-control" name="recommendations_text" cols="10" rows="3"><?php echo $form_data['recommendations_text'] ?></textarea>
                        <label>trip_start_time</label>
                        <input type='time' class="form-control" name='trip_start_time' placeholder="trip_start_time" value="<?php echo $form_data['trip_start_time'] ?>"></br>
                        <label>trip_end_time</label>
                        <input type='time' class="form-control" name='trip_end_time' placeholder="trip_end_time" value="<?php echo $form_data['trip_end_time'] ?>"></br>

                        <input type='submit' class="btn btn-info btn-block" name='submit' value='Update'>
                        <?php echo form_close(); ?>
                        <a href="/exportpdf/create/<?php echo $form_data['id'] ?>">test pdf</a>
                  <?php } else {
                        echo "No Data for this form.";
                  } ?>
            </center>
      </div>
</main>