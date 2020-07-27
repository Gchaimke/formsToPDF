<?php
if (isset($this->session->userdata['logged_in'])) {
	if ($this->session->userdata['logged_in']['role'] != "Admin") {
		header("location: /");
	}
}
?>
<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h2 class="display-3">Edit Company</h2>
			</center>
		</div>
	</div>
	<div class="container">
		<center>
			<?php
			$id = "";
			$company = "";
			if (isset($message_display)) {
				echo "<div class='alert alert-success' role='alert'>";
				echo $message_display . '</div>';
			}
			if (validation_errors()) {
				echo "<div class='alert alert-danger' role='alert'>" . validation_errors() . "</div>";
			}

			if (isset($companies)) {
				//print_r($companies);
				$id = $companies[0]['id'];
				$company = $companies[0]['name'];
				$form_header = $companies[0]['form_header'];
				$form_extra_filds = $companies[0]['form_extra_filds'];
				$form_footer = $companies[0]['form_footer'];
				$logo = $companies[0]['logo'];
			}
			?>
			<?php echo form_open("companies/edit/$id", 'class=user-create'); ?>
			<input type='hidden' name='id' value="<?php echo $id ?>">
			<label>Company</label><input id='company_name' type='text' class="form-control" name='name' value="<?php echo $company ?>" onchange="updateClient(this.value)"></hr>
			<label>Logo</label>
			<div class="input-group mb-3">
				<input id="logo_path" type='text' class="form-control" name='logo' value="<?php echo $logo ?>">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('browse').click();">Upload</button>
				</div>
			</div>
			<img id="logo_img" class="img-thumbnail" src="<?php echo $logo ?>" onclick="document.getElementById('browse').click();">
			<input id="browse" style="display:none;" type="file" onchange="snapLogo()" ></hr>

			<div class="form-group"><label>Form Head</label>
				<textarea name="form_header" class="form-control" cols="40" rows="5"><?php echo $form_header ?></textarea>
			</div>
			<div class="form-group"><label>Form Extra</label>
				<textarea name="form_extra_filds" class="form-control" cols="40" rows="5"><?php echo $form_extra_filds ?></textarea>
			</div>
			<div class="form-group"><label>Form Footer</label>
				<textarea name="form_footer" class="form-control" cols="40" rows="5"><?php echo $form_footer ?></textarea>
			</div>
			<input type='submit' class="btn btn-info btn-block" name='submit' value='Update'>
			<?php echo form_close(); ?>
		</center>
	</div>
</main>
<script>
	var company = document.getElementById("company_name").value;
	function updateClient(value){
            company = value;
      }
</script>