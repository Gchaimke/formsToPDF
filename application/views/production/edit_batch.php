<?php
$serials = '';
$checklist_data = $checklists[0]['data'];
$log = $checklists[0]['log'];
$progress = $checklists[0]['progress'];
$assembler = $checklists[0]['assembler'];
$qc = $checklists[0]['qc'];
$scans = $checklists[0]['scans'];
$date = $checklists[0]['date'];

$this->load->helper('cookie');
$session = get_cookie('ci_session');

foreach ($checklists as $checklist) {
	$serials .= '<a target="_blank" class="badge badge-light" href="/production/edit_checklist/' . $checklist['id'] . '?sn=' . $checklist['serial'] . '">' . $checklist['serial'] . '</a> | ';
}
if (isset($this->session->userdata['logged_in'])) {
	$username = ($this->session->userdata['logged_in']['name']);
	$role = ($this->session->userdata['logged_in']['role']);
	if ($assembler != $username) {
		$assembler = $username;
	}
}
?>
<style>
	div#workTable {
		margin-top: 150px;
	}
</style>
<link rel="stylesheet" href="<?php echo base_url('assets/css/checklist_create.css?'.filemtime('assets/css/checklist_create.css')); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/print.css?'.filemtime('assets/css/print.css')); ?>">
<nav class="navbar checklist navbar-light fixed-top bg-light">
	<button id="snap" class="btn btn-info" disabled><i class="fa fa-camera"></i></button>
	<b id="project" class="navbar-text mobile-hide">Project: <?php echo $project ?></b>
	<b id="sn" class="navbar-text" href="#">SN: <?php echo $serials ?></b>
	<b id="date" class="navbar-text mobile-hide">Date: <?php echo $date ?></b>
	<ul class="nav navbar-nav navbar-right">
		<li class="nav-item">
			<?php echo form_open('production/save_batch_checklists/' . $ids, 'id=ajax-form', 'class=saveData'); ?>
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
</main>
<?php
echo "<script>var photoCount=0; var id='$ids'; var pr='$project'; var sn='$serials'; var ci_session='$session';"; //pass PHP data to JS
echo "var log='$log'; var assembler =' $assembler'; var qc_name='$qc'</script>";  //pass PHP data to JS
?>