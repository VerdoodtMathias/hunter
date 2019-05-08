<?php
include_once ('Db.class.php');
include_once ('User.class.php');

class Follow {

    function getfollowUserID($userID){
        $conn = Db::getInstance();
        $followCheck = $conn->prepare("select followUserID from follow where userID = :userID");
        $followCheck->bindValue(":userID", $userID);
        $followCheck->execute();

        $aantal = $followCheck->rowCount();
        if($aantal > 0){
            $result = $followCheck->fetch();
            $result = $result['followUserID'];
        }else{
            $result = '';
        }

        return $result;
    }

    function getFollowStatus($followUserID){
        $u = new User;
        $userID = $u->getUserID();
        
        $conn = Db::getInstance();
        $followCheck = $conn->prepare("select * from follow where followUserID = :followUserID and userID = :userID ");
        $followCheck->bindValue(":userID", $userID);
        $followCheck->bindValue(":followUserID", $followUserID);
        $followCheck->execute();

        $aantal = $followCheck->rowCount();
        if($aantal == 0){
            $result = "follow";
        }else{
            $result = 'unfollow';
        }

        return $result;
    }

    function followUser($followUserID){
        $u = new User;
        $userID = $u->getUserID();

        if($userID == $followUserID){
            return "ERROR";
            die();
        }
        
        $followStatus = $this->getFollowStatus($followUserID);
        if($followStatus == "follow"){
            $conn = Db::getInstance();
            $followCheck = $conn->prepare("insert into follow (userID, followUserID) VALUES( :userID, :followUserID )");
            $followCheck->bindValue(":userID", $userID);
            $followCheck->bindValue(":followUserID", $followUserID);
            $result = $followCheck->execute();
        }else{
            $conn = Db::getInstance();
            $followCheck = $conn->prepare("delete from follow where followUserID = :followUserID and userID = :userID ");
            $followCheck->bindValue(":userID", $userID);
            $followCheck->bindValue(":followUserID", $followUserID);
            $result = $followCheck->execute();
        }
        

        if(!$result){
            return "A problem has occured! Please try again.";
        }else{
            return "ok";
        }
    }

    /*private $user_id;
    private $followUser_id;
    private $status;

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getFollowUserId()
    {
        return $this->followUser_id;
    }

    public function setFollowUserId($followUser_id)
    {
        $this->followUser_id = $followUser_id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function followUser() {
        $conn = Db::getInstance();
        $statement = $conn->prepare("insert into follow (userID, followUserID, status) values (:u, f, :s)");
        $statement->bindValue(":u", $this->getUserId());
        $statement->bindValue(":f", $this->getFollowUserId());
        $statement->bindValue(":s", 1);
        $statement->execute();
    }

    public function unfollowUser() {
        $conn = Db::getInstance();
        $statement = $conn->prepare("delete from follow where userID = :u and followUserID = :f");
        $statement->bindValue(":u", $this->getUserId());
        $statement->bindValue(":f", $this->getFollowUserId());
        $statement->execute();
    }

    public function followCheck() {
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from follow");
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }*/


}


?>