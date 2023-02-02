<?php include('partials/menu.php'); ?>

<?php
//check if id is set or not
if (isset($_GET['id'])) {
    //get all details
    $id = $_GET['id'];

    //Sql query to get selected food
    $sql2 = "SELECT * FROM db_food WHERE id=$id";

    //execute query
    $res2 = mysqli_query($conn, $sql2);

    //get values based on executed query
    $row2 = mysqli_fetch_assoc($res2);

    //get individual values of selected food
    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['img_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
} else {
    //redirect to manage food page
    header('location:' . URL . 'admin/manage-food.php');
}
?>


<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="db-30">

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" step="0.01" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if ($current_image == "") {
                            //image no avaiable 
                            echo "<div class='error'>No Image Available.</div>";
                        } else {
                            //image avaiable
                        ?>
                            <img src="<?php echo URL; ?>assets/images/food/<?php echo $current_image; ?>" width="100px">
                        <?php
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Choose New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php
                            //query to get active categories
                            $sql = "SELECT * FROM db_category WHERE active='Yes'";
                            //execute query
                            $res = mysqli_query($conn, $sql);
                            //count rows
                            $count = mysqli_num_rows($res);

                            //check if category is avaiable or not
                            if ($count > 0) {
                                //category avaiable
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];

                            ?>
                                    <option <?php if ($current_category == $category_id) {
                                                echo "selected";
                                            } ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                            <?php
                                }
                            } else {
                                //category no avaiable
                                echo "<option value='0'>No Category Avaiable.</option>";
                            }

                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php

        if (isset($_POST['submit'])) {

            //get all the details from FORM
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //upload the image if selected

            //check if upload button is clicked or not
            if (isset($_FILES['image']['name'])) {
                //upload button clicked
                $img_name = $_FILES['image']['name']; //new image name

                //check if file is avaiable or not
                if ($img_name != "") {

                    //rename the Image
                    $ext = end(explode('.', $img_name)); //get extension of img

                    $img_name = "Food-Image-" . rand(0000, 9999) . '.' . $ext;
                    //get src path and dst path
                    $src_path = $_FILES['image']['tmp_name']; //source path
                    $dest_path = "../assets/images/food/" . $img_name; //destination path

                    //upload img
                    $upload = move_uploaded_file($src_path, $dest_path);
                    // check if img is uploaded or not
                    if ($upload == false) {
                        //failed to upload
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload new Image.</div>";
                        //redirect to Manage Food 
                        header('location:' . URL . 'admin/manage-food.php');
                        //Stop the Process
                        die();
                    }
                    //remove image if new image is uploaded and current image exists
                    //remove current image if available
                    if ($current_image != "") {
                        //current img is avaiable
                        //remove image
                        $remove_path = "../assets/images/food/" . $current_image;

                        $remove = unlink($remove_path);

                        //check if img is removed or not
                        if ($remove == false) {
                            //failed to remove current image
                            $_SESSION['remove-failed'] = "<div class='error'>Faile to remove current image.</div>";
                            //redirect to manage food
                            header('location:' . URL . 'admin/manage-food.php');
                            //stop the process
                            die();
                        }
                    }
                } else {
                    $img_name = $current_image; //default image when img is not selected
                }
            } else {
                $img_name = $current_image; //default image when button is not clicked
            }



            //update food in db
            $sql3 = "UPDATE db_food SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    img_name = '$img_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

            //execute query
            $res3 = mysqli_query($conn, $sql3);

            //check query is executed or not
            if ($res3 == true) {
                //query is executed and food updated
                $_SESSION['update'] = "<div class='success'>Updated Food Successfully.</div>";
                header('location:' . URL . 'admin/manage-food.php');
            } else {
                //Failed to Update Food
                $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
                header('location:' . URL . 'admin/manage-food.php');
            }
        }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>