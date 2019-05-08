<?php
include_once("Db.class.php");

class Photo
{

// SAMUEL CODE GEHEUGENSTEUNTJE = public function getPhoto(ARGUMENT) -> Argument gebruiken voor exacte user te bepalen, user wordt meegegeven 
// met het argument.
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