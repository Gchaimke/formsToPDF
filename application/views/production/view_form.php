<?php
if (isset($this->session->userdata['logged_in'])) {
      $user_role = $this->session->userdata['logged_in']['role'];
      $user_name = $this->session->userdata['logged_in']['name'];
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
                                                                  echo '<option selected>' . htmlspecialchars($company['name']) . '</option>';
                                                            } else {
                                                                  echo '<option>' . htmlspecialchars($company['name']) . '</option>';
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
                                          <select id='creator_id' class='form-control' name='creator_id' <?php if ($user_role != "Admin") echo 'disabled' ?>>
                                                <?php if (isset($users)) {
                                                      foreach ($users as $user) {
                                                            if ($user['id'] == $form_data['creator_id']) {
                                                                  $emails_arr = preg_split('/\r\n|[\r\n]/', $user['email_to']);
                                                                  echo '<option value="' . $user['id'] . '" selected>' . $user['view_name'] . '</option>';
                                                            } else {
                                                                  echo '<option value="' . $user['id'] . '">' . $user['view_name'] . '</option>';
                                                            }
                                                      }
                                                }
                                                ?>
                                          </select>
                                          <input type='hidden' id='creator_name' class="form-control" name='creator_name' value="<?php echo $form_data['creator_name'] ?>">
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
                                          <input type='text' class="form-control" name='client_num' value="<?php echo htmlspecialchars($form_data['client_num']) ?>">
                                    </div>
                              </div>
                              <div class="form-group col-md-4">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">מספר פניה \ תקלה</div>
                                          </div>
                                          <input type='text' class="form-control" name='issue_num' value="<?php echo htmlspecialchars($form_data['issue_num']) ?>">
                                    </div>
                              </div>
                              <div class="form-group col-md-4">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">סוג תקלה \ התקנה</div>
                                          </div>
                                          <input type='text' class="form-control" name='issue_kind' value="<?php echo htmlspecialchars($form_data['issue_kind']) ?>">
                                    </div>
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-6">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">שם לקוח</div>
                                          </div>
                                          <input type='text' class="form-control" name='client_name' value="<?php echo htmlspecialchars($form_data['client_name']) ?>">
                                    </div>
                              </div>
                              <div class="form-group col-md-6">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">מיקום</div>
                                          </div>
                                          <input type='text' class="form-control" name='place' value="<?php echo htmlspecialchars($form_data['place']) ?>">
                                    </div>
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-6">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">אחראי</div>
                                          </div>
                                          <input type='text' class="form-control" name='manager' value="<?php echo htmlspecialchars($form_data['manager']) ?>">
                                    </div>
                              </div>
                              <div class="form-group col-md-6">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">איש קשר</div>
                                          </div>
                                          <input type='text' class="form-control" name='contact_name' value="<?php echo htmlspecialchars($form_data['contact_name']) ?>">
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
                        <hr />

                        <div class="form-row">
                              <label for="recommendations_text" class="col-md-2 col-form-label ">נסיעות:</label>
                              <div class="form-group col-md-5">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">שעת התחלה נסיעת הלוך</div>
                                          </div>
                                          <input type='time' class="form-control" name='trip_start_time' value="<?php echo $form_data['trip_start_time'] ?>">
                                    </div>
                              </div>
                              <div class="form-group col-md-5">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">שעת סיום נסיעת חזור</div>
                                          </div>
                                          <input type='time' class="form-control" name='back_end_time' value="<?php echo $form_data['back_end_time'] ?>">
                                    </div>
                              </div>
                        </div>
                        <hr />
                        <div class="form-group row" id="emails">
                              <div class="input-group mb-4">
                              <label for="email_to" class="col-sm-2 col-form-label ">מכותבים:</label>
                                    <?php $len = count($emails_arr);
                                    if ($len > 0 && $emails_arr[0] != '') {
                                          $firsthalf = array_slice($emails_arr, 0, $len / 2);
                                          $secondhalf = array_slice($emails_arr, $len / 2);
                                          echo '<div class="col-sm-5">';
                                          foreach ($firsthalf as $email) {
                                                $checked = '';
                                                if (strpos($form_data['email_to'], $email) !== false) {
                                                      $checked = 'checked';
                                                }
                                                echo "<div class='input-group-text'>
                                                      <input type='checkbox' value='$email' $checked>
                                                      <label class='col-sm-2 col-form-label'>$email</label>
                                                      </div>";
                                          }
                                          echo '</div>';
                                          echo '<div class="col-sm-5">';
                                          foreach ($secondhalf as $email) {
                                                $checked = '';
                                                if (strpos($form_data['email_to'], $email) !== false) {
                                                      $checked = 'checked';
                                                }
                                                echo "<div class='input-group-text'>
                                                      <input type='checkbox' value='$email' $checked>
                                                      <label class='col-sm-2 col-form-label'>$email</label>
                                                      </div>";
                                          }
                                          echo '</div>';
                                    } else {
                                          echo '<div class="col-sm-5">אין פריטים ברשימת תפוצה של משתמש</div>';
                                    }
                                    ?>
                                    <input type="text" id="sum" class="form-control ltr mt-5" name='email_to' value="<?php echo $form_data['email_to'] ?>">
                              </div>
                        </div>
                        <hr />

                        <div class="form-group row">
                              <label for="attachments" class="col-sm-2 col-form-label ">קבצים נוספים</label>
                              <div class="col-sm-10">
                                    <input id="fileupload" style="display:none;" type="file" name="files" data-url="/production/do_upload/" />
                                    <input id="attachments" type="hidden" class="form-control ltr" name="attachments" value="<?php echo htmlspecialchars($form_data['attachments']) ?>" />
                                    <div id='files'>
                                          <?php $files_arr = explode(',', $form_data['attachments']);
                                          foreach ($files_arr as $file) {
                                                if (strlen($file) > 1)
                                                      echo '<p class="file ltr done"><a target="blank" href="/'.htmlspecialchars($file).'">' . htmlspecialchars($file) . '</a>
                                                      <a data-file="' . htmlspecialchars($file) . '" href="#files" class="delete_attachment" onclick="delete_attachment(this)">X</a></p>';
                                          }
                                          ?>
                                    </div>
                                    <button class="btn btn-outline-success col-sm-2" type="button" onclick="document.getElementById('fileupload').click();">העלה</button>
                              </div>
                        </div>
                        <hr />

                        <div class="form-group row">
                              <label for="recommendations_text" class="col-sm-2 col-form-label "> חתימת לקוח שמורה:</label>
                              <div class="col-sm-4">
                                    <?php if ($form_data['client_sign']) {
                                          echo '<img src="data:image/png;base64, ' . $form_data["client_sign"] . '" />';
                                    } else {
                                          echo 'אין חתימה';
                                    }
                                    ?>
                              </div>
                              <?php if ($user_role == "Admin") {
                                    echo '<label for="recommendations_text" class="col-sm-2 col-form-label ">חתימת לקוח חדשה:</label>
                              <div class="col-sm-4">
                                    <div id="sketchpadapp">
                                          <canvas id="sign-canvas" style="border: 1px solid red;"></canvas>
                                    </div>
                                    <input type="text" id="client_sign" name="client_sign" hidden>
                                    <a href="#sign-canvas" class="btn btn-outline-danger btn-sm" onclick="clearCanvas()">נקה חתימה</a>
                              </div>';
                              } ?>
                        </div>
                        <hr />

                        <?php if ($user_role == "Admin") {
                              echo "<input type='submit' id='save_btn' class='btn btn-danger' name='submit' value='עדכן דוח'>";
                        }
                        ?>

                        <a target="_blank" class="btn btn-info" href="/exportpdf/create/<?php echo $form_data['id'] ?>">הצג PDF</a>
                        <a class="btn btn-success" href="#" onclick="SendEmail()">שלח דוח</a>
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
            if ($("#sign-canvas").length && $("#client_sign").length) {
                  $("#sign-canvas").jqScribble();
                  $("#sign-canvas").data('jqScribble').update({
                        width: 300,
                        height: 100
                  });
            }

            $("#creator_id").change(function() {
                  $("#creator_name").val($("#creator_id option:selected").text());
            });

            var sum = '';
            $('#emails :checkbox').click(function() {
                  sum = '';
                  $('#emails :checkbox:checked').each(function(idx, elm) {
                        sum += elm.value + ',';
                  });
                  $('#sum').val(sum);
            });
      });

      function clearCanvas() {
            $("#sign-canvas").data("jqScribble").clear();
      }

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
</script>