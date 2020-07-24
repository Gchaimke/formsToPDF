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
				<h2 class="display-3">Templates</h2>
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
		<a class="btn btn-success" href="/templates/add_template"><i class="fa fa-file-text"></i></a>
		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Client</th>
					<th scope="col">Template</th>
					<th scope="col">Edit</th>
					<th scope="col">Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php if (isset($projects)) {
					foreach ($projects as $template) {
						echo '<tr id="' . $template['id'] . '">';
						echo  '<td>' . $template['client'] . '</td>';
						echo  '<td>' . $template['project'] . '</td>';
						echo "<td><a href='/templates/edit_template/" . $template['id'] .
							"' class='btn btn-info'><i class='fa fa-edit'></i></a></td>";
						echo "<td><button id='" . $template['id'] .
							"' class='btn btn-danger' onclick='deleteTemplate(this.id)'><i class='fa fa-trash'></i></button></td>";
						echo '</tr>';
					}
				} ?>
			</tbody>
		</table>
	</div>
</main>
<script>
	function deleteTemplate(id) {
		var r = confirm("Delete Template with id: " + id + "?");
		if (r == true) {
			$.post("/templates/delete_template", {
				id: id
			}).done(function(o) {
				console.log('Template deleted.');
				$('[id^=' + id + ']').remove();
			});
		}
	}
</script>