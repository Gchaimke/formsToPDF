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
				<h5>Edit Company</h5>
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
				$filds = json_decode($companies[0]['view_filds']);
			}
			$filds_checks ='';
			if (isset($view_filds)) {
				$filds_checks = '<ul>';
				foreach ($view_filds as $fild => $status) {
					if (isset($filds->$fild)) {
						$cheked = ($filds->$fild > 0) ? "checked" : '';
					}else{
						$cheked ='';
					}

					$filds_checks .= '<li>' . $fild . '<input class="m-3" type="checkbox" name="view_filds[' . $fild . ']" value="' . $status . '" ' . $cheked . '></li>';
				}
				$filds_checks .= '</ul>';
			}
			?>
			<?php echo form_open("companies/edit/$id", 'class=user-create'); ?>
			<input type='hidden' name='id' value="<?php echo $id ?>">
			<label>Company</label><input id='company_name' type='text' class="form-control" name='name' value="<?php echo $company ?>" onchange="updateClient(this.value)"></hr>
			<label>Logo</label>
			<div class="input-group mb-3 ltr">
				<input id="logo_path" type='text' class="form-control" name='logo' value="<?php echo $logo ?>">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('browse').click();">Upload</button>
				</div>
			</div>

			<img id="logo_img" class="img-thumbnail" src="<?php echo $logo ?>" onclick="document.getElementById('browse').click();">
			<input id="browse" style="display:none;" type="file" onchange="snapLogo()"><br><br>

			<div id="view_filds-column" class="form-group"><label>Select filds to <b style="color: red;">DISABLE</b></label><br>
				<?php echo $filds_checks ?></br>
			</div>
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

	function updateClient(value) {
		company = value;
	}
</script>