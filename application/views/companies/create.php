<main role="main">
      <div class="jumbotron">
            <div class="container">
                  <center>
                        <h5><?= lang('add_company') ?></h5>
                  </center>
            </div>
      </div>
      <div class="container">
            <center>
                  <?php
                  if (isset($message_display)) {
                        echo "<div class='alert alert-danger' role='alert'>";
                        echo $message_display . '</div>';
                  }
                  if (validation_errors()) {
                        echo "<div class='alert alert-danger' role='alert'>" . validation_errors() . "</div>";
                  }
                  ?>

                  <?php echo form_open('companies/create', 'class=client-create'); ?>
                  <label><?= lang('company_name') ?></label><input id='company_name' type='text' class="form-control" name='name' value="" onchange="updateClient(this.value)">
                  <label><?= lang('logo') ?></label>
			<div class="input-group mb-3">
				<input id="logo_path" type='text' class="form-control" name='logo' value="">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('browse').click();"><?= lang('upload') ?></button>
				</div>
			</div>
			<img id="logo_img" class="img-thumbnail" src="" onclick="document.getElementById('browse').click();">
                  <input id="browse" style="display:none;" type="file" onchange="snapLogo()" >

                  <label><?= lang('form_header') ?></label>
                  <textarea class="form-control" name='form_header' rows="5" cols="100"></textarea>

                  <label><?= lang('form_extra') ?></label>
                  <textarea class="form-control" name='form_extra_filds' rows="5" cols="100"></textarea>

                  <label><?= lang('form_footer') ?></label>
                  <textarea class="form-control" name='form_footer' rows="5" cols="100"></textarea>

                  <input type='submit' class="btn btn-info btn-block" name='submit' value='<?= lang('save') ?>'>
                  <?php echo form_close(); ?>
            </center>
      </div>
</main>
<script>
      var company = document.getElementById("company_name").value;
	function updateClient(value){
            company = value;
      }
</script>