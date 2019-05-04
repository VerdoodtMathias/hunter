<?php
    class Security{
        public $password;
        public $passwordConfirmation;

        //check if passowords are secure
        public function passwordsAreSecure(){
            if($this->passwordIsStrongEnough()
               && $this->passwordsAreEqual() ){
                return true;
            }
            else{
                throw New Exception("Please check email, username and password again. Password must be at least 6 characters.");
            }
        }

        //check if password is long enough
        private function passwordIsStrongEnough(){
            if(strlen($this->password) <= 6){
                return false;
            }
            else{
                return true;
            }
        }

        //check if passwords are equal 
        private function passwordsAreEqual(){
            if($this->password == $this->passwordConfirmation){
                return true;
            }
            else{
                return false;
            }
        }
    }

?>