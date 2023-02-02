<?php
    include('../config/constant.php');
    if(isset($_GET['id']) && isset($_GET['img_name'])){
        //get id and image name
        $id = $_GET['id'];
        $img_name = $_GET['name'];

        //remove image if avaiable
        if($img_name != ''){
            //get image path
            $path = '../assets/images/food/'.$img_name;
            //remove img file from folder
            $remove = unlink($path);
            
            //check if image is removed or not
            if($remove == false){
                $_SESSION['upload'] = "<div class = 'error'>Failed to remove current image</div>";
                header('location:'.URL.'admin/manage-food.php');
                die();
            }
        }
        //delete food from db
        $sql = "DELETE FROM db_food WHERE id=$id";
        //execute query
        $res = mysqli_query($conn, $sql);
        //check if query is executed or not and set session message
        if($res == true){
            $_SESSION['delete'] = "<div class = 'success'>Deleted Food Successfully</div>";
            header('location:'.URL.'admin/manage-food.php');
        }
        else{
            $_SESSION['delete'] = "<div class = 'error'>Failed to delete Food</div>";
            header('location:'.URL.'admin/manage-food.php');
        }
    }
    else{
        $_SESSION['unauthorize'] = "<div class = 'error'>Unauthorized Access</div>";
        header('location:'.URL.'admin/manage-food.php');
    }
?>