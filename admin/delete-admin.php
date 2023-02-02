<?php
    //include constant.php
    include('../config/constant.php');

    //get admin id to delete
    $id = $_GET['id'];

    //create sql query to delete admin
    $sql = "DELETE FROM db_admin WHERE id =$id";

    //execute query
    $res = mysqli_query($conn, $sql);

    //check whether query executed successfully or not
    if($res==true){
        //query executed successfully, deleted admin
        //create session var to display status
        $_SESSION['delete'] = "<div class='success'>Successfully deleted Admin</div>";

        //redirect to manage admin page
        header('location:'.URL.'admin/manage-admin.php');
    }
    else{
        //failed to delete
        $_SESSION['delete']= "<div class='error'>Failed to delete Admin. Try again Later.</div>";
        header('location:'.URL.'admin/manage-admin.php');
    }
    //redirect to manage admin page with message(success/error)
?>