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
				<h2 class="display-3">ערוך פרטים</h2>
				<div id="form-messages" class='alert hidden' role='alert'></div>
			</center>
		</div>
	</div>
	<div class="container">
		<center>
			<?php
			if (validation_errors()) {
				echo "<div class='alert alert-danger' role='alert'>" . validation_errors() . "</div>";
			}

			if (isset($user)) {
				$user = $user[0]; ?>

				<div class="col-sm-8">
					<?php
					$attributes = ['class' => '', 'id' => 'ajax-form'];
					 echo form_open('users/edit',$attributes); ?>
					<input type='hidden' name='id' value="<?php echo $user['id'] ?>">
					<div class="form-group row">
						<?php
						$current_role = ($this->session->userdata['logged_in']['role']);
						if ($current_role == "Admin") {
							echo '<label for="role" class="col-sm-2 col-form-label ">תפקיד</label><div class="col-sm-8">';
							echo "<select class='form-control' name='role'>";
							if (isset($settings)) {
								$arr = explode(",", $settings[0]['roles']);
								foreach ($arr as $crole) {
									if ($crole == $user['role']) {
										echo '<option selected>' . $crole . '</option>';
									} else {
										echo '<option>' . $crole . '</option>';
									}
								}
							}
							echo "</select>";
						}
						?>
					</div>
				</div>

				<div class="form-group row">
					<label for="name" class="col-sm-2 col-form-label">שם משתמש</label>
					<div class="col-sm-8">
						<input type='text' class="form-control" placeholder="name" name='name' value="<?php echo $user['name'] ?>" <?php if ($current_role != "Admin") {
																																		echo 'disabled';
																																	} ?>>
					</div>
				</div>

				<div class="form-group row">
					<label for="password" class="col-sm-2 col-form-label ">סיסמה</label>
					<div class="col-sm-8">
						<input type='text' class="form-control" placeholder="password" name='password'>
					</div>
				</div>

				<div class="form-group row">
					<label for="email" class="col-sm-2 col-form-label ">מייל</label>
					<div class="col-sm-8">
						<input type='text' class="form-control ltr" placeholder="email" name='email' value="<?php echo $user['email'] ?>">
					</div>
				</div>

				<div class="form-group row">
					<label for="email_to" class="col-sm-2 col-form-label ">רשימת תפוצה</label>
					<div class="col-sm-8">
						<textarea class="form-control ltr" name="email_to" cols="10" rows="3"><?php echo $user['email_to'] ?></textarea>
					</div>
				</div>

				<input type='submit' class="btn btn-info btn-block" name='submit' value='עדכן'>
				<?php echo form_close(); ?>
			<?php } //close if 
			?>
	</div>
	</center>
	</div>
</main>