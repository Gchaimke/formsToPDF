<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h5><?= lang('tickets_table') ?></h5>
			</center>
		</div>
	</div>
	<center>
		<div class="container col-md-10">
			<?php
			if (isset($message_display)) {
				echo "<div  class='alert alert-success' role='alert'>";
				echo $message_display . '</div>';
			}
			?>
			<div class="form-group col-md-8 mb-3">
				<div class="row mb-4">
					<div class="input-group col-12 col-md-6">
						<div class="input-group-prepend">
							<div class="input-group-text"><?= lang('add_to_company') ?></div>
						</div>
						<select id="company" class='form-control' name='company'>
							<?php if (isset($companies)) {
								foreach ($companies as $company) {
									echo '<option value="' . htmlspecialchars($company['id']) . '">' . htmlspecialchars($company['name']) . '</option>';
								}
							}
							?>
						</select>
					</div>
					<div id='add_btn' class='btn btn-success mr-md-2 my-4 my-md-0 col-12 col-md-3'><?= lang('add_tickets') ?></div>
				</div>

				<?php
				if (isset($html_table)) {
					echo $html_table;
				} ?>
			</div>
		</div>
	</center>
</main>
<script>
	$("#add_btn").on('click', function() {
		$('#table_header').append('<th><?= lang('status') ?></th>');
		var post_array = [];
		$(".tickets_row").each(function() {
			var line_array = $(this).serializeArray();
			post_array.push(line_array);
		});
		post_items(post_array);
	});

	function post_items(post_array) {
		$.post('/tickets/import/' + $("#company").val(), {
			items_array: post_array
		}).done(function(response) {
			var ajax_data = JSON.parse(response);
			$("tr.column").each(function() {
				if ($(this).attr('data-id') != '' && ajax_data.inserted.includes($(this).attr('data-id'))) {
					$(this).append('<td><?= lang('added') ?></td>').addClass('alert-success');
				} else {
					$(this).append('<td><?= lang('updated') ?></td>').addClass('alert-warning');
				}
			});
		}).fail(function(response) {
			$(this).append('<td>ERROR</td>').addClass('alert-danger');
		});
	}

	$(document).ready(function() {
		var found = {};
		var count = 1;
		$('[data-id]').each(function() {
			var $this = $(this);
			if (found[$this.data('id')]) {
				let current = $this.data('id') + "_" + count;
				$this.attr('data-id', current);
				$this.find("[name=client_num]").val(current);
				$this.find('div').first().text(current);
				count++;
			} else {
				found[$this.data('id')] = true;
			}
		});
		//console.log(all_data_id);
	});
</script>