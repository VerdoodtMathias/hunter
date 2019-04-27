<?php
    require_once("bootstrap.php");

if (!empty($_POST)){

    $description = $_POST['description'];
    $image = $_FILES['upload_file']['name'];

    $temp = explode(".", $_FILES['upload_file']['name']);
    $newfilename = round(microtime(true)) . '.' . end($temp);
    $image = $newfilename;

    try {
        if (!empty($image) && !empty($description)) {
            $post = new Post();
            $post->setImage($image);
            $post->setDescription($description);

            define ('SITE_ROOT', realpath(dirname(__FILE__)));
            if ($post->SavePost()) {
                $filetmp = $_FILES["upload_file"]["tmp_name"];
                $filename = $image;
                $destFile = __DIR__ . '/img/uploads/' . $filename;
                move_uploaded_file($_FILES['upload_file']['tmp_name'], $destFile);
                chmod($destFile, 0666);
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

    <title>Upload Post</title>
</head>
<body>

<section class="content">
    <h1>Upload Post</h1>
    <form action="" method="post" enctype="multipart/form-data" id="upload-form">
        <?php if (isset($error)): ?>
            <div><?php echo $error; ?></div>
        <?php endif; ?>


        <label for="upload-file">Image</label>
        <br>
        <div id="prev-div">
            <img id="img-prev" src="#" alt="uploaded image" />
            <br>
        </div>
        <input type="file" name="upload_file"  accept="image/*" id="upload-file" onchange="readURL(this);">
        <br>
        <br>

        <label for="upload-desc">Description</label>
        <br>
        <input type="text" name="description" placeholder="Description" id="upload-desc">
        <br>

        <input type="submit" name="submit" value="Upload">
    </form>
    <input type="text" id="error" style="display: none">
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $('#prev-div').hide();
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#prev-div').show();
                $('#img-prev').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>

</body>
</html>