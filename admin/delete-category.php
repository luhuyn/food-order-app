<?php
    include('../config/constant.php');
    //check if id and image value are set or not
    if(isset($_GET['id']) and isset($_GET['img_name'])){
        //get value and delete
        $id = $_GET['id'];
        $img_name = $_GET['img_name'];

        //remove physical image file is avaiable
        if($img_name != ""){
            //imahe is avaiable so remove it
            $path = '../assets/images/category/'.$img_name;
            //remove image
            $remove = unlink($path);
            //if failed to remove img then add an error message an stop process
            if($remove == false){
                //set session message
                $_SESSION['remove']="<div class = 'error'>Failed to remove category image</div>";
                //redirect to manage category page
                header('location:'.URL.'admin/manage-category.php');
                die();
            }
        }
        //delete data from db
        //sql query to delete data from db
        $sql = "DELETE FROM db_category WHERE id = $id";

        //execute query
        $res = mysqli_query($conn, $sql);
        //check if data is removed from db or not
        if($res==true){
            //display message and redirect
            $_SESSION['delete']= "<div class='success'>Deleted category successfully</div>";
            header('location:'.URL.'admin/manage-category.php');
        }
        else{
            $_SESSION['delete']= "<div class='error'>Failed to delete category successfully</div>";
            header('location:'.URL.'admin/manage-category.php');
        }

    }
    else{
        //redirect to manage category page
        header('location:'.URL.'admin/manage-category.php');
    }
?>