<?php
    include 'classes/User.php';
    include 'inc/header.php';
    Session::checkSession();
?>

<?php
    if(isset($_GET['id'])){
        $userid = (int)$_GET['id'];
        $sessId = Session::get("id");
        if ($userid != $sessId) {
            header("Location: index.php");
        }
    }
    $user = new User();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updatepass'])){
        $updatePass = $user->updatePassword($userid, $_POST);
    }
?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>Change Password <span class="pull-right"><a class="btn btn-primary" href="profile.php?id=<?php echo $userid; ?>">BACK</a></span></h3>
        </div>
        <div class="panel-body">
            <div style="max-width: 500px; margin: 0 auto;">
<?php
if (isset($updatePass)) {
    echo $updatePass;
}
?>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="old_pass">Old Password</label>
                        <input type="password" id="old_pass" name="old_pass" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="new_pass">New Password</label>
                        <input type="password" id="new_pass" name="new_pass" class="form-control">
                    </div>

                    <button type="submit" name="updatepass" class="btn btn-success">UPDATE</button>

                </form>
            </div>
        </div>
    </div>

<?php include 'inc/footer.php'; ?>
