<?php
if (isset($this->session->userdata['logged_in'])) {
  $user_id = ($this->session->userdata['logged_in']['id']);
  $user_view_name = ($this->session->userdata['logged_in']['view_name']);
  $user_role = ($this->session->userdata['logged_in']['role']);
}
?>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark main-menu ltr">
  <a class="navbar-brand btn btn-sm btn-outline-primary rtl" href="/">דוחות v2.1</a>
  <span class="navbar-text mr-4"><?php echo $_SERVER['SERVER_NAME']; ?></span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse rtl" id="navbarDefault">
    <ul class="navbar-nav  my-4 my-md-0">
      <li class="nav-item mx-1 mt-1 mt-md-0 "><a class="nav-link btn btn-sm btn-outline-warning" href="/tickets">משימות</a></li>
      <li class="nav-item mx-1 mt-1 mt-md-0 "><a class="nav-link btn btn-sm btn-outline-success" href="/"> דוח חדש</a></li>
      <li class="nav-item mx-1 mt-1 mt-md-0 "><a class="nav-link btn btn-sm btn-outline-info" href="/production/manage_forms"> רשימת דוחות</a></li>
      <?php if ($user_role == 'Admin') { ?>
        <li class="nav-item mx-1 mt-1 mt-md-0 "><a class="nav-link btn btn-sm btn-outline-danger" href="/admin/view_charts/<?php echo $user_id ?>"> כספים </a></li>
      <?php } ?>
    </ul>
  </div>

  <div class="collapse navbar-collapse rtl" id="navbarDefault">
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          שלום <?php echo isset($user_view_name) ? $user_view_name : "" ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php if ($user_role == 'Admin' || $user_role == 'Manager') { ?>
            <a class="dropdown-item p-2 px-md-2" href="/users">משתמשים</a>
            <a class="dropdown-item p-2 px-md-2" href="/companies">חברות</a>
            <a class="dropdown-item p-2 px-md-2" href="/contacts">אנשי קשר</a>
            <hr>
          <?php } ?>
          <?php if ($user_role == 'Admin') { ?>
            <a class="dropdown-item p-2 px-md-2" href="/admin/settings">הגדרות</a>
            <hr>
          <?php } ?>


          <a class="dropdown-item p-2 px-md-2" href="/users/edit/<?php echo isset($user_id) ? $user_id : "" ?>">עדכן פרטים שלי</a>
          <a class="dropdown-item p-2 px-md-2" href="/users/logout">צא ממערכת</a>
        </div>
      </li>
    </ul>
  </div>
</nav>