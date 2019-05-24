<?php
include_once("Db.class.php");

class Photo
{


public function getPhoto($id){

        $conn =  Db::getInstance();

        $statement = $conn->prepare("select * from users where id = :id");
        $statement->bindValue(":id",$id);
        $statement->execute();
        $result =  $statement->fetch();
        return $result['user_img'];

    }
}
?>