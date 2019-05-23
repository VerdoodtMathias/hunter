<?php

include_once ('../classes/Post.class.php');

$flag = new Post();

try {
    $flag->setPostId($_POST['post_id']);
    $flag->flag_post();

    $feedback = [
        "status" => "flagged",
        "post_id"   => htmlspecialchars($flag->getPostId())
    ];
}
catch (Exception $e) {

}

header('Content-Type: application/json');
echo json_encode($feedback);