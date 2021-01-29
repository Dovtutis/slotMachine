<?php
session_start();
require "./Class/DB.php";
require "./Class/Validation.php";
$db = new DB();
$vld = new Validation();
$currentPage = 'login';
$currentPageTitle = 'Login';

require "./process/loginProcess.php";
require "./inc/header.php";

?>

<main class="container">
    <h1 class="text-center display-4 my-3"><?php echo $currentPageTitle?></h1>
    <form action="" method="post" autocomplete="off" id="main-form">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username" value="<?php echo $username ?? ''?>">
            <p class="error-msg"><?php echo $response['errors']['username'] ?? null?></p>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" value="">
            <p class="error-msg"><?php echo $response['errors']['password'] ?? null?></p>
        </div>
        <button type="submit" name="submit" class="btn btn-lg btn-outline-primary">Login</button>
    </form>
</main>

<?php
$db->closeConnection();
require "./inc/footer.php";
?>
