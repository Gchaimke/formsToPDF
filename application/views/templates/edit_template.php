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
				<h2 class="display-3">Edit Template</h2>
			</center>
		</div>
	</div>
	<div class="container">
		<center>
			<?php
			$id = "";
			$client = "";
			$pr =  "";
			$dt = "";
			$sd = "";
			if (isset($message_display)) {
				echo "<div class='alert alert-danger' role='alert'>";
				echo $message_display . '</div>';
			}
			if (validation_errors()) {
				echo "<div class='alert alert-danger' role='alert'>" . validation_errors() . "</div>";
			}

			if (isset($project)) {
				$id = $project[0]['id'];
				$client = $project[0]['client'];
				$pr =  $project[0]['project'];
				$dt = $project[0]['data'];
				$tp =  $project[0]['template'];
				$sd =  $project[0]['scans'];
			}
			?>

			<?php echo form_open('templates/edit_template', 'class=user-create'); ?>
			<input type='hidden' name='id' value="<?php echo $id ?>">
			<input type='text' class="form-control" name='client' value="<?php echo $client ?>" disabled></br>
			<input type='text' class="form-control" name='project' value="<?php echo $pr ?>" disabled></br>
			<div class="form-group"><label>Serial template</label><br>
				<label>yy = Year | mm = Month | x,xx,xxx,xxxx = Serialized number | pattern = AVxxx-mm-yy</label>
				<input type="text" name="template" value="<?php echo $tp ?>" class="form-control">
			</div>
			<div class="form-group"><label>Checklist Data</label><br>
				<label>Last column is function mark, columns separated by ';'. Functions: HD = Table Header | QC = QC Select | V = Regular Checkbox | N = Name Selection | </label>
				<textarea class="form-control" name='data' rows="10" cols="170"><?php echo $dt ?></textarea></br></div>
			<div class="form-group"><label>Scan Data</label><br>
                  <label>Last column is function mark, columns separated by ';'. Functions: HD = Table Header  </label>
				<textarea class="form-control" name='scans' rows="5" cols="170"><?php echo $sd ?></textarea></br></div>
			<input type='submit' class="btn btn-info btn-block" name='submit' value='Submit'></ <?php echo form_close(); ?> </center> </div> </main>