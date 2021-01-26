<?php
if (isset($this->session->userdata['logged_in'])) {
	$user_role = $this->session->userdata['logged_in']['role'];
	$user_name = $this->session->userdata['logged_in']['name'];
	$user_id = $this->session->userdata['logged_in']['id'];
}
?>
<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h5>משימות</h5>
			</center>
		</div>
	</div>
	<div class="container">
		<div id="form-messages"></div>
		<?php
		if (isset($message_display)) {
			echo "<div class='alert alert-success' role='alert'>";
			echo $message_display . '</div>';
		}
		?>
		<?php if ($user_role == "Admin" || $user_role == "Manager") {
			echo '<a href="/tickets/uploader" class="btn btn-outline-info"><i class="fa fa-file-excel-o"> לעלות קובץ משימות </i></a>';
		} ?>
		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th scope="col">מספר לקוח</th>
					<th scope="col">שם לקוח</th>
					<th scope="col">כתובת לקוח</th>
					<th scope="col">עיר</th>
					<th scope="col">משימה למחסן</th>
					<th scope="col">חברה</th>
					<th scope="col">סטטוס</th>
					<th scope="col">יצרת דוח</th>
					<?php if ($user_role == "Admin" || $user_role == "Manager") {
						echo '<th scope="col">טכנאי</th><th scope="col">מחק</th>';
					} ?>

				</tr>
			</thead>
			<tbody>
				<?php if (isset($tickets)) {
					foreach ($tickets as $ticket) { ?>
						<tr id="<?= $ticket['id'] ?>">
							<td class="align-middle" style="width: 100px;"><?= $ticket['client_num'] ?></td>
							<td class="align-middle"><?= $ticket['client_name'] ?></td>
							<td class="align-middle"><?= $ticket['address'] ?></td>
							<td class="align-middle"><?= $ticket['city'] ?></td>
							<td class="align-middle"><?= $ticket['warehouse_num'] ?></td>
							<td class="align-middle"><?php
														if (isset($companies)) {
															foreach ($companies as $company) {
																if ($company['id'] == $ticket['company_id']) {
																	echo $company['name'];
																}
															}
														} ?></td>

							<?php if ($ticket['status'] == "new") {
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
								echo '<td class="align-middle"><span class="revert badge badge-success p-2">' . $ticket['status'] . '</span ></td>';
								echo '<td class="align-middle"></td>';
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
								echo '<td class="align-middle"><button id="' . $ticket['id'] . '" class="btn btn-danger" onclick="deleteClient(this.id)"><i class="fa fa-trash"></i></button></td>';
							} ?>
						</tr>
				<?php }
				} ?>
			</tbody>
		</table>
	</div>
</main>
<script>
	function deleteClient(id) {
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