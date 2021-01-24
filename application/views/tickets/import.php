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
		<div class="container col-lg-12">
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

			echo '<table ><tbody>';
			$i = 0;
			if (isset($xlsx)) {
				$columns = array('מספר לקוח', 'שם לקוח', 'כתובת לקוח', '	משימה למחסן');
				echo "<tr>";
				foreach ($columns as $column) {
					echo "<th>$column</th>";
				}
				echo "</tr>";
				foreach ($xlsx->rows() as $elt) {
					if ($i != 0) {
						echo "<form class='tickets'><tr>";
						echo "<td><input type='hidden' name='client_num' value='{$elt[0]}'>{$elt[0]}</td>
								<td><input type='hidden' name='client_name' value='{$elt[1]}'>{$elt[1]}</td>
								<td><input type='hidden' name='address' value='{$elt[2]}'>{$elt[2]}</td>
								<td><input type='hidden' name='warehouse_num' value='{$elt[3]}'>{$elt[3]}</td>";
						echo "</tr></form>";
					}
					$i++;
				}
				echo "</tbody></table>";
			}
			?>
			<div class="form-group col-md-4 mt-3">
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
		$(".tickets").each(function() {
			var current_line = $(this).next();
			var data_array = $(this).serializeArray();
			$.ajax({
				type: 'POST',
				url: '/tickets/import/' + $("#company").val(),
				data: data_array
			}).success(function(response) {
				setTimeout(function() {
					delaySuccess(data);
				}, 3000);
			}).done(function(response) {
				if (response == 'success') {
					current_line.append('<td>הוסף</td>').addClass('alert-success');
				} else {
					current_line.append('<td>קיים</td>').addClass('alert-danger');
				}
				console.log(response);
			}).fail(function(response) {
				current_line.append('<td>' + response + '</td>').addClass('alert-danger');
				console.log(response);
			});
		});

	});
</script>