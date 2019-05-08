<?php

include_once ('Db.class.php');

class User {
    private $username;
    private $password;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $settings = [
            "cost" => 12
        ];
        $this->password = password_hash($password, PASSWORD_DEFAULT, $settings);
    }

    public function Save() {
        $conn = Db::getInstance();
        $statementCheck = $conn->prepare("select * from users where username = :username");
        $statementCheck->bindValue(":username", $this->username);
        $statementCheck->execute();

        if ($statementCheck->rowCount() < 1) {
            $statement = $conn->prepare("insert into users (username, password) VALUES (:username, :password)");
            $statement->bindValue(":username", $this->username);
            $statement->bindValue(":password", $this->password);
            if($statement->execute()) {
                session_start();
                $_SESSION['username'] = $this->username;
                header('location: index.php');
            } else {
                echo "Something went wrong";
            }
        } else {
            return false;
        }
    }

    public function changeSettings($username, $newusername, $bio, $user_img, $newpassword){
        $conn = Db::getInstance();
        
        if($username != $newusername){
            $statementCheck = $conn->prepare("select * from users where username = :username");
            $statementCheck->bindValue(":username", $newusername);
            $statementCheck->execute();
            $userExist = $statementCheck->rowCount();
        }else{
            $userExist = 0;
        }

        if ($userExist == 0) {
            //username bestaat niet of is niet veranderd, gegevens aanpassen
            
            $code ='';
            if(!empty($newpassword)){
                $settings = [
                    "cost" => 12
                ];
                $newpasswordhash = password_hash($newpassword, PASSWORD_DEFAULT, $settings);
                $code = ", password = '".$newpasswordhash."'";
            }

            $conn =  Db::getInstance();
            $statement = $conn->prepare("UPDATE users SET username= :newusername, bio=:bio, user_img=:user_img ".$code." WHERE username= :username");
            $statement->bindValue(":username", $_SESSION['username']);
            $statement->bindValue(":newusername", $newusername);
            $statement->bindValue(":bio",$bio);
            $statement->bindValue(":user_img",$user_img);

            if($statement->execute()){
               return true;
            }else{
                return "ERROR: Er is iets fout gegaan tijdens het aanpassen van de gegevens";
            }
        }else{
            //username bestaat wel, mag niet veranderd worden
            return "ERROR: Gelieve een andere username te kiezen";
        }
    }

    public function getUserDetails(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from users where username = :username");
        $statement->bindValue(":username", $_SESSION['username']);
        $statement->execute();
        $result =  $statement->fetch();
        return $result;
    }

    public function getUserID(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from users where username = :username");
        $statement->bindValue(":username", $_SESSION['username']);
        $statement->execute();
        $result =  $statement->fetch();
        return $result['id'];
    }

    public function getAccountDetails($user_id){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from users where id = :user_id");
        $statement->bindValue(":user_id", $user_id);
        $statement->execute();
        $result =  $statement->fetch();
        return $result;
    }

    public function getAllUsers() {
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from users where id != :u");
        $statement->bindValue(":u", $_SESSION['user_id']);
        $statement->execute();
        $allUsers = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $allUsers;
    }

}