<div id="form-messages" class='alert hidden' role='alert'></div>
<main role="main">
    <div class="jumbotron">
        <div class="container">
            <center>
                <h5><?= lang('settings') ?></h5>
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
            $blocked_ip = '';
            if ($settings['blocked_ip'] != '') {
                $blocked_ip_array = json_decode($settings['blocked_ip']);
                foreach ($blocked_ip_array as $ip) {
                    $blocked_ip .= $ip;
                }
            }
        }
        ?>
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= lang('users') ?>
                <span class="badge badge-primary badge-pill"><?php echo $users_count ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= lang('companies') ?>
                <span class="badge badge-primary badge-pill"><?php echo $companies_count ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= lang('forms') ?>
                <span class="badge badge-primary badge-pill"><?php echo $forms_count ?></span>
            </li>
        </ul><br>
        <?php echo form_open('admin/save_settings', 'id=ajax-form', 'class=user-create'); ?>
        <div class="form-row">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><?= lang('language') ?></div>
                </div>
                <select class="form-control" name='language'>
                    <?php if (isset($languages)) {
                        echo "<option value=''>" . lang('default') . "</option>";
                        foreach ($languages as $lang) {
                            if ($settings['language'] == $lang) {
                                echo "<option selected>$lang</option>";
                            } else {
                                echo "<option>$lang</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <label><?= lang('send_req_emails_details') ?></label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><?= lang('send_req_emails') ?></div>
            </div>
            <input name="emails" class="form-control" style="direction: ltr;" value="<?php echo $settings['emails']; ?>">
        </div>
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
                <label class='col-sm-2 col-form-label'><?= lang('use_smtp') ?></label>
            </div>
        </div>
        <div class="form-row ltr">
            <div class="form-group col-md-4">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><?= lang('smtp_host') ?></div>
                    </div>
                    <input id='smtp_host' type='text' class="form-control" name='smtp_host' value="<?php echo $settings['smtp_host']; ?>" <?php echo $disabled ?>>
                </div>
            </div>
            <div class="form-group col-md-2">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><?= lang('smtp_port') ?></div>
                    </div>
                    <input id='smtp_port' type='number' class="form-control" name='smtp_port' value="<?php echo $settings['smtp_port']; ?>" <?php echo $disabled ?>>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><?= lang('username') ?></div>
                    </div>
                    <input id='smtp_user' type='text' class="form-control" name='smtp_user' value='<?php echo $settings['smtp_user']; ?>' <?php echo $disabled ?>>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><?= lang('password') ?></div>
                    </div>
                    <input id='smtp_pass' type='password' class="form-control" name='smtp_pass' value='' <?php echo $disabled ?>>
                </div>
            </div>
        </div>
        <hr>
        <label><?= lang('blocked_ip_details') ?></label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><?= lang('blocked_ip') ?></div>
            </div>
            <textarea name="blocked_ip" class="form-control" style="direction: ltr;" rows="4"><?= $blocked_ip ?></textarea>
        </div>
        <hr>
        <input type='submit' class='btn btn-info' name='submit' value='<?= lang('save') ?>'>
        <?php echo form_close(); ?><br />
        <button class="btn btn-info" onclick="createDB(0)"><?= lang('create_db') ?></button>
        <a class="btn btn-info" href="/admin/view_log"><?= lang('sys_log') ?></a>
        <a class="btn btn-info" href="/admin/view_folders"><?= lang('explorer') ?></a>
        <button class="btn btn-success m-3" onclick="backupDB()"><?= lang('backup_db') ?></button>
        <a id="last-db" class="m-5" style="display: none;" href=""><?= lang('download_db') ?></a>
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