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
					<input id="xlsxupload" style="display:none;" type="file" name="files" data-url="/production/upload_xlsx/" />
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
				echo "<div class='alert alert-success' role='alert'>";
				echo $message_display . '</div>';
			}

			echo '<table><tbody>';
			$i = 0;
			if (isset($xlsx)) {
				foreach ($xlsx->rows() as $elt) {
					if ($i == 0) {
						echo "<tr>";
						for ($j = 0; $j < 8; $j++) {
							echo "<th>" . $elt[$j] . "</th>";
						}
						echo "</tr>";
					} else {
						echo "<tr>";
						for ($j = 0; $j < 8; $j++) {
							echo "<td>" . $elt[$j] . "</td>";
						}
						echo "</tr>";
					}
					$i++;
				}

				echo "</tbody></table>";
			}
			?>
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
					setTimeout(function() {
						console.log(data);
						console.log(e);
						data.context = $('<p class="file ltr">').append($('<a target="blank" href="/production/parse_uploaded_xlsx/' + data.result + '">').text('Parse file')).appendTo('#files');
						data.context.addClass("done");
						$("#upload_spinner").css("display", "none");
					}, 2000);
					if ($('#attachments').val() == '') {
						$('#attachments').val(ndata.result);
					} else {
						$('#attachments').val($('#attachments').val() + "," + data.result);

					}
				}
				$('#save_btn').click();
			}
		});
	}
</script>