<!doctype html>
<?php
if (isset($this->session->userdata['logged_in'])) {
    header("location: /users/user_login_process");
}
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url('assets/favicon.ico'); ?>">
    <title>גרעין מערכות&copy; <?php echo date('Y'); ?> </title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<style>
    .rtl {
        direction: rtl;
    }

    .center {
        text-align: center;
    }

    .message {
        color: black;
    }

    .error_msg {
        color: #fd0000;
    }

    .message,
    .error_msg {
        font-size: larger;
        font-weight: bold;
    }

    #cover {
        background: #222 url('https://unsplash.it/1920/1080/?random') center center no-repeat;
        background-size: cover;
        height: 100%;
        text-align: center;
        display: flex;
        align-items: center;
        position: relative;
    }

    #cover-caption {
        width: 100%;
        position: relative;
        z-index: 1;
    }

    /* only used for background overlay not needed for centering */
    form:before {
        content: '';
        height: 100%;
        left: 0;
        position: absolute;
        top: 0;
        width: 100%;
        background-color: rgba(255, 255, 255, 0.5);
        z-index: -1;
        border-radius: 10px;
    }
</style>

<body>
    <section id="cover" class="min-vh-100">
        <div id="cover-caption">
            <div class="container">
                <div class="row text-white">
                    <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">
                        <?php
                        if (isset($response) && $response != "") {
                            echo '<div class="alert alert-success" role="alert">';
                            echo $response . ' </div>';
                        }

                        if (isset($logout_message)) {
                            echo "<div class='message'>";
                            echo $logout_message;
                            echo "</div>";
                        }

                        if (isset($message_display)) {
                            echo "<div class='message'>";
                            echo $message_display;
                            echo "</div>";
                        }

                        if (isset($error_message)) {
                            echo "<div class='error_msg'>$error_message" . validation_errors() . "</div>";
                        }
                        ?>
                        <img class="display-4 py-2 text-truncate" src="/assets/img/user.png" alt="" width="100" height="100">
                        <div class="px-2 rtl">
                            <?php echo form_open('users/user_login_process', 'class=justify-content-center'); ?>
                            <div class="form-group">
                                <label for="inputUser" class="sr-only">שם משתמש</label>
                                <input type="text" name="name" id="name" class="form-control center" placeholder="שם משתמש" required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword" class="sr-only">סיסמה</label>
                                <input type="password" name="password" id="password" class="form-control center" placeholder="סיסמה" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">להתחבר</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>