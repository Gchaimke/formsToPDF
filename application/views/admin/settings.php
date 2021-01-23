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
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">תמיד לשלוח למיילים הבאים</div>
            </div>
            <input name="emails" class="form-control" style="direction: ltr;" value="<?php echo $settings['emails']; ?>">
        </div>
        <label>נא להשתמש בפסיק בין המאיילים (,)</label>
        <hr>
        <?php
        $checked = '';
        $disabled = '';
        if ($settings['smtp_on'] == 1) {
            $checked = 'checked';
        } else {
            $disabled = 'disabled';
        }
        ?>
        <div class="input-group mb-2">
            <div class='input-group-text'>
                <input type='checkbox' id='smtp_on' name='smtp_on' <?php echo $checked ?>>
                <label class='col-sm-2 col-form-label'>להשתמש ב-SMTP </label>
            </div>
        </div>
        <div class="form-row ltr">
            <div class="form-group col-md-4">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">SMTP HOST</div>
                    </div>
                    <input id='smtp_host' type='text' class="form-control" name='smtp_host' value="<?php echo $settings['smtp_host']; ?>" <?php echo $disabled ?>>
                </div>
            </div>
            <div class="form-group col-md-2">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Port</div>
                    </div>
                    <input id='smtp_port' type='number' class="form-control" name='smtp_port' value="<?php echo $settings['smtp_port']; ?>" <?php echo $disabled ?>>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Username</div>
                    </div>
                    <input id='smtp_user' type='text' class="form-control" name='smtp_user' value='<?php echo $settings['smtp_user']; ?>' <?php echo $disabled ?>>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Password</div>
                    </div>
                    <input id='smtp_pass' type='password' class="form-control" name='smtp_pass' value='' <?php echo $disabled ?>>
                </div>
            </div>
        </div>
        <input type='submit' class='btn btn-info' name='submit' value='שמור'>
        <?php echo form_close(); ?><br />
        <button class="btn btn-info" onclick="createDB(0)">לייצר בסיס נתונים</button>
        <a class="btn btn-info" href="/admin/view_log">דוחות מערכת</a>
        <a class="btn btn-info" href="/admin/view_folders">הצג תיקיות</a>
        <button class="btn btn-success m-3" onclick="backupDB()">Backup DB</button>
        <a id="last-db" class="m-5" style="display: none;" href="">Download last DB</a>
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

    $('#smtp_on').click(function(e) {
        if ($('#smtp_on').prop("checked") == true) {
            $('#smtp_host').prop("disabled", false);
            $('#smtp_port').prop("disabled", false);
            $('#smtp_user').prop("disabled", false);
            $('#smtp_pass').prop("disabled", false);
        } else {
            $('#smtp_host').prop("disabled", true);
            $('#smtp_port').prop("disabled", true);
            $('#smtp_user').prop("disabled", true);
            $('#smtp_pass').prop("disabled", true);
        }
    });

    function backupDB() {
        $.post("/admin/backupDB", {}).done(function(o) {
            // Make sure that the formMessages div has the 'success' class.
            $('#form-messages').addClass('alert-success');
            // Set the message text.
            $('#form-messages').html(o).fadeIn(1000).delay(3000).fadeOut(1000);
            $('#last-db').attr("href", "/" + o);
            $('#last-db').toggle();
        });
    }
</script>