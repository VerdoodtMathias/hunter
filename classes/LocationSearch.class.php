<?php

include_once ('Db.class.php');

class LocationName {
    private $location_name;

    public function getLocationName()
    {
        return $this->location_name;
    }
    public function setLocationName($location_name)
    {
        $this->location_name = $location_name;
    }

    public function _LocationName() {
        $conn = Db::getInstance();
        $name = $this->getLocationName();
        $name = "%$name%";

        $stmt = $conn->prepare("select * from posts WHERE city LIKE :s");
        $stmt->bindValue(":s", $name);
        $stmt->execute();

        $nameresult = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $nameresult[] = $row;
        }

        return $nameresult;
    }
}