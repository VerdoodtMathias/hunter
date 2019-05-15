<?php

include_once ('classes/Like.class.php');
include_once ('classes/Comment.class.php');


if (!empty($_POST['like'])) {
    $l = new Like();
    $l->setPostId($_POST['like']);
    $l->setUserId($_SESSION['user_id']);
    $l->likePost();
} elseif (!empty($_POST['unlike'])) {
    $l = new Like();
    $l->setPostId($_POST['unlike']);
    $l->setUserId($_SESSION['user_id']);
    $l->unLikePost();
}


$filter = "";

// Loop comments in PHP
$comment = new Comment();
$allComments = $comment->GetComments();
rsort($allComments);

// Place a comment in PHP
if (!empty($_POST['comment'])){
    $comment = $_POST['comment'];
    $post_id = $_POST['post_id'];

    $c = new Comment();
    $c->setUserId($user_id);
    $c->setPostId($post_id);
    $c->setUsername($_SESSION['username']);
    $c->setComment($comment);
    $c->PlaceComment();
}

if (!empty($_POST['flag'])) {
    $flag = new Post();
    $flag->setPostId($_POST['flag']);
    $flag->flag_post();
}


?>

<ul class="list">
    <? if ($posts->rowCount() < 1) { ?>
        <p>No Posts to see here...</p>
    <? } else { ?>
    <?php while($row = $posts->fetch()) : ?>
        <?php if ($row['flag'] < 3): ?>

            <li class="post" data-id="<?php echo $row['id'];?>" value="<?php echo $row['id'];?>">

                <a href="account.php?userID=<?php echo $row['user_id']; ?>" id="user-link">
                    <?php foreach ($username as $u): ?>
                        <?php if ($row['user_id'] == $u['id']):?>
                            <div id="user-img-div"><img src="images/uploads/avatar/<?php echo $u['user_img']; ?>" alt=""></div>
                            <h3><?php echo htmlspecialchars($u['username']); ?></h3>
                            <br><p id="time-set"><?php echo $row['time_set']; ?></p>

                        <?php endif; ?>
                    <?php endforeach; ?>
                </a>

                <a class="locationName" href="locationdetail.php?city=<?php echo $row['city']; ?>"><? echo $row['city']; ?></a>

                <form action="" method="post" id="flag">
                    <a href="#">
                        <input type="hidden" value="<?php echo $row['id'];?>" name="flag">
                        <input type="submit" value="Flag" class="flag-btn" data-id="<?php echo $row['id'];?>">
                    </a>
                </form>

                <p class="flag-p">This post has been flagged: <strong class="flag-count"><?php echo htmlspecialchars($row['flag']); ?></strong> time<?php if ($row['flag'] != 1): ?><span class="s">s</span><?php endif; ?></p>


                <div id="img-div">
                    <a href="details.php?watch=<?echo $row['id'];?>">
                        <figure class="<?php echo $row['filter'] ?>">
                            <img src="<?php echo 'images/uploads/'.$row['post_img']; ?>" alt="post_img" width="50px" height="auto">
                        </figure>
                    </a>
                </div>
                <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                <p><?php echo htmlspecialchars($row['description']); ?></p>





                <!-- LIKES -->
                <?php
                    $likes = "";
                    $l = new Like();
                    $l->setUserId($_SESSION['user_id']);
                    $l->setPostId($row['id']);
                    $likes = $l->getLikes();
                ?>

                <form action="" method="post" class="like-form">
                    <? if($likes['status'] == 1): ?>
                        <input type="hidden" name="unlike" value="<?php echo $row['id'];?>">
                        <input type="submit" class="like-post unlike" data-id="<?php echo ($row['id']. "|" .$_SESSION['user_id']);?>">
                    <? else: ?>
                        <input type="hidden" name="like" value="<?php echo $row['id'];?>">
                        <input type="submit" class="like-post like" data-id="<?php echo ($row['id']. "|" .$_SESSION['user_id']);?>">
                    <? endif; ?>
                </form>


                <form action="" method="post" class="comment-form">
                    <label for="comment<?php echo $row['id'];?>"></label>
                    <input type="text" name="comment" id="comment<?php echo $row['id'];?>" class="comment-text" placeholder="Leave a comment...">
                    <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>" class="id_post">
                    <input type="submit" value="COMMENT" class="btn-comment" data-id="<?php echo $row['id'];?>">
                </form>

                <ul class="comment-ul" data-id="<?php echo $row['id']; ?>">
                    <?php foreach ($allComments as $c): ?>
                        <?php if ($c['post_id'] == $row['id']): ?>
                            <li class="comment-li" >
                                <strong><?php echo htmlspecialchars($c['username']); ?> </strong>
                                <p><?php echo htmlspecialchars($c['comment']); ?></p>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>

                <? if ($row['user_id'] == $_SESSION['user_id']): ?>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input id="btnDelete" type="submit" name="delete" value="Delete" />
                </form>
                <? endif; ?>

            </li>

        <?php endif; ?>
    <?php endwhile; ?>
    <? } ?>
</ul>

<button class="show-posts">Show more</button>