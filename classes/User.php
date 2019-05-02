<?php 
    class User{

        private $firstname;
        private $lastname;
        private $email;
        private $password;
        private $city;

        public function getFirstname(){
                return $this->firstname;
        }

        public function setFirstname($firstname){
                $this->firstname = $firstname;
                return $this;
        }
        
        public function getLastname(){
                return $this->lastname;
        }

        public function setLastname($lastname)
        {
                $this->lastname = $lastname;
                return $this;
        }

        public function getEmail(){
                return $this->email;
        }

        public function setEmail($email){
                $this->email = $email;
                return $this;
        }

        public function getPassword(){
                return $this->password;
        }

        public function setPassword($password){
                $this->password = $password;
                return $this;
        }

        public function getCity(){
                return $this->city;
        }

        public function setCity($city){
                $this->city = $city;
                return $this;
        }

        public function Select() {
                $conn = Db::getInstance();
                $statement = $conn->prepare("select * from user where id=1");
                $profile = $statement->fetchAll();
                return $profile;
    
                if ($statement->execute()){
                    return true;
                } else {
                    return false;
                }
        }

        public function Update() {
                $conn = Db::getInstance();
                $statement = $conn->prepare("update user set (firstname, lastname, email, password, city) VALUES (:f, :l, :e, :p, :c) where id=1");
                $statement->bindValue(":f", $this->getFirstname() );
                $statement->bindValue(":l", $this->getLastname() );
                $statement->bindValue(":e", $this->getEmail() );
                $statement->bindValue(":p", $this->getPassword() );
                $statement->bindValue(":c", $this->getCity() );
                
                if ($statement->execute()){
                        return true;
                    } else {
                        return false;
                    }
        }

    }

?>