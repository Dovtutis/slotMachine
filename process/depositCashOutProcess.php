<?php
session_start();
require "../Class/DB.php";
require "../Class/Validation.php";
$jsonResponse = [];

$db = new DB();
$vld = new Validation();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_SESSION["username"];
        $userBalance = getUserBalance($username);
        $minimalSum = 50;

    if ($_POST['btnName'] === 'depositBtn'){
        $sumFromInput = $vld->emptyAndClean('depositCashOutSum');
        $sumFromInput = $vld->checkMinimalSum($sumFromInput, $minimalSum);
        $totalSum = $sumFromInput + $userBalance;

        if ($vld->thereAreNoErrors()) {
            $db->updateBalance($totalSum, $username);
            $userBalance = getUserBalance($username);
            $_SESSION["balance"] = $userBalance;
            $jsonResponse['userBalance'] = $userBalance;
        } else {
            $jsonResponse['errors'] = $vld->getValidationErrors();
        }

    }elseif ($_POST['btnName'] === 'cashOutBtn'){
        $sumFromInput = $vld->emptyAndClean('depositCashOutSum');
        $sumFromInput = $vld->checkMinimalSum($sumFromInput, $minimalSum);
        $cashOutValidation = $vld->checkIfBalanceIsEnough($sumFromInput, $userBalance);

        if ($vld->thereAreNoErrors()) {
            if ($cashOutValidation){
                $totalSum = $userBalance - $sumFromInput;
                $db->updateBalance($totalSum, $username);
                $userBalance = getUserBalance($username);
                $_SESSION["balance"] = $userBalance;
                $jsonResponse['userBalance'] = $userBalance;
            }
        } else {
            $jsonResponse['errors'] = $vld->getValidationErrors();
        }
    }

    header('Content-Type:application/json');
    echo $jsonResponse = json_encode($jsonResponse);
}

function getUserBalance($username){
    global $db;
    $user = $db->userExists($username);
    $userBalance = $user["balance"];
    return $userBalance;
}


