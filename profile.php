<?php
    include 'classes/User.php';
    include 'inc/header.php';
    Session::checkSession();
?>

<?php
    if(isset($_GET['id'])){
        $userid = (int)$_GET['id'];
    }
    $user = new User();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){
        $usrUpdate = $user->updateUserData($userid, $_POST);
    }
    $userdata = $user->getUserById($userid);
?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>User Profile <span class="pull-right"><a class="btn btn-primary" href="index.php">BACK</a></span></h3>
        </div>
        <div class="panel-body">
            <div style="max-width: 500px;margin: 0 auto;">
<?php
if (isset($usrUpdate)) {
    echo $usrUpdate;
}
?>
<?php if($userdata){ ?>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo $userdata->name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?php echo $userdata->username; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="text" id="email" name="email" class="form-control" value="<?php echo $userdata->email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Contact no</label>
                        <input type="text" name="mobile" id="mobile" class="form-control" value="<?php echo $userdata->mobile; ?>">
                    </div>
                    <?php
                        $sessId = Session::get("id");
                        if($sessId == $userid){
                    ?>
                    <button type="submit" name="update" class="btn btn-success">UPDATE</button>
                    <a class="btn btn-info" href="changepassword.php?id=<?php echo $userid; ?>">Change Password</a>
                    <?php } ?>
                </form>
<?php } ?>
            </div>
        </div>
    </div>

<?php include 'inc/footer.php'; ?>
