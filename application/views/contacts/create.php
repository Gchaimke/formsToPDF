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
                        <h5>הוסף איש קשר</h5>
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

                  <?php echo form_open('contacts/create', 'class=client-create'); ?>
                  <div class="form-row">
				<div class="form-group col-md-4">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text">שם</div>
						</div>
						<input type='text' class="form-control" name='name' value="">

					</div>
				</div>
				<div class="form-group col-md-4">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text">מייל</div>
						</div>
						<input type='text' class="form-control" name='email' value="">

					</div>
				</div>
				<div class="form-group col-md-4">
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<div class="input-group-text">חברה</div>
						</div>
						<input type='text' class="form-control" name='company' value="">

					</div>
				</div>
			</div>
                  <input type='submit' class="btn btn-info btn-block" name='submit' value='הוסף'>
                  <?php echo form_close(); ?>
            </center>
      </div>
</main>