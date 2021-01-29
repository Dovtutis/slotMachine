<?php


class DB
{
    private $serverName = 'localhost';
    private $userName = 'root';
    private $password = '';
    private $databaseName = 'slotMachine';
    public $connection;


    public function __construct()
    {
        $this->connection = new mysqli($this->serverName, $this->userName, $this->password, $this->databaseName);

        if ($this->connection->connect_error){
            die('Sugriuvo serveris: ' . $this->connection->connect_error);
        }

        if (!isset($_SESSION['statusArr'])){
            $_SESSION['statusArr'] = [];
        }
    }


    public function createDBPostsTable()
    {
        $sql = "
        CREATE TABLE Users(
            id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            passwordRepeat VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";

        $this->makeQuery($sql, 'Table created successfully');
    }

        public function createUser($username, $password){
        $sql = "INSERT INTO users (username, password) VALUES (?, ?);";
        $stmt = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            die('kazkas sugriuvo');
        }

        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPwd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ./index.php");
        exit();
    }


    private function makeQuery($sql, $msg)
    {
        if ($this->connection->query($sql) === TRUE) {
        } else {
        }
    }

    public function userExists($username){
        $sql = "SELECT * FROM users WHERE username = ? ;";
        $stmt = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            return false;
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }else {
            $result = false;
            return $result;
        }

        mysqli_stmt_close($stmt);
    }

    public function loginUser ($username, $password)
    {
        $userExists = $this->userExists($username);

        if ($userExists === false) {
            return true;
        }

        $passwordHashed = $userExists["password"];
        $checkedPassword = password_verify($password, $passwordHashed);

        if ($checkedPassword === false){
            return true;
        }
        else if ($checkedPassword === true){
            session_start();
            $_SESSION["username"] = $userExists["username"];
            $_SESSION["balance"] = $userExists["balance"];
            header("location: ./account.php");
            exit();
        }
    }

    public function updateBalance($sum, $username)
    {
        $sql = "UPDATE users
        SET `balance` = '$sum'
        WHERE `username` = '$username' 
        LIMIT 1
        ";

        $this->makeQuery($sql, 'irasas atnaujintas sekmingai');
    }

    public function closeConnection(){
        $this->connection->close();
    }
}
