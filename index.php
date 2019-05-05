<!--<?php
/*
    require_once("bootstrap.php");

    $post = new Post();
    $post->getPost();

    $conn = Db::getInstance();
    $statement = $conn->prepare("select * from post");
    $statement->execute();
    $collection = $statement->fetchAll();
*/
?>-->







    <?php
 
    session_start();
    spl_autoload_register(function($class) {
        include_once("classes/" . $class . ".class.php");
    });
 
    // Check if logged in
    User::authenticate();
   
    // create database connection
    $db = Db::getInstance();
    
 
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hunter</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cssgram/0.1.10/cssgram.min.css">
</head>
<body>
<div id="wrapper">
    <!-- Navigatie -->
    <?php
        include_once("includes/header.inc.php");
    ?>
 
    
    
   
    </div>



     <a href="upload.php">UPLOAD</a>

        <div class="collection">
            <?php foreach($collection as $c): ?>
            <div class="post">
            
            <img src="img/uploads/<?php echo $c['picture'] ?>" alt="<?php echo $c['picture'] ?>" class="postimg">
            <h2><?php echo $c['description']; ?></h2>
            </div>
        <?php endforeach; ?>
  </div>
x
 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.22.1/moment.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>