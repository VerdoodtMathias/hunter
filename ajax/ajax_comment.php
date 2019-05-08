<?php

include_once ('../inc/session_check.inc.php');
include_once ('../classes/Comment.class.php');

$c = new Comment();

try
{

    $c->setUserId($_SESSION['user_id']);
    $c->setPostId($_POST['post_id']);
    $c->setComment($_POST['text']);
    $c->setUsername($_SESSION['username']);
    $c->PlaceComment();

    $feedback = [
        'status'    => 'success',
        'text'      => htmlspecialchars($c->getComment()),
        'post_id'   => htmlspecialchars($c->getPostId()),
        'user'      => htmlspecialchars($c->getUsername())
    ];
}
catch(Exception $e)
{
    die("Oops... Something went wrong there");
}

header('Content-Type: application/json');
echo json_encode($feedback);