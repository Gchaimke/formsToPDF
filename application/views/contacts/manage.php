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
				<h5>חברות</h5>
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
		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th scope="col">שם</th>
					<th scope="col">מאייל</th>
					<th scope="col">חברה</th>
					<th scope="col">ערוך</th>
					<th scope="col">מחק</th>
				</tr>
			</thead>
			<tbody>
				<?php if (isset($contacts)) {
					foreach ($contacts as $contact) {
						echo '<tr id="' . $contact['id'] . '">';
						echo  "<td class=\"align-middle\" style=\"width: 100px;\">{$contact['name']}</td>";
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