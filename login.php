<?php

	spl_autoload_register(function($class) {
		include_once("classes/" . $class . ".class.php");
	});

	if(!empty($_POST)){
		$username= $_POST['username'];
		$password = $_POST['password'];
		try{
			// start database connection
			$db = Db::getInstance();
			$user = new User($db);
			$user->setUsername($username);
			$user->setPassword($password);
			if($user->canILogin($username, $password)){
				$user->login();
			}
			else{
				$error = true;
			}
		}
		catch(Exception $e){
			$error =$e->getMessage();
		}
	}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In</title>
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
	<div class="pinsightLogin">

		<div class="form form--login">
      
			<form action="" method="post">
				<h2 class="form__title">Log In</h2>

				<div class="form__field">
					<label for="username">Username</label>
					<input type="text" id="username" name="username" placeholder="Your Username">
				</div>
				<div class="form__field">
					<label for="password">Password</label>
					<input type="password" id="password" name="password" placeholder="Password">
				</div>
        <div class="form__field remember">
          <input type="checkbox" id="rememberMe">
          <label for="rememberMe" class="label__inline">Remember me</label>
        </div>
				<div class="form__field">
					<input type="submit" value="Sign in" class="btn btn--primary">
        </div>
				<p class="link">Not a member? <a href="register.php">Sign up now!</a></p>
			</form>
		</div>
	</div>
</body>
</html>
