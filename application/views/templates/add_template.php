<?php
if (isset($this->session->userdata['logged_in'])) {
      if ($this->session->userdata['logged_in']['role'] != "Admin") {
            header("location: /");
      }
}

if (isset($clients)) {
      echo '<script>var clients = {};' . PHP_EOL;
      foreach ($clients as $client) {
            echo 'clients["' . $client['name'] . '"]="' . $client['projects'] . '";' . PHP_EOL;
      }
      echo '</script>';
}
?>
<main role="main">
      <div class="jumbotron">
            <div class="container">
                  <center>
                        <h2 class="display-3">Add Template</h2>
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

                  <?php echo form_open('templates/add_template', 'class=user-create'); ?>
                  <div class="form-group"><label>Select Client</label>
                  <select id="select_client" class="form-control" name='client'>
                        <?php if (isset($clients)) {
                              foreach ($clients as $client) {
                                    echo '<option>' . $client['name'] . '</option>';
                              }
                        }
                        ?>
                  </select></div></br>
                  <div class="form-group"><label>Select Project</label>
                  <select id="select_project" class="form-control" name='project'>
                  </select></div></br>
                  <div class="form-group"><label>Serial template</label><br>
				<label>yy = Year | mm = Month | x,xx,xxx,xxxx = Serialized number | pattern = AVxxx-mm-yy</label>
                  <input type="text" name="template" value="AVxxx-mm-yy" class="form-control">
                  </div>
                  <div class="form-group"><label>Checklist Data</label><br>
                  <label>Last column is function mark, columns separated by ';'. Functions: HD = Table Header | QC = QC Select | V = Regular Checkbox | N = Name Selection | </label>
                  <textarea class="form-control" name='data' rows="10" cols="100">Assembly;Verify;HD&#13;&#10;checkbox 1;V&#13;&#10;checkbox 2;V&#13;&#10;Qc select;QC
                  </textarea></br></div>
                  <div class="form-group"><label>Scan Data</label><br>
                  <label>Last column is function mark, columns separated by ';'. Functions: HD = Table Header  </label>
                  <textarea class="form-control" name='scans' rows="10" cols="100">PN;SN;HD&#13;&#10;Serail 1&#13;&#10;Serial 2</textarea></br></div>
                  <input type='submit' class="btn btn-info btn-block" name='submit' value='Submit'>
                  <?php echo form_close(); ?>
            </center>
      </div>
</main>