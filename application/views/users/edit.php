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
				<h5><?= lang('edit_details') ?></h5>
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
							echo '<div class="input-group-prepend"><div class="input-group-text">' . lang('role') . '</div></div>';
							echo "<select class='form-control' name='role'>";
							if (isset($user_roles)) {
								foreach ($user_roles as $c_role) {
									if ($c_role == $user['role']) {
										echo "<option value='$c_role' selected>" . lang($c_role) . "</option>";
									} else {
										echo "<option value='$c_role'>" . lang($c_role) . "</option>";
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
							<div class="input-group-text"><?= lang('username') ?></div>
						</div>
						<input type='text' class="form-control" name='name' value="<?php echo $user['name'] ?>" <?php echo ($role != "Admin") ? 'disabled' : "" ?>>
					</div>
				</div>
				<div class="form-row">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text"><?= lang('view_name') ?></div>
						</div>
						<input type='text' class="form-control" name='view_name' value="<?php echo $user['view_name'] ?>" required>
					</div>
				</div>
				<div class="form-row">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text"><?= lang('password') ?></div>
						</div>
						<input type='text' class="form-control" placeholder="********" name='password'>
					</div>
				</div>
				<div class="form-row">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text"><?= lang('email') ?></div>
						</div>
						<input type='text' class="form-control ltr" name='email' value="<?php echo $user['email'] ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text"><?= lang('language') ?></div>
						</div>
						<select class="form-control" name='language'>
							<?php if (isset($languages)) {
								echo "<option value='system'>" . lang('default') . "</option>";
								foreach ($languages as $lang) {
									if ($user['language'] == $lang) {
										echo "<option selected>$lang</option>";
									} else {
										echo "<option>$lang</option>";
									}
								}
							}
							?>
						</select>
					</div>
				</div>
				<?php if ($role != "User") {
					echo '<div class="form-row">';
					echo '<div class="input-group-text">' . lang('companies_list') . '</div>';
					echo $filds_checks;
					echo '</div>';
				}  ?>

				<input type='submit' class="btn btn-info" name='submit' value='<?= lang('update') ?>'>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</main>