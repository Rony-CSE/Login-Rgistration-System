<?php
    include 'classes/User.php';
    include 'inc/header.php';
    Session::checkLogin();
?>
<?php
    $user = new User();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
        $usrLogin = $user->userLogin($_POST);
    }
?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>User Login</h3>
        </div>
        <div class="panel-body">
            <div style="max-width: 500px;margin: 0 auto;">
                <?php
                    if (isset($usrLogin)){
                        echo $usrLogin;
                    }
                ?>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="text" id="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <button type="submit" name="login" class="btn btn-success">LOGIN</button>
                    <button type="reset" name="reset" class="btn btn-default">CLEAR</button>
                </form>
            </div>
        </div>
    </div>

<?php include 'inc/footer.php';?>
