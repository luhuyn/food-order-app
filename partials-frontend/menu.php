<?php include('config/constant.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feasty</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <section class ="navigation bar">
        <div class ="container">
            <div class ="logo">
                <a href="#" title="logo">
                    <img src="./assets/images/logo.png" alt="Feasty Logo" class="img-responsive">
                    <p class="title">Feasty</p>
                </a>
            </div>
            <div class = "menu text-right">
                <ul>
                    <li>
                        <a href="<?php echo URL; ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo URL; ?>categories.php">Categories</a>
                    </li>
                    <li>
                        <a href="<?php echo URL; ?>food.php">Food</a>
                    </li>
                    <li>
                        <a href="#">Contact us</a>
                    </li>
                </ul>
            </div>

            <div class = "clear-fix"></div>
        </div>
    </section>