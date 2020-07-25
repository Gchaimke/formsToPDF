<?php
if (isset($this->session->userdata['logged_in'])) {
  $id = ($this->session->userdata['logged_in']['id']);
  $username = ($this->session->userdata['logged_in']['name']);
  $role = ($this->session->userdata['logged_in']['role']);
}
?>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark main-menu"> 
  <a class="navbar-brand" href="/">Online Forms 8</a>
  <ul class="navbar-nav mr-auto">
    <?php
    if (isset($project)) {
      echo '<li class="nav-item project"><a class="nav-link" href="/production/checklists/' . $project . '">' . $project . '</a></li>';
    }
    ?>
  </ul>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarDefault">
    <ul class="navbar-nav mr-auto">
      |
    </ul>
    <ul class="navbar-nav  pull-right">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Hello <?php echo $username; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/users/edit/<?php echo $id ?>">Password</a>
          <a class="dropdown-item" href="/users/logout">Logout</a>
        </div>
      </li>
      <?php if ($role == 'Admin') {?>
        <li class="nav-item"><a class="nav-link" href="/clients">Company</a></li>
        <li class="nav-item"><a class="nav-link" href="/users">Users</a></li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Admin
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="/admin/view_log">System Log</a>
        <a class="dropdown-item" href="/admin/settings">Settings</a>
        </div>
      </li>
      <?php }?>
    </ul>
  </div>
</nav>