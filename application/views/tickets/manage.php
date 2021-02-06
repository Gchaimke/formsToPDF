<?php
if (isset($this->session->userdata['logged_in'])) {
	$user_role = $this->session->userdata['logged_in']['role'];
}
if ($user_role == "Admin" || $user_role == "Manager") {
	$u_button_html = '<a href="/tickets/import_xlsx" class="btn btn-outline-info"><i class="fa fa-file-excel-o"> ' . lang('upload_tickets') . '</i></a>';
	$tb_header_html = '<th scope="col" style="min-width:120px;">' . lang('technician') . '</th><th scope="col">' . lang('delete') . '</th>';
	$btn_done = '<span class="done-ticket btn btn-outline-success"><i class="fa fa-check"></i></span>';
	$btn_revert = '<span class="revert btn btn-outline-secondary"><i class="fa fa-undo"></i></span>';
} else {
	$u_button_html = $tb_header_html = '';
	$btn_done = $btn_revert = '';
}

?>
<style>
	span.btn {
		padding: 0px 13px;
		margin-right: 5px;
	}

	span.badge {
		width: 100px;
	}
</style>
<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h5><?= lang('tickets') ?></h5>
			</center>
		</div>
	</div>
	<div class="container col-md-10">
		<div id="form-messages"></div>
		<?php
		if (isset($message_display)) {
			echo "<div class='alert alert-success' role='alert'>";
			echo $message_display . '</div>';
		}
		?>
		<div id="buttons-section">
			<div id="show_filters" class='btn btn-outline-info mobile-no-hide'><i class="fa fa-filter"></i></div>
			<a id="no_filters" href="/tickets" class="btn btn-outline-secondary hidden" onclick=' '><?= lang('reset_filter') ?></a>
			<?= $u_button_html ?>
		</div>
		<div class="form-row mobile-hide" id="filters_section">
			<div class="form-group ml-2">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><?= lang('status') ?></div>
					</div>
					<select class="status_filter">
						<option value=""><?= lang('no_filter') ?></option>
						<option value=0><?= lang('new') ?></option>
						<option value=1><?= lang('working') ?></option>
						<option value=2><?= lang('done') ?></option>
					</select>
				</div>
			</div>
			<div class="form-group ml-2">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><?= lang('company') ?></div>
					</div>
					<select class="company_filter" name="company">
						<option value=""><?= lang('no_filter') ?></option>
						<?php foreach ($companies as $company) {
							echo "<option value='{$company['id']}'>{$company['name']}</option>";
						} ?>
					</select>
				</div>
			</div>
			<div class="form-group ml-2">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><?= lang('technician') ?></div>
					</div>
					<select class="creator_filter">
						<option value=""><?= lang('no_filter') ?></option>
						<option value="0"><?= lang('unresolved') ?></option>
						<?php foreach ($users as $user) {
							echo "<option value='{$user['id']}'>{$user['view_name']}</option>";
						} ?>
					</select>
				</div>
			</div>
			<div class="form-group ml-2 ">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><?= lang('search') ?></div>
					</div>
					<input type="text" class="search_filter" name="search">
				</div>
			</div>
			<div class="form-group ml-2">
				<div class="input-group">
					<a href="" class="filter_button btn btn-success hidden" style="color: azure;" onclick=' '><?= lang('filter') ?></a>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col" style="min-width:105px;"><?= lang('client_num_column') ?></th>
						<th scope="col" class="mobile-hide"><?= lang('client_name_column') ?></th>
						<th scope="col" class="mobile-hide" style="width: 170px;"><?= lang('place_column') ?></th>
						<th scope="col" class="mobile-hide" style="width: 100px;"><?= lang('city_column') ?></th>
						<th scope="col" class="mobile-hide"><?= lang('warehouse_num') ?></th>
						<th scope="col" class="mobile-hide" style="width: 150px;"><?= lang('company') ?></th>
						<th scope="col"><?= lang('status') ?></th>
						<?= $tb_header_html ?>
					</tr>
				</thead>
				<tbody>
					<?php if (isset($tickets)) {
						foreach ($tickets as $ticket) {
							if (isset($companies)) {
								foreach ($companies as $company) {
									if ($company['id'] == $ticket['company_id']) {
										$company_name =  $company['name'];
									}
								}
							} ?>
							<tr id="<?= $ticket['id'] ?>" class="data-row">
								<?php if ($ticket['status'] != 0) : ?>
									<td class="align-middle view_name"><a href='/production/form_search/<?= $ticket['client_num'] ?>'><?= $ticket['client_num'] ?></a></td>
								<?php else : ?>
									<td class="align-middle view_name"><?= $ticket['client_num'] ?></td>
								<?php endif ?>

								<td class="align-middle mobile-hide mobile-data"><?= $ticket['client_name'] ?></td>
								<td class="align-middle mobile-hide"><?= $ticket['address'] ?></td>
								<td class="align-middle mobile-hide mobile-data"><?= $ticket['city'] ?></td>
								<td class="align-middle mobile-hide"><?= $ticket['warehouse_num'] ?></td>
								<td class="align-middle mobile-hide mobile-data"><?= $company_name ?></td>
								<td class="align-middle">
									<?php
									if ($ticket['status'] == 0) {
										echo '<span class="badge badge-primary">' . lang('new');
										echo '<span class="btn btn-outline-secondary">
									<a href="/production/new_form?company_id=' . $ticket['company_id'] .
											'&client_num=' . $ticket['client_num'] .
											'&client_name=' . urlencode($ticket['client_name']) .
											'&address=' . urlencode($ticket['address']) .
											'&search=' . urlencode($ticket['city']) . '" style="color:black;"><i class="fa fa-edit"></i></a></span ></span >';
									} else if ($ticket['status'] == 1) {
										echo '<span class="badge badge-warning">' . lang('working') . ' ' . $btn_done . '</span >';
									} else {
										echo '<span class="badge badge-success">' . lang('done') . ' ' . $btn_revert . '</span >';
									}
									echo '</td>';

									if ($user_role == "Admin" || $user_role == "Manager") {
										echo "<td class='align-middle'>";
										echo '<select class="user_selection form-control" name="user"><option value="-1"></option>';
										foreach ($users as $user) {
											if ($user['id'] ==  $ticket['creator_id']) {
												echo '<option value="' . $user['id'] . '" selected>' . htmlspecialchars($user['view_name']) . '</option>';
											} else {
												echo '<option value="' . $user['id'] . '">' . htmlspecialchars($user['view_name']) . '</option>';
											}
										}
										echo '</select></td>';
										echo '<td class="align-middle">
									 <button id="' . $ticket['id'] . '" class="btn btn-outline-danger" onclick="deleteTicket(this.id)">
									 <i class="fa fa-trash"></i></button></td>';
									} ?>
							</tr>
					<?php }
					} ?>
				</tbody>
			</table>
		</div>
	</div>
</main>
<script>
	var creator = "<?php echo $creator = (isset($_GET['creator'])) ? $_GET['creator'] : ''; ?>";
	var company = "<?php echo $company = (isset($_GET['company'])) ? $_GET['company'] : ''; ?>";
	var search = "<?php echo $search = (isset($_GET['search'])) ? $_GET['search'] : ''; ?>";
	var status = "<?php echo $status = (isset($_GET['status'])) ? $_GET['status'] : ''; ?>";

	$('.creator_filter').on('change', function() {
		creator = $('.creator_filter').val();
		update_filter();
		location = $('.filter_button').attr("href");
	});

	$('.company_filter').on('change', function() {
		company = $('.company_filter').val();
		update_filter();
		location = $('.filter_button').attr("href");
	});

	$('.search_filter').on('change', function() {
		search = $('.search_filter').val();
		update_filter();
		location = $('.filter_button').attr("href");
	});

	$('.status_filter').on('change', function() {
		status = $('.status_filter').val();
		update_filter();
		location = $('.filter_button').attr("href");
	});

	function update_filter() {
		$('.filter_button').attr("href", '?creator=' + creator + '&company=' + company + '&search=' + search + '&status=' + status);

	}

	function set_options_selected() {
		if (creator != '' || company != '' || status != '' || search != '') {
			$('#no_filters').toggle();
		}
		$('.creator_filter').val(creator);
		$('.company_filter').val(company);
		$('.status_filter').val(status);
		$('.city_filter').val(search);
	}

	window.onload = function() {
		update_filter();
		set_options_selected();
	}

	function deleteTicket(id) {
		var r = confirm("Delete ticket with id: " + id + "?");
		if (r == true) {
			$.post("/tickets/delete", {
				id: id
			}).done(function(o) {
				console.log('ticket deleted.');
				$('[id^=' + id + ']').remove();
			});
		}
	}
	$('.user_selection').on('change', function() {
		var user_id = $(this).val();
		var ticket_id = $(this).closest('tr').attr('id');
		$.post('/tickets/update/' + ticket_id, {
			user_id: user_id
		}).done(function(response) {
			$('#form-messages').addClass('alert-success');
			$('#form-messages').text(response).fadeIn(1000).delay(3000).fadeOut(1000); //show message
			console.log(response);
		}).fail(function(response) {
			$('#form-messages').addClass('alert-danger');
			$('#form-messages').text('אין אפשרות לשמור שינוים' + response).fadeIn(1000).delay(3000).fadeOut(5000);
			console.log(response);
		});
	});
	$('.done-ticket').on('click', function() {
		var ticket_id = $(this).closest('tr').attr('id');
		$.post('/tickets/update/' + ticket_id, {
			status: 2
		}).done(function(response) {
			$('#form-messages').addClass('alert-success');
			$('#form-messages').text(response).fadeIn(1000).delay(3000).fadeOut(1000); //show message
			console.log(response);
			location.reload();
		}).fail(function(response) {
			$('#form-messages').addClass('alert-danger');
			$('#form-messages').text('אין אפשרות לשמור שינוים' + response).fadeIn(1000).delay(3000).fadeOut(5000);
			console.log(response);
		});
	});
	$('.revert').on('click', function() {
		var ticket_id = $(this).closest('tr').attr('id');
		$.post('/tickets/update/' + ticket_id, {
			status: '1'
		}).done(function(response) {
			$('#form-messages').addClass('alert-success');
			$('#form-messages').text(response).fadeIn(1000).delay(3000).fadeOut(1000); //show message
			console.log(response);
			location.reload();
		}).fail(function(response) {
			$('#form-messages').addClass('alert-danger');
			$('#form-messages').text('אין אפשרות לשמור שינוים' + response).fadeIn(1000).delay(3000).fadeOut(5000);
			console.log(response);
		});
	});
</script>