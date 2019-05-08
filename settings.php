<?php
include_once("classes/Db.class.php");
include_once("classes/User.class.php");
session_start();

// NOG TIMESTAMP TOEVOEGEN!!

if (!isset($_SESSION['username'])) {
    header('location: login.php');
}
if(!empty($_POST)){

    $u = new User();
    // $u->Password= $_POST['oldPassword'];
    $username = $_SESSION['username'];
    $newusername = $_POST['username'];
    $bio = $_POST['bio'];

    $user_img = "";
    $destFile = "";

    $fotonaam = $_FILES['profilePicture']['tmp_name'];
    if (!empty($fotonaam)) {$foto = file_get_contents($fotonaam);}

    $temp = explode(".", $_FILES['profilePicture']['name']);
    $newfilename = round(microtime(true)) . '.' . end($temp);
    $foto = $newfilename;

    $user_img = $foto;

    $newpassword = "";
    if(!empty($_POST['newPassword'])) {
        $newpassword = $_POST['newPassword'];
    }

    define ('SITE_ROOT', realpath(dirname(__FILE__)));

    $result = $u->changeSettings($username, $newusername, $bio, $user_img, $newpassword);
    if($result === true){

        if ($fotonaam != NULL){
            $destFile = __DIR__ . '/images/uploads/avatar/' . $user_img;
            move_uploaded_file($_FILES['profilePicture']['tmp_name'], $destFile);
            chmod($destFile, 0666);
        }

        //echo "De gegevens zijn succesvol aangepast, gelieve terug in te loggen met de nieuwe gegevens";
        session_destroy();
        header('location: login.php');
    }else{
        echo $result;
    }
}
$conn =  Db::getInstance();
$statement = $conn->prepare("SELECT * FROM users WHERE username = '" .$_SESSION['username']."'");
//$statement->bindValue(":username",$this->username);
$statement->execute();
if( $statement->rowCount() > 0){
	$user = $statement->fetch(); // array van resultaten opvragen
}


?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include_once ('inc/head.inc.php'); ?>
    <title>InspirationHunter Settings</title>
    <link rel="stylesheet" href="css/style.css">
	
</head>

<body>
<?php include_once ('inc/nav.inc.php'); ?>

<section class="content">
<h1> Edit account:  </h1>

<div style="margin:20px 10px 10px 10px; padding:25px;border-radius:7px;background-color:rgba(93,180,205,0.25);box-shadow: 0 2px 3px rgba(0,0,0,.16);color:#0781ad;border:solid 1px #0781ad;opacity:0.66;">
    Warning: For security reasons, editing your account details will require you to log in again. 
</div>

    <section class="login-form-wrap3">

        <form class="password-form" method="POST" action="" enctype="multipart/form-data" id="upload-form">
            <label>username :
                <input class="textbox" type="text" name="username" value=<?php echo $user['username'] ?> >
            </label><br />
            <label>Bio :
                <input class="textbox" type="text" name="bio" value=<?php echo $user['bio'] ?> >
            </label><br />

            <label for="profilePicture">My Profile Picture</label>
            <br>
            <div id="prev-div">
                <figure class="<?php $_POST['filter'] ?>">
                    <img id="img-prev" src="#" alt="uploaded image" />
                </figure>
                <br>
            </div>
            <input type="file" name="profilePicture" id="profilePicture" accept="image/gif, image/jpeg, image/png, image/jpg" onchange="readURL(this);"><br />
            <img id="imgPreview" src="img.php" alt="" style="height: 200px;" />
            <br>

            <label>New password:</label> 
            <br>
            <input class="textbox" type="password" name="newPassword" placeholder="">
            <br>
            <br>
            <input class="buttonReset" type="submit" value="Submit">
        </form>
    </section>

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

    getLocationName();

    function showFilter() {
        var x = document.getElementById("upload-filter").value;
        document.getElementsByTagName("figure")[0].setAttribute("class", x);
    }

</script>


</body>

</html>