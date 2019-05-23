<?php
include_once ('inc/session_check.inc.php');
include_once ('classes/Post.class.php');
include_once ('classes/User.class.php');
include_once ('classes/Comment.class.php');

$a = new User();
$allUsers = $a->getAllUsers();

$post = new Post();
$posts = $post->getEveryPost();

$getUsername = new Post();
$username = $getUsername->postUsername();

//$location = new Post();
$location = $_GET['city'];

$locationdetails = new Post();
$locationdetails->setCity($location);
$locationdetails = $locationdetails->getLocationDetails();
$posts = $locationdetails;


?><!doctype html>
<html lang="en">
<head>
    <?php include_once ('inc/head.inc.php'); ?>
    <title>Location Details - Picture Purrrfect</title>
</head>
<body>

<?php include_once ('inc/nav.inc.php'); ?>


<section class="content">
    <h1 id="welcome">Posted in, <strong class="username"><?php echo $location; ?></strong></h1>

  
    <?php if (isset($result)): ?>
        <?php include_once ('inc/search.inc.php'); ?>
    <?php else: ?>
  

    <h3 style="font-weight:700; font-size:1.3em; margin-top: 1.3em;">Posts based on <?php echo $location ?></h3>
    <?php endif; ?>

   <?php if (isset($nameresult)) { ?>
        <? if (count($nameresult) != 0) {?>
            <?php include_once ('inc/search.inc.php'); ?>
        <? } else { ?>
            <p>No search results... try again...</p>
        <? } ?>
    <?php } ?>

    <?php if (!isset($nameresult)): ?>
        <?php include_once ('inc/posts.inc.php');?>
    <?php endif; ?>
  
    
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>