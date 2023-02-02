<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h2>Manage Food</h2>

        <br /><br />

        <a href="<?php echo URL; ?>admin/add-food.php" class="btn-primary">Add New Food</a>
        <br /><br />
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if (isset($_SESSION['unauthorize'])) {
            echo $_SESSION['unauthorize'];
            unset($_SESSION['unauthorize']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>
        <br />
        <table class="db-full">
            <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
            $sql = "SELECT * FROM db_food";
            //execute
            $res = mysqli_query($conn, $sql);
            //count rows to check if have food or not
            $count = mysqli_num_rows($res);
            //create serial number var and set value as 1
            $sn = 1;

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    //get values from columns
                    $id = $row['id'];
                    $title = $row['title'];
                    $price =  $row['price'];
                    $img_name = $row['img_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
            ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $price; ?></td>
                        <td>
                            <?php
                            if ($img_name == "") {
                                echo "<div class='error'>No Image</div>";
                            } else {
                            ?>
                                <img src="<?php echo URL; ?>assets/images/food/<?php echo $img_name; ?>" width="100px">
                            <?php
                            }
                            ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo URL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                            <a href="<?php echo URL; ?>admin/delete-food.php?id=<?php echo $id; ?>&img_name=<?php echo $img_name; ?>" class="btn-danger">Delete Food</a>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr> <td colspan='2' class='error'>No Food Added Yet</td></tr>";
            }
            ?>


        </table>
    </div>
</div>
<?php include('partials/footer.php'); ?>