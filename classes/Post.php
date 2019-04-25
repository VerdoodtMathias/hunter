<?php 

    class Post {
        private $picture;
        private $description;


        /**
         * Get the value of image
         */ 
        public function getPicture()
        {
                return $this->picture;
        }

        /**
         * Set the value of image
         *
         * @return  self
         */ 
        public function setPicture($picture)
        {
                $this->picture = $picture;

                return $this;
        }

        /**
         * Get the value of description
         */ 
        public function getDescription()
        {
                return $this->description;
        }

        /**
         * Set the value of description
         *
         * @return  self
         */ 
        public function setDescription($description)
        {
                $this->description = $description;

                return $this;
        }



        public function SavePost() {
            $conn = Db::getInstance();
            $statement = $conn->prepare("insert into post (picture, description) VALUES (:p, :d)");
            $statement->bindValue(":p", $this->getPicture());
            $statement->bindValue(":d", $this->getDescription());

            if ($statement->execute()){
                return true;
            } else {
                return false;
            }
        }

    }