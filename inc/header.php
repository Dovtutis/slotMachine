<?php


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $currentPageTitle?></title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
<nav>
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-5">
        <a class="navbar-brand" href="index.php">Slot Machine</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto">
                <?php
                if (!isset($_SESSION['username'])) :?>
                    <a class="nav-item nav-link <?php echo $currentPage === 'register' ? 'active' : ''?>"  href="register.php">Register</a>
                    <a class="nav-item nav-link <?php echo $currentPage === 'login' ? 'active' : ''?>"  href="login.php">Login</a>
                <?php else :?>
                    <a class="nav-item nav-link"><?php echo $_SESSION['username']?></a>
                    <a class="nav-item nav-link <?php echo $currentPage === 'home' ? 'active' : ''?>" href="account.php">My Account</a>
                    <a class="nav-item nav-link <?php echo $currentPage === 'home' ? 'active' : ''?>" href="game.php">Game</a>
                    <a class="nav-item nav-link" href="./inc/logout.inc.php">Logout</a>
                <?php endif;?>
            </div>
        </div>
    </nav>
</nav>