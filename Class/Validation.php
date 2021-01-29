<?php


class Validation
{
    public $validErrors = [];

    public function emptyAndClean($var)
    {
        if ($this->checkPostVar($var)) {
            $var = $this->cleanPostVar($var);
            return $var;
        }else {
            $this->validErrors[$var] = 'not set or empty';
        }
    }

    public function cleanCheckReturnUsername($var)
    {
        if ($this->checkPostVar($var)) {
            $username = $this->cleanPostVar($var);
            $username = $this->checkLength($username, $var);
            $username = $this->checkIfUserExists($username);
            return $username;
        }else {
            $this->validErrors[$var] = 'not set or empty';
        }
    }

    public function cleanCheckReturnPassword($var)
    {
        if ($this->checkPostVar($var)) {
            $password = $this->cleanPostVar($var);
            $password = $this->checkLength($password, $var);
            return $password;
        }else {
            $this->validErrors[$var] = 'not set or empty';
        }
    }

    public function checkPostVar($var)
    {
        if (isset($_POST[$var]) && !empty($_POST[$var])) {
            if (trim($_POST[$var]) !== '') {
                return true;
            }
        }
    }

    public function cleanPostVar($var)
    {
        $trimmed = trim($_POST[$var]);
        $safe = htmlspecialchars($trimmed);
        return $safe;
    }

    public function checkLength($var, $type)
    {
        if (strlen($var) > 3 && strlen($var)<21){
            return $var;
        }else{
            $this->validErrors[$type] = "You must type from 4 to 20 symbols";
        }
    }

    public function checkIfUserExists($var){
        global $db;
        if ($db->userExists($var) !== false){
            $this->validErrors['username'] = 'Username is already taken';
        }else{
            return $var;
        }
    }


    public function passwordsMatch($password, $passwordRepeat){
        $result;
        if ($password !== $passwordRepeat){
            $this->validErrors['password'] = "Passwords do not match";
        }
    }

    public function checkMinimalSum($sum, $minimalSum){
        $result;
        if ($sum<$minimalSum){
            $this->validErrors['depositCashOut'] = "Minimal sum is $minimalSum";
        }else{
            return $sum;
        }
    }

    public function checkIfBalanceIsEnough($sumFromInput, $userBalance)
    {
        if ($userBalance - $sumFromInput >= 0){
            return true;
        }else {
            $this->validErrors['depositCashOut'] = "There are not enough money in your account";
        }
    }

    public function checkResults($arr)
    {
        $resultsArr = [];

        if ($arr[0] === $arr[1] && $arr[0] === $arr[2]){
            $resultsArr["multiplayers"][] =  3;
            $resultsArr["messages"][] = "First Row! x3 Multiplayer";
        }
        if ($arr[3] === $arr[4] && $arr[3] === $arr[5]){
            $resultsArr["multiplayers"][] =  4;
            $resultsArr["messages"][] = "Second Row! x4 Multiplayer";
        }
        if ($arr[6] === $arr[7] && $arr[6] === $arr[8]){
            $resultsArr["multiplayers"][] =  5;
            $resultsArr["messages"][] = "Third Row! x5 Multiplayer";
        }
        if ($arr[0] === $arr[4] && $arr[0] === $arr[8] || $arr[2] === $arr[4] && $arr[2] === $arr[6]){
            $resultsArr["multiplayers"][] =  5;
            $resultsArr["messages"][] = "Diagonal Row! x5 Multiplayer";
        }
        if ($arr[0] === $arr[4] && $arr[0] === $arr[8] && $arr[2] === $arr[4] && $arr[0] === $arr[6]){
            $resultsArr["multiplayers"][] =  10;
            $resultsArr["messages"][] = "Diagonal X Row! x10 Multiplayer";
        }
        return $resultsArr;
    }


    public function showValidationErrors()
    {
        if (!empty($this->validErrors)){
            var_dump($this->validErrors);
        }
    }

    public function getValidationErrors()
    {
        if (!empty($this->validErrors)){
            return $this->validErrors;
        }
    }


    public function thereAreNoErrors()
    {
        if (empty($this->validErrors)){
            return true;
        }
    }

}