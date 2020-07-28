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
                        <h2 class="display-3">תופס <?php if (isset($_GET['issue'])) {
                                                            echo $_GET['issue'];
                                                      } ?> </h2>
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

                        <?php
                        $attributes = ['class' => 'rtl', 'id' => 'ajax-form'];
                        echo form_open("admin/update_form", $attributes); ?>
                        <input type='num' class="form-control" name='id' value="<?php echo $form_data['id'] ?>" hidden>

                        <div class="form-group row">
                              <label for="company" class="col-sm-2 col-form-label ">תופס שייך לחברה</label>
                              <div class="col-sm-10">
                                    <input type='text' class="form-control " name='company' placeholder="תופס שייך לחברה" value="<?php echo $form_data['company'] ?>">
                              </div>
                        </div>
                        <div class="form-row">
                              <div class="form-group col-md-4">
                                    <label for="date" class=" col-form-label ">תאריך</label>
                                    <input type='date' class="form-control" name='date' value="<?php echo $form_data['date'] ?>">

                              </div>
                              <div class="form-group col-md-4">
                                    <label for="start_time" class="col-form-label ">שעת התחלה</label>
                                    <input type='time' class="form-control" name='start_time' placeholder="שעת התחלה" value="<?php echo $form_data['start_time'] ?>">
                              </div>
                              <div class="form-group col-md-4">
                                    <label for="end_time" class=" col-form-label ">שעת סיום</label>
                                    <input type='time' class="form-control" name='end_time' placeholder="שעת סיום" value="<?php echo $form_data['end_time'] ?>">
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-4">
                                    <label for="client_num" class=" col-form-label ">מספר לקוח</label>
                                    <input type='text' class="form-control" name='client_num' placeholder="מספר לקוח" value="<?php echo $form_data['client_num'] ?>">
                              </div>
                              <div class="form-group col-md-4">
                                    <label for="issue_num" class="col-form-label ">מספר פניה \ תקלה</label>
                                    <input type='text' class="form-control" name='issue_num' placeholder="מספר פניה \ תקלה" value="<?php echo $form_data['issue_num'] ?>">
                              </div>
                              <div class="form-group col-md-4">
                                    <label for="issue_kind" class=" col-form-label ">סוג תקלה \ התקנה</label>
                                    <input type='text' class="form-control" name='issue_kind' placeholder="סוג תקלה \ התקנה" value="<?php echo $form_data['issue_kind'] ?>">
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-6">
                                    <label for="client_name" class=" col-form-label ">שם לקוח</label>
                                    <input type='text' class="form-control" name='client_name' placeholder="שם לקוח" value="<?php echo $form_data['client_name'] ?>">
                              </div>
                              <div class="form-group col-md-6">
                                    <label for="place" class="col-form-label ">מיקום</label>
                                    <input type='text' class="form-control" name='place' placeholder="מיקום" value="<?php echo $form_data['place'] ?>">
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-4">
                                    <label for="manager" class=" col-form-label ">אחראי</label>
                                    <input type='text' class="form-control" name='manager' placeholder="אחראי" value="<?php echo $form_data['manager'] ?>">
                              </div>
                              <div class="form-group col-md-4">
                                    <label for="contact_name" class="col-form-label ">איש קשר</label>
                                    <input type='text' class="form-control" name='contact_name' placeholder="איש קשר" value="<?php echo $form_data['contact_name'] ?>">
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
                                    <input type='time' class="form-control" name='trip_start_time' placeholder="נסיעה הלוך התחלה" value="<?php echo $form_data['trip_start_time'] ?>">
                              </div>
                              <div class="form-group col-md-3">
                                    <label for="trip_end_time" class="col-form-label ">נסיעה הלוך סיום</label>
                                    <input type='time' class="form-control" name='trip_end_time' placeholder="נסיעה הלוך סיום" value="<?php echo $form_data['trip_end_time'] ?>">
                              </div>
                              <div class="form-group col-md-3">
                                    <label for="back_start_time" class=" col-form-label ">נסיעה חזור התחלה</label>
                                    <input type='time' class="form-control" name='back_start_time' placeholder="נסיעה חזור התחלה" value="<?php echo $form_data['back_start_time'] ?>">
                              </div>
                              <div class="form-group col-md-3">
                                    <label for="back_end_time" class=" col-form-label ">נסיעה חזור סיום</label>
                                    <input type='time' class="form-control" name='back_end_time' placeholder="נסיעה חזור סיום" value="<?php echo $form_data['back_end_time'] ?>">
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
            $('#form-messages').html("Please Wait, sending Email ...").fadeIn(1000);
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