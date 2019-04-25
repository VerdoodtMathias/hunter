<?
    require_once("bootstrap.php");

    

if (!empty($_POST)){
    $description = $_POST['description'];
    $picture = $_POST['picture'];
    
    try {
        if (!empty($picture) && !empty($description)) {
            $post = new Post();
            $post->setPicture($picture);
            $post->setDescription($description);

            if ($post->SavePost()) {
                
                header('location: index.php');
            } else {
                $error = "Something went wrong";
            }
        } else {
            $error = "Leave no empty fields!";
        }
    } catch (Exception $e) {
        die("The site is down.");
    }
}
?><!doctype html>
<html lang="en">
<head>
    <title>Upload Post - Hunter</title>
</head>
<body>


<section class="content">
    <h1>Upload Post</h1>
    <form action="" method="post" id="upload-form">
        <?php if (isset($error)): ?>
            <div><?php echo $error; ?></div>
        <?php endif; ?>

        <label for="picture">Image</label>
        <input type="file" name="picture" id="picture">
        <br>
        

        <label for="upload">Description</label>
        <br>
        <input type="text" name="description" placeholder="Description" id="upload">
        <br>

        <input type="submit" name="submit" value="Upload">
    </form>

</section>



</body>
</html>