<?php
include_once ('inc/session_check.inc.php');
include_once ('classes/Post.class.php');
include_once ('classes/User.class.php');
include_once ('classes/Follow.class.php');
include_once ('classes/Comment.class.php');

$u = new User();
$user_id = $u->getUserID();
$_SESSION['user_id'] = $user_id;

$f = new Follow();
$followUserID = $f->getfollowUserID($user_id);

$post = new Post();
$posts = $post->getAllPosts($followUserID);

$getUsername = new Post();
$username = $getUsername->postUsername();


?><!doctype html>
<html lang="en">
<head>
    <?php include_once ('inc/head.inc.php'); ?>
    <title>Home - Inspiration Hunter</title>
</head>
<body>

<?php include_once ('inc/nav.inc.php'); ?>


<section class="content">
    <h1 id="welcome">Welcome, <strong class="username"><?php echo $_SESSION['username']; ?></strong></h1>

    <?php if (isset($result)) { ?>
        <? if (count($result) != 0) {?>
            <?php include_once ('inc/search.inc.php'); ?>
        <? } else { ?>
            <p>No search results... try again...</p>
        <? } ?>
    <?php } ?>

    <?php if (!isset($result)): ?>

        <h3 style="font-weight:700; font-size:1.3em;">Your feed</h3>
        <?php include_once ('inc/posts.inc.php');?>
    <?php endif; ?>
    
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>