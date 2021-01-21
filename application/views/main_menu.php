<?php
if (isset($this->session->userdata['logged_in']) && $this->session->userdata['logged_in']['id'] != '') {
  $id = ($this->session->userdata['logged_in']['id']);
  $username = ($this->session->userdata['logged_in']['name']);
  $user_view_name = ($this->session->userdata['logged_in']['view_name']);
  $role = ($this->session->userdata['logged_in']['role']);
} else {
  header("location: /");
}
?>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark main-menu rtl">
  <a class="navbar-brand btn btn-sm btn-outline-primary" href="/">דוחות v1.9</a>
  <span class="navbar-text mx-2"><?php echo $_SERVER['SERVER_NAME']; ?></span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarDefault">
    <ul class="navbar-nav  my-4 my-md-0">
      <li class="nav-item mx-1 mt-3 mt-md-0 "><a class="nav-link btn btn-sm btn-outline-success" href="/"> דוח חדש</a></li>
      <li class="nav-item mx-1 mt-3 mt-md-0 "><a class="nav-link btn btn-sm btn-outline-info" href="/production/manage_forms"> רשימת דוחות</a></li>
      <?php if ($role == 'Admin') { ?>
        <li class="nav-item mx-1 mt-3 mt-md-0 "><a class="nav-link btn btn-sm btn-outline-danger" href="/admin/view_charts/<?php echo $id ?>"> כספים </a></li>
      <?php } ?>
    </ul>
  </div>

  <div class="collapse navbar-collapse" id="navbarDefault">
    <ul class="navbar-nav mr-auto">

    </ul>

    <ul class="navbar-nav  pull-right">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          שלום <?php echo isset($user_view_name) ? $user_view_name : "" ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php if ($role == 'Admin' || $role == 'Manager') { ?>
            <a class="dropdown-item p-2 px-md-2" href="/users">משתמשים</a>
            <a class="dropdown-item p-2 px-md-2" href="/companies">חברות</a>
            <a class="dropdown-item p-2 px-md-2" href="/contacts">אנשי קשר</a>
            <hr>
          <?php } ?>
          <?php if ($role == 'Admin') { ?>
            <a class="dropdown-item p-2 px-md-2" href="/admin/settings">הגדרות</a>
            <hr>
          <?php } ?>


          <a class="dropdown-item p-2 px-md-2" href="/users/edit/<?php echo isset($id) ? $id : "" ?>">עדכן פרטים שלי</a>
          <a class="dropdown-item p-2 px-md-2" href="/users/logout">צא ממערכת</a>
        </div>
      </li>
    </ul>
  </div>
</nav>