<?php include('partials/menu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h2>Update Order</h2>
        <br><br>
        <?php

        //check if id is set or not
        if (isset($_GET['id'])) {
            //get order details
            $id = $_GET['id'];

            //get all other details by id
            //sql query to get the order details
            $sql = "SELECT * FROM db_order WHERE id=$id";
            //execute query
            $res = mysqli_query($conn, $sql);
            //count rows
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                //detail avaiable
                $row = mysqli_fetch_assoc($res);
                $food = $row['food'];
                $price = $row['price'];
                $qty = $row['qty'];
                $order_status = $row['order_status'];
                $customer_name = $row['customer_name'];
                $customer_contact = $row['customer_contact'];
                $customer_email = $row['customer_email'];
                $customer_address = $row['customer_address'];
            } else {
                header('location:'.URL.'admin/manage-order.php');
            }
        } else {
            header('location:'.URL.'admin/manage-order.php');
        }

        ?>

        <form action="" method="POST">

            <table class="db-30">
                <tr>
                    <td>Food Name</td>
                    <td><b> <?php echo $food; ?> </b></td>
                </tr>

                <tr>
                    <td>Price</td>
                    <td>
                        <b> € <?php echo $price; ?></b>
                    </td>
                </tr>

                <tr>
                    <td>Qty</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <select name="order_status">
                            <option <?php if ($order_status == "Ordered") {
                                        echo "selected";
                                    } ?> value="Ordered">Ordered</option>
                            <option <?php if ($order_status == "On Delivery") {
                                        echo "selected";
                                    } ?> value="On Delivery">On Delivery</option>
                            <option <?php if ($order_status == "Delivered") {
                                        echo "selected";
                                    } ?> value="Delivered">Delivered</option>
                            <option <?php if ($order_status == "Cancelled") {
                                        echo "selected";
                                    } ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer Name: </td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Contact: </td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Email: </td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Address: </td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td clospan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>


        <?php
        //check if update button is clicked or not
        if (isset($_POST['submit'])) {
            //get all values from FORM
            $id = $_POST['id'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $total = $price * $qty;
            $order_status = $_POST['order_status'];
            $customer_name = $_POST['customer_name'];
            $customer_contact = $_POST['customer_contact'];
            $customer_email = $_POST['customer_email'];
            $customer_address = $_POST['customer_address'];
            
            //update values
            $sql2 = "UPDATE db_order SET 
                    qty = $qty,
                    total = $total,
                    order_status = '$order_status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                    WHERE id=$id
                ";

            //execute query
            $res2 = mysqli_query($conn, $sql2);
            
            if ($res2 == true) {
                //Updated
                $_SESSION['update'] = "<div class='success'>Updated Order Successfully.</div>";
                header('location:' . URL . 'admin/manage-order.php');
            } else {
                //Failed to Update
                $_SESSION['update'] = "<div class='error'>Failed to Update Order.</div>";
                header('location:' . URL . 'admin/manage-order.php');
            }
        }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>