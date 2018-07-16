<?php
    include 'classes/User.php';
    include 'inc/header.php';
?>
<?php
    $user = new User();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
        $usrReg = $user->userRegistration($_POST);
    }
?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>User Registration</h3>
        </div>
        <div class="panel-body">
            <div style="max-width: 500px;margin: 0 auto;">
                <?php
                    if (isset($usrReg)){
                        echo $usrReg;
                    }
                ?>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="text" id="email" name="email" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile</label>
                        <input type="text" name="mobile" id="mobile" class="form-control" >
                    </div>
                    <button type="submit" name="register" class="btn btn-success">REGISTER</button>
                    <button type="reset" name="reset" class="btn btn-default">CLEAR</button>
                </form>
            </div>
        </div>
    </div>

<?php include 'inc/footer.php';?>
