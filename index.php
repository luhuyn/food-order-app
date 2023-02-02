<?php include('partials-frontend/menu.php'); ?>

<section class="search-food text-center">
    <div class="container">
        <form action="<?php echo URL; ?>search-food.php" method="post">
            <input type="search" name="search" placeholder="Search for anything you want to eat...">
            <input type="submit" name="submit" value="search" class="btn btn-primary">
        </form>
    </div>
</section>
<?php 
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    ?>

<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Our Food</h2>

        <?php
        //create sql query to display categories from db
        $sql = "SELECT * FROM db_category WHERE active='Yes' AND featured='Yes' LIMIT 3";
        //execute
        $res = mysqli_query($conn, $sql);
        //count rows to check if category is avaiable or not
        $count = mysqli_num_rows($res);
        if ($count > 0) {
            //categories avaiable
            while ($row = mysqli_fetch_assoc($res)) {
                //get values 
                $id =  $row['id'];
                $title = $row['title'];
                $img_name = $row['img_name'];
        ?>
                <a href="<?php echo URL; ?>food-category.php?category_id=<?php echo $id; ?>">
                    <div class="box-3 float-container food-item">
                        <?php
                        if ($img_name == "") {
                            //display message
                            echo "<div class ='error'>No Image Avaiable</div>";
                        } else {
                        ?>
                            <img src="<?php echo URL; ?>assets/images/category/<?php echo $img_name; ?>" class="img-responsive img-curve category-img">
                        <?php
                        }
                        ?>
                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                    </div>
                </a>
        <?php
            }
        } else {
            //categories not avaiable
            echo "<div class = 'error'>No Category Added</div>";
        }
        ?>

        <div class="clear-fix"></div>
    </div>
</section>

<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Menu</h2>

        <?php
        //get food from db that are active and featured
        //sql query
        $sql2 = "SELECT * FROM db_food WHERE active = 'Yes' AND featured='Yes' LIMIT 6";

        //execute query
        $res2 = mysqli_query($conn, $sql2);

        //count rows
        $count2 = mysqli_num_rows($res2);

        //check if food is avaiable or not
        if ($count2 > 0) {
            while ($row = mysqli_fetch_assoc($res2)) {
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
                            if($img_name == ""){
                                echo"<div class = 'error'>No Image Avaiable</div>";
                            } else{
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
            //food not avaiable
            echo "<div class= 'error'>No Food Avaiable now</div>";
        }
        ?>


        <div class="clear-fix"></div>
    </div>
    <p class="text-center">
        <a href="#">See all Food</a>
    </p>
</section>

<?php include('partials-frontend/footer.php'); ?>