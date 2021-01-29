<?php
session_start();
require "./Class/DB.php";
require "./Class/Validation.php";

$db = new DB();
$vld = new Validation();
$currentPage = 'game';
$currentPageTitle = 'Slot Machine';

$imageArray = [
    'https://previews.123rf.com/images/lineartestpilot/lineartestpilot1909/lineartestpilot190907636/129368971-cartoon-question-mark-with-speech-bubble-in-retro-texture-style.jpg',
];
$resultsArray = [0,0,0,0,0,0,0,0,0];
$response['messages'] = [];
$username = $_SESSION["username"];

require "./process/gameProcess.php";

$user = $db->userExists($username);
$userBalance = $user["balance"];

require "./inc/header.php";
?>


<main>
    <div class="container gameContainer my-1">
        <div class="my-2"><h2>3x3 Slot Machine</h2></div>
        <div class="my-2"><h3 id="userBalance">Your balance is: <?php echo $userBalance?></h3></div>
        <div class="depositCashOutBox">
            <?php foreach ($response['messages'] as $message):?>
                <h2><?php echo $message?></h2>
            <?php endforeach;?>
            <form action="" method="post" autocomplete="off" id="game-form">
                <div class="form-group depositCashOutInputBox">
                    <input required type="text" class="form-control" name="betSum" id="betSum" value="" placeholder="Enter your bet">
                    <p class="error-msg"><?php echo $response['errors']['depositCashOut'] ?? null?></p>
                    <button type="submit" name="play" class="depositCashOutButton">Play</button>
                </div>
            </form>
        </div>
        <div class="my-5 slotMachineContainer">
            <?php foreach ($resultsArray as $result):?>
                <img class="gameImg" src="<?php echo $imageArray[$result]?>" alt="">
            <?php endforeach;?>
        </div>
    </div>
</main>


<?php
require "./inc/footer.php";
?>
