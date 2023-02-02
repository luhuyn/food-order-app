<?php include('partials-frontend/menu.php'); ?>
<style>
    body {
        background-image: url(assets/images/cate-bg.jpeg);
    }
</style>

<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Our Food</h2>

        <?php
        //display all categories that are active
        //sql query
        $sql = "SELECT * FROM db_category WHERE active = 'Yes'";

        //execute query
        $res = mysqli_query($conn, $sql);

        //count rows
        $count = mysqli_num_rows($res);

        //check if categories avaiable or not
        if ($count > 0) {
            //categories avaiable
            while ($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $title = $row['title'];
                $img_name = $row['img_name'];
        ?>
                <a href="<?php echo URL; ?>food-category.php?category_id=<?php echo $id; ?>">
                    <div class="box-3 float-container food-item">
                        <?php
                            if($img_name == ""){
                                //image not avaiable
                                echo"<div class='error'>Image Not Found.</div>";
                            } 
                            else{
                                //imahe avaiable
                                ?>
                                    <img src="<?php echo URL; ?>assets/images/category/<?php echo $img_name ?>" class="img-responsive img-curve item-img">
                                <?php

                            }
                        ?>
                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                    </div>
                </a>

        <?php
            }
        } else {
            echo "<div class ='error'>No Category Found</div>";
        }
        ?>

        <div class="clear-fix"></div>
    </div>
</section>

<?php include('partials-frontend/footer.php'); ?>