<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h5><?= lang('menu_contacts') ?></h5>
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
		<a class="btn btn-success" href="/contacts/create"><i class="fa fa-user-plus"></i></a>
		<div class="table-responsive">
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col" style="min-width: 150px;"><?= lang('name') ?></th>
						<th scope="col"><?= lang('email') ?></th>
						<th scope="col" style="min-width: 150px;"><?= lang('company') ?></th>
						<th scope="col"><?= lang('edit') ?></th>
						<th scope="col"><?= lang('delete') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if (isset($contacts)) {
						foreach ($contacts as $contact) {
							echo '<tr id="' . $contact['id'] . '">';
							echo  '<td class="align-middle">' . $contact['name'] . '</td>';
							echo  '<td class="align-middle">' . $contact['email'] . '</td>';
							echo  '<td class="align-middle">' . $contact['company'] . '</td>';
							echo '<td class="align-middle"><a href="/contacts/edit/' . $contact['id'] .
								'" class="btn btn-info"><i class="fa fa-edit"></i></a></td>';
							echo '<td class="align-middle"><button id="' . $contact['id'] .
								'" class="btn btn-danger" onclick="deleteClient(this.id)"><i class="fa fa-trash"></i></button></td>';
							echo '</tr>';
						}
					} ?>
				</tbody>
			</table>
		</div>
	</div>
</main>
<script>
	function deleteClient(id) {
		var r = confirm("Delete Client with id: " + id + "?");
		if (r == true) {
			$.post("/contacts/delete", {
				id: id
			}).done(function(o) {
				console.log('Client deleted.');
				$('[id^=' + id + ']').remove();
			});
		}
	}
</script>