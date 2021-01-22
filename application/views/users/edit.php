<?php
$filds_checks = '';
if (isset($companies)) {
	$companies_list = json_decode($user['companies_list']);
	$filds_checks = '<ul>';
	foreach ($companies as $company) {
		$cheked = (isset($companies_list) && in_array($company['id'], $companies_list)) ? "checked" : '';
		$filds_checks .= '<li>' . $company['name'] . '<input class="m-3" type="checkbox" name="companies_list[]" value="' . $company['id'] . '" ' . $cheked . '></li>';
	}
	$filds_checks .= '</ul>';
}
$display = ($role == 'User') ? 'none' : 'flex';
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
				?>
				<?php
				$attributes = ['class' => '', 'id' => 'ajax-form'];
				echo form_open('users/edit', $attributes); ?>
				<input type='hidden' name='id' value="<?php echo $user['id'] ?>">
				<div class="form-row">
					<div class="input-group mb-2">
						<?php if ($role == "Admin") {
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
						<input type='text' class="form-control" name='name' value="<?php echo $user['name'] ?>" <?php echo ($role != "Admin") ? 'disabled' : "" ?>>
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
				<div class="form-row" style="display: <?= $display ?>;">
					<div class="input-group-text">רשימת חברות</div>
					<?= $filds_checks ?>
				</div>
				<input type='submit' class="btn btn-info" name='submit' value='עדכן'>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</main>