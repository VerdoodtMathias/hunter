<?php

spl_autoload_register(function($class) {
    include_once("classes/" . $class . ".class.php");
});

//nakijken of formulier verzonden is
if(!empty($_POST)){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];

    try{
        $security = new Security();
        $security->password = $_POST['password'];
        $security->passwordConfirmation = $_POST['password_confirmation'];

       //nakijken of de wachtwoorden correct zijn
       if($security->passwordsAreSecure() ){
        // start database connection
        $db = Db::getInstance();

        $user = new User($db);
        $user->setUsername($username);
        $user->setFullname($fullname);
        $user->setEmail($email);
        $user->setPassword($password);
        //check if email is in use
            if($user->emailAvailable()){
                //check if username is already in use
                if($user->userAvailable()){
                    //register user
                    if($user->register()){
                        $user->login();
                    }
                }
            }
        }
    }
    catch(Exception $e){
        $error = $e->getMessage();
    }
    
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php if(!empty($error)): ?>
        <div class="profile__change__msg profile__change__msg--error">
            <p><?php echo $error ?></p>
        </div>
    <?php endif; ?>
    <div class="pinsightLogin pinsightLogin--register">
      <div class="form form--login">
       
        <form action="" method="post">
            <h2 form__title>Join us</h2>
            <div class="form__field">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Your email" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : ''); ?>">
            </div>
            <div class="form__field">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" placeholder="Full name" value="<?php echo (isset($_POST['fullname']) ? $_POST['fullname'] : ''); ?>">
            </div>
            <div class="form__field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="User name" value="<?php echo (isset($_POST['username']) ? $_POST['username'] : ''); ?>">
            </div>
            <div class="form__field">
                <label class="link" for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" value="<?php echo (isset($_POST['password']) ? $_POST['password'] : ''); ?>">
            </div>
            <div class="form__field">
                <label for="password_confirmation">Confirm your password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat password"  value="<?php echo (isset($_POST['password_confirmation']) ? $_POST['password_confirmation'] : ''); ?>">
            </div>
            <div class="form__field">
                <input type="submit" value="Sign me up" class="btn btn--primary" name="register">
            </div>
            <p class="link">Already have a account? <a href="login.php">Login</a></p>
        </form>
      </div>
    </div>
</body>
</html>
