<?php

include_once ('classes/Detail.class.php');
include_once ('classes/Post.class.php');
include_once ('classes/Db.class.php');

$watch = $_GET['watch'];

$query = "SELECT * FROM posts WHERE id = '{$watch}'";
$conn = Db::getInstance();
$stmt = $conn->prepare($query);

$stmt->execute();

$result = $stmt->fetchAll();

$num_results = 5;
$delta = (! empty($_POST['delta'])) ? $_POST['delta'] : 24;
$reduce_brightness = (isset($_POST['reduce_brightness'])) ? $_POST['reduce_brightness'] : 1;
$reduce_gradients = (isset($_POST['reduce_gradients'])) ? $_POST['reduce_gradients'] : 1;

include_once("inc/colors.inc.php");
$ex=new GetMostCommonColors();

//$details = new Post();
//$details = $details->getPostDetails();



?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once ('inc/head.inc.php'); ?>
</head>
<body>

<?php include_once ('inc/nav.inc.php'); ?>

<section class="content">
    <?php foreach( $result as $result ): ?>
        <h1> <? echo $result['title']?> </h1>
        <img src="<?php echo 'images/uploads/'.$result['post_img'] ?>" alt="post_img" width="150px" height="auto" class="detail-img">
        <?php $colors=$ex->Get_Color('images/uploads/'.$result['post_img'], $num_results, $reduce_brightness, $reduce_gradients, $delta); ?>
    <?php endforeach; ?>


    <div id="wrap">

    <table>
    <tr id="color-title"><td>Color</td><td>Color Code</td><td>Percentage</td><td rowspan="<?php echo (($num_results > 0)?($num_results+1):22500);?>"></td></tr>
    <?php
    foreach ( $colors as $hex => $count )
    {
        if ( $count > 0 )
        {
            echo "<tr class='tr-colors'><td class='color'><div style=\"background-color:#".$hex.";\"></div></td><td class='color-code'>"."#".$hex."</td><td class='color-count' style='display: none; width: 0;'>$count</td></tr>";
        }
    }
    ?>
    </table>

    </div>
</section>
</body>
</html>