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
                        <h2 class="display-3">Create new user.</h2>
                  </center>
            </div>
      </div>
      <div class="container">
            <center>
                  <?php
                  if (isset($message_display)) {
                        echo "<div class='alert alert-danger' role='alert'>";
                        echo $message_display . '</div>';
                  }
                  if (validation_errors()) {
                        echo "<div class='alert alert-danger' role='alert'>" . validation_errors() . "</div>";
                  }
                  ?>
                  <?php echo form_open('users/create', 'class=user-create'); ?>
                  <select class="form-control" name='role'>
                        <?php if (isset($settings)) {
                              $arr = explode(",", $settings[0]['roles']);
                              foreach ($arr as $role) {
                                    echo '<option>' . $role . '</option>';
                              }
                        }
                        ?>
                  </select></br>
                  <?php
                  echo form_input('name', '', 'class=form-control') . '<br/>';
                  echo form_password('password', '', 'class=form-control'); ?><br />
                  <input type='submit' class="btn btn-info btn-block" name='submit' value='Submit'>
                  <?php echo form_close(); ?>
            </center>
      </div>
</main>