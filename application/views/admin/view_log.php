<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h5>Manage Logs </h5>
			</center>
		</div>
	</div>
	<div class="container">
		<nav aria-label="Checklist navigation">
			<?php if (isset($links)) {
				echo $links;
			} ?>
		</nav>
		<?php if (isset($results)) { ?>
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Logs</th>
						<th scope="col">Size</th>
						<th scope="col"><?= lang('delete') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($results as $key => $file) { ?>
						<tr>
							<?php
							$log_name = basename($file['name']);
							echo "<td class='ltr'><a href='#' onclick=showLogFile('$log_name') >$log_name</a></td>";
							echo '<td>', human_filesize($file['size']), '</td>';
							echo "<td><button data-file='{$file['name']}' class='btn btn-danger delete_log'><i class='fa fa-trash'></i></button></td>";
							?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } else { ?>
			<div>No logs found.</div>
		<?php } ?>
	</div>
	<div id='show-log' style='display:none;'>
		<div id="show-log-header">
			<div id="serial-header"></div><button type="button" class="close" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
		</div>
		<ul class="list-group list-group-flush">
		</ul>
	</div>
</main>
<script>
	function showLogFile(file) {
		$.post("/admin/get_log", {
			file: file
		}).done(function(o) {
			if (o != '') {
				log_arr = o.split(/\r?\n/)
				$("#show-log").show();
				$("#show-log .list-group").empty();
				$("#serial-header").text(file);
				log_arr.forEach(element => {
					if (element != '') {
						if (~element.indexOf("DELETE") || ~element.indexOf("ERROR")) {
							$("#show-log .list-group").append("<li class='list-group-item list-group-item-danger'>" + element + "</li>");
						} else if (~element.indexOf("TRASH")) {
							$("#show-log .list-group").append("<li class='list-group-item list-group-item-warning'>" + element + "</li>");
						} else {
							$("#show-log .list-group").append("<li class='list-group-item list-group-item-info'>" + element + "</li>");
						}
					}
				});
			}
		});

	}
	$('.delete_log').on('click', function() {
		var name = $(this).attr('data-file');
		var r = confirm("Delete log " + name + "?");
		if (r == true) {
			$.post("/admin/delete_file", {
				file: name
			}).done(function(o) {
				location.reload();
			});
		}
	});
</script>
<?php
function human_filesize($bytes, $decimals = 2)
{
	$sz = 'BKMGTP';
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}
?>