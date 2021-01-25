<script src="<?php echo base_url('assets/js/jQUpload/jquery.ui.widget.js'); ?>"></script>
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
					<input id="xlsxupload" style="display:none;" type="file" name="files" data-url="/tickets/upload_xlsx/" />
					<input id="attachments" type="hidden" class="form-control ltr" name="attachments" value="" />
					<div id='files'>
					</div>
					<button class="btn btn-outline-success col-sm-2" type="button" onclick="document.getElementById('xlsxupload').click();">
						<span id="upload_spinner" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span>
						העלה</button>

				</div>
			</div>
			<?php
			if (isset($message_display)) {
				echo "<div  class='alert alert-success' role='alert'>";
				echo $message_display . '</div>';
			}

			echo '<table class="table"><thead class="thead-dark">';
			$i = 0;
			if (isset($xlsx)) {
				$columns = array('מספר לקוח', 'שם לקוח', 'כתובת לקוח','עיר', 'משימה למחסן');
				echo "<tr id='table_header'>";
				foreach ($columns as $column) {
					echo "<th>$column</th>";
				}
				echo "</tr></thead><tbody>";
				foreach ($xlsx->rows() as $elt) {
					if ($i != 0) {
						echo "<form class='tickets'><tr id='$elt[0]' class='column'>";
						echo "<td><input type='hidden' name='client_num' value='{$elt[0]}'>{$elt[0]}</td>
								<td><input type='hidden' name='client_name' value='{$elt[1]}'>{$elt[1]}</td>
								<td><input type='hidden' name='address' value='{$elt[2]}'>{$elt[2]}</td>
								<td><input type='hidden' name='city' value='{$elt[3]}'>{$elt[3]}</td>
								<td><input type='hidden' name='warehouse_num' value='{$elt[4]}'>{$elt[4]}</td>";
						echo "</tr></form>";
					}
					$i++;
				}
				echo "</tbody></table>";
			}
			?>
			<div class="form-group col-md-6 mt-3">
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
	if ($("#xlsxupload").length) {
		$("#xlsxupload").fileupload({
			autoUpload: true,
			add: function(e, data) {
				data.submit();
			},
			progress: function(e, data) {
				$("#upload_spinner").css("display", "inherit");
			},
			done: function(e, data) {
				if (data.result.includes("error")) {
					if (data.result.includes("larger")) {
						alert("אין אפשרות להעלות קובץ גדול מ-2מגה!");
					} else if (data.result.includes("filetype")) {
						alert("אין אפשרות להעלות קובץ מסוג הזה!");
					} else {
						alert(data.result.replace(/<\/?[^>]+(>|$)/g, ""));
					}
					data.context.addClass("error");
				} else {
					location.reload();
				}
				$('#save_btn').click();
			}
		});
	}

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
				if ($(this).attr('id') != '' && ajax_data.success.includes($(this).attr('id'))) {
					$(this).append('<td>הוסף</td>').addClass('alert-success');
				} else {
					$(this).append('<td>קיים</td>').addClass('alert-danger');
				}
			});
		}).fail(function(response) {
			$(this).append('<td>ERROR</td>').addClass('alert-danger');
		});
	}
</script>