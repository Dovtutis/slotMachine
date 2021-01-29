<?php

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])){

    $username = $vld->emptyAndClean('username');
    $password = $vld->emptyAndClean('password');

    if ($vld->thereAreNoErrors()) {
        if ($db->loginUser($username, $password) !== false){
            $vld->validErrors['username'] = 'Wrong username or password';
            $response['errors'] = $vld->getValidationErrors();
        }
    }
}




