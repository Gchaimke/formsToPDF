<?php
if (isset($this->session->userdata['logged_in'])) {
    $id = ($this->session->userdata['logged_in']['id']);
    $username = ($this->session->userdata['logged_in']['name']);
    $role = ($this->session->userdata['logged_in']['role']);
    if ($role != "Admin") {
        header("location: /");
    }
}
?>
<main role="main">
    <div class="jumbotron">
        <div class="container">
            <center>
                <h5>משתמשים</h5>
            </center>
        </div>
    </div>
    <div class="container">
        <?php
        if (isset($message_display)) {
            echo "<div class='alert alert-success' role='alert'>";
            echo $message_display . '</div>';
        }
        ?>
        <a class="btn btn-success" href="/users/create"><i class="fa fa-user-plus"></i></a>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" class="mobile-hide">#</th>
                    <th scope="col">שם משתמש</th>
                    <th scope="col">שם יוצג</th>
                    <th scope="col">תפקיד</th>
                    <th scope="col">ערוך</th>
                    <th scope="col">מחק</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($users)) {
                    foreach ($users as $user) {
                        echo '<tr>';
                        echo '<tr id="' . $user['id'] . '">';
                        echo  '<td class="mobile-hide">' . $user['id'] . '</td>';
                        echo  '<td>' . $user['name'] . '</td>';
                        echo  '<td>' . $user['view_name'] . '</td>';
                        echo  '<td>' . $user['role'] . '</td>';
                        echo "<td><a href='/users/edit/" . $user['id'] . "' class='btn btn-info'><i class='fa fa-edit'></i></a></td>";
                        if ($user['name'] == $username) {
                            echo "<td><button id='" . $user['id'] . "' class='btn btn-danger' onclick='delPhoto(this.id)' disabled><i class='fa fa-trash'></i></button></td>";
                        } else {
                            echo "<td><button id='" . $user['id'] . "' class='btn btn-danger' onclick='delPhoto(this.id)'><i class='fa fa-trash'></i></button></td>";
                        }

                        echo '</tr>';
                    }
                } ?>
            </tbody>
        </table>
    </div>
</main>
<script>
    function delPhoto(id) {
        var r = confirm("Delete User with id: " + id + "?");
        if (r == true) {
            $.post("/users/delete", {
                id: id
            }).done(function(o) {
                console.log('user deleted from the server.');
                $('[id^=' + id + ']').remove();
            });
        }
    }
</script>