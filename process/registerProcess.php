<?php

    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])){

        $username = $vld->cleanCheckReturnUsername('username');
        $password = $vld->cleanCheckReturnPassword('password');
        $passwordRepeat = $vld->cleanCheckReturnPassword('passwordRepeat');

        if (empty($validErrors['password']) && empty($validErrors['passwordRepeat'])){
            $vld->passwordsMatch($password, $passwordRepeat);
        }

        if ($vld->thereAreNoErrors()) {
            $response['success']['username'] = $username;
            $response['success']['password'] = $password;
            $response['success']['passwordRepeat'] = $passwordRepeat;
            $db = new DB();

            $db->createUser($username, $password, $passwordRepeat);
            $response['userCreated'] = 'User created successfully';
        } else {
            $response['errors'] = $vld->getValidationErrors();
        }
    }




