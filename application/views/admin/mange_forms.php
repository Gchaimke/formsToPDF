<?php
$project =  explode("/", $_SERVER['REQUEST_URI'])[3];
?>
<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h2 class="display-3"><?php echo urldecode($project); ?> Checklists</h2>
			</center>
		</div>
	</div>
	<div class="container">
		<?php
		if (isset($message_display)) {
			echo "<div class='alert alert-success' role='alert'>";
			echo $message_display . '</div>';
		}
		?>
		<nav aria-label="Checklist navigation">
			<ul class="pagination left">
				<a class="btn btn-warning" href="/production/add_checklist/<?php echo $project; ?>"><i class="fa fa-file-text"></i></a>
				<a class="btn btn-info" onclick="gen_checklists('<?php echo urldecode($project); ?>',1)">+1</a>
				<a class="btn btn-info" onclick="gen_checklists('<?php echo urldecode($project); ?>',5)">+5</a>
				<a class="btn btn-info" onclick="gen_checklists('<?php echo urldecode($project); ?>',10)">+10</a>
				<a id='batchLink' class="btn btn-info fa fa-list-ol disabled" href="/production/edit_batch/" onclick="cleanUrl()"></a>
			</ul>
			<?php if (isset($links)) {
				echo $links;
			} ?>
		</nav>
		<?php if (isset($results)) { ?>
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">*</th>
						<th scope="col">Serial Number</th>
						<th scope="col" class="mobile-hide">Project</th>
						<th scope="col" class="mobile-hide">Progress</th>
						<th scope="col" class="mobile-hide">Last Edited By</th>
						<th scope="col" class="mobile-hide">QC</th>
						<th scope="col" class="mobile-hide">Date</th>
						<th scope="col">Edit</th>
						<th scope="col">Trash</th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($results as $data) { ?>
						<tr id='<?php echo $data->id ?>'>
							<td>
								<div class='checkbox'><input type='checkbox' class='select' id='<?php echo $data->id ?>' $checked></div>
							</td>
							<td><?php if ($data->serial != '') {
									echo $data->serial;
								} else {
									echo "SN template not found!";
								}  ?></td>
							<td class="mobile-hide"><?php echo $data->project ?></td>
							<td class="mobile-hide">
								<a href='#' id='<?php echo $data->id ?>' onclick='showLog("<?php echo $data->log ?>","<?php echo $data->serial ?>")'>
									<?php echo $data->progress ?>%</a></td>
							<td class="mobile-hide"><?php echo $data->assembler ?></td>
							<td class="mobile-hide"><?php echo $data->qc ?></td>
							<td class="mobile-hide"><?php echo $data->date ?></td>
							<td><a id='edit_checklist' target="_blank" href='/production/edit_checklist/<?php echo $data->id ?>?sn=<?php echo $data->serial ?>' class='btn btn-info'><i class="fa fa-edit"></i></a></td>
							<td><button id='<?php echo $data->id ?>' class='btn btn-danger' onclick='trashChecklist(this.id,"<?php echo urldecode($project); ?>","<?php echo $data->serial; ?>")'><i class="fa fa-trash"></i></button></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } else { ?>
			<div>No checklist(s) found.</div>
		<?php } ?>
	</div>
	<div id='show-log' style='display:none;'>
		<div id="show-log-header">
			<div id="serial-header"></div>Click here to move<button type="button" class="close" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
		</div>
		<ul class="list-group list-group-flush">
		</ul>
	</div>
</main>
<script>
	var client = '<?php echo $client[0]['name'] ?>';

	function trashChecklist(id,project,serial) {
		var r = confirm("Trash checklist " + serial + "?");
		if (r == true) {
			$.post("/production/trashChecklist", {
				id: id,
				project : project,
				serial : serial
			}).done(function(o) {
				//$('[id^=' + id + ']').remove();
				location.reload();
			});
		}
	}

	function gen_checklists(project, count) {
		var r = confirm("Add " + count + " checklist/s to " + project + "?");
		if (r == true) {
			$.post("/production/gen_checklists", {
				client: client,
				project: project,
				count: count
			}).done(function(o) {
				if (o != 1) {
					alert(o);
				}
				location.reload();
			});
		}
	}
</script>