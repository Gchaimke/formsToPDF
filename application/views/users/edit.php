<?php
if (isset($this->session->userdata['logged_in']) && isset($user)) {
	if ($this->session->userdata['logged_in']['id'] != $user[0]['id']) {
		if ($this->session->userdata['logged_in']['role'] != "Admin") {
			header("location: /");
		}
	}
}
?>
<div id="form-messages" class='alert hidden' role='alert'></div>
<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h5>ערוך פרטים</h5>
				
			</center>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">
				<?php
				if (validation_errors()) {
					echo "<div class='alert alert-danger' role='alert'>" . validation_errors() . "</div>";
				}
				$user = $user[0]; ?>
				<?php
				$attributes = ['class' => '', 'id' => 'ajax-form'];
				echo form_open('users/edit', $attributes); ?>
				<input type='hidden' name='id' value="<?php echo $user['id'] ?>">
				<div class="form-row">
					<div class="input-group mb-2">
						<?php
						$current_role = ($this->session->userdata['logged_in']['role']);
						if ($current_role == "Admin") {
							echo '<div class="input-group-prepend"><div class="input-group-text">תפקיד</div></div>';
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

				<div class="form-row">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text">שם משתמש</div>
						</div>
						<input type='text' class="form-control" name='name' value="<?php echo $user['name'] ?>" <?php if ($current_role != "Admin") {
																																		echo 'disabled';
																																	} ?>>
					</div>
				</div>
				<div class="form-row">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text">שם יוצג</div>
						</div>
						<input type='text' class="form-control" name='view_name' value="<?php echo $user['view_name'] ?>" required>
					</div>
				</div>

				<div class="form-row">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text">סיסמה</div>
						</div>
						<input type='text' class="form-control" placeholder="********" name='password'>
					</div>
				</div>

				<div class="form-row">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text">מייל</div>
						</div>
						<input type='text' class="form-control ltr" name='email' value="<?php echo $user['email'] ?>">
					</div>
				</div>

				<div class="form-row">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text">רשימת תפוצה
								<br />
								<div style="font-size:9px;display: contents;">אחד לשורה</div>
							</div>
						</div><textarea class="form-control ltr" name="email_to" cols="10" rows="3"><?php echo $user['email_to'] ?></textarea>
					</div>
				</div>
				<input type='submit' class="btn btn-info" name='submit' value='עדכן'>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</main>