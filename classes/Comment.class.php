<?php

include_once ('Db.class.php');

class Comment {
    private $user_id;
    private $post_id;
    private $comment;

    private $username;

    public function getUserId()
    {
        return $this->user_id;
    }
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getPostId()
    {
        return $this->post_id;
    }
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
    }

    public function getComment()
    {
        return $this->comment;
    }
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }





    public function PlaceComment() {
        $conn = Db::getInstance();
        $statement = $conn->prepare("insert into comments (user_id, username, post_id, comment) values (:u, :un, :p,:c );");
        $statement->bindValue(':u', $this->user_id);
        $statement->bindValue(':un', $this->username);
        $statement->bindValue(':p', $this->post_id);
        $statement->bindValue(':c', $this->comment);
        $statement->execute();
    }

    /*public function GetComments(){
        $conn = Db::getInstance();
        $statementComment = $conn->prepare("SELECT * FROM users u inner join comments c on u.id = c.user_id;");
        $statementComment->execute();
        $comments = $statementComment->fetch(PDO::FETCH_ASSOC);
        return $comments;
    }*/

    public function GetComments(){
        $conn = Db::getInstance();
        $statementComment = $conn->prepare("SELECT * FROM comments; ");
        $statementComment->execute();
        $comments = $statementComment->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
    }
    
    /*
    public function getUserComment()
    {
        $conn = Db::getInstance();
        $statementUser = $conn->prepare("SELECT * FROM users u inner join comments c on u.id = c.user_id");
        $statementUser->execute();
        $commentUser = $statementUser->fetchColumn();
        return $commentUser;
    }*/




}