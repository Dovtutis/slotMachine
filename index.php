<?php
session_start();
require "./Class/DB.php";
$db = new DB();
//$db->createDBPostsTable();
$currentPage = 'home';
$currentPageTitle = 'Slot Machine';

require "./inc/header.php";
?>


<main>

</main>

<script src="js/script.js"></script>
<?php
$db->closeConnection();
require "./inc/footer.php";
?>
