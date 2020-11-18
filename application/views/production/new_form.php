<?php $user = $user[0] ?>
<script src="<?php echo base_url('assets/js/jQUpload/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jQUpload/jquery.iframe-transport.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jQUpload/jquery.fileupload.js'); ?>"></script>
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
                  <input type='hidden' class="form-control " name='company' value="<?php echo $_GET['company'] ?>">
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
                                          <div class="input-group-text">מספר לקוח</div>
                                    </div>
                                    <input type='text' class="form-control" name='client_num'>
                              </div>
                        </div>
                        <div class="form-group col-md-4">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text">מספר פניה \ תקלה</div>
                                    </div>
                                    <input type='text' id='issue_num' class="form-control" name='issue_num'>
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
                  <hr />
                  <div class="form-group row" id="emails">
                        <label for="email_to" class="col-sm-2 col-form-label ">מכותבים:</label>
                        <?php
                        $emails_arr = preg_split('/\r\n|[\r\n]/', $user['email_to']);
                        $len = count($emails_arr);
                        if ($len > 0 && $emails_arr[0] != '') {
                              $firsthalf = array_slice($emails_arr, 0, $len / 2);
                              $secondhalf = array_slice($emails_arr, $len / 2);
                              echo "<div class='col-sm-5'>
                              <div class='input-group-text'>
                              <input type='checkbox' value='" . $user['email'] . "'>
                              <label class='col-sm-2 col-form-label'>" . $user['email'] . "</label>
                              </div>";
                              foreach ($firsthalf as $email) {
                                    echo "
                              <div class='input-group-text'>
                              <input type='checkbox' value='$email'>
                              <label class='col-sm-2 col-form-label'>$email</label>
                              </div>";
                              }
                              echo '</div>';
                              echo '<div class="col-sm-5">';
                              foreach ($secondhalf as $email) {
                                    echo "
                              <div class='input-group-text'>
                              <input type='checkbox' value='$email'>
                              <label class='col-sm-2 col-form-label'>$email</label>
                              </div>";
                              }
                              echo '</div>';
                        } else {
                              echo '<div class="col-sm-5">אין פריטים ברשימת תפוצה של משתמש</div>';
                        }
                        ?>
                        <input type="text" id="sum" class="form-control ltr mt-3" name='email_to' value="">
                  </div>
                  <hr />


                  <div class="form-group row">
                        <label for="attachments" class="col-sm-2 col-form-label ">קבצים נוספים</label>
                        <div class="col-sm-10">
                              <input id="fileupload" style="display:none;" type="file" name="files" data-url="/production/do_upload/<?php echo $_GET['company'] ?>" />
                              <input type="hidden" id="attachments" value="" name="attachments" />
                              <div id='files'></div>
                              <button class="btn btn-outline-secondary col-sm-2 mt-2 mt-md-0" type="button" onclick="document.getElementById('fileupload').click();">העלה</button>
                        </div>
                  </div>
                  <hr />
                  <div class="form-row row">
                        <div class="form-group row col-md-9 mr-2">
                              <label for="details" class="col-sm-2 col-form-label ">הערות (CSV)</label>
                              <div class="col-sm-10">
                                    <textarea class="form-control" name="details" rows="3"></textarea>
                              </div>
                        </div>
                        <div class="form-group col-md-3">
                              <div class="input-group">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text">מחיר</div>
                                    </div>
                                    <input type='text' id='price' class="form-control" name='price'>
                              </div>
                        </div>
                  </div>
                  <hr />

                  <div class="form-row">
                        <div class="form-group col-md-12">
                              <label for="client_sign" class=" col-form-label ">חתימת לקוח</label>
                              <div id="sketchpadapp">
                                    <canvas id="sign-canvas" style="border: 1px solid red;"></canvas>
                              </div>
                              <input type='text' id="client_sign" name='client_sign' hidden>
                              <a href="#sign-canvas" class="btn btn-outline-danger btn-sm mt-3" onclick='$("#sign-canvas").data("jqScribble").clear();'>נקה חתימה</a>
                        </div>
                  </div>
                  <hr />
                  <input id='save_form' type='button' class="btn btn-success my-5" name='submit' value='שמור'>
                  <input type='submit' class="btn btn-danger my-5" name='submit' value='שמור ושלח לרשימת תפוצה'>
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
            });

            var sum = '';
            $('#emails :checkbox').click(function() {
                  sum = '';
                  $('#emails :checkbox:checked').each(function(idx, elm) {
                        sum += elm.value + ", ";
                  });
                  $('#sum').val(sum);
            });
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
            }).fail(function(response) {
                  $('#form-messages').addClass('alert-danger');
                  // Set the message text.
                  $('#form-messages').html('אין אפשרות לשמור שינוים' + response).fadeIn(1000);
            });
      });

      $('#save_form').click(function() {
            saveSign();
            var formData = $('#new-form').serialize();
            $.ajax({
                  type: 'POST',
                  url: $('#new-form').attr('action'),
                  data: formData
            }).done(function(response) {
                  console.log(response);
                  if ($.isNumeric(response)) {
                        window.location.href = "/production/view_form/" + response;
                  } else {
                        $('#form-messages').addClass('alert-danger');
                        // Set the message text.
                        $('#form-messages').html('אין אפשרות לשמור את השינוים ' + response).fadeIn(1000);
                  }
            }).fail(function(response) {
                  $('#form-messages').addClass('alert-danger');
                  // Set the message text.
                  $('#form-messages').html('אין אפשרות לשמור שינוים' + response).fadeIn(1000);
            });
      })

      function SendEmail(id) {
            var ans = 'no';
            //var r = confirm("לשלוח עם קבצים נוספים?");
            //if (r == true) {
            //      var ans = 'yes';
            //} else {
            //      ans = 'no';
            //}
            //var newWindow = window.open("", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=800");
            // Make sure that the formMessages div has the 'success' class.
            $('#form-messages').removeClass('alert-danger').addClass('alert-info');
            // Set the message text.
            $('#form-messages').html("שולח מייל, נא להמתין...").fadeIn(1000);
            $.post("/exportpdf/create/" + id, {
                  email: true,
                  add_attachments: ans
            }).done(function(o) {
                  // Make sure that the formMessages div has the 'success' class.
                  $('#form-messages').removeClass('alert-info').addClass('alert-success');
                  // Set the message text.
                  $('#form-messages').html(o).fadeIn(1000).delay(5000).fadeOut(1000);
                  setTimeout(function() {
                        //window.location.href = "/exportpdf/create/" + id;
                        window.location.href = "/production/view_form/" + id;
                  }, 3000); //will call the function after 2 secs.
                  //newWindow.location.href = "/exportpdf/create/" + id;
            }).fail(function(o) {
                  $('#form-messages').removeClass('alert-info').addClass('alert-danger');
                  // Set the message text.
                  $('#form-messages').html(o).fadeIn(1000);
            });
      }
</script>