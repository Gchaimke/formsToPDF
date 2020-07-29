<div id="form-messages" class='alert hidden test' role='alert'></div>
<main role="main">
      <div class="jumbotron">
            <div class="container">
                  <center>
                        <h5>דוח חדש</h5>
                  </center>
            </div>
      </div>
      <div class="container">
            <center>
                  <?php echo form_open("production/add_form", 'id=new-form'); ?>
                  <input type='text' class="form-control " name='company' value="<?php echo $_GET['company'] ?>" hidden>
                  <div class="form-row">
                        <div class="form-group col-md-4">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text"><span class="red">*</span>תאריך</div>
                                    </div>
                                    <input type='date' class="form-control" name='date' required>
                              </div>
                        </div>
                        <div class="form-group col-md-4">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text">שעת התחלה</div>
                                    </div>
                                    <input type='time' class="form-control" name='start_time'>
                              </div>
                        </div>
                        <div class="form-group col-md-4">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text">שעת סיום</div>
                                    </div>
                                    <input type='time' class="form-control" name='end_time'>
                              </div>
                        </div>
                  </div>

                  <div class="form-row">
                        <div class="form-group col-md-4">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text"><span class="red">*</span>מספר לקוח</div>
                                    </div>
                                    <input type='text' class="form-control" name='client_num' required>
                              </div>
                        </div>
                        <div class="form-group col-md-4">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text"><span class="red">*</span>מספר פניה \ תקלה</div>
                                    </div>
                                    <input type='text' class="form-control" name='issue_num' required>
                              </div>
                        </div>
                        <div class="form-group col-md-4">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text">סוג תקלה \ התקנה</div>
                                    </div>
                                    <input type='text' class="form-control" name='issue_kind'>
                              </div>
                        </div>
                  </div>

                  <div class="form-row">
                        <div class="form-group col-md-6">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text">שם לקוח</div>
                                    </div>
                                    <input type='text' class="form-control" name='client_name'>
                              </div>
                        </div>
                        <div class="form-group col-md-6">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text">מיקום</div>
                                    </div>
                                    <input type='text' class="form-control" name='place'>
                              </div>
                        </div>
                  </div>

                  <div class="form-row">
                        <div class="form-group col-md-6">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text">אחראי</div>
                                    </div>
                                    <input type='text' class="form-control" name='manager'>
                              </div>
                        </div>
                        <div class="form-group col-md-6">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text">איש קשר</div>
                                    </div>
                                    <input type='text' class="form-control" name='contact_name'>
                              </div>
                        </div>
                  </div>
                  <div class="form-group row">
                        <label for="activity_text" class="col-sm-2 col-form-label ">תיאור תקלה \ פניה</label>
                        <div class="col-sm-10">
                              <textarea class="form-control" name="activity_text" cols="10" rows="3"></textarea>
                        </div>
                  </div>

                  <div class="form-group row">
                        <label for="checking_text" class="col-sm-2 col-form-label ">תוצאות הבדיקה</label>
                        <div class="col-sm-10">
                              <textarea class="form-control" name="checking_text" cols="10" rows="3"></textarea>
                        </div>
                  </div>

                  <div class="form-group row">
                        <label for="summary_text" class="col-sm-2 col-form-label ">סיכום</label>
                        <div class="col-sm-10">
                              <textarea class="form-control" name="summary_text" cols="10" rows="3"></textarea>
                        </div>
                  </div>

                  <div class="form-group row">
                        <label for="remarks_text" class="col-sm-2 col-form-label ">הערות</label>
                        <div class="col-sm-10">
                              <textarea class="form-control" name="remarks_text" cols="10" rows="3"></textarea>
                        </div>
                  </div>

                  <div class="form-group row">
                        <label for="recommendations_text" class="col-sm-2 col-form-label ">המלצות</label>
                        <div class="col-sm-10">
                              <textarea class="form-control" name="recommendations_text" cols="10" rows="3"></textarea>
                        </div>
                  </div>

                  <div class="form-row">
                        <div class="form-group col-md-3">
                              <label for="trip_start_time" class=" col-form-label ">נסיעה הלוך התחלה</label>
                              <input type='time' class="form-control" name='trip_start_time'>
                        </div>
                        <div class="form-group col-md-3">
                              <label for="trip_end_time" class="col-form-label ">נסיעה הלוך סיום</label>
                              <input type='time' class="form-control" name='trip_end_time'>
                        </div>
                        <div class="form-group col-md-3">
                              <label for="back_start_time" class=" col-form-label ">נסיעה חזור התחלה</label>
                              <input type='time' class="form-control" name='back_start_time'>
                        </div>
                        <div class="form-group col-md-3">
                              <label for="back_end_time" class=" col-form-label ">נסיעה חזור סיום</label>
                              <input type='time' class="form-control" name='back_end_time'>
                        </div>
                  </div>
                  <div class="form-row">
                        <div class="form-group col-md-12">
                              <label for="back_start_time" class=" col-form-label ">חתימת לקוח</label>
                              <div id="sketchpadapp">
                                    <canvas id="sign-canvas" style="border: 1px solid red;"></canvas>
                              </div>
                              <input type='text' id="client_sign" name='client_sign' hidden>
                              <a href="#sign-canvas" class="btn btn-info btn-block" onclick='$("#sign-canvas").data("jqScribble").clear();'>נקה חתימה</a>
                        </div>
                  </div>

                  <input type='submit' class="btn btn-info btn-block" name='submit' value='שמור ושלח לרשימת תפוצה'>
                  <?php echo form_close(); ?>

            </center>
      </div>
</main>
<script>
      $(document).ready(function() {
            //startup scripts here
            $("#sign-canvas").jqScribble();
            $("#sign-canvas").data('jqScribble').update({
                  width: 300,
                  height: 100
            })
      });

      $('#new-form').submit(function(event) {
            // Stop the browser from submitting the form.
            event.preventDefault();
            saveSign();
            var formData = $('#new-form').serialize();
            $.ajax({
                  type: 'POST',
                  url: $('#new-form').attr('action'),
                  data: formData
            }).done(function(response) {
                  if ($.isNumeric(response)) {
                        SendEmail(response);
                  } else {
                        $('#form-messages').addClass('alert-danger');
                        // Set the message text.
                        $('#form-messages').html('אין אפשרות לשמור את השינוים ' + response).fadeIn(1000);
                  }
            }).fail(function() {
                  $('#form-messages').addClass('alert-danger');
                  // Set the message text.
                  $('#form-messages').html('אין אפשרות לשמור שינוים' + response).fadeIn(1000);
            });

      });

      function SendEmail(id) {
            // Make sure that the formMessages div has the 'success' class.
            $('#form-messages').removeClass('alert-danger').addClass('alert-info');
            // Set the message text.
            $('#form-messages').html("שולח מייל, נא להמתין...").fadeIn(1000);
            $.post("/exportpdf/create/" + id, {
                  email: true
            }).done(function(o) {
                  // Make sure that the formMessages div has the 'success' class.
                  $('#form-messages').removeClass('alert-info').addClass('alert-success');
                  // Set the message text.
                  $('#form-messages').html(o).fadeIn(1000).delay(3000).fadeOut(1000);
                  setTimeout(function() {
                        window.location.href = "/exportpdf/create/" + id;
                  }, 3000); //will call the function after 2 secs.

            }).fail(function(o) {
                  $('#form-messages').removeClass('alert-info').addClass('alert-danger');
                  // Set the message text.
                  $('#form-messages').html(o).fadeIn(1000);
            });
      }
</script>