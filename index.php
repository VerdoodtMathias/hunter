<?php

    require_once("bootstrap.php");

    $post = new Post();
    $post->getPost();

    $conn = Db::getInstance();
    $statement = $conn->prepare("select * from post");
    $statement->execute();
    $collection = $statement->fetchAll();










?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="css/index.css">
        <title>Document</title>
    </head>
    <body>
        <a href="upload.php">UPLOAD</a>

        <div class="collection">
            <?php foreach($collection as $c): ?>
            <div class="post">
            
            <img src="img/uploads/<?php echo $c['picture'] ?>" alt="<?php echo $c['picture'] ?>" class="postimg">
            <h2><?php echo $c['description']; ?></h2>
            </div>
        <?php endforeach; ?>
  </div>
    </body>
    </html>