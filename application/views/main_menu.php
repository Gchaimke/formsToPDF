<?php
if (isset($this->session->userdata['logged_in'])) {
  $id = ($this->session->userdata['logged_in']['id']);
  $username = ($this->session->userdata['logged_in']['name']);
  $role = ($this->session->userdata['logged_in']['role']);
}
?>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark main-menu rtl">
  <a class="navbar-brand" href="/">דוחות v1.5</a>
  <div class="navbar-brand"><?php echo $_SERVER['SERVER_NAME']; ?></div>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarDefault">
    <ul class="navbar-nav mr-auto">

    </ul>

    <ul class="navbar-nav  pull-right">
    <li class="nav-item"><a class="nav-link" href="/admin/manage_forms">דוחות</a></li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          שלום <?php echo $username; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php if ($role == 'Admin') { ?>
            
            <a class="dropdown-item" href="/companies">חברות</a>
            <a class="dropdown-item" href="/users">משתמשים</a>
            <a class="dropdown-item" href="/admin/settings">הגדרות</a>
          <?php } ?>
          <hr>
          <a class="dropdown-item" href="/users/edit/<?php echo $id ?>">עדכן פרטים שלי</a>
          <a class="dropdown-item" href="/users/logout">צא ממערכת</a>
        </div>
      </li>
    </ul>
  </div>
</nav>