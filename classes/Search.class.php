<?php

include_once ('Db.class.php');

class Search {
    protected $search_term;

    public function getSearchTerm()
    {
        return $this->search_term;
    }
    public function setSearchTerm($search_term)
    {
        $this->search_term = $search_term;
    }

    public function _Search() {
        $conn = Db::getInstance();
        $search = $this->getSearchTerm();
        $search = "%$search%";

        $stmt = $conn->prepare("select * from posts WHERE title LIKE :s");
        $stmt->bindValue(":s", $search);
        $stmt->execute();

        $result = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }

        return $result;
    }
}