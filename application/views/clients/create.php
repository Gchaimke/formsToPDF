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
                        <h2 class="display-3">Add Company</h2>
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
                  <label>Company Name</label><input id='client_name' type='text' class="form-control" name='name' value="" onchange="updateClient(this.value)">
                  <label>Logo</label>
			<div class="input-group mb-3">
				<input id="logo_path" type='text' class="form-control" name='logo' value="">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('browse').click();">Upload</button>
				</div>
			</div>
			<img id="logo_img" class="img-thumbnail" src="" onclick="document.getElementById('browse').click();">
                  <input id="browse" style="display:none;" type="file" onchange="snapLogo()" >

                  <label>Document Header</label>
                  <textarea class="form-control" name='header' rows="5" cols="100">Company name in header</textarea>

                  <label>Form Filds</label>
                  <textarea class="form-control" name='filds' rows="5" cols="100">תאריך, שעת התחלה, שעת סיום, מספר לקוח, מספר פנייה\תקלה, סוג תקלה\התקנה, שם לקוח, מיקום, אחראי, איש קשר, תיאורתקלה\התקנה, תוצאות הבדיקה, סיכום, הערות, המלצות, שעת נסיעה הלוך, שעתנסיעה חזור</textarea>

                  <label>Document Footer</label>
                  <textarea class="form-control" name='footer' rows="5" cols="100">Company footer</textarea>

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