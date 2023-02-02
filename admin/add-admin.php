<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h2>Add New Admin</h2>
        <br />

        <?php
        if (isset($_SESSION['add'])) { //check whether the session is set or not
            echo $_SESSION['add']; //display the session message if set
            unset($_SESSION['add']); //remove session message
        }
        ?>
        <form action="" method="POST">
            <table class="db-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Full Name">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Your Username">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Your Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include('partials/footer.php'); ?>

<?php
//Process values from FORM and Save to dbs

//Check whether the button is clicked or not
if (isset($_POST['submit'])) {
    //Button clicked

    //Get data from FORM
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); //password encryption with MD5

    //SQL Query to save data into dbs
    $sql = "INSERT INTO db_admin SET 
            full_name='$full_name', 
            username= '$username', 
            password='$password'
        ";

    //execute query and save data into dbs
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    //check whether(executed query) data is inserted or not and display appropriate message
    if ($res == TRUE) {

        //create a session variable to display message
        $_SESSION['add'] = "<div class='success'>Successfully created a new Admin</div>";

        //redirect page to Manage Admin
        header("location:" . URL . 'admin/manage-admin.php');
    } else {
        $_SESSION['add'] = "<div class='error'>Failed to create a new Admin</div>";
        //redirect page to Add Admin
        header("location:" . URL . 'admin/add-admin.php');
    }
}
?>