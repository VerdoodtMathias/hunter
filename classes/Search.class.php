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

    