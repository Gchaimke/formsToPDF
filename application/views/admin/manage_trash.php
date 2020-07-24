<?php
$project =  'Trash';
?>
<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h2 class="display-3">Checklists in <?php echo urldecode($project); ?> </h2>
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
			<?php if (isset($links)) {
				echo $links;
			} ?>
		</nav>
		<?php if (isset($results)) { ?>
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Serial Number</th>
						<th scope="col" class="mobile-hide">Project</th>
						<th scope="col" class="mobile-hide">Progress</th>
						<th scope="col" class="mobile-hide">Last Edited By</th>
						<th scope="col" class="mobile-hide">QC</th>
						<th scope="col" class="mobile-hide">Date</th>
						<th scope="col">Restore</th>
						<th scope="col">Delete</th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($results as $data) { ?>
						<tr id='<?php echo $data->id ?>'>
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
							<td><button id='<?php echo $data->id ?>' class='btn btn-info' onclick='restoreChecklist(this.id,"<?php echo $data->project ?>")'><i class="fa fa-undo"></i></button></td>
							<td><button id='<?php echo $data->id ?>' class='btn btn-danger' onclick='delChecklist(this.id,"<?php echo $data->project ?>","<?php echo $data->serial ?>")'><i class="fa fa-trash"></i></button></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } else { ?>
			<div>No trashed checklist(s) found.</div>
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
	function delChecklist(id,project,serial) {
		var r = confirm("Delete checklist with id: " + id + "?");
		if (r == true) {
			$.post("/admin/delete_from_trash", {
				id: id,
				project : project,
				serial : serial
			}).done(function(o) {
				//$('[id^=' + id + ']').remove();
				location.reload();
			});
		}
	}

    function restoreChecklist(id,project) {
		var r = confirm("Restore checklist with id: " + id + "?");
		if (r == true) {
			$.post("/admin/restoreChecklist", {
				id: id,
                project : project
			}).done(function(o) {
				//$('[id^=' + id + ']').remove();
				location.reload();
			});
		}
	}
</script>