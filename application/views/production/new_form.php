<main role="main">
      <div class="jumbotron">
            <div class="container">
                  <center>
                        <h2 class="display-3">דוח חדש</h2>
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
                  
                  <?php echo form_open("production/add_form", 'class=rtl'); ?>
                  <input type='text' class="form-control " name='company'  value="<?php echo $_GET['company']?>" hidden>
                  <div class="form-row">
                              <div class="form-group col-md-4">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">תאריך</div>
                                          </div>
                                          <input type='date' class="form-control" name='date' >

                                    </div>
                              </div>
                              <div class="form-group col-md-4">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">שעת התחלה</div>
                                          </div>
                                          <input type='time' class="form-control" name='start_time' >
                                    </div>
                              </div>
                              <div class="form-group col-md-4">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">שעת סיום</div>
                                          </div>
                                          <input type='time' class="form-control" name='end_time' >
                                    </div>
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-4">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">מספר לקוח</div>
                                          </div>
                                          <input type='text' class="form-control" name='client_num' >
                                    </div>
                              </div>
                              <div class="form-group col-md-4">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">מספר פניה \ תקלה</div>
                                          </div>
                                          <input type='text' class="form-control" name='issue_num' >
                                    </div>
                              </div>
                              <div class="form-group col-md-4">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">סוג תקלה \ התקנה</div>
                                          </div>
                                          <input type='text' class="form-control" name='issue_kind' >
                                    </div>
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-6">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">שם לקוח</div>
                                          </div>
                                          <input type='text' class="form-control" name='client_name' >
                                    </div>
                              </div>
                              <div class="form-group col-md-6">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">מיקום</div>
                                          </div>
                                          <input type='text' class="form-control" name='place' >
                                    </div>
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-6">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">אחראי</div>
                                          </div>
                                          <input type='text' class="form-control" name='manager' >
                                    </div>
                              </div>
                              <div class="form-group col-md-6">
                                    <div class="input-group mb-2">
                                          <div class="input-group-prepend">
                                                <div class="input-group-text">איש קשר</div>
                                          </div>
                                          <input type='text' class="form-control" name='contact_name' >
                                    </div>
                              </div>
                        </div>
                        <div class="form-group row">
                              <label for="activity_text" class="col-sm-2 col-form-label ">תיאור תקלה \ פניה</label>
                              <div class="col-sm-10">
                                    <textarea class="form-control" name="activity_text" cols="10" rows="3" ></textarea>
                              </div>
                        </div>

                        <div class="form-group row">
                              <label for="checking_text" class="col-sm-2 col-form-label ">תוצאות הבדיקה</label>
                              <div class="col-sm-10">
                              <textarea class="form-control" name="checking_text" cols="10" rows="3" ></textarea>
                              </div>
                        </div>

                        <div class="form-group row">
                              <label for="summary_text" class="col-sm-2 col-form-label ">סיכום</label>
                              <div class="col-sm-10">
                              <textarea class="form-control" name="summary_text" cols="10" rows="3" ></textarea>
                              </div>
                        </div>

                        <div class="form-group row">
                              <label for="remarks_text" class="col-sm-2 col-form-label ">הערות</label>
                              <div class="col-sm-10">
                              <textarea class="form-control" name="remarks_text" cols="10" rows="3" ></textarea>
                              </div>
                        </div>

                        <div class="form-group row">
                              <label for="recommendations_text" class="col-sm-2 col-form-label ">המלצות</label>
                              <div class="col-sm-10">
                              <textarea class="form-control" name="recommendations_text" cols="10" rows="3" ></textarea>
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-3">
                                    <label for="trip_start_time" class=" col-form-label ">נסיעה הלוך התחלה</label>
                                    <input type='time' class="form-control" name='trip_start_time'  >
                              </div>
                              <div class="form-group col-md-3">
                                    <label for="trip_end_time" class="col-form-label ">נסיעה הלוך סיום</label>
                                    <input type='time' class="form-control" name='trip_end_time'  >
                              </div>
                              <div class="form-group col-md-3">
                                    <label for="back_start_time" class=" col-form-label ">נסיעה חזור התחלה</label>
                                    <input type='time' class="form-control" name='back_start_time'  >
                              </div>
                              <div class="form-group col-md-3">
                                    <label for="back_end_time" class=" col-form-label ">נסיעה חזור סיום</label>
                                    <input type='time' class="form-control" name='back_end_time'  >
                              </div>
                        </div>
                                  
                  <input type='submit' class="btn btn-info btn-block" name='submit' value='שמור ושלח לרשימת תפוצה'>
                  <?php echo form_close(); ?>
            </center>
      </div>
</main>