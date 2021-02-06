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
		} ?>
		<?php
		echo '<div class="card-columns">';
		foreach ($companies as $company) {
			$companies_list = json_decode($user['companies_list']);
			if (isset($companies_list) && in_array($company['id'], $companies_list)) {
				$company_name = $company['name'];
				echo '<div id="' . $company_name . '" class="card"><center><div class="card-body">
				<h5 class="card-title">' . $company_name . '</h5>';
				echo '<img id="logo_img" class="img-thumbnail" src="' . $company['logo'] . '" height="100px">';
				echo '<p class="card-text"></p></div>';
				echo '<div class="card-footer">';
				echo  "<a href='/production/new_form/$company_name' class='btn btn-primary ml-2'>".lang('new_form')."</a>";
				if($company_name == 'בזק בינלאומי'){
					echo '<a class="btn btn-success" href="/production/create_script/'.$company['id'].'">'.lang('new_config').'</a>';
				}
				echo '</div></center></div>';
			}
		}
		?>
	</div>
	</div>
</main>