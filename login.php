<?php
include_once ('classes/Login.class.php');
// test
if (!empty($_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $login = new Login();
    $login->setUsername($username);
    $login->setPassword($password);
    $login->canLogin();
    if (!$login->canLogin()) {
        $error = "";
    }

}

?><!doctype html>
<html lang="en">
<head>
    <title>Login - Inspiration Hunter</title>
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
    <img src="images/logotext.svg" alt="">
    <h1>Login</h1>
    <br>
    <?php if (isset($error)): ?>
        <div class="form_error">Username and Password don't match.</div>
    <?php endif; ?>
    <label for="username">Username</label>
    <br>
    <input type="text" name="username" id="username">
    <br>

    <label for="password">Password</label>
    <br>
    <input type="password" name="password" id="password">
    <br>

    <input type="submit" value="Login">
    <br>
    
    <a href="register.php">No account yet? Create account.</a>
</form>



</body>
</html>