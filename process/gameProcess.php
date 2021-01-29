<?php

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["play"])){
    $username = $_SESSION["username"];
    $user = $db->userExists($username);
    $userBalance = $user["balance"];
    $minimbalBet = 5;
    $resultsArray = [0,0,0,0,0,0,0,0,0];

    $sumFromInput = $vld->emptyAndClean('betSum');
    $betValidation = $vld->checkIfBalanceIsEnough($sumFromInput, $userBalance);
    $sumFromInput = $vld->checkMinimalSum($sumFromInput, $minimbalBet);

    if ($vld->thereAreNoErrors()) {
        $db = new DB();
        $resultsArray = [];
        for ($x=0; $x<9; $x++) {
            $resultsArray[] = rand(0,2);
        }
        $imageArray = [
            'https://media1.giphy.com/media/w7IOh6J3W6Vd34o22r/giphy.gif',
            'https://media2.giphy.com/media/l41JPeFUmYnY31Sfu/giphy.gif',
            'https://media3.giphy.com/media/3oFzlVEIlQtEuoHebS/giphy.gif'
        ];

    $results = $vld->checkResults($resultsArray);
    if (!empty($results)){
        $multiplayerResults = $results["multiplayers"];
        $response['messages'] = $results["messages"];

        foreach ($multiplayerResults as $result){
            $totalSum = $userBalance + ($sumFromInput * $result);
            $db->updateBalance($totalSum, $username);
        }
    }else{
        $response['messages'][] = "Try again!";
        $totalSum = $userBalance - $sumFromInput;
        $db->updateBalance($totalSum, $username);
    }

    } else {
        $response['errors'] = $vld->getValidationErrors();
    }
}



