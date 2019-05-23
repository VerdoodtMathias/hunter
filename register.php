<?php
include_once ('classes/Db.class.php');
include_once ('classes/User.class.php');

if (!empty($_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password-confirm'];

    if (!empty($username) && !empty($password) && $password == $passwordConfirm) {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->Save();
        if ($user->Save() == false) {
            $error = "Username already exists.";
        }
    } else {
        $error = "Please fill in all the fields.";
    }
}

?><!doctype html>
<html lang="en">
<head>
    <title>Register - Picture Purrrfect</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="images/logo.ico">

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/mobile-reset.css">
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/logreg.css">
</head>
<body>

<form action="" method="post" id="logreg_form">
    <img src="images/Picture%20Purrrfect.png" alt="">
    <h1>Register</h1>
    <br>
    <?php if (isset($error)): ?>
        <div class="form_error"><?php echo $error; ?></div>
    <?php endif; ?>
    <label for="username">Username</label>
    <br>
    <input type="text" name="username" id="username">
    <br>
    
    <label for="password">Password</label>
    <br>
    <input type="password" name="password" id="password">
    <br>

    <label for="password-confirm">Confirm Password</label>
    <br>
    <input type="password" name="password-confirm" id="password-confirm">
    <br>

    <input type="submit" value="Register">
    <br>
    
    <a href="login.php">Already have an account?</a>
</form>



</body>
</html>