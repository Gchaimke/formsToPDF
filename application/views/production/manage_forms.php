<?php
if (isset($this->session->userdata['logged_in'])) {
	$user_role = $this->session->userdata['logged_in']['role'];
	$user_id = $this->session->userdata['logged_in']['id'];
}
?>
<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h5>דוחות</h5>
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
		<form id="form" class='ltr'>
			<div class="input-group mb-3">
				<input id='inputSearch' type="text" class="form-control" 
				placeholder="מספר תקלה,מספר לקוח,שם לקוח,יוצר" 
				aria-label="Search in forms" aria-describedby="basic-addon2" autofocus>
				<div class="input-group-append">
					<button class="btn btn-outline-primary" type="button" onclick="formSearch()">חפש</button>
				</div>
			</div>
			<div id='searchResult' class='rtl text-center'></div>
		</form>
		<?php if (isset($results)) { ?>
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">תאריך</th>
						<th scope="col">יוצר</th>
						<th scope="col" class="mobile-hide">מספר לקוח</th>
						<th scope="col" class="mobile-hide">שם הלקוח</th>
						<th scope="col" class="mobile-hide">מיקום</th>
						<th scope="col" class="mobile-hide">סוג תקלה</th>
						<th scope="col" class="mobile-hide">חברה נותנת שירות</th>
						<th scope="col">ערוך</th>
						<?php if ($user_role == "Admin") {
							echo '<th scope="col">מחק</th>';
						}
						?>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($results as $data) {
						if ($user_role != 'Admin' && $data->creator_id != $user_id)
							continue;
					?>
						<tr id='<?php echo $data->id ?>'>
							<td class="align-middle"><?php echo date("d-m-Y", strtotime($data->date))  ?></td>
							<?php foreach($users as $user){
								if($user['id']==$data->creator_id){
									echo '<td class="align-middle">'.$user['view_name'].'</td>';
								}
							}?>
							<td class="mobile-hide align-middle"><?php echo $data->client_num ?></td>
							<td class="mobile-hide align-middle"><?php echo $data->client_name ?></td>
							<td class="mobile-hide align-middle"><?php echo $data->place ?></td>
							<td class="mobile-hide align-middle"><?php echo $data->issue_kind ?></td>
							<td class="mobile-hide align-middle"><?php echo $data->company ?></td>
							<td><a href='/production/view_form/<?php echo $data->id ?>' class='btn btn-outline-info'><i class="fa fa-edit"></i></a></td>
							<?php if ($user_role == "Admin") {
								echo "<td><button id='" . $data->id . "' class='btn btn-outline-danger' onclick='deleteForm(this.id)'><i class='fa fa-trash'></i></button></td>";
							}
							?>

						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } else { ?>
			<div>אין עדיין דוחות</div>
		<?php } ?>
	</div>
</main>
<script>
	function deleteForm(id) {
		var r = confirm("Delete this form: " + id + "?");
		if (r == true) {
			$.post("/production/delete_form", {
				id: id,
			}).done(function(o) {
				location.reload();
			});
		}
	}

	function formSearch() {
		var search = document.getElementById("inputSearch").value;
		if (search.length >= 3) {
			$.post("/production/form_search", {
				search: search
			}).done(function(e) {
				if (e.length > 0) {
					$('#searchResult').empty();
					$('#searchResult').append(e);
				} else {
					$('#searchResult').empty();
					$('#searchResult').append("<h2>Form: " + search + " not found!</h2>");
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