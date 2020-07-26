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
			echo $message_display . '</div>';
		} ?>
			<?php
			echo '<div class="card-columns">';
			foreach ($companies as $company) {
				$company_name = $company['name'];
				echo '<div id="' . $company_name . '" class="card"><center><div class="card-body">
				<h5 class="card-title">'.$company_name.'</h5>';
				echo '<p class="card-text"></p></div>';
				echo '<div class="card-footer">';
				echo  "<a href='/production/checklists/$company_name' class='btn btn-primary  btn-block'>New Form</a>";
				echo '</div></center></div>';
			}

			?>
	</div>
	</div>
</main>