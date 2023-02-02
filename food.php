<?php include('partials-frontend/menu.php') ?>

<section class="search-food text-center">
    <div class="container">
        <form action="<?php echo URL; ?>search-food.php" method="post">
            <input type="search" name="search" placeholder="Search for anything you want to eat..." required>
            <input type="submit" name="submit" value="search" class="btn btn-primary">
        </form>
    </div>
</section>

<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Menu</h2>

        <?php
        //get food from db that are active and featured
        //sql query
        $sql = "SELECT * FROM db_food WHERE active = 'Yes'";

        //execute query
        $res = mysqli_query($conn, $sql);

        //count rows
        $count = mysqli_num_rows($res);

        //check if food is avaiable or not
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                //get all values
                $id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $description = $row['description'];
                $img_name = $row['img_name'];
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
                        <a href="<?php echo URL; ?>order.php?food_id=<?php echo $id ?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
        <?php
            }
        } else {
            //food not avaiable
            echo "<div class= 'error'>No Food Avaiable now</div>";
        }
        ?>

        <div class="clear-fix"></div>
    </div>
</section>

<?php include('partials-frontend/footer.php'); ?>