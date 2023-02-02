<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h2>Dashboard</h2>
        <br>

        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>
        <br>
        <div class="col-4 text-center">

            <?php
            //sql query
            $sql = "SELECT * FROM db_category";
            //execute query
            $res = mysqli_query($conn, $sql);
            //count rows
            $count = mysqli_num_rows($res);
            ?>

            <h1><?php echo $count; ?></h1>
            <br />
            Categories
        </div>

        <div class="col-4 text-center">

            <?php
            //sql query
            $sql2 = "SELECT * FROM db_food";
            //execute query
            $res2 = mysqli_query($conn, $sql2);
            //count rows
            $count2 = mysqli_num_rows($res2);
            ?>

            <h1><?php echo $count2; ?></h1>
            <br />
            Foods
        </div>

        <div class="col-4 text-center">

            <?php
            //sql query
            $sql3 = "SELECT * FROM db_order";
            //execute query
            $res3 = mysqli_query($conn, $sql3);
            //count rows
            $count3 = mysqli_num_rows($res3);
            ?>

            <h1><?php echo $count3; ?></h1>
            <br />
            Total Orders
        </div>

        <div class="col-4 text-center">

            <?php
            //create sql query to get total revenue generated
            //aggregate function in sql
            $sql4 = "SELECT SUM(total) AS Total FROM db_order WHERE order_status='Delivered'";

            //execute
            $res4 = mysqli_query($conn, $sql4);

            //get values
            $row4 = mysqli_fetch_assoc($res4);

            //get total revenue
            $total_revenue = $row4['Total'];

            ?>

            <h1>€<?php echo $total_revenue; ?></h1>
            <br />
            Revenue Generated
        </div>
        <div class="clear-fix"></div>
    </div>
</div>

<?php include('partials/footer.php'); ?>