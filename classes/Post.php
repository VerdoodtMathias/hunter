<?php 

    class Post {
        private $image;
        private $description;


        /**
         * Get the value of picture
         */ 
        public function getImage()
        {
                return $this->image;
        }

        /**
         * Set the value of picture
         *
         * @return  self
         */ 
        public function setImage($image)
        {
                $this->image = $image;

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
            $statement->bindValue(":p", $this->getImage());
            $statement->bindValue(":d", $this->getDescription());

            if ($statement->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function getPost(){
            $conn = Db::getInstance();
            $statement = $conn->prepare("select * from post");
            $statement->execute();
            $collection = $statement->fetchAll();
            return $collection;
        }

    }