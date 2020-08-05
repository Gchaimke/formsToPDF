<?php
if (isset($this->session->userdata['logged_in'])) {
    if ($this->session->userdata['logged_in']['role'] != "Admin") {
        header("location: /");
    }
}
?>
<div id="form-messages" class='alert hidden' role='alert'></div>
<main role="main">
    <div class="jumbotron">
        <div class="container">
            <center>
                <h5>הגדרות</h5>
            </center>
        </div>
    </div>
    <div class="container">
        <?php
        $users_count = 0;
        $companies_count = 0;
        $forms_count = 0;
        if (isset($users) and isset($companies) and isset($forms) and isset($settings)) {
            $users_count = $users;
            $companies_count = $companies;
            $forms_count = $forms;
        }
        ?>
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                משתמשים
                <span class="badge badge-primary badge-pill"><?php echo $users_count ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                חברות
                <span class="badge badge-primary badge-pill"><?php echo $companies_count ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                דוחות
                <span class="badge badge-primary badge-pill"><?php echo $forms_count ?></span>
            </li>
        </ul><br>
        <?php echo form_open('admin/save_settings', 'id=ajax-form', 'class=user-create'); ?>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">תפקידים</div>
            </div>
            <input name="roles" class="form-control" value="<?php echo $settings['roles']; ?>">
        </div>

        <?php 
        $smtp_arr=explode(',',$settings['roles']);
        ?>
        <div class="input-group mb-2">
            <div class='input-group-text'>
                <input type='checkbox' value=''>
                <label class='col-sm-2 col-form-label'>להשתמש ב-SMTP </label>
            </div>
        </div>
        <div class="form-row ltr">
            <div class="form-group col-md-4">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">SMTP HOST</div>
                    </div>
                    <input type='text' class="form-control" name='smpt_host' value="ssl://smtp.gmail.com">
                </div>
            </div>
            <div class="form-group col-md-2">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Port</div>
                    </div>
                    <input type='number' class="form-control" name='smpt_port' value="465">
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Username</div>
                    </div>
                    <input type='text' class="form-control" name='smpt_user' >
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Password</div>
                    </div>
                    <input type='text' class="form-control" name='smpt_pass'>
                </div>
            </div>
        </div>
        <input type='submit' class='btn btn-info' name='submit' value='שמור'>
        <?php echo form_close(); ?><br />
        <button class="btn btn-info" onclick="createDB(0)">לייצר בסיס נתונים</button>
        <a class="btn btn-info" href="/admin/view_log">דוחות מערכת</a>
    </div>
</main>

<script>
    function createDB() {
        $.post("/admin/create", {}).done(function(o) {
            // Make sure that the formMessages div has the 'success' class.
            $('#form-messages').addClass('alert-success');
            // Set the message text.
            $('#form-messages').html(o).fadeIn(1000).delay(3000).fadeOut(1000);
        });
    }
</script>