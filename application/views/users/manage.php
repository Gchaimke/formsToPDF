<?php
if (isset($this->session->userdata['logged_in']) && ($this->session->userdata['logged_in']['id']) != '') {
    $id = ($this->session->userdata['logged_in']['id']);
    $username = ($this->session->userdata['logged_in']['name']);
    $role = ($this->session->userdata['logged_in']['role']);
}
?>
<main role="main">
    <div class="jumbotron">
        <div class="container">
            <center>
                <h5><?= lang('users') ?></h5>
            </center>
        </div>
    </div>
    <div class="container">
        <?php
        if (isset($message_display) && $message_display != '') {
            echo "<div class='alert alert-success' role='alert'>";
            echo $message_display . '</div>';
        }
        ?>
        <a class="btn btn-success" href="/users/create"><i class="fa fa-user-plus"></i></a>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="mobile-hide">#</th>
                        <th scope="col" style="min-width: 150px;"><?= lang('username') ?></th>
                        <th scope="col" style="min-width: 110px;"><?= lang('view_name') ?></th>
                        <th scope="col"><?= lang('role') ?></th>
                        <th scope="col"><?= lang('edit') ?></th>
                        <?php if ($role == "Admin") { ?>
                            <th scope="col"><?= lang('delete') ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($users)) {
                        foreach ($users as $user) {
                            if ($role != "Admin" && ($user['role'] == "Admin" || $user['role'] == "Manager")) {
                                continue;
                            }
                            echo '<tr>';
                            echo '<tr id="' . $user['id'] . '">';
                            echo  '<td class="mobile-hide">' . $user['id'] . '</td>';
                            echo  '<td>' . $user['name'] . '</td>';
                            echo  '<td>' . $user['view_name'] . '</td>';
                            echo  '<td>' . $user['role'] . '</td>';
                            echo "<td><a href='/users/edit/" . $user['id'] . "' class='btn btn-info'><i class='fa fa-edit'></i></a></td>";
                            if ($role == "Admin") {
                                echo "<td><button id='" . $user['id'] . "' class='btn btn-danger' onclick='delete_user(this.id)'><i class='fa fa-trash'></i></button></td>";
                            }
                            echo '</tr>';
                        }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<script>
    function delete_user(id) {
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