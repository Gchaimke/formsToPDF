<?php
if (isset($this->session->userdata['logged_in'])) {
      $user_id = $this->session->userdata['logged_in']['id'];
      $user_role = $this->session->userdata['logged_in']['role'];
}
$user = $user[0];
if (isset($companie)) {
      $companie_name = $companie['name'];
}

$client_num = (isset($_GET['client_num']))?$_GET['client_num']:"";
$client_name = (isset($_GET['client_name']))?htmlspecialchars($_GET['client_name']):"";
$address = (isset($_GET['address']))?htmlspecialchars($_GET['address']):"";
$city = (isset($_GET['city']))?htmlspecialchars($_GET['city']):"";
?>

<script src="<?php echo base_url('assets/js/jQUpload/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jQUpload/jquery.iframe-transport.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jQUpload/jquery.fileupload.js'); ?>"></script>
<style>
      <?php echo $hide_filds ?>.hiden {
            display: none !important;
      }

      img.logo {
            width: 100px;
            margin-right: 230px;
            margin-top: -65px;
      }
</style>
<div id="form-messages" class='alert hidden test' role='alert'></div>
<main role="main">
      <div class="jumbotron">
            <div class="container">
                  <center>
                        <h5><?= lang('new_form') ?></h5> <img class="logo" src="<?php echo $companie['logo'] ?>">
                  </center>
            </div>
      </div>
      <div class="container">
            <center>
                  <?php echo form_open("production/add_form", 'id=new-form'); ?>
                  <input type='hidden' class="form-control " name='company' value="<?php echo $companie_name ?>">
                  <div class="form-row">
                        <div id="date_column" class="form-group col-md-4">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text"><span class="red">*</span><?= lang('date') ?></div>
                                    </div>
                                    <input type='date' class="form-control" name='date' required>
                              </div>
                        </div>
                        <div id="start_time_column" class="form-group col-md-4">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text"><?= lang('start_time_column') ?></div>
                                    </div>
                                    <input type='time' class="form-control" name='start_time'>
                              </div>
                        </div>
                        <div id="end_time_column" class="form-group col-md-4">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text"><?= lang('end_time_column') ?></div>
                                    </div>
                                    <input type='time' class="form-control" name='end_time'>
                              </div>
                        </div>
                  </div>

                  <div class="form-row">
                        <div id="client_num_column" class="form-group col-md-4">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text"><?= lang('client_num_column') ?></div>
                                    </div>
                                    <input type='text' class="form-control" name='client_num' value="<?=$client_num?>">
                              </div>
                        </div>
                        <div id="issue_num_column" class="form-group col-md-4">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text"><?= lang('issue_num_column') ?></div>
                                    </div>
                                    <input type='text' id='issue_num' class="form-control" name='issue_num'>
                              </div>
                        </div>
                        <div id="issue_kind_column" class="form-group col-md-4">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text"><?= lang('issue_kind_column') ?></div>
                                    </div>
                                    <input type='text' class="form-control" name='issue_kind'>
                              </div>
                        </div>
                  </div>

                  <div class="form-row">
                        <div id="client_name_column" class="form-group col-md-4">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text"><?= lang('client_name_column') ?></div>
                                    </div>
                                    <input type='text' class="form-control" name='client_name' value="<?=$client_name?>">
                              </div>
                        </div>
                        <div id="place_column" class="form-group col-md-4">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text"><?= lang('place_column') ?></div>
                                    </div>
                                    <input type='text' class="form-control" name='place' value="<?=$address?>">
                              </div>
                        </div>
                        <div id="city_column" class="form-group col-md-4">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text"><?= lang('city_column') ?></div>
                                    </div>
                                    <input type='text' class="form-control" name='city' value="<?=$city?>">
                              </div>
                        </div>
                  </div>

                  <div class="form-row">
                        <div id="manager_column" class="form-group col-md-6">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text"><?= lang('manager_column') ?></div>
                                    </div>
                                    <input type='text' class="form-control" name='manager'>
                              </div>
                        </div>
                        <div id="contact_name_column" class="form-group col-md-6">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text"><?= lang('contact_name_column') ?></div>
                                    </div>
                                    <input type='text' class="form-control" name='contact_name'>
                              </div>
                        </div>
                  </div>
                  <div class="form-row">
                        <div id="old_serial" class="form-group col-md-6">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text"><?= lang('old_serial') ?></div>
                                    </div>
                                    <input type='text' class="form-control" name='old_serial'>
                              </div>
                        </div>
                        <div id="new_serial" class="form-group col-md-6">
                              <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                          <div class="input-group-text"><?= lang('new_serial') ?></div>
                                    </div>
                                    <input type='text' class="form-control" name='new_serial'>
                              </div>
                        </div>
                  </div>

                  <div id="activity_text_column" class="form-group row">
                        <label for="activity_text" class="col-sm-2 col-form-label "><?= lang('activity_text_column') ?></label>
                        <div class="col-sm-10">
                              <textarea class="form-control" name="activity_text" cols="10" rows="6"></textarea>
                        </div>
                  </div>
                  <div id="checking_text_column" class="form-group row">
                        <label for="checking_text" class="col-sm-2 col-form-label "><?= lang('checking_text_column') ?></label>
                        <div class="col-sm-10">
                              <textarea class="form-control" name="checking_text" cols="10" rows="2"></textarea>
                        </div>
                  </div>

                  <div id="summary_text_column" class="form-group row">
                        <label for="summary_text" class="col-sm-2 col-form-label "><?= lang('summary_text_column') ?></label>
                        <div class="col-sm-10">
                              <textarea class="form-control" name="summary_text" cols="10" rows="2"></textarea>
                        </div>
                  </div>

                  <div id="remarks_text_column" class="form-group row">
                        <label for="remarks_text" class="col-sm-2 col-form-label "><?= lang('remarks_text_column') ?></label>
                        <div class="col-sm-10">
                              <textarea class="form-control" name="remarks_text" cols="10" rows="2"></textarea>
                        </div>
                  </div>

                  <div id="recommendations_text_column" class="form-group row">
                        <label for="recommendations_text" class="col-sm-2 col-form-label "><?= lang('recommendations_text_column') ?></label>
                        <div class="col-sm-10">
                              <textarea class="form-control" name="recommendations_text" cols="10" rows="2"></textarea>
                        </div>
                  </div>
                  <hr />
                  <?php if (isset($contacts)) { ?>
                        <div class="form-group row" id="emails">
                              <label for="email_to" class="col-sm-2 col-form-label "><?= lang('emails') ?></label>
                        <?php

                        foreach ($contacts as $contact) {
                              $users_list = json_decode($contact['users_list']);
                              if (isset($users_list) && in_array($user_id, $users_list)) {
                                    if ($contact['company'] == 'manager') {
                                          echo "<div class='input-group-text ml-2'>
                                    <input type='checkbox' value='{$contact['email']}'>
                                    <label class='col email-label'>{$contact['name']}</label>
                                    </div>";
                                    }
                                    if ($contact['company'] == $companie_name) {
                                          echo "<div class='input-group-text ml-2'>
                                                <input type='checkbox' value='{$contact['email']}'>
                                                <label class='col email-label'>{$contact['name']}</label>
                                                </div>";
                                    }
                              }
                        }
                  } else {
                        echo '<div class="col-sm-5">'.lang('no_emails') .'</div>';
                  }
                        ?>
                        <input type="text" id="sum" class="form-control ltr mt-3 mr-3 ml-3" name='email_to' value="" hidden>
                        </div>
                        <hr />


                        <div id="files_column" class="form-group row">
                              <label for="attachments" class="col-sm-12 col-form-label "><?= lang('cant_add_files') ?></label>
                        </div>
                        <hr />
                        <?php if ($user_role == "Admin") { ?>
                              <hr />
                              <div class="form-row row" id="details_column">
                                    <div class="form-group row col-md-9 mr-2 ">
                                          <label for="details" class="col-sm-2 col-form-label "><?= lang('details_column') ?></label>
                                          <div class="col-sm-10">
                                                <textarea class="form-control" name="details" rows="1"></textarea>
                                          </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                          <div class="input-group">
                                                <div class="input-group-prepend">
                                                      <div class="input-group-text"><?= lang('price') ?></div>
                                                </div>
                                                <input type='text' id='price' class="form-control" name='price' value=''>
                                          </div>
                                    </div>
                              </div>
                        <?php } //end if user admin
                        ?>
                        <div class="form-row client-sign-form" style="display: none;">
                              <div class="form-group col-md-12">
                                    <div id="sketchpadapp">
                                          <canvas id="sign-canvas" style="border: 5px solid red;"></canvas>
                                    </div>
                                    <input type='text' id="client_sign" name='client_sign' hidden>
                                    <div class="btn btn-outline-success btn-sm mt-3" onclick=' $(".client-sign-form").toggle();'><?= lang('save_sign') ?></div>
                                    <div class="btn btn-outline-danger btn-sm mt-3" onclick='$("#sign-canvas").data("jqScribble").clear();'><?= lang('clean_sign') ?></div>
                                    <div class="btn btn-outline-danger btn-sm mt-3" onclick='$(".client-sign-form").toggle();$("#sign-canvas").data("jqScribble").clear();'>X</div>
                              </div>
                        </div>
                        <hr />
                        <div class="btn btn-info my-5 ml-3" style="color: azure;" onclick=' $(".client-sign-form").toggle();'><?= lang('client_sign') ?></div>
                        <input id='save_form' type='button' class="btn btn-success my-5 ml-3" name='submit' value='<?= lang('save') ?>'>
                        <input type='submit' class="btn btn-danger my-5 ml-3" name='submit' value='<?= lang('save_and_send') ?>'>
                        <?php echo form_close(); ?>

            </center>
      </div>
</main>
<script>
      $(document).ready(function() {
            //startup scripts here
            $("#sign-canvas").jqScribble();
            $("#sign-canvas").data('jqScribble').update({
                  width: $('.container').width(),
                  height: 300
            });

            var sum = '';
            $('#emails :checkbox').click(function() {
                  sum = '';
                  $('#emails :checkbox:checked').each(function(idx, elm) {
                        sum += elm.value + ",";
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
                        $('#form-messages').html('<?= lang('cant_save') ?> ' + response).fadeIn(1000);
                  }
            }).fail(function(response) {
                  $('#form-messages').addClass('alert-danger');
                  // Set the message text.
                  $('#form-messages').html('<?= lang('cant_save') ?> ' + response).fadeIn(1000);
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
                        $('#form-messages').html('<?= lang('cant_save') ?> ' + response).fadeIn(1000);
                  }
            }).fail(function(response) {
                  $('#form-messages').addClass('alert-danger');
                  // Set the message text.
                  $('#form-messages').html('<?= lang('cant_save') ?> ' + response).fadeIn(1000);
            });
      })

      function SendEmail(id) {
            var ans = 'no';
            $('#form-messages').removeClass('alert-danger').addClass('alert-info');
            // Set the message text.
            $('#form-messages').html("<?= lang('sending_email') ?>").fadeIn(1000);
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
                        //window.location.href = "/production/view_form/" + id;
                        window.location.href = "/";
                  }, 3000); //will call the function after 2 secs.
            }).fail(function(o) {
                  $('#form-messages').removeClass('alert-info').addClass('alert-danger');
                  // Set the message text.
                  $('#form-messages').html(o).fadeIn(1000);
            });
      }
</script>