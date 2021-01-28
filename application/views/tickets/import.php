<?php
$filter_array = array("לא בוצע", "בוצע")
?><script src="<?php echo base_url('assets/js/jQUpload/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jQUpload/jquery.iframe-transport.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jQUpload/jquery.fileupload.js'); ?>"></script>
<main role="main">
	<div class="jumbotron">
		<div class="container">
			<center>
				<h5>Tikets</h5>
			</center>
		</div>
	</div>

	<center>
		<div class="container col-lg-6">
			<div id="files_column" class="form-group row">
				<div class="col-sm-12">
					<input id="upload" style="display:none;" type="file" name="files" data-url="/tickets/upload_xlsx/" />
					<input id="attachments" type="hidden" class="form-control ltr" name="attachments" value="" />
					<div id='files'>
					</div>
					<button class="btn btn-outline-success col-sm-2" type="button" onclick="document.getElementById('upload').click();">
						<span id="upload_spinner" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span>
						העלה</button>

				</div>
			</div>
			<?php
			if (isset($message_display)) {
				echo "<div  class='alert alert-success' role='alert'>";
				echo $message_display . '</div>';
			}

			echo '<div class="table-responsive"><table class="table"><thead class="thead-dark">';
			$i = 0;
			$count = 0;
			$row_nums = array();
			if (isset($xlsx)) {
				$columns = array('מספר לקוח', 'שם לקוח', 'כתובת לקוח', 'עיר', 'משימה למחסן');
				echo "<tr id='table_header'>";
				foreach ($columns as $column) {
					echo "<th>$column</th>";
				}
				echo "</tr></thead><tbody>";
				foreach ($xlsx->rows() as $row) {
					if ($i != 0 && count($row_nums) > 4) {

						if (1 === preg_match('~[0-9]~', $row[$row_nums['warehouse_num']])) {
							preg_match_all('!\d+!', $row[$row_nums['warehouse_num']], $matches);
							$row[$row_nums['warehouse_num']] = $matches[0][0];
						} else {
							continue;
						}

						echo "<form class='tickets'><tr id='$row[0]' class='column'>";
						echo "<td style='min-width:100px'>
								<input type='hidden' name='client_num' value='{$row[$row_nums['client_num']]}'>{$row[$row_nums['client_num']]}</td>
								<td style='min-width:120px'>
								<input type='hidden' name='client_name' value='{$row[$row_nums['client_name']]}'>{$row[$row_nums['client_name']]}</td>
								<td style='min-width:110px'>
								<input type='hidden' name='address' value='{$row[$row_nums['address']]}'>{$row[$row_nums['address']]}</td>
								<td style='min-width:100px'>
								<input type='hidden' name='city' value='{$row[$row_nums['city']]}'>{$row[$row_nums['city']]}</td>
								<td style='min-width:100px'>
								<input type='hidden' name='warehouse_num' value='{$row[$row_nums['warehouse_num']]}'>{$row[$row_nums['warehouse_num']]}</td>";
						echo "</tr></form>";
						$count++;
					} else {
						foreach ($row as $key => $column) {
							if ($column == "סמל מוסד") {
								$row_nums['client_num'] = $key;
							}
							if ($column == "שם מוסד") {
								$row_nums['client_name'] = $key;
							}
							if ($column == "כתובת גאוגרפית") {
								$row_nums['address'] = $key;
							}
							if ($column == "שם ישוב") {
								$row_nums['city'] = $key;
							}
							if ($column == "בבל") {
								$row_nums['warehouse_num'] = $key;
							}
						}
					}
					$i++;
				}
				$msg = $count > 0 ? '' : 'פומרט של קובץ לא נכון, נא לבדוק קמות של פריטים בשורה';
				echo "</tbody></table></div>" . $msg;
			}
			?>
			<div class="form-group col-md-8 mt-3">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text">הוסף לחברת</div>
					</div>
					<select id="company" class='form-control' name='company'>
						<?php if (isset($companies)) {
							foreach ($companies as $company) {
								echo '<option value="' . htmlspecialchars($company['id']) . '">' . htmlspecialchars($company['name']) . '</option>';
							}
						}
						?>
					</select>
					<div id='add_btn' class='btn btn-success mr-2'>הוסף משימות</div>
				</div>

			</div>
		</div>
	</center>
</main>
<script>
	$("#add_btn").on('click', function() {
		$('#table_header').append('<th>סטטוס</th>');
		var post_array = [];
		$(".tickets").each(function() {
			var line_array = $(this).serializeArray();
			post_array.push(line_array);
		});
		//console.log(post_array);
		post_items(post_array);

	});

	function post_items(post_array) {
		$.post('/tickets/import/' + $("#company").val(), {
			items_array: post_array
		}).done(function(response) {
			var ajax_data = JSON.parse(response);
			$("tr.column").each(function() {
				if ($(this).attr('id') != '' && ajax_data.inserted.includes($(this).attr('id'))) {
					$(this).append('<td>הוסף</td>').addClass('alert-success');
				} else {
					$(this).append('<td>עודכן</td>').addClass('alert-warning');
				}
			});
		}).fail(function(response) {
			$(this).append('<td>ERROR</td>').addClass('alert-danger');
		});
	}
</script>