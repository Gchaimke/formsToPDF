<?php
if (isset($id)) {
    $id = $id;
} else {
    $id = 0;
}

?>

<main role="main">
    <div class="jumbotron">
        <center>
            <div id="form-messages" class='alert hidden' role='alert'></div>
        </center>
    </div>
</main>

<script>
    window.onload = function(e) {
        SendEmail();
    }

    function SendEmail() {
        // Make sure that the formMessages div has the 'success' class.
        $('#form-messages').addClass('alert-info');
        // Set the message text.
        $('#form-messages').html("Please Wait, sending Email ...").fadeIn(1000);
        $.post("/exportpdf/create/<?php echo $id ?>", {
            email: true
        }).done(function(o) {
            // Make sure that the formMessages div has the 'success' class.
            $('#form-messages').removeClass('alert-info').addClass('alert-success');
            // Set the message text.
            $('#form-messages').html(o).fadeIn(1000).delay(3000).fadeOut(1000);
            setTimeout(function() {
                window.location.href = "/"; 
            }, 2000); //will call the function after 2 secs.
        }).fail(function(o) {
            $('#form-messages').removeClass('alert-info').addClass('alert-danger');
            // Set the message text.
            $('#form-messages').html(o).fadeIn(1000);
        });
    }
</script>