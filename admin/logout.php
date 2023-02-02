<?php
    //include constant
    include('../config/constant.php');
    //destroy session
    session_destroy(); //unset $_SESSION['user']

    //redirect to login page
    header('location:'.URL.'admin/login.php');

?>