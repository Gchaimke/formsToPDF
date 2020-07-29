<!doctype html>
<?php
if (isset($this->session->userdata['logged_in'])) {
  header("location: /users/user_login_process");
}
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="<?php echo base_url('assets/favicon.ico'); ?>">
  <title><?php echo "WorkflowTag - " . pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME); ?></title>

  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/login.css'); ?>" rel="stylesheet">
</head>

<body>
  <?php
  if (isset($response) && $response != "") {
    echo '<div class="alert alert-success" role="alert">';
    echo $response . ' </div>';
  }

  echo "<center>";
  if (isset($logout_message)) {
    echo "<div class='message'>";
    echo $logout_message;
    echo "</div>";
  }

  if (isset($message_display)) {
    echo "<div class='message'>";
    echo $message_display;
    echo "</div>";
  }

  if (isset($error_message)) {
    echo "<div class='error_msg'>$error_message" . validation_errors() . "</div>";
  }

  echo form_open('users/user_login_process', 'class=form-signin');

  ?>

  <img class="mb-4" src="/assets/img/user.png" alt="" width="100" height="100">
  <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
  <label for="inputUser" class="sr-only">User Name</label>
  <input type="text" name="name" id="name" class="form-control" placeholder="User Name" required autofocus>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
  <input type="submit" value=" Login " name="submit" class="btn btn-lg btn-primary btn-block" /><br />
  <p class="mt-5 mb-3 text-muted">Workflow Tag&copy; <?php echo date('Y'); ?></p>
  <?php echo form_close(); ?>