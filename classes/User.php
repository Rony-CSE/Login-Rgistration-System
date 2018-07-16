<?php
include_once 'Session.php';
include 'Database.php';

class User{

    private $db;

    public function __construct()
    {
        // This function is used to establish database connection
        $this->db = new Database();
    }


    public function userRegistration($data){
        // This function is used to register a user
        $name      = $data['name'];
        $username  = $data['username'];
        $email     = $data['email'];
        $password  = $data['password'];
        $mobile    = $data['mobile'];

        $chk_email = $this->emailCheck($email);

        if ($name == "" OR $username == "" OR $email == "" OR $password == ""){
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> Field must not be empty.</div>";
            return $msg;
        }

        if (strlen($username) < 3){
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> Username is too short.</div>";
            return $msg;
        }elseif (preg_match('/[^a-z0-9_-]+/i', $username)){
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> Username can contain alphanumerical, dashes and underscores.</div>";
            return $msg;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> Email is not valid.</div>";
            return $msg;
        }

        if ($chk_email == true){
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> The email is already exists.</div>";
            return $msg;
        }


        // Data insert portion
        $sql = "INSERT INTO tbl_users (name, username, email, password, mobile) VALUES (:name, :username, :email, :password, :mobile)";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':name', $name);
        $query->bindValue(':username', $username);
        $query->bindValue(':email', $email);
        $query->bindValue(':password', md5($password));
        $query->bindValue(':mobile', $mobile);
        $result = $query->execute();
        if ($result){
            $msg = "<div class='alert alert-success'><strong>Success!</strong> you have successfully registered.</div>";
            return $msg;
        }else{
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> There are some problem inserting data.</div>";
            return $msg;
        }

    }


    private function emailCheck($email){
        // Only for this class
        // This function check if the email is already in the database or not
        $sql = "SELECT email FROM tbl_users WHERE email = :email";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':email', $email);
        $query->execute();
        if ($query->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }


    private function getLoginUser($email, $password){
        // This function is used to retreive registered user from 'tbl_users' table
        // Only for this class
        $sql = "SELECT * FROM tbl_users WHERE email=:email AND password=:password LIMIT 1";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':email', $email);
        $query->bindValue(':password', $password);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }


    public function userLogin($data){
        // This function is used to get data from login.php page
        // and initialize session for the user
        $email = $data['email'];
        $password = md5($data['password']);
        $chk_email = $this->emailCheck($email);
        if ($email == "" OR $password == ""){
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> Fields must not be Empty.</div>";
            return $msg;
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> Email is not valid.</div>";
            return $msg;
        }

        if ($chk_email == false){
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> The email is NOT exists.</div>";
            return $msg;
        }

        $result = $this->getLoginUser($email, $password);
        if ($result){
            Session::init();
            Session::set("login", true);
            Session::set("id", $result->id);
            Session::set("name", $result->name);
            Session::set("username", $result->username);
            Session::set("loginmsg", "<div class='alert alert-success'><strong>Success!</strong> You Are LoggedIn.</div>");
            header("Location: index.php");
        }else{
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> Data not Found.</div>";
            return $msg;
        }
    }


    public function getUserData(){
        // This function is used to display all data from 'tbl_users' table
        $sql = "SELECT * FROM tbl_users ORDER BY id DESC";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $r = $query->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }


    public function getUserById($userid){
        // This function is used to retreive single user by its id
        $sql = "SELECT * FROM tbl_users WHERE id=:id LIMIT 1";
        $query= $this->db->pdo->prepare($sql);
        $query->bindValue(':id', $userid);
        $query->execute();
        $r = $query->fetch(PDO::FETCH_OBJ);
        return $r;
    }


    public function updateUserData($id, $data){
        // This function is used to update user's profile/info
        $name     = $data['name'];
        $username = $data['username'];
        $email    = $data['email'];
        $mobile   = $data['mobile'];

        if ($name == "" OR $username == "" OR $email == "" OR $mobile == "") {
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> Field must not be empty.</div>";
            return $msg;
        }

        if (strlen($username) < 3){
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> Username is too short.</div>";
            return $msg;
        }elseif (preg_match('/[^a-z0-9_-]+/i', $username)){
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> Username can contain alphanumerical, dashes and underscores.</div>";
            return $msg;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> Email is not valid.</div>";
            return $msg;
        }


        // Data Update portion
        $sql = "UPDATE tbl_users SET
            name     = :name,
            username = :username,
            email    = :email,
            mobile   = :mobile
        WHERE id = :id";

        $query = $this->db->pdo->prepare($sql);

        $query->bindValue(':name', $name);
        $query->bindValue(':username', $username);
        $query->bindValue(':email', $email);
        $query->bindValue(':mobile', $mobile);
        $query->bindValue(':id', $id);
        $result = $query->execute();
        if ($result){
            $msg = "<div class='alert alert-success'><strong>Success!</strong> you have Successfully Updated.</div>";
            return $msg;
        }else{
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> There are some problem Updating data.</div>";
            return $msg;
        }
    }


    private function checkPassword($id, $old_pass){
        $password = md5($old_pass);
        $sql = "SELECT password FROM tbl_users WHERE id=:id AND password=:password";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id', $id);
        $query->bindValue(':password', $password);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        }else{
            return false;
        }
    }


    public function updatePassword($id, $data){
        // This function is used for changing password
        $old_pass = $data['old_pass'];
        $new_pass = $data['new_pass'];
        $chk_pass = $this->checkPassword($id, $old_pass);

        if ($old_pass == "" OR $new_pass == "") {
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> Fields Must Not be Empty.</div>";
            return $msg;
        }

        if ($chk_pass == false) {
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> Password is NOT Exist.</div>";
            return $msg;
        }

        if (strlen($new_pass) < 6) {
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> Password is Too Short.</div>";
            return $msg;
        }

        $password = md5($new_pass);
        $sql = "UPDATE tbl_users SET password=:password WHERE id=:id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':password', $password);
        $query->bindValue(':id', $id);
        $r = $query->execute();
        if ($r) {
            $msg = "<div class='alert alert-success'><strong>Success!</strong> Password is Updated Successfully.</div>";
            return $msg;
        }else{
            $msg = "<div class='alert alert-danger'><strong>ERROR!</strong> Password is Can NOT Updated.</div>";
            return $msg;
        }
    }
}
?>
