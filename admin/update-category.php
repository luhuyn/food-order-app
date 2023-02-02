<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h2>Update Category</h2>
        <br /><br />

        <?php
        //check if id is set or not
        if (isset($_GET['id'])) {
            //get id and all other details
            $id = $_GET['id'];
            //create sql query to get all
            $sql = "SELECT * FROM db_category WHERE id= $id";

            //execute query
            $res = mysqli_query($conn, $sql);
            //count rows
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                //get all data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['img_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                //redirect to manage category page with status
                $_SESSION['no-category-found'] = "<div class='error'>No Category Found</div>";
                header('location:' . URL . 'admin/manage-category.php');
            }
        } else {
            header('location:' . URL . 'admin/manage-category.php');
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="db-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">

                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if ($current_image != 0) {
                            //display image
                        ?>
                            <img src="<?php echo URL; ?>assets/images/category/<?php echo $current_image; ?>" width="100px">
                        <?php
                        } else {
                            //display message
                            echo "<div class = 'error'>No Image</div>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            //get all values from FORM
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //update new img if selected
            //check if image is selected or not
            if (isset($_FILES['image']['name'])) {
                //get images details
                $img_name = $_FILES['image']['name'];
                //check if image is avaiable or not
                if ($img_name != "") {
                    //image avaiable

                    //upload new image

                    //auto rename img
                    //get extensions of img(jpg, png, gif, etc)
                    $ext = end(explode('.', $img_name));
                    //rename img
                    $img_name = "Food_Category_" . rand(000, 999) . '.' . $ext;

                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = '../assets/images/category/' . $img_name;

                    //upload 
                    $upload = move_uploaded_file($source_path, $destination_path);
                    //check if image is uploaded or not
                    //if img is not uploaded then stop the process and redirect with error
                    if ($upload == false) {
                        //set status
                        $_SESSION['upload'] = "<div class='error'>Failed</div>";
                        //redirect to add category page
                        header('location:' . URL . 'admin/manage-category.php');
                        //stop process
                        die();
                    }
                    //remove current image if avaiable
                    if ($current_image != "") {
                        $remove_path = "../assets/images/category/" . $current_image;
                        $remove = unlink($remove_path);
                        //check if image is removed or not
                        //failed to remove then display message and stop process
                        if ($remove == false) {
                            $_SESSION['failed-remove'] = "<div class = 'error'>Failed to remove current image</div>";
                            header('location:' . URL . 'admin/manage-category.php');
                            die();
                        }
                    }
                } else {
                    $img_name = $current_image;
                }
            } else {
                $img_name = $current_image;
            }

            //update db
            $sql2 = "UPDATE db_category SET
                        title = '$title',
                        img_name = '$img_name',
                        featured = '$featured',
                        active = '$active'
                        WHERE id = $id
                ";

            //execute query 
            $res2 = mysqli_query($conn, $sql2);
            //redirect to manage category with status
            //check if executed or not
            if ($res2 == true) {
                //category is updated
                $_SESSION['update'] = "<div class = 'success'>Updated Category Successfully</div>";
                header('location:' . URL . 'admin/manage-category.php');
            } else {
                $_SESSION['update'] = "<div class = 'error'>Failed to update Category</div>";
                header('location:' . URL . 'admin/manage-category.php');
            }
        }
        ?>
    </div>
</div>
<?php include('partials/footer.php'); ?>