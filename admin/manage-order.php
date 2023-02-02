<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h2>Manage Order</h2>
        <br /><br /><br />
        <?php
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>
        <br><br>

        <table class="db-full">
            <tr>
                <th>No.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>

            <?php
            //gel all orders from db
            $sql = "SELECT * FROM db_order ORDER BY id DESC"; // display lastest order at first
            //execute query
            $res = mysqli_query($conn, $sql);
            //count rows
            $count = mysqli_num_rows($res);

            $sn = 1; //create serial number

            if ($count > 0) {
                //orer avaiable
                while ($row = mysqli_fetch_assoc($res)) {
                    //get all order details
                    $id = $row['id'];
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $order_status = $row['order_status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];

            ?>

                    <tr>
                        <td><?php echo $sn++; ?>. </td>
                        <td><?php echo $food; ?></td>
                        <td>€<?php echo $price; ?></td>
                        <td><?php echo $qty; ?></td>
                        <td>€<?php echo $total; ?></td>
                        <td><?php echo $order_date; ?></td>
                        <td>
                            <?php
                            // Ordered, On Delivery, Delivered, Cancelled

                            if ($order_status == "Ordered") {
                                echo "<label>$order_status</label>";
                            } elseif ($order_status == "On Delivery") {
                                echo "<label style='color: orange;'>$order_status</label>";
                            } elseif ($order_status == "Delivered") {
                                echo "<label style='color: green;'>$order_status</label>";
                            } elseif ($order_status == "Cancelled") {
                                echo "<label style='color: red;'>$order_status</label>";
                            }
                            ?>
                        </td>

                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $customer_contact; ?></td>
                        <td><?php echo $customer_email; ?></td>
                        <td><?php echo $customer_address; ?></td>
                        <td>
                            <a href="<?php echo URL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>
                        </td>
                    </tr>

            <?php
                }
            } else {
                //prders not avaiable
                echo "<tr><td colspan='12' class='error'>No orders avaiable</td></tr>";
            }
            ?>

        </table>
    </div>

</div>

<?php include('partials/footer.php'); ?>