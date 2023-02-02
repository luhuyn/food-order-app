<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h2>Change Password</h2>
        <br /> <br />

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        ?>

        <form action="" method="POST">
            <table class="db-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm New Password: </td>
                    <td>
                        <input type="password" name="confirm_new_password" placeholder="Confirm New Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-tertiary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
//check whether submit button is clicked or not
if (isset($_POST['submit'])) {
    //get data from FORM
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_new_password = md5($_POST['confirm_new_password']);
    //check whether user with current id and current password exists or not
    $sql = "SELECT * FROM db_admin WHERE id = $id AND password = '$current_password' ";
    //execute query
    $res = mysqli_query($conn, $sql);
    if ($res == true) {
        //check if data is avaiable or not
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            //user exists and can change password
            //check if new password and confirm password match or not
            if ($new_password == $confirm_new_password) {
                //update password
                $sql2 = "UPDATE db_admin SET password = '$new_password'
                            WHERE id = $id";
                //execute query
                $res2 = mysqli_query($conn, $sql2);
                //check if query executed or not
                if ($res2 == true) {
                    //display success message
                    $_SESSION['change-pwd'] = "<div class='success'>Change Password Successfully</div>";
                    //redirect user
                    header('location:' . URL . 'admin/manage-admin.php');
                } else {
                    //display error message
                    $_SESSION['change-pwd'] = "<div class='error'>Failed to Change Password.</div>";
                    //redirect user
                    header('location:' . URL . 'admin/manage-admin.php');
                }
            } else {
                //redirect to manage admin with error status
                $_SESSION['pwd-not-match'] = "<div class='error'>Password does not match. Try again</div>";
                //redirect user
                header('location:' . URL . 'admin/manage-admin.php');
            }
        } else {
            //user does not exist, display message and redirect
            $_SESSION['user-not-found'] = "<div class='error'>Error! An error occurred. Please try again later</div>";
            //redirect user
            header('location:' . URL . 'admin/manage-admin.php');
        }
    }
    //check whether new password and confirm password match or not

    //change password if all above is true
}
?>

<?php include('partials/footer.php'); ?>