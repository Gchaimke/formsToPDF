<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h5><?= lang('companies') ?></h5>
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
		<a class="btn btn-success" href="/companies/create"><i class="fa fa-user-plus"></i></a>
		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th scope="col"><?= lang('logo') ?></th>
					<th scope="col"><?= lang('company_name') ?></th>
					<th scope="col"><?= lang('edit') ?></th>
					<?php echo ($role == 'Admin') ? '<th scope="col">'.lang('delete').'</th>' : '' ?>
				</tr>
			</thead>
			<tbody>
				<?php if (isset($companies)) {
					foreach ($companies as $company) {
						echo '<tr id="' . $company['id'] . '">';
						echo  '<td class="align-middle" style="width: 100px;"><img class="img-thumbnail" src="' . $company['logo'] . '"></td>';
						echo  '<td class="align-middle">' . $company['name'] . '</td>';
						echo '<td class="align-middle"><a href="/companies/edit/' . $company['id'] .
							'" class="btn btn-info"><i class="fa fa-edit"></i></a></td>';
						if ($role == 'Admin') {
							echo '<td class="align-middle"><button id="' . $company['id'] .
								'" class="btn btn-danger" onclick="deleteClient(this.id)"><i class="fa fa-trash"></i></button></td>';
						}
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
			$.post("/companies/delete", {
				id: id
			}).done(function(o) {
				console.log('Client deleted.');
				$('[id^=' + id + ']').remove();
			});
		}
	}
</script>