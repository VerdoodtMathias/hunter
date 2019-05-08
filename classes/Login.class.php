<?php

include_once ('Db.class.php');

class Login {
    private $username;
    private $password;

    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function canLogin() {
        $conn = Db::getInstance();
        $statement = $conn->prepare("select password from users where username = :username");
        $statement->bindValue(":username", $this->username);
        $statement->execute();
        $dbPassword = $statement->fetchColumn();
        if (password_verify($this->password, $dbPassword)) {
            session_start();
            $_SESSION['username'] = $this->username;
            header('location: index.php');
        }
    }
}