<?php
if (isset($this->session->userdata['logged_in']) && isset($user)) {
	if ($this->session->userdata['logged_in']['id'] != $user[0]['id']) {
		if ($this->session->userdata['logged_in']['role'] != "Admin") {
			header("location: /");
		}
	}
}
?>
<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h2 class="display-3">Edit User</h2>
			</center>
		</div>
	</div>
	<div class="container">
		<center>
			<?php
			$id = "";
			$role = "";
			$name =  "";
			if (isset($message_display)) {
				echo "<div class='alert alert-danger' role='alert'>";
				echo $message_display . '</div>';
			}
			if (validation_errors()) {
				echo "<div class='alert alert-danger' role='alert'>" . validation_errors() . "</div>";
			}

			if (isset($user)) {
				$user = $user[0];
				$id = $user['id'];
				$role = $user['role'];
				$name =  $user['name'];
				$email =  $user['email'];
				$email_to =  $user['email_to'];
			}
			?>

			<?php echo form_open('users/edit', 'class=user-create'); ?>
			<input type='hidden' name='id' value="<?php echo $id ?>">
			<?php
			$current_role = ($this->session->userdata['logged_in']['role']);
			if ($current_role == "Admin") {
				echo "<select class='form-control' name='role'>";
				if (isset($settings)) {
					$arr = explode(",", $settings[0]['roles']);
					foreach ($arr as $crole) {
						if ($crole == $role) {
							echo '<option selected>' . $crole . '</option>';
						} else {
							echo '<option>' . $crole . '</option>';
						}
					}
				}
				echo "</select></br>";
			}
			?>

			<label>Name</label>
			<input type='text' class="form-control" placeholder="name" name='name' value="<?php echo $name ?>">
			<label>password</label>
			<input type='text' class="form-control" placeholder="password" name='password'>
			<label>email</label>
			<input type='text' class="form-control" placeholder="email" name='email' value="<?php echo $email ?>">
			<label>email_to</label>
			<input type='text' class="form-control" placeholder="email_to" name='email_to' value="<?php echo $email_to ?>"><br />
			<input type='submit' class="btn btn-info btn-block" name='submit' value='update'>
			<?php echo form_close(); ?>
		</center>
	</div>
</main>