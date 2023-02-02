<?php include('partials-frontend/menu.php'); ?>

<?php
//check if food is set or not
if (isset($_GET['food_id'])) {
    //get food id and its details
    $food_id = $_GET['food_id'];

    //get details
    $sql = "SELECT * FROM db_food WHERE id= $food_id";
    //execute query
    $res = mysqli_query($conn, $sql);
    //count rows
    $count = mysqli_num_rows($res);
    //check if data is avaible or not
    if ($count == 1) {
        //get data from db
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $price = $row['price'];
        $img_name = $row['img_name'];
    } else {
        header('location:'.URL);
    }
} else {
    header('location:'.URL);
}
?>
<section class="search-food">
    <div class="container">

        <h2 class="text-center text-white">Confirm your order.</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-img">
                    <?php
                    //check if image is avaiable or not
                    if ($img_name == "") {
                        echo "<div class = 'error'>No Image Avaiable</div>";
                    } else {
                        //image avaiable
                    ?>
                        <img src="<?php echo URL; ?>assets/images/food/<?php echo $img_name; ?>" class="img-responsive img-curve">
                    <?php
                    }
                    ?>
                </div>

                <div class="food-des">
                    <h3><?php echo $title; ?></h3>
                    <input type="hidden" name="food" value="<?php echo $title; ?>">

                    <p class="food-price">€<?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>
                </div>
            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>

                <div class="order-label">Full Name: </div>
                <input type="text" name="full-name" placeholder="E.g. Luu Huyen" class="input-responsive" required>

                <div class="order-label">Phone Number: </div>
                <input type="tel" name="contact" placeholder="E.g. 3999xxxxx" class="input-responsive" required pattern="\d+">

                <div class="order-label">Email: </div>
                <input type="email" name="email" placeholder="E.g. luuhuyen177@gmail.com" class="input-responsive" required>

                <div class="order-label">Address: </div>
                <textarea name="address" rows="10" placeholder="E.g. Viale Italia, Messina" class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>
        </form>

        <?php 

//check if submit button is clicked or not
if(isset($_POST['submit']))
{
    //get all details from FORM
    $food = $_POST['food'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $total = $price * $qty; // total = price x qty 
    $order_date = date("Y-m-d h:i:sa"); //order date
    $order_status = "Ordered";  // Ordered, On Delivery, Delivered, Cancelled
    $customer_name = $_POST['full-name'];
    $customer_contact = $_POST['contact'];
    $customer_email = $_POST['email'];
    $customer_address = $_POST['address'];


    //save order in db
    //create sql to save data
    $sql2 = "INSERT INTO db_order SET 
    food = '$food',
    price = $price,
    qty = $qty,
    total = $total,
    order_date = '$order_date',
    order_status = '$order_status',
    customer_name = '$customer_name',
    customer_contact = '$customer_contact',
    customer_email = '$customer_email',
    customer_address = '$customer_address'
    ";
    
    //execute query
    $res2 = mysqli_query($conn, $sql2);
    echo $sql2;

    //check if query is executed or not
    if($res2==true)
    {
        //query executed and order saved
        $_SESSION['order'] = "<div class='success text-center'>Order Successfully.</div>";
        header('location:'.URL);
    }
    else
    {
        //Failed to Save Order
        $_SESSION['order'] = "<div class='error text-center'>Failed to Order Food.</div>";
        header('location:'.URL);
    }

}

?>
    </div>
</section>

<?php include('partials-frontend/footer.php'); ?>


