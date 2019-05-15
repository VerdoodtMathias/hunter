<?php

include_once ('Db.class.php');

class Post {
    private $image;
    private $filter;
    private $description;
    private $user_id;
    private $title;
    private $time;
    private $post_id;
    private $city;
    private $tags;

    public function postUsername() {
        $conn = Db::getInstance();
        $statementUser = $conn->prepare("select * from users");
        $statementUser->execute();
        $res =  $statementUser->fetchAll();
        return $res;
    }

    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image)
    {
        // Image crop! werkt nog niet...
        /*$size = 400;
        $image_crop = imagecrop($image, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size]);
        $image = $image_crop;*/
        $this->image = $image;
    }

    public function getFilter()
    {
        return $this->filter;
    }
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }


    public function getUserId()
    {
        return $this->user_id;
    }
    public function setUserId($user_id)
    {
        $conn = Db::getInstance();
        $statementUser = $conn->prepare("select id from users where username = :username");
        $statementUser->bindValue(":username", $_SESSION['username']);
        $statementUser->execute();
        $user_id = $statementUser->fetchColumn();
        $this->user_id = $user_id;
    }


    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setTime($time)
    {
        date_default_timezone_set('Europe/Paris');
        $time = date("Y-m-d H:i:s");
        $this->time = $time;
    }
    public function getTime()
    {
        return $this->time;
    }

    public function getCity()
    {
        return $this->city;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getTags()
    {
        return $this->tags;
    }
    public function setTags($tags): void
    {
        $this->tags = $tags;
    }



    public function SavePost() {
        $conn = Db::getInstance();
        $statement = $conn->prepare("insert into posts (user_id, description, post_img, title, time_set, filter, city) VALUES (:id, :d, :p, :t, :ti, :f, :c)");
        $statement->bindValue(":id", $this->getUserId());
        $statement->bindValue(":d", $this->getDescription());
        $statement->bindValue(":p", $this->getImage());
        $statement->bindValue(":t", $this->getTitle());
        $statement->bindValue(":ti", $this->getTime());
        $statement->bindValue(":f", $this->getFilter());
        $statement->bindValue(":c", $this->getCity());

        if ($statement->execute()){
            return true;
        } else {
            return false;
        }
    }
    
    public function getAllPosts($user_id){
        $conn = Db::getInstance();
        //$statement = $conn->prepare("select * from posts where user_id = '".$user_id."'");
        $statement = $conn->prepare("select * from posts p inner join follow f on p.user_id = f.followUserID where f.status = 1 and f.userID = :u");
        $statement->bindValue(":u", $_SESSION['user_id']);
        $statement->execute();
        return $statement;
    }
    public function getCustomPosts($user_id){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from posts where user_id = '".$user_id."'");
        $statement->execute();
        return $statement;
    }

    public function getPostDetails() {
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from posts p inner join users u on p.user_id = u.id where id = :id");
        $statement->bindValue(":id", $_GET['watch']);
        $statement->execute();
        $res = $statement->fetchObject();
        return $res;
    }


    // FLAG POST
    public function getPostId()
    {
        return $this->post_id;
    }
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
    }

    public function flag_post(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("update posts set flag = flag +1 where id = :id");
        $statement->bindValue(":id", $this->getPostId());
        $statement->execute();
    }

    // DISCOVER PAGE 

    public function getEveryPost(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from posts");
        $statement->execute();
        return $statement;
    }

    public function getLocationDetails(){
        $conn = Db::getInstance();      
        $statement = $conn->prepare("select * from posts where city = :loc");
        $statement->bindValue(":loc", $this->city);
        $statement->execute();
        return $statement;
    }


    

}