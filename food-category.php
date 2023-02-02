<?php include('partials-frontend/menu.php') ?>

<?php
if (isset($_GET['category_id'])) {
    //get category id
    $category_id = $_GET['category_id'];
    // get category title
    $sql = "SELECT title FROM db_category WHERE id=$category_id";

    //execute query
    $res = mysqli_query($conn, $sql);

    //get value from db
    $row = mysqli_fetch_assoc($res);

    //get title
    $category_title = $row['title'];
} else {
    header('location:' . URL);
}
?>
<section class="search-food text-center">
    <div class="container">
        <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>
    </div>
</section>
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Menu</h2>

        <?php
        //create sql query to get food based on selected category
        $sql2 = "SELECT * FROM db_food WHERE category_id = $category_id";

        //execute query 
        $res2 = mysqli_query($conn, $sql2);

        //count rows
        $count2 = mysqli_num_rows($res2);

        //check if food is avaiable or not
        if ($count2 > 0) {
            while ($row2 = mysqli_fetch_assoc($res2)) {
                $id = $row2['id'];
                $title = $row2['title'];
                $price = $row2['price'];
                $description = $row2['description'];
                $img_name = $row2['img_name'];

        ?>
                <div class="food-box">
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
                        <h4><?php echo $title; ?></h4>
                        <p class="food-price">€<?php echo $price; ?></p>
                        <p class="food-detail">
                            <?php echo $description; ?>
                        </p>
                        <br>
                        <a href="<?php echo URL; ?>order.php?food_id=<?php echo $id?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<div class = 'error'>No Food Avaible</div>";
        }
        ?>


        <div class="clear-fix"></div>
    </div>
</section>
<?php include('partials-frontend/footer.php'); ?>