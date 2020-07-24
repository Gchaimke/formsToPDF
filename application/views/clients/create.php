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
                        <h2 class="display-3">Add Client</h2>
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

                  <?php echo form_open('clients/create', 'class=client-create'); ?>
                  <label>Client Name</label><input id='client_name' type='text' class="form-control" name='name' value="" onchange="updateClient(this.value)"><hr>
                  <label>Logo</label>
			<div class="input-group mb-3">
				<input id="logo_path" type='text' class="form-control" name='logo' value="">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('browse').click();">Upload</button>
				</div>
			</div>
			<img id="logo_img" class="img-thumbnail" src="" onclick="document.getElementById('browse').click();">
                  <input id="browse" style="display:none;" type="file" onchange="snapLogo()" ><hr>
                  
                  <label>Client Projects</label>
                  <textarea class="form-control" name='projects' rows="10" cols="100">Project 1, Project 2, Project 3</textarea><hr>
                  <input type='submit' class="btn btn-info btn-block" name='submit' value='Submit'>
                  <?php echo form_close(); ?>
            </center>
      </div>
</main>
<script>
	var client = document.getElementById("client_name").value;
	function updateClient(value){
            client = value;
      }
	var ext = '';
</script>