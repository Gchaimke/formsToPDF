<?php
if (isset($all_users)) {
	$users_list = json_decode($contacts['users_list']);
	$filds_checks = '<ul>';
	foreach ($all_users as $user) {
		$cheked = (isset($users_list) && in_array($user['id'], $users_list)) ? "checked" : '';
		$filds_checks .= '<li>' . $user['view_name'] . '<input class="m-3" type="checkbox" name="users_list[]" value="' . $user['id'] . '" ' . $cheked . '></li>';
	}
	$filds_checks .= '</ul>';
}
?>
<style>
	li {
		text-align: left;
		list-style: none;
	}

	ul {
		columns: 3;
		-webkit-columns: 3;
		-moz-columns: 3;
	}
</style>
<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h5><?= lang('edit_contact') ?></h5>
			</center>
		</div>
	</div>
	<div class="container">
		<center>
			<?php
			if (isset($message_display)) {
				echo "<div class='alert alert-success' role='alert'>";
				echo $message_display . '</div>';
			}
			if (validation_errors()) {
				echo "<div class='alert alert-danger' role='alert'>" . validation_errors() . "</div>";
			}

			if (isset($contacts)) {
				//print_r($contacts);
				$id = $contacts['id'];
				$name = $contacts['name'];
				$email = $contacts['email'];
				$company_name = $contacts['company'];
			}
			?>
			<?php echo form_open("contacts/edit/$id", 'class=user-create'); ?>
			<input type='hidden' name='id' value="<?php echo $id ?>">
			<div class="form-row">
				<div class="form-group col-md-4">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text"><?= lang('name') ?></div>
						</div>
						<input type='text' class="form-control" name='name' value="<?php echo $name ?>">

					</div>
				</div>
				<div class="form-group col-md-4">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text"><?= lang('email') ?></div>
						</div>
						<input type='text' class="form-control" name='email' value="<?php echo $email ?>">

					</div>
				</div>
				<div class="form-group col-md-4">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text"><?= lang('company') ?></div>
						</div>
						<select class='form-control' name='company'>
							<?php if (isset($companies)) {
								array_push($companies,array('name' => 'manager'));
								foreach ($companies as $company) {
									if ($company['name'] == $company_name) {
										echo '<option selected>' . htmlspecialchars($company['name']) . '</option>';
									} else {
										echo '<option>' . htmlspecialchars($company['name']) . '</option>';
									}
								}
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="input-group-text"><?= lang('users_list_view') ?></div>
				<?= $filds_checks ?>
			</div>
			<input type='submit' class="btn btn-info btn-block" name='submit' value='<?= lang('save') ?>'>
			<?php echo form_close(); ?>
		</center>
	</div>
</main>
<script>

</script>