<?php
    include_once ('inc/session_check.inc.php');
    include_once ('classes/Post.class.php');

if (!empty($_POST)){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_FILES['upload_file']['name'];
    $city = htmlspecialchars($_POST['city']);
    $filter = $_POST['filter'];
    //$tags = $_POST['tags'];
    $time = "";

    $temp = explode(".", $_FILES['upload_file']['name']);
    $newfilename = round(microtime(true)) . '.' . end($temp);
    $image = $newfilename;


    $user_id = $_SESSION['user_id'];

    try {
        if (!empty($image) && !empty($description) && !empty($title) /*&& !empty($tags)*/) {

            $post = new Post();
            $post->setImage($image);
            $post->setFilter($filter);
            $post->setDescription($description);
            $post->setUserId($user_id);
            $post->setTitle($title);
            $post->setTime($time);
            $post->setCity($city);
            //$post->setTags($tags);

            define ('SITE_ROOT', realpath(dirname(__FILE__)));

            if ($post->SavePost()) {

                $filetmp = $_FILES["upload_file"]["tmp_name"];
                $filename = $image;

                $destFile = __DIR__ . '/images/uploads/' . $filename;
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
    <?php include_once ('inc/head.inc.php'); ?>
    <title>Upload Post - Picture Purrrfect</title>
</head>
<body>

<?php include_once ('inc/nav.inc.php'); ?>

<section class="content">
    <h1>Upload Post</h1>
    <form action="" method="post" enctype="multipart/form-data" id="upload-form">
        <?php if (isset($error)): ?>
            <div><?php echo $error; ?></div>
        <?php endif; ?>
        
        <label for="upload-title">Title</label>
        <br>
        <input type="text" name="title" placeholder="Title" id="upload-title">
        <br>


        <label for="upload-file">Image</label>
        <br>
        <div id="prev-div">
            <figure class="<?php $_POST['filter'] ?>">
            <img id="img-prev" src="#" alt="uploaded image" />
            </figure>
            <br>
        </div>
        <input type="file" name="upload_file"  accept="image/*" id="upload-file" onchange="readURL(this);">
        <br>

        <label for="upload-filter">Filter</label>
        <br>
        <select id="upload-filter" name="filter" placeholder="None" onchange="showFilter();">
            <option value="#nofilter">None</option>
            <option value="_1977">1977</option>
            <option value="aden">Aden</option>
            <option value="brannan">Brannan</option>
            <option value="brooklyn">Brooklyn</option>
            <option value="clarendon">Clarendon</option>
            <option value="earlybird">Earlybird</option>
            <option value="gingham">Gingham</option>
            <option value="hudson">Hudson</option>
            <option value="inkwell">Inkwell</option>
            <option value="kelvin">Kelvin</option>
            <option value="lark">Lark</option>
            <option value="lofi">Lo-Fi</option>
            <option value="maven">Maven</option>
            <option value="mayfair">Mayfair</option>
            <option value="moon">Moon</option>
            <option value="nashville">Nashville</option>
            <option value="perpetua">Perpetua</option>
            <option value="reyes">Reyes</option>
            <option value="rise">Rise</option>
            <option value="slumber">Slumber</option>
            <option value="stinson">Stinson</option>
            <option value="toaster">Toaster</option>
            <option value="valencia">Valencia</option>
            <option value="walden">Walden</option>
            <option value="willow">Willow</option>
            <option value="xpro2">X-pro II</option>
        </select>
        <br>
        <br>

        <label for="upload-desc">Description</label>
        <br>
        <input type="text" name="description" placeholder="Description" id="upload-desc">
        <br>

        <!--<label for="upload-tags">Tags</label>
        <br>
        <input type="text" name="tags" placeholder="tag1,tag2,..." id="upload-tags">
        <br>-->


        <input type="hidden" id="city" name="city" value="unknown location" />

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

    // getLocationName();

    function showFilter() {
        var x = document.getElementById("upload-filter").value;
        document.getElementsByTagName("figure")[0].setAttribute("class", x);
    }

</script>
<script language="javascript" type="text/javascript">

    var loc = document.getElementById("city");
    var url = "";
    var lat = "";
    var lon = "";

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            loc.innerHTML = "Geolocation is not supported by this browser.";
        }
    }
    function showPosition(position) {
        lat = position.coords.latitude;
        lon = position.coords.longitude;

        getCityFromPosition(lat, lon);
    }

    function getCityFromPosition(lat, lon){
        url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + lat + "," + lon + "&sensor=false&key=AIzaSyCVvQeila2uW_EHtmzE3Ol34HH5XWyXc7A";

        window.jQuery.ajax({
            url: url,
            dataType: "json",
            success: function (data) {
                loc.value = data.results[0].address_components[2].long_name;
            }
        });
    }

    $( document ).ready(function() {
        getLocation();
    });

</script>


</body>
</html>