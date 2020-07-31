<script src="<?php echo base_url('assets/js/jQUpload/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jQUpload/jquery.iframe-transport.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jQUpload/jquery.fileupload.js'); ?>"></script>
<style>
    .file {
        position: relative;
        background: linear-gradient(to right, lightblue 50%, transparent 50%);
        background-size: 200% 100%;
        background-position: right bottom;
        transition: all 1s ease;
    }

    .file.done {
        background: lightgreen;
    }

    .file a {
        display: block;
        position: relative;
        padding: 5px;
        color: black;
    }
</style>
<div id="form-messages" class='alert hidden' role='alert'></div>
<main role="main">
    <div class="jumbotron">
        <div class="container">
            <center>
                <h5>Uploads </h5>
            </center>
        </div>
    </div>
    <div class="container">
        <center>
            <input id="fileupload" style="display:none;" type="file" name="files" data-url="/production/do_upload/0011111" />
            <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('fileupload').click();">Upload</button>
            <textarea rows="3" cols="100" id="attachments" type="text" class="ltr" name="attachments"></textarea>
            <div id='files'></div>

        </center>
    </div>
</main>

<script>
    $("#fileupload").fileupload({
        autoUpload: true,
        add: function(e, data) {
            data.context = $('<p class="file ltr">')
                .append($('<span>').text(data.files[0].name))
                .appendTo('#files');
            data.submit();
        },
        progress: function(e, data) {
            var progress = parseInt((data.loaded / data.total) * 100, 10);
            data.context.css("background-position-x", 100 - progress + "%");
        },
        done: function(e, data) {
            setTimeout(function() {
                data.context.addClass("done");
            }, 1000);
            $('#attachments').html($('#attachments').html()+","+data.result);
            console.log(data.result);
        }
    });
</script>