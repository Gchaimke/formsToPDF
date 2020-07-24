<?php
$id = $checklist[0]['id'];
$project = $checklist[0]['project'];
$serial = $checklist[0]['serial'];
$checklist_data = $checklist[0]['data'];
$log = $checklist[0]['log'];
$progress = $checklist[0]['progress'];
$assembler = $checklist[0]['assembler'];
$qc = $checklist[0]['qc'];
$scans = $checklist[0]['scans'];
$date = $checklist[0]['date'];
$logo = $client[0]['logo'];
$client = $client[0]['name'];

if (isset($this->session->userdata['logged_in'])) {
	$username = ($this->session->userdata['logged_in']['name']);
	$role = ($this->session->userdata['logged_in']['role']);
	if ($assembler != $username) {
		$assembler = $username;
	}
}
?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/checklist_create.css?'.filemtime('assets/css/checklist_create.css')); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/print.css?'.filemtime('assets/css/print.css')); ?>">
<nav class="navbar checklist navbar-light fixed-top bg-light">
	<?php echo "<img class='img-thumbnail checklist-logo' src='$logo'>" ?>
	<b id="project" class="navbar-text mobile-hide" href="#">Project: <?php echo $project ?></b>
	<b id="sn" class="navbar-text" href="#">SN: <?php echo $serial ?></b>
	<b id="date" class="navbar-text mobile-hide" href="#">Date: <?php echo $date ?></b>
	<ul class="nav navbar-nav navbar-right">
		<li class="nav-item">
		<button id="snap1" class="btn btn-info" onclick="document.getElementById('browse').click();"><i class="fa fa-camera"></i></button>
			<?php echo form_open('production/save_checklist/' . $id . '?sn=' . $serial, 'id=ajax-form','class=saveData'); ?>
			<input id="input_data" type='hidden' name='data' value="<?php echo $checklist_data ?>">
			<input id="input_progress" type='hidden' name='progress' value="<?php echo $progress ?>">
			<input type='hidden' name='assembler' value="<?php echo $assembler ?>">
			<input id="input_qc" type='hidden' name='qc' value="<?php echo $qc ?>">
			<input id="input_log" type='hidden' name='log' value="<?php echo $log ?>">
			<input id="input_scans" type='hidden' name='scans' value="<?php echo $scans ?>">
			<button id="save" type='submit' class="btn btn-success navbar-btn " value="Save"><i class="fa fa-save"></i></button>
			</form>
		</li>
	</ul>
	<div class="progress fixed-bottom">
		<div id="progress-bar" class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
	</div>
</nav>
<main role="main" class="container">
	<div id="form-messages" class='alert hidden' role='alert'></div>
	<div id="workTable">
		<?php echo $checklist_rows ?>
	</div>
	<div id="scansTable">
		<?php echo $scans_rows ?>
	</div>
	<div id="photo-stock" class="container">
		<center>
			<h2>System Photos</h2>
		</center>
		<div id="photo-messages" class='alert hidden' role='alert'></div>
		<?php
		$working_dir = '/Uploads/' . $client . '/' . $project . '/' . $serial . '/';
		echo "<script>var photoCount=0; var id='$id'; var project='$project'; var serial='$serial';"; //pass PHP data to JS
		echo "var log='$log'; var assembler =' $assembler'; var client='$client';</script>";  //pass PHP data to JS
		if (file_exists(".$working_dir")) {
			if ($handle = opendir(".$working_dir")) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != ".." && pathinfo($entry, PATHINFO_EXTENSION) == 'jpeg' && PATHINFO_FILENAME !='') {
						echo '<span id="' . pathinfo($entry, PATHINFO_FILENAME) . '" onclick="delPhoto(this.id)" class="btn btn-danger delete-photo fa fa-trash"> ' . pathinfo($entry, PATHINFO_FILENAME) . '</span><img id="' . pathinfo($entry, PATHINFO_FILENAME) . '" src="' . $working_dir . $entry . '" class="respondCanvas" >';
						echo '<script>photoCount++</script>';
					}
				}
				closedir($handle);
			}
		}
		?>
	</div>
	<input id="browse" style="display:none;" type="file" onchange="snapPhoto()" multiple>
	<div id="preview"></div>
</main>