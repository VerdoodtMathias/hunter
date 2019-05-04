<!--

Password verify is een EXAMENVRAAG. 
BCrypt is een EXAMENVRAAG. 

-->

<?php
	
if ( !empty ($_POST) ) {

// Email en wachtwoord opvragen
$email = $_POST['email'];
$password = $_POST['password'];

// Hash opvragen op basis van email
$conn = new PDO("mysql:host=localhost;dbname=netflix;", "root", "root", null);

// Check of rehash van password gelijk is aan hash uit db 
// Select * from users where email = 'sarah'
// Alles wat van de gebruiker komt moet je beveiligen!
$statement = $conn->prepare("select * from users where email = :email "); 
// Door dubbelpunt komt het niet rechtstreeks van gebruiker maar gaat het via PDO
$statement->bindParam(":email", $email); 
$result = $statement->execute();

$user = $statement->fetch(PDO::FETCH_ASSOC);
var_dump($user);

// assoc is een kolomnaam
// num is met nummertjes
// both is nummers en kolomnaam

if ( password_verify($password, $user['password']) ){
// cost en random salt zich in je hash
// verify is kijken of het overeen komt

// ja -> login
echo "Top"; 
session_start();
$_SESSION['userid'] = $user['id'];
header('Location:index.php');
}
// nee -> error
else {
echo "Fout";
}

// wat je nog moet kennen is password_verify
// http://php.net/manual/en/function.password-verify.php
}

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>IMDFlix</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="netflixLogin">
<div class="form form--login">
<form action="" method="post">
<h2 form__title>Sign In</h2>

		<!-- een error -->
		<?php if (isset($error)): ?>
		<div class="form__error">
		<p>
		Sorry, we can't log you in with that email address and password. Can you try again?
		</p>
		</div>
		<?php endif; ?>

		<!-- een form maken -->
		<div class="form__field">
		<label for="Email">Email</label>
		<input type="text" name="email">
		</div>
		<div class="form__field">
		<label for="Password">Password</label>
		<input type="password" name="password">
		</div>

		<div class="form__field">
		<input type="submit" value="Sign in" class="btn btn--primary">	
		<input type="checkbox" id="rememberMe"><label for="rememberMe" class="label__inline">Remember me</label>
		</div>

		<div>
		<p>No account yet?<a href="register.php">Sign up here</a></p>
		</div>
		</form>
		</div>
	</div>
</body>
</html>