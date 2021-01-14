<?php
if (isset($this->session->userdata['logged_in'])) {
	if ($this->session->userdata['logged_in']['role'] != "Admin") {
		header("location: /");
	}
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
				<h5>שנה איש קשר</h5>
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
				$company = $contacts['company'];
			}
			?>
			<?php echo form_open("contacts/edit/$id", 'class=user-create'); ?>
			<input type='hidden' name='id' value="<?php echo $id ?>">
			<div class="form-row">
				<div class="form-group col-md-4">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text">שם</div>
						</div>
						<input type='text' class="form-control" name='name' value="<?php echo $name ?>">

					</div>
				</div>
				<div class="form-group col-md-4">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text">מייל</div>
						</div>
						<input type='text' class="form-control" name='email' value="<?php echo $email ?>">

					</div>
				</div>
				<div class="form-group col-md-4">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text">חברה</div>
						</div>
						<input type='text' class="form-control" name='company' value="<?php echo $company ?>">

					</div>
				</div>
			</div>
			<input type='submit' class="btn btn-info btn-block" name='submit' value='שמור'>
			<?php echo form_close(); ?>
		</center>
	</div>
</main>
<script>

</script>