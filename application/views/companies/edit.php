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
				<h2 class="display-3">Edit Client</h2>
			</center>
		</div>
	</div>
	<div class="container">
		<center>
			<?php
			$id = "";
			$client = "";
			if (isset($message_display)) {
				echo "<div class='alert alert-success' role='alert'>";
				echo $message_display . '</div>';
			}
			if (validation_errors()) {
				echo "<div class='alert alert-danger' role='alert'>" . validation_errors() . "</div>";
			}

			if (isset($Companies)) {
				//print_r($Companies);
				$id = $Companies[0]['id'];
				$client = $Companies[0]['name'];
				$projects = $Companies[0]['projects'];
				$logo = $Companies[0]['logo'];
			}
			?>
			<?php echo form_open("Companies/edit/$id", 'class=user-create'); ?>
			<input type='hidden' name='id' value="<?php echo $id ?>">
			<label>Client</label><input id='client_name' type='text' class="form-control" name='name' value="<?php echo $client ?>" disabled></hr>
			<label>Logo</label>
			<div class="input-group mb-3">
				<input id="logo_path" type='text' class="form-control" name='logo' value="<?php echo $logo ?>">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('browse').click();">Upload</button>
				</div>
			</div>
			<img id="logo_img" class="img-thumbnail" src="<?php echo $logo ?>" onclick="document.getElementById('browse').click();">
			<input id="browse" style="display:none;" type="file" onchange="snapLogo()" ></hr>

			<div class="form-group"><label>Client Projects</label>
				<textarea name="projects" class="form-control" cols="40" rows="5"><?php echo $projects ?></textarea>
			</div>
			<input type='submit' class="btn btn-info btn-block" name='submit' value='Update'>
			<?php echo form_close(); ?>
		</center>
	</div>
</main>
<script>
	var client = document.getElementById("client_name").value;
	var ext = '';
</script>