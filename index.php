<?php
    include 'classes/User.php';
    include 'inc/header.php';
    Session::checkSession();
?>
<?php
    $loginmsg = Session::get("loginmsg");
    if (isset($loginmsg))
        echo $loginmsg;
    Session::set("loginmsg", NULL);
?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>User List <span class="pull-right">Welcome ! <strong>
                        <?php
                            $name = Session::get("username");
                            if (isset($name))
                                echo $name;
                        ?>
                    </strong></span></h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Contact no</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        $user = new User();
                        $userData = $user->getUserData();
                        if ($userData) {
                            $i=0;
                            foreach ($userData as $sdata) {
                                $i++;
                    ?>
                <tr>
                    <td><?php echo $i //$sdata['id']; ?></td>
                    <td><?php echo $sdata['name']; ?></td>
                    <td><?php echo $sdata['username']; ?></td>
                    <td><?php echo $sdata['email']; ?></td>
                    <td><?php echo $sdata['mobile']; ?></td>

                    <td><a class="btn btn-primary" href="profile.php?id=<?php echo $sdata['id']; ?>">VIEW</a></td>

                </tr>
            <?php } } else { ?>
                <tr>
                    <td colspan="5">No Data Found</td>
                </tr>
            <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'inc/footer.php'?>
