<?php
if (isset($this->session->userdata['logged_in'])) {
	$user_role = $this->session->userdata['logged_in']['role'];
	$user_id = $this->session->userdata['logged_in']['id'];
}

// משימות סינון לפי: שם טכנאי, חברה, עיר, סטטוס
?>
<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h5>משימות</h5>
			</center>
		</div>
	</div>
	<div class="container col-md-11">
		<div id="form-messages"></div>
		<?php
		if (isset($message_display)) {
			echo "<div class='alert alert-success' role='alert'>";
			echo $message_display . '</div>';
		}
		?>
		<?php if ($user_role == "Admin" || $user_role == "Manager") {
			echo '<a href="/tickets/uploader" class="btn btn-outline-info"><i class="fa fa-file-excel-o"> להעלות קובץ משימות </i></a>';
		} ?>
		<div class="form-row">
			<div class="form-group ml-2">
				<div class="input-group">
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
			<div class="form-group ml-2">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text">חברה</div>
					</div>
					<select class="company_filter" name="company">
						<option value="">-ללא סינון-</option>
						<?php foreach ($companies as $company) {
							echo "<option value='{$company['id']}'>{$company['name']}</option>";
						} ?>
					</select>
				</div>
			</div>
			<div class="form-group ml-2">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text">עיר</div>
					</div>
					<input type="text" class="city_filter" name="city">
				</div>
			</div>
			<div class="form-group ml-2">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text">סטטוס</div>
					</div>
					<select class="status_filter">
						<option value="">-ללא סינון-</option>
						<option value="new">new</option>
						<option value="working">working</option>
						<option value="done">done</option>
					</select>
				</div>
			</div>
			<div class="form-group ml-2">
				<div class="input-group">
					<a href="" class="filter_button btn btn-success" style="color: azure;" onclick=' '>סינון</a>
				</div>
			</div>
			<div class="form-group ml-2">
				<div class="input-group">
					<a href="/tickets" class="btn btn-warning" style="color: azure;" onclick=' '>בטל סינון</a>
				</div>
			</div>
		</div>
		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th scope="col">מספר לקוח</th>
					<th scope="col" class="mobile-hide">שם לקוח</th>
					<th scope="col" class="mobile-hide" style="width: 170px;">כתובת לקוח</th>
					<th scope="col" style="width: 100px;">עיר</th>
					<th scope="col" class="mobile-hide">משימה למחסן</th>
					<th scope="col" style="width: 150px;">חברה</th>
					<th scope="col">סטטוס</th>
					<th scope="col">יצרת דוח</th>
					<?php if ($user_role == "Admin" || $user_role == "Manager") {
						echo '<th scope="col">טכנאי</th><th scope="col">מחק</th>';
					} ?>

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
						<tr id="<?= $ticket['id'] ?>">
							<?php if ($ticket['status'] != "new") : ?>
								<td class="align-middle"><a href='/production/form_search/<?= $ticket['client_num'] ?>'><?= $ticket['client_num'] ?></a></td>
							<?php else : ?>
								<td class="align-middle"><?= $ticket['client_num'] ?></td>
							<?php endif ?>

							<td class="align-middle mobile-hide"><?= $ticket['client_name'] ?></td>
							<td class="align-middle mobile-hide"><?= $ticket['address'] ?></td>
							<td class="align-middle"><?= $ticket['city'] ?></td>
							<td class="align-middle mobile-hide"><?= $ticket['warehouse_num'] ?></td>
							<td class="align-middle"><?=$company_name?></td>
							<?php
							if ($ticket['status'] == "new") {
								echo '<td class="align-middle"><span class="badge badge-primary p-2">' . $ticket['status'] . '</span ></td>';
								echo '<td class="align-middle"><a href="/production/new_form?company_id=' . $ticket['company_id'] .
									'&client_num=' . $ticket['client_num'] .
									'&client_name=' . urlencode($ticket['client_name']) .
									'&address=' . urlencode($ticket['address']) .
									'&city=' . urlencode($ticket['city']) . '" class="btn btn-info"><i class="fa fa-edit"></i></a></td>';
							} else if ($ticket['status'] == "working") {
								echo '<td class="align-middle"><span class="badge badge-warning p-2">' . $ticket['status'] . '</span ></td>';
								if ($user_role == "Admin" || $user_role == "Manager") {
									echo '<td class="align-middle"><span class="btn btn-success done-ticket"><i class="fa fa-check"></i></span></td>';
								} else {
									echo '<td class="align-middle"></td>';
								}
							} else {
								echo '<td class="align-middle"><span class="badge badge-success p-2">' . $ticket['status'] . '</span ></td>';
								if ($user_role == "Admin" || $user_role == "Manager") {
									echo '<td class="align-middle"><span class="revert badge badge-warning p-2"><i class="fa fa-undo"></i></span></td>';
								} else {
									echo '<td class="align-middle"></td>';
								}
							}

							if ($user_role == "Admin" || $user_role == "Manager") {
								echo "<td class='align-middle'>";
								echo '<select class="user_selection form-control" name="user"><option value="-1"></option>';
								foreach ($users as $user) {
									if ($user['id'] ==  $ticket['creator_id']) {
										echo '<option value="' . htmlspecialchars($user['id']) . '" selected>' . htmlspecialchars($user['view_name']) . '</option>';
									} else {
										echo '<option value="' . htmlspecialchars($user['id']) . '">' . htmlspecialchars($user['view_name']) . '</option>';
									}
								}
								echo '</select>';

								echo "</td>";
								echo '<td class="align-middle"><button id="' . $ticket['id'] . '" class="btn btn-danger" onclick="deleteTicket(this.id)"><i class="fa fa-trash"></i></button></td>';
							} ?>
						</tr>
				<?php }
				} ?>
			</tbody>
		</table>
	</div>
</main>
<script>
	var creator = "<?php echo $creator = (isset($_GET['creator'])) ? $_GET['creator'] : ''; ?>";
	var company = "<?php echo $company = (isset($_GET['company'])) ? $_GET['company'] : ''; ?>";
	var city = "<?php echo $city = (isset($_GET['city'])) ? $_GET['city'] : ''; ?>";
	var status = "<?php echo $status = (isset($_GET['status'])) ? $_GET['status'] : ''; ?>";

	$('.creator_filter').on('change', function() {
		creator = $('.creator_filter').val();
		update_filter()
	});

	$('.company_filter').on('change', function() {
		company = $('.company_filter').val();
		update_filter()
	});

	$('.city_filter').on('change', function() {
		city = $('.city_filter').val();
		update_filter()
	});

	$('.status_filter').on('change', function() {
		status = $('.status_filter').val();
		update_filter()
	});

	function update_filter() {
		$('.filter_button').attr("href", '?creator=' + creator + '&company=' + company + '&city=' + city + '&status=' + status);
	}

	function set_options_selected() {
		$('.creator_filter').val(creator);
		$('.company_filter').val(company);
		$('.status_filter').val(status);
		$('.city_filter').val(city);
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
			status: 'done'
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
			status: 'working'
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