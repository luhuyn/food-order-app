<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h2>Add Category</h2>
        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data"> <!-- enctype allows up to upload file -->
            <table class="db-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Input Category Title">

                    </td>
                </tr>

                <tr>
                    <td>Selected Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-primary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            //get values from FORM 
            $title = $_POST['title'];
            //for radio input, need to check if button is selected or not
            if (isset($_POST['featured'])) {
                //get values from FORM
                $featured = $_POST['featured'];
            } else {
                $featured = "No";
            }

            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No";
            }
            //check if img is selected or not and set value for img name accordingly
            // print_r($_FILES['image']); 
            // die(); //break code here

            if (isset($_FILES['image']['name'])) {
                //upload image
                //to upload, need image name, source path and destination path
                $img_name = $_FILES['image']['name'];

                //upload image only if image is selected
                if ($img_name != "") {

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
                        $_SESSION['upload'] = "<div class='error'>Failed to upload</div>";
                        //redirect to add category page
                        header('location:' . URL . 'admin/add-category.php');
                        //stop process
                        die();
                    }
                }
            } else {
                //no upload image, set img_name value as blank
                $img_name = "";
            }
            //create sql query to insert category into db
            $sql = "INSERT INTO db_category SET
                            title='$title',
                            img_name='$img_name',
                            featured='$featured',
                            active='$active'
                    ";
            //execute query and save in db
            $res = mysqli_query($conn, $sql);
            if ($res == true) {
                $_SESSION['add'] = "<div class = 'success'>Add Category Successfully</div>";
                header('location:' . URL . 'admin/manage-category.php');
            } else {
                $_SESSION['add'] = "<div class = 'error'>Failed to add category</div>";
                header('location:' . URL . 'admin/add-category.php');
            }
        }
        ?>
    </div>
</div>
<?php include('partials/footer.php'); ?>