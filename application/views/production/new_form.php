<main role="main">
      <div class="jumbotron">
            <div class="container">
                  <center>
                        <h2 class="display-3">תופס חדש</h2>
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
                  
                  <?php echo form_open("production/add_form", 'class=rtl'); ?>
                  <input type='text' class="form-control " name='company' placeholder="Company"  hidden>
                  <div class="form-row">
                              <div class="form-group col-md-4">
                                    <label for="date" class=" col-form-label ">תאריך</label>
                                    <input type='date' class="form-control" name='date'>

                              </div>
                              <div class="form-group col-md-4">
                                    <label for="start_time" class="col-form-label ">שעת התחלה</label>
                                    <input type='time' class="form-control" name='start_time' placeholder="שעת התחלה" >
                              </div>
                              <div class="form-group col-md-4">
                                    <label for="end_time" class=" col-form-label ">שעת סיום</label>
                                    <input type='time' class="form-control" name='end_time' placeholder="שעת סיום" >
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-4">
                                    <label for="client_num" class=" col-form-label ">מספר לקוח</label>
                                    <input type='text' class="form-control" name='client_num' placeholder="מספר לקוח" >
                              </div>
                              <div class="form-group col-md-4">
                                    <label for="issue_num" class="col-form-label ">מספר פניה \ תקלה</label>
                                    <input type='text' class="form-control" name='issue_num' placeholder="מספר פניה \ תקלה" >
                              </div>
                              <div class="form-group col-md-4">
                                    <label for="issue_kind" class=" col-form-label ">סוג תקלה \ התקנה</label>
                                    <input type='text' class="form-control" name='issue_kind' placeholder="סוג תקלה \ התקנה" >
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-6">
                                    <label for="client_name" class=" col-form-label ">שם לקוח</label>
                                    <input type='text' class="form-control" name='client_name' placeholder="שם לקוח" >
                              </div>
                              <div class="form-group col-md-6">
                                    <label for="place" class="col-form-label ">מיקום</label>
                                    <input type='text' class="form-control" name='place' placeholder="מיקום" >
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-4">
                                    <label for="manager" class=" col-form-label ">אחראי</label>
                                    <input type='text' class="form-control" name='manager' placeholder="אחראי" >
                              </div>
                              <div class="form-group col-md-4">
                                    <label for="contact_name" class="col-form-label ">איש קשר</label>
                                    <input type='text' class="form-control" name='contact_name' placeholder="איש קשר" >
                              </div>
                        </div>

                        <div class="form-group row">
                              <label for="activity_text" class="col-sm-2 col-form-label ">תיאור תקלה \ פניה</label>
                              <div class="col-sm-10">
                                    <textarea class="form-control" name="activity_text" cols="10" rows="3" placeholder="תיאור תקלה \ פניה"></textarea>
                              </div>
                        </div>

                        <div class="form-group row">
                              <label for="checking_text" class="col-sm-2 col-form-label ">תוצאות הבדיקה</label>
                              <div class="col-sm-10">
                              <textarea class="form-control" name="checking_text" cols="10" rows="3" placeholder="תוצאות הבדיקה"></textarea>
                              </div>
                        </div>

                        <div class="form-group row">
                              <label for="summary_text" class="col-sm-2 col-form-label ">סיכום</label>
                              <div class="col-sm-10">
                              <textarea class="form-control" name="summary_text" cols="10" rows="3" placeholder="סיכום"></textarea>
                              </div>
                        </div>

                        <div class="form-group row">
                              <label for="remarks_text" class="col-sm-2 col-form-label ">הערות</label>
                              <div class="col-sm-10">
                              <textarea class="form-control" name="remarks_text" cols="10" rows="3" placeholder="הערות"></textarea>
                              </div>
                        </div>

                        <div class="form-group row">
                              <label for="recommendations_text" class="col-sm-2 col-form-label ">המלצות</label>
                              <div class="col-sm-10">
                              <textarea class="form-control" name="recommendations_text" cols="10" rows="3" placeholder="המלצות"></textarea>
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-3">
                                    <label for="trip_start_time" class=" col-form-label ">נסיעה הלוך התחלה</label>
                                    <input type='time' class="form-control" name='trip_start_time' placeholder="נסיעה הלוך התחלה" >
                              </div>
                              <div class="form-group col-md-3">
                                    <label for="trip_end_time" class="col-form-label ">נסיעה הלוך סיום</label>
                                    <input type='time' class="form-control" name='trip_end_time' placeholder="נסיעה הלוך סיום" >
                              </div>
                              <div class="form-group col-md-3">
                                    <label for="back_start_time" class=" col-form-label ">נסיעה חזור התחלה</label>
                                    <input type='text' class="form-control" name='back_start_time' placeholder="נסיעה חזור התחלה" >
                              </div>
                              <div class="form-group col-md-3">
                                    <label for="back_end_time" class=" col-form-label ">נסיעה חזור סיום</label>
                                    <input type='time' class="form-control" name='back_end_time' placeholder="נסיעה חזור סיום" >
                              </div>
                        </div>
                                  
                  <input type='submit' class="btn btn-info btn-block" name='submit' value='שלח'>
                  <?php echo form_close(); ?>
            </center>
      </div>
</main>