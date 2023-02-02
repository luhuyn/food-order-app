<?php
    //authorization - access control
    //check if user is logged in or not
    if(!isset($_SESSION['user'])){ //if user session is not set
        //user not loged in
        //redirect to login page with messages
        $_SESSION['no-login-message'] = "<div class ='error'>You must login first</div>";
        header('location:'.URL.'admin/login.php');
    }
?>