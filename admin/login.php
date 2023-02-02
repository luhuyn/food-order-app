<?php include('../config/constant.php'); ?>
<html>

<head>
    <title>Login - Feasty</title>
    <link rel="stylesheet" href="../assets/admin.css">
</head>
<style>
    body {
        background-image: url(../assets/images/bg_login.jpeg);
        background-repeat: no-repeat;
        background-size: 1500px;
    }
</style>

<body>
    <div class="login text-center">
        <h2 class="text-center">Login</h2>
        <br>

        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        if (isset($_SESSION['no-login-message'])) {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>

        <br>

        <!-- Login form -->
        <form action="" method="POST">
            Username:
            <input type="text" name="username" placeholder="Enter your username"> <br><br><br>
            Password:
            <input type="password" name="password" placeholder="Enter your password"> <br> <br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary">
        </form>
        <br>
        <p class="text-center">Created by - <a href="luuhuyen177@gmail.com">Luu Huyen</a></p>
    </div>
</body>

</html>

<?php

//check if submit button is clicked or not
if (isset($_POST['submit'])) {
    //login process
    //get data from login form
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    //sql to check if user with username and password exists or not
    $sql = "SELECT * FROM db_admin WHERE username = '$username' AND password = '$password' ";

    // execute query
    $res = mysqli_query($conn, $sql);

    // count rows to check if user exists or not
    $count = mysqli_num_rows($res);
    if ($count == 1) {
        //user avaiable, login success
        $_SESSION['login'] = "<div class='success'>Login Successfully. </div>";
        $_SESSION['user'] = $username; //to check if user is logged in or not and logout will unset 

        //redirect to homepage/dashboard
        header('location:' . URL . 'admin/');
    } else {
        //user not avaiable, cannot login
        $_SESSION['login'] = "<div class='error'>Wrong Username or Password. Try again </div>";
        header('location:' . URL . 'admin/login.php');
    }
}

?>