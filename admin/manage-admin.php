<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h2>Manage Admin</h2>
        <br /><br />

        <!--Create new Admin-->
        <a href="add-admin.php" class="btn-primary">Add New Admin</a>
        <br /><br />

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; //display session status
            unset($_SESSION['add']); //remove session message
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if (isset($_SESSION['user-not-found'])) {
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
        }
        if (isset($_SESSION['pwd-not-match'])) {
            echo $_SESSION['pwd-not-match'];
            unset($_SESSION['pwd-not-match']);
        }
        if (isset($_SESSION['change-pwd'])) {
            echo $_SESSION['change-pwd'];
            unset($_SESSION['change-pwd']);
        }
        ?>
        <br /><br />

        <table class="db-full">
            <tr>
                <th>No.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php
            //query to get all admin
            $sql = "SELECT * FROM db_admin";
            //execute the query
            $res = mysqli_query($conn, $sql);
            //check whether the query is executed or not
            if ($res == TRUE) {
                //count rows to check whether data is in dbs or not
                $count = mysqli_num_rows($res); //function to get all rows in dbs
                $sn = 1; //create a variable and assign value
                //check num of rows
                if ($count > 0) {
                    //have data in dbs
                    while ($rows = mysqli_fetch_assoc($res)) {
                        //use while loop to get all data from dbs
                        //and while loop will runs as long as we have data in dbs

                        //get individual data
                        $id = $rows['id'];
                        $full_name = $rows['full_name'];
                        $username = $rows['username'];

                        //display the values in table
            ?>

                        <tr>
                            <td> <?php echo  $sn++; ?> </td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                                <a href="<?php echo URL; ?>admin/change-password.php?id=<?php echo $id; ?>" class="btn-tertiary">Change password</a>
                                <a href="<?php echo URL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                <a href="<?php echo URL; ?>admin/delete-admin.php?id= <?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                            </td>
                        </tr>


            <?php

                    }
                } else {
                    //not have data in dbs
                }
            }
            ?>

            <!-- <tr>
                        <td>2. </td>
                        <td>Luu Huyen</td>
                        <td>luhuyn</td>
                        <td>
                            <a href="#" class="btn-secondary">Update Admin</a>
                            <a href="#" class="btn-danger">Delete Admin</a>
                        </td>
                    </tr>

                    <tr>
                        <td>3. </td>
                        <td>Luu Huyen</td>
                        <td>luhuyn</td>
                        <td>
                            <a href="#" class="btn-secondary">Update Admin</a>
                            <a href="#" class="btn-danger">Delete Admin</a>
                        </td>
                    </tr> -->

        </table>
    </div>
</div>
<?php include('partials/footer.php'); ?>