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

?><!doctype html>
<html lang="en">
<head>
    <?php include_once ('inc/head.inc.php'); ?>
    <title>Discover - Picture Purrrfect</title>
</head>
<body>

<?php include_once ('inc/nav.inc.php'); ?>


<section class="content">
    <h1 id="welcome">Let's find some people to follow, <strong class="username"><?php echo $_SESSION['username']; ?></strong></h1>


    <?php if (isset($result)): ?>
        <?php include_once ('inc/search.inc.php'); ?>
    <?php else: ?>
    <div style="margin-top: 20px;">
        <h3 style="font-weight:700; font-size:1.3em;">People to follow</h3>
        <ul id="all-users-list">
            <?php foreach ($allUsers as $a): ?>
                <li id="user-list-item">
                    <a href="account.php?userID=<?php echo $a['id']; ?>">
                        <div id="user-img-div">
                            <img src="images/uploads/avatar/<?php echo $a['user_img']; ?>" alt="">
                        </div>
                        <h3><?php echo $a['username']; ?></h3>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <h3 style="font-weight:700; font-size:1.3em; margin-top: 1.3em;">You might like this posts</h3>
    <?php endif; ?>

    <?php include_once ('inc/posts.inc.php');?>
  
    
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/script.js"></script>
<script>
      function initMap() {
        var uluru = {lat: -25.363, lng: 131.044};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVvQeila2uW_EHtmzE3Ol34HH5XWyXc7A&callback=initMap">
    </script>

</body>
</html>