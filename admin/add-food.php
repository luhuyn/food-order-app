<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h2>Add Food</h2>
        <br>

        <?php
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>
        <br/>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="db-30">

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food..."></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" step="0.01" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                                //create sql to get all active categories from db
                                $sql = "SELECT * FROM db_category WHERE active= 'Yes'";
                                //execute query
                                $res = mysqli_query($conn, $sql);

                                //count rows
                                $count = mysqli_num_rows($res);

                                if($count>0){
                                    //have categories
                                    while ($row=mysqli_fetch_assoc($res)){
                                        //get details of categories
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                            <option value="<?php echo $id; ?>"><?php echo $title;?></option>
                                        <?php
                                    }
                                }
                                else{
                                    //do not have categories
                                    ?>
                                        <option value="0"> No Category Found</option>
                                    <?php
                                }
                                //display on dropdown
                            ?>
                        </select>
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
                        <input type="submit" name="submit" value="Add Food" class="btn-primary">
                    </td>
                </tr>

            </table>
        </form>

        <?php
            //check if button is clicked or not
            if(isset($_POST['submit'])){
                // get data from FORM
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //check if radio buttons are checked or not
                if(isset($_POST['featured'])){
                    $featured = $_POST['featured'];
                }
                else{
                    $featured = "No"; //set default value
                }

                if(isset($_POST['active'])){
                    $active = $_POST['active'];
                }
                else{
                    $active = "No"; //set default value
                }

                //upload image if selected
                
                if(isset($_FILES['image']['name'])){
                    //get detail of the selected image
                    $img_name = $_FILES['image']['name'];
                    
                    //check if select image is clicked or not and upload image only if image is selected
                    if($img_name != ""){
                        //image is selected
                        //rename image
                        //get extension of selected image
                        $ext = end(explode('.', $img_name));

                        //create new name for img
                        $img_name = "Food-Image-".rand(0000, 9999).'.'.$ext;

                        //upload image
                        //get the src path and destination path

                        $src = $_FILES['image']['tmp_name'];
                        $destination = "../assets/images/food/".$img_name;
                        //upload food image
                        $upload = move_uploaded_file($src, $destination);

                        //check if image uploaded or not
                        if($upload == false){
                            $_SESSION['upload'] = "<div class = 'error'>Failed to upload Image</div>";
                            header('location:'.URL.'admin/add-food.php');
                            die();
                        }
                    }
                }
                else{
                    $img_name = "";
                }

                //insert into db
                // create a sql query to save or add food
                //for numerical do not need to pass value in ''
                $sql2 = "INSERT INTO db_food SET 
                        title = '$title',
                        description = '$description',
                        price = $price,
                        img_name = '$img_name',
                        category_id = $category, 
                        featured = '$featured',
                        active = '$active'        
                ";
                //execute query
                $res2 = mysqli_query($conn, $sql2);
                //check if data is inserted or not
                if($res2 ==true){
                    $_SESSION['add'] = "<div class ='success'>Added Food Successfully</div>";
                    header('location:'.URL.'admin/manage-food.php');
                }else{
                    $_SESSION['add'] = "<div class ='error'>Failed to add Food</div>";
                    header('location:'.URL.'admin/manage-food.php');
                }
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>