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
                <h5>Script editor</h5>
            </center>
        </div>
    </div>
    <div class="container">
        <center>
            <?php
            if (validation_errors()) {
                echo "<div class='alert alert-danger' role='alert'>" . validation_errors() . "</div>";
            }
            ?>
            <?php echo form_open("production/download_conf"); ?>
            <div class="form-row col-md-6">
                <div id="client_num_column" class="form-group col-md-12">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">מספר לקוח <span class="red">*</span></div>
                        </div>
                        <input type='text' class="form-control" name='client_num' required>
                    </div>
                </div>
            </div>
            <div class="form-row col-md-6">
            <div id="client_name_column" class="form-group col-md-12">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">שם לקוח <span class="red">*</span></div>
                        </div>
                        <input type='text' class="form-control" name='client_name' required pattern="[a-zA-Z0-9-\s]{2,}$" title="English only!">
                    </div>
                </div>
            </div>
            <div class="form-row col-md-6">
                <div id="phone_id_column" class="form-group col-md-12">
                    <div class="input-group mb-2 ltr">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Phone ID <span class="red">*</span></div>
                        </div>
                        <input type='text' class="form-control" name='phone_id' required placeholder="83-8300654">
                    </div>
                </div>
            </div>
            <div class="form-row col-md-6">
                <div id="wan_ip_column" class="form-group col-md-12">
                    <div class="input-group mb-2 ltr">
                        <div class="input-group-prepend">
                            <div class="input-group-text">WAN IP <span class="red">*</span></div>
                        </div>
                        <input type='text' class="form-control" name='wan_ip' required pattern="^([0-9]{1,3}\.){3}[0-9]{1,3}$" placeholder="xxx.xxx.xxx.xxx">
                    </div>
                </div>
            </div>

            <div class="form-row col-md-6">
                <div id="manbas_ip_column" class="form-group col-md-12">
                    <div class="input-group mb-2 ltr">
                        <div class="input-group-prepend">
                            <div class="input-group-text">MANBAS IP START <span class="red">*</span></div>
                        </div>
                        <input type='text' class="form-control" name='manbas_ip' required pattern="^([0-9]{1,3}\.){2}[0-9]{1,3}$" placeholder="xxx.xxx.xxx">
                    </div>
                </div>
            </div>
            <div class="form-row col-md-6">
                <div id="pedagogy_ip_column" class="form-group col-md-12">
                    <div class="input-group mb-2 ltr">
                        <div class="input-group-prepend">
                            <div class="input-group-text">PEDAGOGY IP START <span class="red">*</span></div>
                        </div>
                        <input type='text' class="form-control" name='pedagogy_ip' required pattern="^([0-9]{1,3}\.){2}[0-9]{1,3}$" placeholder="xxx.xxx.xxx">
                    </div>
                </div>
            </div>
            <div class="form-row col-md-6">
                <div id="wi_fi_ip_column" class="form-group col-md-12">
                    <div class="input-group mb-2 ltr">
                        <div class="input-group-prepend">
                            <div class="input-group-text">WIFI IP START <span class="red">*</span></div>
                        </div>
                        <input type='text' class="form-control" name='wi_fi_ip' required pattern="^([0-9]{1,3}\.){2}[0-9]{1,3}$" placeholder="xxx.xxx.xxx">
                    </div>
                </div>
            </div>

            <div class="form-row col-md-6">
                <div id="clock_mac_column" class="form-group col-md-12">
                    <div class="input-group mb-2 ltr">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Clock MAC</div>
                        </div>
                        <input id='clock_mac' type='text' class="form-control" name='clock_mac' placeholder="11aa22bb33cc">
                    </div>
                </div>
            </div>
            <input type='submit' class="btn btn-success my-5 ml-3" name='submit' value='להוריד'>
            <?php echo form_close(); ?>
        </center>
    </div>
</main>