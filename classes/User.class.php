<?php
    class User {
        private $email;
        private $username;
        private $fullname;
        private $password;
        private $newPassword;
        private $bio;
        private $image;
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        /**
         * Get the value of email
         */ 
        public function getEmail() {
            return strtolower($this->email);
        }

        /**
         * Set the value of email
         * @return  self
         */ 
        public function setEmail($email) {
            //validate email

            // Remove all illegal characters from email
            $email = filter_var($email, FILTER_SANITIZE_EMAIL); 
            //check if not empty
            if(empty($email)) {
                throw new Exception("Email cannot be empty."); 
            }
            //check if contains @ and .
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                throw new Exception("Please fill in correct email."); 
            }
            $this->email = $email;
            return $this;
        }

        /**
         * Get the value of username
         */ 
        public function getUsername() {
                return strtolower($this->username);
        }

        /**
         * Set the value of username
         * @return  self
         */ 
        public function setUsername($username) {
                //validate username

                //check if not empty
                if(empty($username)){
                     throw new Exception('Please fill in username');   
                }
                $this->username = $username;
                return $this;
        }

        
        /**
         * Get the value of fullname
         */ 
        public function getFullname()
        {
                return $this->fullname;
        }

        /**
         * Set the value of fullname
         *
         * @return  self
         */ 
        public function setFullname($fullname)
        {
                if(empty($fullname)){
                        throw new Exception ("Please check all fields. Password must be at least 6 characters.");
                }

                // check for valid name
                else if(!preg_match("/^[a-zA-Z ]*$/",$fullname)) {
                     throw new Exception("Please Only use letters and whitespace");
                }
                $this->fullname = $fullname;

                return $this;
        }

        /**
         * Get the value of password
         */ 
        public function getPassword() {
                return $this->password;
        }

        /**
         * Set the value of password
         * @return  self
         */ 
        public function setPassword($password) {
                if(empty($password)) {
                    throw new Exception("The old password input cannot be empty");
                }
                $this->password = $password;
                return $this;
        }

        /**
         * Get the value of newPassword
         */ 
        public function getNewPassword() {
                return $this->newPassword;
        }

        /**
         * Set the value of newPassword
         * @return  self
         */ 
        public function setNewPassword($newPassword) {
                if(empty($newPassword)) {
                    throw new Exception("The new password input cannot be empty");
                }
                if(strlen($newPassword) <= 6) {
                    throw new Exception("The new password must be minimum 7 characters long");
                }
                $this->newPassword = $newPassword;
                return $this;
        }

        /**
         * Get the value of bio
         */ 
        public function getBio() {
                return $this->bio;
        }

        /**
         * Set the value of bio
         * @return  self
         */ 
        public function setBio($bio) {
                $this->bio = $bio;
                return $this;
        }

        /**
         * Get the value of image
         */ 
        public function getImage() {
            return $this->image;
        }

        /**
         * Set the value of image
         *
         * @return  self
         */ 
        public function setImage($image) {
            $this->image = $image;
            return $this;
        }


        ////////////////////////////////////////////////////
        ////////////////// Registration ////////////////////
        ////////////////////////////////////////////////////

        /**
         * Registers a user into the database
         * @return true if succesfull 
         * @return false if unsuccessful  
         */

        public function register() {
            // connection and query
            $statement = $this->db->prepare("
                INSERT INTO users
                (username, email, fullname, password)
                VALUES (:username, :email, :fullname, :password)
            ");

            $hash = password_hash($this->getPassword(), PASSWORD_DEFAULT);

            $statement->bindValue(":username", $this->getUsername());
            $statement->bindValue(":fullname", $this->getFullname());
            $statement->bindValue(":email", $this->getEmail());
            $statement->bindValue(":password", $hash);
    
            // execute
            $result = $statement->execute();

            // give return 
            return $result;
            
        }

        //check if email is in use
        public function emailAvailable(){
                // connection and query email 
                $statement_e = $this->db->prepare("
                SELECT * FROM users WHERE email ='".$this->getEmail()."'
                ");
                $result_e = $statement_e->execute();

                //check if email is already in database
                if(($statement_e->rowCount())>0){
                        throw new Exception("Email already in use!"); //not in use 
                }
                return true; //already in use
        }

        //check if username is in use
        public function userAvailable(){
                // connection and query email 
                $statement_u = $this->db->prepare("
                SELECT * FROM users WHERE username ='".$this->getUsername()."'
                ");
                $result_u = $statement_u->execute();
                
                //check if email is already in database
                if(($statement_u->rowCount())>0){
                        throw new Exception("Username already in use!"); //not in use
                }
                return true; //already in use
        }

        ////////////////////////////////////////////////////
        ////////////////////// Login ///////////////////////
        ////////////////////////////////////////////////////

        //check if user can login
        public function canILogin($email, $password){
                // connection and query
                $statement = $this->db->prepare("
                SELECT * FROM users WHERE username = :username
                ");
                $statement->bindValue(':username',$this->getUsername());
                $statement->execute();

                $result = $statement->fetch(PDO::FETCH_ASSOC);
                if(password_verify($this->password, $result['password'])){
                        return true;
                }
                else
                {
                    throw new Exception("Username and password do not match. Please try again."); //login failed
                }
        }

        public function login() {
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['username'] = $this->getUsername();
            header("Location: index.php?sort=followers");
        }

        # authenticate if user is loggedin
        public static function authenticate() {
            if(!isset($_SESSION)) {
                session_start();
            }
            if(!isset($_SESSION['username'])) {
                header("Location: login.php");
            }
        }

        ////////////////////////////////////////////////////
        ////////////// Account settings ////////////////////
        ////////////////////////////////////////////////////

        public function resizeAvatar($max_width = 100, $max_height = 100, $quality = 80) {
            $fileActualExt = $this->getActualFileExtention();
            $fileNewName = $this->getFileNewName($fileActualExt);
            $source_file = "users/avatars/".$fileNewName;
            $dst_dir = "users/avatars/".$fileNewName;
            $imgsize = getimagesize($source_file);
            $width = $imgsize[0];
            $height = $imgsize[1];
            $mime = $imgsize['mime'];
         
            switch($mime){
                case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = 7;
                break;
         
                case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = 80;
                break;
         
                default:
                return false;
                break;
            }
             
            $dst_img = imagecreatetruecolor($max_width, $max_height);
            $src_img = $image_create($source_file);
             
            $width_new = $height * $max_width / $max_height;
            $height_new = $width * $max_height / $max_width;
            //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
            if($width_new > $width){
                //cut point by height
                $h_point = (($height - $height_new) / 2);
                //copy image
                imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
            }else{
                //cut point by width
                $w_point = (($width - $width_new) / 2);
                imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
            }
            
                // integer representation of the color black (rgb: 0,0,0)
                $background = imagecolorallocate($dst_img , 0, 0, 0);
                // removing the black from the placeholder
                imagecolortransparent($dst_img, $background);
                $image($dst_img, $dst_dir, $quality);
                
                if($dst_img)imagedestroy($dst_img);
                if($src_img)imagedestroy($src_img);
        }

        private function getActualFileExtention() {
            $image_path = "users/avatars" . basename($_FILES['avatar']['name']);
            // get the extention from the uploaded image (.jpg, .png, etc)
            $mime = pathinfo($image_path,PATHINFO_EXTENSION);
            // bring the extention to lowercases (because .jpg can also be .JPG)
            $fileActualExt = strtolower($mime);
            // return file extention
            return $fileActualExt;
        }

        private function getFileNewName($fileActualExt) {
            // prevent that 2 files with the same name will override each other
            $fileNameNew = md5($_SESSION['username']).".".$fileActualExt;
            return $fileNameNew;
        }

        public function setAvatar() {
            $fileActualExt = $this->getActualFileExtention();
            $fileNewName = $this->getFileNewName($fileActualExt);
            $fileTmpName = $_FILES['avatar']['tmp_name'];
            // a list of image extentions we want to allow to be uploaded
            $allowed = array('jpg', 'jpeg', 'png');
            // check if the uploaded image has one of the allowed extentions
            if (in_array($fileActualExt, $allowed)) {
                // prepare the destination where the uploaded image will be moved to
                $fileDestination = 'users/avatars/'.$fileNewName;
                // delete old image
                $filename = "users/avatars/".md5($_SESSION['username'])."*";
                $fileinfo = glob($filename);
                if(!empty($fileinfo)) {
                    $this->deleteAvatar();
                }
                // upload the file from the temporary destination to the correct destination
                move_uploaded_file($fileTmpName, $fileDestination);
                // change avatar status from 0 to 1
                $statement = $this->db->prepare("update users set avatar_status = 1, avatar = :avatar where username = '".$_SESSION['username']."';");
                $statement->bindValue(":avatar", $fileDestination);
                $statement->execute();
            } else {
                throw new Exception("You cannot upload files of this type!");
            }
        }

        public function deleteAvatar() {
            // Select the image
            $filename = "users/avatars/".md5($_SESSION['username'])."*";
            $fileinfo = glob($filename);
            // check if an image exists
            if(!empty($fileinfo)) {
                $fileext = explode(".", $fileinfo[0]);
                $fileactualext = $fileext[1];
                $file = "users/avatars/".md5($_SESSION['username']).".".$fileactualext;
                // delete the image
                if(!unlink($file)) {
                    throw new Exception("Image was not deleted");
                }
            } else {
                throw new Exception("There is no image to delete");
            }
            $statement = $this->db->prepare("update users set avatar_status = 0, avatar = :avatar where username = '".$_SESSION['username']."';");
            $statement->bindValue(":avatar", "");
            $statement->execute();
        }

        public static function getAvatar() {
            // Select the correct image name 
            $avatarPath = "users/avatars/".md5($_SESSION['username'])."*";
            $avatarInfo = glob($avatarPath);
            $fileext = explode(".", $avatarInfo[0]);
            $fileactualext = $fileext[1];
            return "<img class='avatar' src='users/avatars/".md5($_SESSION['username']).".".$fileactualext."?".mt_rand()."'>";
        }

        public function updateProfile() {
            $statement = $this->db->prepare("update users set fullname = :name, email = :email, bio = :bio where username = '".$_SESSION['username']."';");
            $statement->bindValue(":name", $this->fullname);
            $statement->bindValue(":email", $this->email);
            $statement->bindValue(":bio", $this->bio);
            $statement->execute();
        }

        private function checkOldPassword() {
            $statement = $this->db->prepare("select * from users where username = '".$_SESSION['username']."';");
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if(password_verify($this->getPassword(), $result['password'])) {
                return true;
            } else {
                return false;
            }
        }

        public function updatePassword() {
            if(!$this->checkOldPassword()) {
                throw new Exception("Your old password is incorrect");
            }
            $statement = $this->db->prepare("update users set password = :newpassword where username = '".$_SESSION['username']."';");
            $hash = password_hash($this->getNewPassword(), PASSWORD_DEFAULT);
            $statement->bindValue(":newpassword", $hash);
            $statement->execute();
        }

        ////////////////////////////////////////////////////
        ////////////// General User Info ///////////////////
        ////////////////////////////////////////////////////

        public function getUserId($username) {
            $statement = $this->db->prepare("select * from users where username = '".$username."';");
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $userId = $result['id'];
            return $userId;
        }

        public function getUserResults($username) {
            $statement = $this->db->prepare("select * from users where username = '".$username."';");
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

    }

    
?>