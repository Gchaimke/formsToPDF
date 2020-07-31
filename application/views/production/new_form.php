<?php $user = $this->session->userdata['logged_in']; ?>
<script src="<?php echo base_url('assets/js/jQUpload/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jQUpload/jquery.iframe-transport.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jQUpload/jquery.fileupload.js'); ?>"></script>
<style>
      .file {
            position: relative;
            background: linear-gradient(to right, lightblue 50%, transparent 50%);
            background-size: 200% 100%;
            background-position: right bottom;
            transition: all 1s ease;
      }

      .file.done {
            background: lightgreen;
      }

      .file a {
            display: block;
            position: relative;
            padding: 5px;
            color: black;
      }
</style>
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
                                    <input type='text' id='issue_num' class="form-control" name='issue_num' required>
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
                  <div class="form-group row" id="emails">
                        <label for="email_to" class="col-sm-2 col-form-label ">למי לשלוח מייל:</label>
                        <?php
                        $emails_arr = preg_split('/\r\n|[\r\n]/', $user['email_to']);
                        $len = count($emails_arr);
                        if ($len > 0 && $emails_arr[0]!='') {
                              $firsthalf = array_slice($emails_arr, 0, $len / 2);
                              $secondhalf = array_slice($emails_arr, $len / 2);
                              echo '<div class="col-sm-5">';
                              foreach ($firsthalf as $email) {
                                    echo "<div class='input-group'>
                              <div class='input-group-text'>
                              <input type='checkbox' value='$email'>
                              </div>
                              <label class='col-sm-2 col-form-label'>$email</label>
                              </div>";
                              }
                              echo '</div>';
                              echo '<div class="col-sm-5">';
                              foreach ($secondhalf as $email) {
                                    echo "<div class='input-group'>
                              <div class='input-group-text'>
                              <input type='checkbox' value='$email'>
                              </div>
                              <label class='col-sm-2 col-form-label'>$email</label>
                              </div>";
                              }
                              echo '</div>';
                        }else{
                              echo '<div class="col-sm-5">אין פריטים ברשימת תפוצה של משתמש</div>';
                        }
                        ?>

                  </div>
                  <div class="form-group row">
                        <label for="email_to" class="col-sm-2 col-form-label ">רשימת תפוצה</label>
                        <div class="col-sm-10">
                              <input type='text' id="sum" class="form-control ltr" name='email_to'>
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

                  <div class="form-group row">
                        <label for="attachments" class="col-sm-2 col-form-label ">קבצים נוספים</label>
                        <div class="col-sm-10">
                              <input id="fileupload" style="display:none;" type="file" name="files" data-url="/production/do_upload/<?php echo $_GET['company'] ?>" />
                              <textarea rows="3" cols="100" id="attachments" type="text" class="ltr" name="attachments"></textarea>
                              <div id='files'></div>
                              <button class="btn btn-outline-secondary col-sm-2" type="button" onclick="document.getElementById('fileupload').click();">העלה</button>
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
                  $('#form-messages').html(o).fadeIn(1000).delay(5000).fadeOut(1000);
                  setTimeout(function() {
                        window.location.href = "/exportpdf/create/" + id;
                  }, 3000); //will call the function after 2 secs.

            }).fail(function(o) {
                  $('#form-messages').removeClass('alert-info').addClass('alert-danger');
                  // Set the message text.
                  $('#form-messages').html(o).fadeIn(1000);
            });
      }

      $("#fileupload").fileupload({
            autoUpload: true,
            add: function(e, data) {
                  data.context = $('<p class="file ltr">')
                        .append($('<span>').text(data.files[0].name))
                        .appendTo('#files');
                  data.submit();
            },
            progress: function(e, data) {
                  var progress = parseInt((data.loaded / data.total) * 100, 10);
                  data.context.css("background-position-x", 100 - progress + "%");
            },
            done: function(e, data) {
                  setTimeout(function() {
                        data.context.addClass("done");
                  }, 1000);
                  if ($('#attachments').val() == '') {
                        $('#attachments').val(data.result);
                  } else {
                        $('#attachments').val($('#attachments').val() + "," + data.result);
                  }

                  console.log(data.result);
            }
      });
</script>