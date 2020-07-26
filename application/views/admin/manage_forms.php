<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h2 class="display-3">Forms</h2>
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
		<form id="form">
			<div class="input-group mb-3">
				<input id='inputSearch' type="text" class="form-control" placeholder="Search in forms" aria-label="Search in forms" aria-describedby="basic-addon2" autofocus>
				<div class="input-group-append">
					<button class="btn btn-secondary" type="button" onclick="formSearch()">Search</button>
				</div>
			</div>
			<div id='searchResult'></div>
		</form>
		<?php if (isset($results)) { ?>
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">*</th>
						<th scope="col">Form Date</th>
						<th scope="col" class="mobile-hide">Issue Number</th>
						<th scope="col" class="mobile-hide">Client Number</th>
						<th scope="col" class="mobile-hide">Client Name</th>
						<th scope="col" class="mobile-hide">Place</th>
						<th scope="col" class="mobile-hide">Issue</th>
						<th scope="col">Save</th>
						<th scope="col">Trash</th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($results as $data) { ?>
						<tr id='<?php echo $data->id ?>'>
							<td>
								<div class='checkbox'><input type='checkbox' class='select' id='<?php echo $data->id ?>' $checked></div>
							</td>
							<td><?php if ($data->date != '') {
									echo $data->date;
								} else {
									echo "SN template not found!";
								}  ?></td>
							<td class="mobile-hide"><?php echo $data->issue_num ?></td>
							<td class="mobile-hide"><?php echo $data->client_num ?></td>
							<td class="mobile-hide"><?php echo $data->client_name ?></td>
							<td class="mobile-hide"><?php echo $data->place ?></td>
							<td class="mobile-hide"><?php echo $data->issue_kind ?></td>
							
							<td><a id='edit_checklist' target="_blank" href='/production/edit_checklist/<?php echo $data->id ?>?sn=<?php echo $data->issue_num ?>' class='btn btn-info'><i class="fa fa-edit"></i></a></td>
							<td><button id='<?php echo $data->id ?>' class='btn btn-danger' onclick='trashChecklist(this.id,"<?php echo urldecode($project); ?>","<?php echo $data->issue_num; ?>")'><i class="fa fa-trash"></i></button></td>
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
			<div id="issue_num-header"></div>Click here to move<button type="button" class="close" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
		</div>
		<ul class="list-group list-group-flush">
		</ul>
	</div>
</main>
<script>
	function trashChecklist(id,project,issue_num) {
		var r = confirm("Trash checklist " + issue_num + "?");
		if (r == true) {
			$.post("/production/trashChecklist", {
				id: id,
				project : project,
				issue_num : issue_num
			}).done(function(o) {
				//$('[id^=' + id + ']').remove();
				location.reload();
			});
		}
	}

	function formSearch() {
		var search = document.getElementById("inputSearch").value;
		if (search.length >= 3) {
			$.post("/admin/form_search", {
				search: search
			}).done(function(e) {
				if (e.length > 0) {
					$('#searchResult').empty();
					$('#searchResult').append( e );
				} else {
					$('#searchResult').empty();
					$('#searchResult').append("<h2>Form: "+search+" not found!</h2>");
				}
			});
		} else {
			$('#searchResult').empty();
			$('#searchResult').append("<h2>Search must be munimum 3 simbols</h2>")
		}
	}

	document.onkeydown = function(e) {
		var pathname = window.location.pathname.split("/");
		if (e.which == 13) { //enter
			e.preventDefault();
			serialSearch();
		}
	};
</script>