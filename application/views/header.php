<!doctype html>
<?php
if (isset($this->session->userdata['logged_in'])) {
  $id = ($this->session->userdata['logged_in']['id']);
  $username = ($this->session->userdata['logged_in']['name']);
  $role = ($this->session->userdata['logged_in']['role']);
  $user_language = $this->session->userdata['logged_in']['language'];
  if ($user_language == '') {
    $user_language = $this->Admin_model->getSettings()[0]['language'];
  }
  $dir = $user_language == 'hebrew' ? 'rtl' : 'ltr';
} else {
  header("location: /users/login");
}
?>
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Language" content="en">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Online Forms">
  <meta name="author" content="Chaim Gorbov">
  <link rel="icon" href="<?php echo base_url('assets/favicon.ico'); ?>">
  <title>
    <?php echo "Online Forms - " . trim($_SERVER['REQUEST_URI'], "/"); ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/all.css?' . filemtime('assets/css/all.css')); ?>" rel="stylesheet">
  <?php
  if ($dir == 'rtl') {
    echo '<link href="' . base_url('assets/css/rtl.css?' . filemtime('assets/css/rtl.css')) . '" rel="stylesheet">';
  }
  ?>
  <!-- Custom styles for this template -->
  <?php
  if (isset($css_to_load)) {
    if (is_array($css_to_load)) {
      foreach ($css_to_load as $row) {
        echo  "<link href=" . base_url("assets/css/$row") . " rel='stylesheet'>";
      }
    } else {
      echo  "<link href=" . base_url("assets/css/$css_to_load") . " rel='stylesheet'>";
    }
  }
  ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body class="<?= $dir ?>">