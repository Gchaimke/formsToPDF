<?php
if (isset($this->session->userdata['logged_in']) && $this->session->userdata['logged_in']['id'] != '') {
	$user_role = $this->session->userdata['logged_in']['role'];
	$user_id = $this->session->userdata['logged_in']['id'];
}else{
	header("location: /");
}
$creator_id = isset($creator) ? $creator : '';
$company_name = isset($company) ? $company : '';
$date = isset($date) ? $date : '';
$month = substr($date, 5, 2);
$year = substr($date, 0, 4);
?>
<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h5>דוחות</h5>
			</center>
		</div>
	</div>

	<div class="container rtl col-md-10">
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
				<input id='inputSearch' type="text" class="form-control" placeholder="מספר תקלה,מספר לקוח,שם לקוח,יוצר" aria-label="Search in forms" aria-describedby="basic-addon2" autofocus>
				<div class="input-group-append">
					<button class="btn btn-outline-primary" type="button" onclick="formSearch()">חפש</button>
				</div>
			</div>
			<div id='searchResult' class='rtl text-center'></div>
		</form>
		<div class="form-row mb-3">
			<div class="form-group col-md-2">
				<div class="input-group mb-2">
					<div class="input-group-prepend">
						<div class="input-group-text">יוצר</div>
					</div>
					<select class="creator_filter">
						<option value="">-ללא סינון-</option>
						<?php foreach ($users as $user) {
							echo "<option value='{$user['id']}'>{$user['view_name']}</option>";
						} ?>
					</select>
				</div>
			</div>
			<div class="form-group col-md-2">
				<div class="input-group mb-2">
					<div class="input-group-prepend">
						<div class="input-group-text">חברה</div>
					</div>
					<select class="company_filter">
						<option value="">-ללא סינון-</option>
						<?php foreach ($companies as $company) {
							echo "<option value='{$company['name']}'>{$company['name']}</option>";
						} ?>
					</select>
				</div>
			</div>
			<div class="form-group col-md-2">
				<div class="input-group mb-2">
					<div class="input-group-prepend">
						<div class="input-group-text">חודש</div>
					</div>
					<select id="month-dropdown" class="month_filter">
						<option value="">-ללא סינון-</option>
					</select>
				</div>
			</div>
			<div class="form-group col-md-2">
				<div class="input-group mb-2">
					<div class="input-group-prepend">
						<div class="input-group-text">שנה</div>
					</div>
					<select id="yaer-dropdown" class="year_filter">
						<option value="">-ללא סינון-</option>
					</select>
				</div>
			</div>
			<div class="form-group col-md-1">
				<div class="input-group">
					<a href="" class="filter_button btn btn-info" style="color: azure;" onclick=' '>סינון</a>
				</div>
			</div>
			<div class="form-group col-md-1">
				<div class="input-group">
					<a href="/production/manage_forms" class="btn btn-info" style="color: azure;" onclick=' '>בטל סינון</a>
				</div>
			</div>
		</div>

		<div id="show_csv" class='btn btn-outline-info'><i class="fa fa-file-excel-o"></i></div>
		<div id="csv_month" style="display:none;">
		</div>
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
						<?php if ($user_role == "Admin") {
							echo '<th scope="col" class="mobile-hide">מחיר</th>';
						} ?>
						<th scope="col">ערוך </th>
						<?php if ($user_role == "Admin") {
							echo '<th scope="col">מחק</th>';
						}
						?>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($results as $data) {
						if ($user_role != 'Admin' && $user_role != 'Manager') {
							if ($data->creator_id != $user_id) {
								continue;
							}
						}
					?>
						<tr id='<?php echo $data->id ?>'>
							<td class="align-middle">
								<?php
								echo date("d-m-Y", strtotime($data->date));
								if ($data->attachments != '') {
									echo '<i class="mr-1 fa fa-paperclip" aria-hidden="true"></i> ';
								} ?>
							</td>
							<?php foreach ($users as $user) {
								if ($user['id'] == $data->creator_id) {
									echo '<td class="align-middle">' . $user['view_name'] . '</td>';
								}
							} ?>
							<td class="mobile-hide align-middle"><?php echo $data->client_num ?></td>
							<td class="mobile-hide align-middle"><?php echo $data->client_name ?></td>
							<td class="mobile-hide align-middle"><?php echo $data->place ?></td>
							<td class="mobile-hide align-middle"><?php echo $data->issue_kind ?></td>
							<td class="mobile-hide align-middle"><?php echo $data->company ?></td>
							<?php if ($user_role == "Admin") {
								echo '<td class="mobile-hide align-middle">' . $data->price . '</td>';
							} ?>
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
	var creator = "<?php echo $creator = (isset($_GET['creator'])) ? $_GET['creator'] : ''; ?>";
	var company = "<?php echo $company = (isset($_GET['company'])) ? $_GET['company'] : ''; ?>";
	var month = "<?php echo $month = (isset($_GET['month'])) ? $_GET['month'] : ''; ?>";
	var year = "<?php echo $year = (isset($_GET['year'])) ? $_GET['year'] : ''; ?>";
	$('.creator_filter').on('change', function() {
		creator = $('.creator_filter').val();
		update_filter()
	});

	$('.year_filter').on('change', function() {
		year = $('.year_filter').val();
		update_filter()
	});

	$('.month_filter').on('change', function() {
		month = $('.month_filter').val();
		update_filter()
	});

	$('.company_filter').on('change', function() {
		company = $('.company_filter').val();
		update_filter()
	});

	function update_filter() {
		$('.filter_button').attr("href", '?creator=' + creator + '&company=' + company + '&year=' + year + '&month=' + month);
	}

	function view_csv_export() {
		let creator_str = "?creator=" + "<?php echo $creator = (isset($_GET['creator'])) ? $_GET['creator'] : ''; ?>";
		let year_str = "&year=" + "<?php echo $year = (isset($_GET['year'])) ? $_GET['year'] : ''; ?>";
		let company_str = "&company=" + "<?php echo $company = (isset($_GET['company'])) ? $_GET['company'] : ''; ?>";
		for (let index = 1; index <= 12; index++) {
			$('#csv_month').append("<a target='blank' href='/production/export_to/" + index + creator_str + year_str + company_str + "' class='btn btn-outline-info'>" + index + "</a>")
		}
	}

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

	function set_options_selected() {
		$('.creator_filter').val(creator);
		$('.year_filter').val(year);
		$('.month_filter').val(month);
		$('.company_filter').val(company);
	}

	window.onload = function() {
		set_years();
		set_month();
		view_csv_export();
		update_filter();
		set_options_selected();
	}
</script>