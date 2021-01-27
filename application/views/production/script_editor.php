<script src="<?php echo base_url('assets/js/jQUpload/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jQUpload/jquery.iframe-transport.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jQUpload/jquery.fileupload.js'); ?>"></script>
<style>
    input {
        direction: ltr
    }
</style>

<div id="form-messages" class='alert hidden test' role='alert'></div>
<main role="main">
    <div class="jumbotron">
        <div class="container">
            <center>
                <h5>יצירת קונפיגורציה - מנב"ס בזק בינלאומי</h5>
            </center>
        </div>
    </div>
    <div class="container">
        <center>
            <?php
            if (validation_errors()) {
                echo "<div class='alert alert-danger' role='alert'>" . validation_errors() . "</div>";
            }
            $hiden = isset($no_template) ? 'hidden' : '';
            $button = isset($no_template) ? 'העלה' : 'החלף';
            if ($this->session->userdata['logged_in']['role'] == "Admin") { ?>
                <div id="files_column" class="form-group row">
                    <div class="col-sm-12">
                        <input id="upload" style="display:none;" type="file" name="files" data-url="/production/upload_template/<?= $company_id ?>" />
                        <input id="attachments" type="hidden" class="form-control ltr" name="attachments" value="" />
                        <div id='files'>
                        </div>
                        <button class="btn btn-outline-success col-sm-2" type="button" onclick="document.getElementById('upload').click();">
                            <span id="upload_spinner" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span>
                            <?= $button ?></button>
                    </div>
                </div>
            <?php } else if (isset($no_template)) {
                echo 'קובץ לא קיים במערכת, נא להתקשר לאחראי';
            } ?>
            <?php echo form_open("production/download_conf/"); ?>
            <input type="hidden" name="company_id" value="<?= $company_id ?>">
            <center class="<?= $hiden ?>">

                <div class="form-row col-md-6">
                    <div id="client_num_column" class="form-group col-md-12">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"> סמל מוסד - מספר<span class="red">*</span></div>
                            </div>
                            <input type='text' class="form-control" name='client_num' required>
                        </div>
                    </div>
                </div>
                <div class="form-row col-md-6">
                    <div id="client_name_column" class="form-group col-md-12">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">שם מוסד - בית ספר<span class="red">*</span></div>
                            </div>
                            <input type='text' class="form-control" name='client_name' required pattern="[a-zA-Z0-9-\s]{2,}$" title="English only!">
                        </div>
                    </div>
                </div>
                <div class="form-row col-md-6">
                    <div id="phone_id_column" class="form-group col-md-12">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">קוד קו - סיב אופטי<span class="red">*</span></div>
                            </div>
                            <input type='text' class="form-control" name='phone_id' required placeholder="83-8300654">
                        </div>
                    </div>
                </div>
                <div class="form-row col-md-6">
                    <div id="wan_ip_column" class="form-group col-md-12">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">כתובת WAN IP בית ספר<span class="red">*</span></div>
                            </div>
                            <input type='text' class="form-control" name='wan_ip' required pattern="^([0-9]{1,3}\.){3}[0-9]{1,3}$" placeholder="xxx.xxx.xxx.xxx">
                        </div>
                    </div>
                </div>

                <div class="form-row col-md-6">
                    <div id="manbas_ip_column" class="form-group col-md-12">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">כתובת IP מנב"ס<span class="red">*</span></div>
                            </div>
                            <input type='text' class="form-control" name='manbas_ip' required pattern="^([0-9]{1,3}\.){2}[0-9]{1,3}$" placeholder="xxx.xxx.xxx">
                        </div>
                    </div>
                </div>
                <div class="form-row col-md-6">
                    <div id="pedagogy_ip_column" class="form-group col-md-12">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">כתובת IP פדגוגי<span class="red">*</span></div>
                            </div>
                            <input type='text' class="form-control" name='pedagogy_ip' required pattern="^([0-9]{1,3}\.){2}[0-9]{1,3}$" placeholder="xxx.xxx.xxx">
                        </div>
                    </div>
                </div>
                <div class="form-row col-md-6">
                    <div id="wi_fi_ip_column" class="form-group col-md-12">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">כתובת Wifi<span class="red">*</span></div>
                            </div>
                            <input type='text' class="form-control" name='wi_fi_ip' required pattern="^([0-9]{1,3}\.){2}[0-9]{1,3}$" placeholder="xxx.xxx.xxx">
                        </div>
                    </div>
                </div>

                <div class="form-row col-md-6">
                    <div id="clock_mac_column" class="form-group col-md-12">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Mac שעון נוכחות</div>
                            </div>
                            <input id='clock_mac' type='text' class="form-control" name='clock_mac' placeholder="11aa22bb33cc">
                        </div>
                    </div>
                </div>
                <input type='submit' class="btn btn-success my-5 ml-3" name='submit' value='להוריד'>
                <?php echo form_close(); ?>
            </center>
        </center>
    </div>
</main>