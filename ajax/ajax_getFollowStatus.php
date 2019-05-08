<?php
    session_start();

    include_once ('../classes/Follow.class.php');

    $followUserID = $_POST['followUserID'];
    
    $f = new Follow;
    echo $f->getFollowStatus($followUserID);
    
?>