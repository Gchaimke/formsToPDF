<?php
$user_role = '';
if (isset($this->session->userdata['logged_in'])) {
	$user_role = $this->session->userdata['logged_in']['role'];
}
$creator_id = isset($creator) ? $creator : '';
$company_name = isset($company) ? $company : '';
$date = isset($date) ? $date : '';
$month = substr($date, 5, 2);
$year = substr($date, 0, 4);
$is_hiden = $hide_filter ? 'hidden' : '';
?>
<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h5><?= lang('forms') ?></h5>
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
		<div id="buttons-section">
			<div id="show_filters" class='btn btn-outline-info <?= $is_hiden ?> mobile-no-hide'><i class="fa fa-filter"></i></div>
			<a id="no_filters" href="/production/manage_forms" class="btn btn-outline-secondary hidden" onclick=' '><?= lang('reset_filter') ?></a>
			<?php
			if ($user_role == 'Admin' || $user_role == 'Manager') { ?>
				<div id="show_csv" class='btn btn-outline-info'><i class="fa fa-file-excel-o"></i></div>
				<div id="csv_month" style="display:none;"></div>
			<?php }	?>
		</div>
		<div id="filters_section" class="form-row mobile-hide">
			<div class="form-group ml-2">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><?= lang('day') ?></div>
					</div>
					<input type='date' class="form-control date_filter" name='date'>
				</div>
			</div>
			<div class="form-group ml-2">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><?= lang('technician') ?></div>
					</div>
					<select class="creator_filter">
						<option value=""><?= lang('no_filter') ?></option>
						<?php
						if (isset($users)) {
							foreach ($users as $user) {
								echo "<option value='{$user['id']}'>{$user['view_name']}</option>";
							}
						} ?>
					</select>
				</div>
			</div>
			<div class="form-group ml-2">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><?= lang('company') ?></div>
					</div>
					<select class="company_filter">
						<option value=""><?= lang('no_filter') ?></option>
						<?php
						if (isset($companies)) {
							foreach ($companies as $company) {
								echo "<option value='{$company['name']}'>{$company['name']}</option>";
							}
						} ?>
					</select>
				</div>
			</div>
			<div class="form-group ml-2">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><?= lang('month') ?></div>
					</div>
					<select id="month-dropdown" class="month_filter">
						<option value=""><?= lang('no_filter') ?></option>
					</select>
				</div>
			</div>
			<div class="form-group ml-2">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><?= lang('year') ?></div>
					</div>
					<select id="yaer-dropdown" class="year_filter">
						<option value=""><?= lang('no_filter') ?></option>
					</select>
				</div>
			</div>
			<div class="form-group ml-2">
				<div class="input-group">
					<a href="" class="filter_button btn btn-success hidden" style="color: azure;" onclick=' '><?= lang('filter') ?></a>
				</div>
			</div>
		</div>
		<div id="search_section">
			<form id="form" class='mobile-hide ltr'>
				<div class="input-group mb-3">
					<input id='inputSearch' type="text" class="form-control" placeholder="<?= lang('search_placeholder') ?>" aria-label="Search in forms" aria-describedby="basic-addon2" autofocus>
					<div class="input-group-append">
						<button class="btn btn-outline-primary" type="button" onclick="formSearch()"><?= lang('search') ?></button>
					</div>
				</div>
				<div id='searchResult' class='rtl text-center'></div>
			</form>
		</div>
		<div class="table-responsive">
			<?php if (isset($html_table)) {
				echo $html_table;
			} else {
				echo '<div>' . lang('no_forms') . '</div>';
			} ?>
		</div>
		<nav aria-label="Checklist navigation" class="<?= $is_hiden ?>">
			<?php if (isset($links)) {
				echo $links;
			} ?>
		</nav>
	</div>

</main>
<script>
	var creator = "<?php echo $creator = (isset($_GET['creator'])) ? $_GET['creator'] : ''; ?>";
	var company = "<?php echo $company = (isset($_GET['company'])) ? $_GET['company'] : ''; ?>";
	var month = "<?php echo $month = (isset($_GET['month'])) ? $_GET['month'] : ''; ?>";
	var year = "<?php echo $year = (isset($_GET['year'])) ? $_GET['year'] : ''; ?>";
	var date = "<?php echo $date = (isset($_GET['date'])) ? $_GET['date'] : ''; ?>";
	$('.creator_filter').on('change', function() {
		creator = $('.creator_filter').val();
		update_filter();
		location = $('.filter_button').attr("href");
	});

	$('.year_filter').on('change', function() {
		year = $('.year_filter').val();
		update_filter();
		location = $('.filter_button').attr("href");
	});

	$('.month_filter').on('change', function() {
		month = $('.month_filter').val();
		update_filter();
		location = $('.filter_button').attr("href");
	});

	$('.date_filter').on('change', function() {
		date = $('.date_filter').val();
		update_filter();
		location = $('.filter_button').attr("href");
	});

	$('.company_filter').on('change', function() {
		company = $('.company_filter').val();
		update_filter();
		location = $('.filter_button').attr("href");
	});

	function update_filter() {
		$('.filter_button').attr("href", '?creator=' + creator + '&company=' + company + '&year=' + year + '&month=' + month + '&date=' + date);
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
		location = "/production/form_search/" + search;
	}

	document.onkeydown = function(e) {
		var pathname = window.location.pathname.split("/");
		if (e.which == 13) { //enter
			e.preventDefault();
			formSearch();
		}
	};

	function set_options_selected() {
		if (creator != '' || year != '' || month != '' || date != '' || company != '') {
			$('#no_filters').toggle();
		}
		$('.creator_filter').val(creator);
		$('.year_filter').val(year);
		$('.month_filter').val(month);
		$('.date_filter').val(date);
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