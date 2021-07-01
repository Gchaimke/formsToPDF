<script src="<?php echo base_url('assets/js/jQUpload/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jQUpload/jquery.iframe-transport.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jQUpload/jquery.fileupload.js'); ?>"></script>
<main role="main">
    <div class="jumbotron">
        <div class="container">
            <center>
                <h5><?= lang('tickets') ?></h5>
            </center>
        </div>
    </div>
    <center>
        <div class="container col-md-10">
            <?php
            if (isset($message_display)) {
                echo "<div  class='alert alert-success' role='alert'>";
                echo $message_display . '</div>';
            }
            ?>
            <div id="files_column" class="form-group row">
                <div class="col-sm-12">
                    <input id="upload" style="display:none;" type="file" name="files" data-url="/tickets/upload_xlsx/" />
                    <input id="attachments" type="hidden" class="form-control ltr" name="attachments" value="" />
                    <div id='files'>
                    </div>
                    <button class="btn btn-outline-success col-sm-2" type="button" onclick="document.getElementById('upload').click();">
                        <span id="upload_spinner" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span>
                        <?= lang('upload') ?></button></br>
                    <?php
                    if(isset($xlsx_columns)){
                        echo "Found rows<br>". implode(",",$xlsx_columns);
                    }else{
                        echo "file not found";
                    }
                    ?>
                </div>
            </div>
            <div class="form-group col-md-8 mb-3">
                <?php
                if (isset($fields)) {
                    echo form_open('tickets/view_table');
                    foreach ($fields as $key => $value) {
                        echo "<div class='input-group mb-2'>
                        <div class='input-group-prepend'>
                        <div class='input-group-text'>$value</div>
                        </div><select name='$key' class='rows_selector form-control'>";
                        echo "<option value='0'>".lang('select_column') ."</option>";
                        foreach ($xlsx_columns as $key => $column) {
                            echo "<option value='$key'>$column</option>";
                        }
                        echo "</select></div>";
                    }
                    echo "<input type='submit' class='btn btn-success mr-2' value='".lang('show_table') ."'>";
                    echo form_close();
                } ?>
            </div>
        </div>
    </center>
</main>
<script>
    $("#view_table").on('click', function() {
        $('.hidden').show();
        var post_array = [];
        $(".rows_selector").each(function() {
            post_array.push($(this).val());
        });
        post_items(post_array);
    });
</script>