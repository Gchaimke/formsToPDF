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
				<h2 class="display-4">Companies</h2>
			</center>
		</div>
	</div>
	<div class="container">
		<?php
		if (isset($message_display)) {
			echo "<div class='alert alert-success' role='alert'>";
			echo $message_display. '</div>';
		}
		?>
		<a class="btn btn-success" href="/Companies/create"><i class="fa fa-user-plus"></i></a>
		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Client</th>
					<th scope="col">Edit</th>
					<th scope="col">Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php if (isset($Companies)) {
					foreach ($Companies as $client) {
						echo '<tr id="' . $client['id'] . '">';
						echo  '<td>' . $client['name'] . '</td>';
						echo "<td><a href='/Companies/edit/" . $client['id'] .
							"' class='btn btn-info'><i class='fa fa-edit'></i></a></td>";
						echo "<td><button id='" . $client['id'] .
							"' class='btn btn-danger' onclick='deleteClient(this.id)'><i class='fa fa-trash'></i></button></td>";
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
			$.post("/Companies/delete", {
				id: id
			}).done(function(o) {
				console.log('Client deleted.');
				$('[id^=' + id + ']').remove();
			});
		}
	}
</script>