<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h2>Update Admin</h2>
        <br /><br />

        <?php
        //get selected admin id
        $id = $_GET['id'];
        //create sql query to get details
        $sql = "SELECT * FROM db_admin WHERE id=$id";
        //execute query
        $res = mysqli_query($conn, $sql);

        //check whether query is executed or not
        if ($res == true) {
            //check whether data is avaiable or not
            $count = mysqli_num_rows($res);
            //check whether we have admin data or not
            if ($count == 1) {
                //get data detail
                $row = mysqli_fetch_assoc($res);
                $full_name = $row['full_name'];
                $username = $row['username'];
            } else {
                //redirect to manage admin page
                header('location:' . URL . 'admin/manage-admin.php');
            }
        }
        ?>
        <br /><br />
        <form action="" method="POST">
            <table class="db-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
//check whether submit button is clicked or not
if (isset($_POST['submit'])) {
    //get all values from FORM to update
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    //create a SQL query to update admin
    $sql = "UPDATE db_admin SET 
        full_name='$full_name',
        username='$username' 
        WHERE id='$id'
        ";

    //execute query
    $res = mysqli_query($conn, $sql);

    //check whether query executed successfully or not
    if ($res == true) {
        //query executed and admin is updated
        $_SESSION['update'] = "<div class='success'>Successfully updated Admin</div>";
        //redirect to manage admin page
        header('location:' . URL . 'admin/manage-admin.php');
    } else {
        //failed to update
        $_SESSION['update'] = "<div class='error'>Failed to update Admin. Try again later.</div>";
        //redirect to manage admin page
        header('location:' . URL . 'admin/manage-admin.php');
    }
}
?>

<?php include('partials/footer.php'); ?>