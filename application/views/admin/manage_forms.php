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
				<h2 class="display-3">Forms</h2>
			</center>
		</div>
	</div>
	<div class="container rtl">
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
				<input id='inputSearch' type="text" class="form-control" placeholder="חפש בתפסים" aria-label="Search in forms" aria-describedby="basic-addon2" autofocus>
				<div class="input-group-append">
					<button class="btn btn-secondary" type="button" onclick="formSearch()">חפש</button>
				</div>
			</div>
			<div id='searchResult'></div>
		</form>
		<?php if (isset($results)) { ?>
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">*</th>
						<th scope="col">תאריך</th>
						<th scope="col" class="mobile-hide">מספר תקלה</th>
						<th scope="col" class="mobile-hide">מספר לקוח</th>
						<th scope="col" class="mobile-hide">שם הלקוח</th>
						<th scope="col" class="mobile-hide">מיקום</th>
						<th scope="col" class="mobile-hide">סוג תקלה</th>
						<th scope="col">ערוך</th>
						<th scope="col">מחק</th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($results as $data) { ?>
						<tr id='<?php echo $data->id ?>'>
							<td>
								<div class='checkbox'><input type='checkbox' class='select' id='<?php echo $data->id ?>' $checked></div>
							</td>
							<td class="mobile-hide"><?php if ($data->date != '') {
									echo $data->date;
								} else {
									echo "SN template not found!";
								}  ?></td>
							<td><?php echo $data->issue_num ?></td>
							<td class="mobile-hide"><?php echo $data->client_num ?></td>
							<td><?php echo $data->client_name ?></td>
							<td class="mobile-hide"><?php echo $data->place ?></td>
							<td class="mobile-hide"><?php echo $data->issue_kind ?></td>
							
							<td><a target="_blank" href='/admin/view_form/<?php echo $data->id ?>?issue=<?php echo $data->issue_num ?>' class='btn btn-info'><i class="fa fa-edit"></i></a></td>
							<td><button id='<?php echo $data->id ?>' class='btn btn-danger' onclick='deleteForm(this.id)'><i class="fa fa-trash"></i></button></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } else { ?>
			<div>No checklist(s) found.</div>
		<?php } ?>
	</div>
</main>
<script>
	function deleteForm(id) {
		var r = confirm("Delete this form: " + id + "?");
		if (r == true) {
			$.post("/admin/delete_form", {
				id: id,
			}).done(function(o) {
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
			formSearch();
		}
	};
</script>