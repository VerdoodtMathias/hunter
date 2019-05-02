<?php 

    require_once("bootstrap.php");

?>

<?php

    if (!empty($_POST)){
        $firstname = $_POST['first_name'];
        $lastname = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $city = $_POST['city'];
        
        try {
            if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password) && !empty($city)) {
                $profile = User::Update();
                $profile->setFirstname($firstname);
                $profile->setLastname($lastname);
                $profile->setEmail($email);
                $profile->setPassword($password);
                $profile->setCity($city);
    
                if ($profile->User()) {
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

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit User</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div id="body">
 <div id="content">
    <form method="post">
        <table>
            <th>
                Edit User
            </th>
            <tr>
                <td><input type="text" name="first_name" placeholder="First Name" value="<?php echo $profile['firstname']; ?>"  /></td>
            </tr>
            <tr>
                <td><input type="text" name="last_name" placeholder="Last Name" value="<?php echo $result['lastname']; ?>" /></td>
            </tr>
            <tr>
                <td><input type="text" name="email" placeholder="City" value="<?php echo $result['email']; ?>" /></td>
            </tr>
            <tr>
                <td><input type="text" name="password" placeholder="City" value="<?php echo $result['password']; ?>" /></td>
            </tr>
            <tr>
                <td><input type="text" name="city" placeholder="City" value="<?php echo $result['city']; ?>" /></td>
            </tr>
            <tr>
            <td>
                <button type="submit" name="btn-update"><strong>UPDATE</strong></button></td>
            </tr>
        </table>
    </form>
    </div>
</div>

</body>
</html>