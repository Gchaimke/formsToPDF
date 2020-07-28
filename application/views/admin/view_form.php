<?php
if (isset($this->session->userdata['logged_in'])) {
      if ($this->session->userdata['logged_in']['role'] != "Admin") {
            header("location: /");
      }
}
?>
<main role="main">
      <div class="jumbotron">
            <div class="container">
                  <center>
                        <h2 class="display-3">עדכון דוח </h2>
                  </center>
            </div>
      </div>
      <div id="form-messages" class='alert hidden' role='alert'></div>
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
                        $attributes = ['class' => 'rtl', 'id' => 'ajax-form'];
                        echo form_open("admin/update_form", $attributes); ?>
                        <input type='num' class="form-control" name='id' value="<?php echo $form_data['id'] ?>" hidden>

                        <div class="form-group row col-md-6">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text">תופס שייך לחברה</div>
                                    </div>
                                    <input type='text' class="form-control " name='company' value="<?php echo $form_data['company'] ?>">
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

                        <input type='submit' class="btn btn-info" name='submit' value='עדכן תופס'>
                        <a class="btn btn-info" href="/exportpdf/create/<?php echo $form_data['id'] ?>">הצג PDF</a>
                        <a class="btn btn-info" href="#" onclick="SendEmail()">שלח PDF</a>
                        <?php echo form_close(); ?>

                  <?php } else {
                        echo "No Data for this form.";
                  } ?>
            </center>
      </div>
</main>

<script>
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
                  $('#form-messages').html(o).fadeIn(1000).delay(3000).fadeOut(1000);
            }).fail(function(o) {
                  $('#form-messages').removeClass('alert-info').addClass('alert-danger');
                  // Set the message text.
                  $('#form-messages').html(o).fadeIn(1000);
            });
      }
</script>