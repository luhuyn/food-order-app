<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h2>Manage Category</h2>

        <br/><br/>

        <a href="<?php echo URL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
        <br/><br/>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['remove'])){
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }
        if(isset($_SESSION['delete'])){
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if(isset($_SESSION['no-category-found'])){
            echo $_SESSION['no-category-found'];
            unset($_SESSION['no-category-found']);
        }
        if(isset($_SESSION['update'])){
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if(isset($_SESSION['failed-remove'])){
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);
        }
        ?>
        <br/><br/>
        <table class="db-full">
            <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
            <?php
                //query to get all categories from db
                $sql =  "SELECT * FROM db_category";
                //execute query
                $res = mysqli_query($conn, $sql);
                //count rows
                $count = mysqli_num_rows($res);

                //create serial number variable and assign value as 1
                $sn=1;

                //check if we have data in db or not
                if($count>0){
                    //have data in db
                    //get data and display
                    while($row=mysqli_fetch_assoc($res)){
                        $id = $row['id'];
                        $title = $row['title'];
                        $img_name = $row['img_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                        ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $title;?></td>
                                <td> 
                                    <?php
                                        //check if image name is avaible or not
                                        if($img_name != ""){
                                            //display image
                                            ?>

                                            <img src="<?php echo URL; ?>assets/images/category/<?php echo $img_name; ?>" width = "100px">
                                            <?php
                                        }else{
                                            //display message
                                            echo "<div class='error'>No Image</div>";
                                        }
                                    ?>
                                </td>

                                <td><?php echo $featured; ?></td>
                                <td><?php echo $active; ?> </td>
                                <td>
                                    <a href ="<?php echo URL; ?>admin/update-category.php?id=<?php echo $id; ?>" class = "btn-secondary">Update Category</a>
                                    <a href ="<?php echo URL; ?>admin/delete-category.php?id=<?php echo $id;?>&img_name=<?php echo $img_name;?>" class = "btn-danger">Delete Category</a>
                                </td>
                            </tr>
                        <?php
                    }
                }else{
                    //do not have data
                    //display message inside the table
                    ?>
                    <tr>
                        <td colspan="6"><div class = "error">No Category Added.</div></td>
                    </tr>
                    <?php
                }
            ?>
            
        </table>
    </div>
</div>
<?php include('partials/footer.php'); ?>