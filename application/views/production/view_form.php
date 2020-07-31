<?php
if (isset($this->session->userdata['logged_in'])) {
      $user_role = $this->session->userdata['logged_in']['role'];
}
?>
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
<div id="form-messages" class='alert hidden' role='alert'></div>
<main role="main">
      <div class="jumbotron">
            <div class="container">
                  <center>
                        <h5>עדכון דוח </h5>
                  </center>
            </div>
      </div>
      <div class="container">
            <center>
                  <?php
                  if (validation_errors()) {
                        echo "<div class='alert alert-danger' role='alert'>" . validation_errors() . "</div>";
                  }
                  ?>
                  <?php if (isset($form_data)) {
                        $form_data = $form_data[0];
                  ?>

                        <?php
                        $attributes = ['id' => 'ajax-form'];
                        echo form_open("production/update_form", $attributes); ?>
                        <input type='num' class="form-control" name='id' value="<?php echo $form_data['id'] ?>" hidden>
                        <div class="form-row">
                              <div class="form-group col-md-6">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">תופס שייך לחברת</div>
                                          </div>
                                          <select class='form-control' name='company'>
                                                <?php if (isset($companies)) {
                                                      foreach ($companies as $company) {
                                                            if ($company['name'] == $form_data['company']) {
                                                                  echo '<option selected>' . $company['name'] . '</option>';
                                                            } else {
                                                                  echo '<option>' . $company['name'] . '</option>';
                                                            }
                                                      }
                                                }
                                                ?>
                                          </select>
                                    </div>
                              </div>
                              <div class="form-group col-md-6">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">יוצר</div>
                                          </div>
                                          <input type='text' class="form-control " name='creator' value="<?php echo $form_data['creator'] ?>">
                                    </div>
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-4">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">תאריך</div>
                                          </div>
                                          <input type='date' class="form-control" name='date' value="<?php echo $form_data['date'] ?>">

                                    </div>
                              </div>
                              <div class="form-group col-md-4">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">שעת התחלה</div>
                                          </div>
                                          <input type='time' class="form-control" name='start_time' value="<?php echo $form_data['start_time'] ?>">
                                    </div>
                              </div>
                              <div class="form-group col-md-4">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">שעת סיום</div>
                                          </div>
                                          <input type='time' class="form-control" name='end_time' value="<?php echo $form_data['end_time'] ?>">
                                    </div>
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-4">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">מספר לקוח</div>
                                          </div>
                                          <input type='text' class="form-control" name='client_num' value="<?php echo $form_data['client_num'] ?>">
                                    </div>
                              </div>
                              <div class="form-group col-md-4">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">מספר פניה \ תקלה</div>
                                          </div>
                                          <input type='text' class="form-control" name='issue_num' value="<?php echo $form_data['issue_num'] ?>">
                                    </div>
                              </div>
                              <div class="form-group col-md-4">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">סוג תקלה \ התקנה</div>
                                          </div>
                                          <input type='text' class="form-control" name='issue_kind' value="<?php echo $form_data['issue_kind'] ?>">
                                    </div>
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-6">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">שם לקוח</div>
                                          </div>
                                          <input type='text' class="form-control" name='client_name' value="<?php echo $form_data['client_name'] ?>">
                                    </div>
                              </div>
                              <div class="form-group col-md-6">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">מיקום</div>
                                          </div>
                                          <input type='text' class="form-control" name='place' value="<?php echo $form_data['place'] ?>">
                                    </div>
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-6">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">אחראי</div>
                                          </div>
                                          <input type='text' class="form-control" name='manager' value="<?php echo $form_data['manager'] ?>">
                                    </div>
                              </div>
                              <div class="form-group col-md-6">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">איש קשר</div>
                                          </div>
                                          <input type='text' class="form-control" name='contact_name' value="<?php echo $form_data['contact_name'] ?>">
                                    </div>
                              </div>
                        </div>

                        <div class="form-group row">
                              <label for="activity_text" class="col-sm-2 col-form-label ">תיאור תקלה \ פניה</label>
                              <div class="col-sm-10">
                                    <textarea class="form-control" name="activity_text" cols="10" rows="3" placeholder="תיאור תקלה \ פניה"><?php echo $form_data['activity_text'] ?></textarea>
                              </div>
                        </div>

                        <div class="form-group row">
                              <label for="checking_text" class="col-sm-2 col-form-label ">תוצאות הבדיקה</label>
                              <div class="col-sm-10">
                                    <textarea class="form-control" name="checking_text" cols="10" rows="3" placeholder="תוצאות הבדיקה"><?php echo $form_data['checking_text'] ?></textarea>
                              </div>
                        </div>

                        <div class="form-group row">
                              <label for="summary_text" class="col-sm-2 col-form-label ">סיכום</label>
                              <div class="col-sm-10">
                                    <textarea class="form-control" name="summary_text" cols="10" rows="3" placeholder="סיכום"><?php echo $form_data['summary_text'] ?></textarea>
                              </div>
                        </div>

                        <div class="form-group row">
                              <label for="remarks_text" class="col-sm-2 col-form-label ">הערות</label>
                              <div class="col-sm-10">
                                    <textarea class="form-control" name="remarks_text" cols="10" rows="3" placeholder="הערות"><?php echo $form_data['remarks_text'] ?></textarea>
                              </div>
                        </div>

                        <div class="form-group row">
                              <label for="recommendations_text" class="col-sm-2 col-form-label ">המלצות</label>
                              <div class="col-sm-10">
                                    <textarea class="form-control" name="recommendations_text" cols="10" rows="3" placeholder="המלצות"><?php echo $form_data['recommendations_text'] ?></textarea>
                              </div>
                        </div>

                        <div class="form-group col-md-12">
                              <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text">רשימת תפוצה</div>
                                    </div>
                                    <input type='text' class="form-control ltr" name='contact_name' value="<?php echo $form_data['email_to'] ?>">
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-3">
                                    <label for="trip_start_time" class=" col-form-label ">נסיעה הלוך התחלה</label>
                                    <input type='time' class="form-control" name='trip_start_time' value="<?php echo $form_data['trip_start_time'] ?>">
                              </div>
                              <div class="form-group col-md-3">
                                    <label for="trip_end_time" class="col-form-label ">נסיעה הלוך סיום</label>
                                    <input type='time' class="form-control" name='trip_end_time' value="<?php echo $form_data['trip_end_time'] ?>">
                              </div>
                              <div class="form-group col-md-3">
                                    <label for="back_start_time" class=" col-form-label ">נסיעה חזור התחלה</label>
                                    <input type='time' class="form-control" name='back_start_time' value="<?php echo $form_data['back_start_time'] ?>">
                              </div>
                              <div class="form-group col-md-3">
                                    <label for="back_end_time" class=" col-form-label ">נסיעה חזור סיום</label>
                                    <input type='time' class="form-control" name='back_end_time' value="<?php echo $form_data['back_end_time'] ?>">
                              </div>
                        </div>

                        <div class="form-group row">
                              <label for="attachments" class="col-sm-2 col-form-label ">קבצים נוספים</label>
                              <div class="col-sm-10">
                                    <input id="fileupload" style="display:none;" type="file" name="files" data-url="/production/do_upload/<?php echo $form_data['company'] ?>" />
                                    <textarea rows="3" cols="100" id="attachments" type="text" class="ltr" name="attachments"><?php echo $form_data['attachments'] ?></textarea>
                                    <div id='files'></div>
                                    <button class="btn btn-outline-secondary col-sm-2" type="button" onclick="document.getElementById('fileupload').click();">העלה</button>
                              </div>
                        </div>

                        <div class="form-group row">
                              <label for="recommendations_text" class="col-sm-2 col-form-label "> חתימת לקוח שמורה:</label>
                              <div class="col-sm-4">
                                    <img src="data:image/png;base64, <?php echo $form_data['client_sign'] ?>" />
                              </div>
                              <label for="recommendations_text" class="col-sm-2 col-form-label ">חתימת לקוח חדשה:</label>
                              <div class="col-sm-4">
                                    <div id="sketchpadapp">
                                          <canvas id="sign-canvas" style="border: 1px solid red;"></canvas>
                                    </div>
                                    <input type='text' id="client_sign" name='client_sign' hidden>
                                    <a href="#sign-canvas" class="btn btn-info btn-block" onclick='$("#sign-canvas").data("jqScribble").clear();'>נקה חתימה</a>
                              </div>
                        </div>

                        <?php if ($user_role == "Admin") {
                              echo "<input type='submit' class='btn btn-info' name='submit' value='עדכן תופס'>";
                        }
                        ?>

                        <a target="_blank" class="btn btn-info" href="/exportpdf/create/<?php echo $form_data['id'] ?>">הצג PDF</a>
                        <a class="btn btn-info" href="#" onclick="SendEmail()">שלח PDF</a>
                        <?php echo form_close(); ?>

                  <?php } else {
                        echo "No Data for this form.";
                  } ?>
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

      function SendEmail() {
            // Make sure that the formMessages div has the 'success' class.
            $('#form-messages').addClass('alert-info');
            // Set the message text.
            $('#form-messages').html("שולח מייל, נא להמתין...").fadeIn(1000);
            $.post("/exportpdf/create/<?php echo $form_data['id'] ?>", {
                  email: true
            }).done(function(o) {
                  // Make sure that the formMessages div has the 'success' class.
                  $('#form-messages').removeClass('alert-info').addClass('alert-success');
                  // Set the message text.
                  $('#form-messages').html(o).fadeIn(1000).delay(5000).fadeOut(1000);
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