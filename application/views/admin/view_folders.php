<div id="form-messages" class='alert hidden' role='alert'></div>
<main role="main">
    <div class="jumbotron">
        <div class="container">
            <center>
                <h5>File Manager</h5>
            </center>
            <button class="btn btn-info" onclick="RemoveEmptySubFolders()">Remove empty folders from uploads</button>
        </div>
    </div>
    
    
    <div class="container">
        <?php
        if (isset($message_display)) {
            echo "<div class='alert alert-success' role='alert'>";
            echo $message_display . '</div>';
        }
        if (isset($folders)) {
            echo $folders;
        }       
        ?>
    </div>
    
</main>
<script>
    function RemoveEmptySubFolders(){
        $.post("/admin/RemoveEmptySubFolders", {
        }).done(function(o) {
            // Make sure that the formMessages div has the 'success' class.
            $('#form-messages').addClass('alert-success');
            // Set the message text.
            $('#form-messages').html(o).fadeIn(1000).delay(3000).fadeOut(1000);
        });
    }
</script>