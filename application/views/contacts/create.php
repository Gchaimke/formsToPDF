<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h5><?= lang('add_contact') ?></h5>
			</center>
		</div>
	</div>
	<div class="container">
		<center>
			<?php
			if (isset($message_display)) {
				echo "<div class='alert alert-danger' role='alert'>";
				echo $message_display . '</div>';
			}
			if (validation_errors()) {
				echo "<div class='alert alert-danger' role='alert'>" . validation_errors() . "</div>";
			}
			?>

			<?php echo form_open('contacts/create', 'class=client-create'); ?>
			<div class="form-row">
				<div class="form-group col-md-4">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text"><?= lang('name') ?></div>
						</div>
						<input type='text' class="form-control" name='name' value="">

					</div>
				</div>
				<div class="form-group col-md-4">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text"><?= lang('email') ?></div>
						</div>
						<input type='text' class="form-control" name='email' value="">

					</div>
				</div>
				<div class="form-group col-md-4">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text"><?= lang('company') ?></div>
						</div>
						<select class='form-control' name='company'>
							<?php if (isset($companies)) {
								array_push($companies, array('name' => 'manager'));
								foreach ($companies as $company) {
									echo '<option>' . htmlspecialchars($company['name']) . '</option>';
								}
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<input type='submit' class="btn btn-info btn-block" name='submit' value='<?= lang('save') ?>'>
			<?php echo form_close(); ?>
		</center>
	</div>
</main>