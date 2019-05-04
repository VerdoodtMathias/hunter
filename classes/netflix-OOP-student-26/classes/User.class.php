<?php
    class User{
        // Waarom private, getter, setter ipv enkel public? 
        // Public werkt maar niets nakijken > vb. email aankijken in db of hij bestaat.
        
        // EXAMENVRAAG we gebruiken private want met public kan je niet checken of een email geldig is of al bestaat
        private $email;
        private $password;
        private $passwordConf;

        /* Set the value of email
         * @return  self
         */ 
        public function setEmail($p_sEmail){
        $this->email = $p_sEmail;
        //return $this; // Waarom heel huidig object terug geven? Extra mogelijkheid
         // This verwijst naar huidig object en daarvan het object email
        }
        // Get the value of email
        public function getEmail(){
        return $this->email;     
        // This is huidig object en daarvan email 
        }
    

    public function register(){
    
        $options = [
        'cost' => 12, 	// 2^12 = 4096 keer / cost factor is het aantal keren dat het pw gehashed wordt // md5 = VEEL te snel // TRAAG = GOED
        ];	// + salt wordt zwz random meegegeven
        $password = password_hash($this->password, PASSWORD_DEFAULT, $options);		// PASSWORD_DEFAULT = constante 
        
        try {			
        // systeem: mysql // 
        // hier connectie leggen
    
            
        $conn = new PDO("mysql:host=localhost; dbname=netflix;", "root", "root");	// Nooit root online gebruiken
            
        $statement = $conn -> prepare("INSERT into users (email, PASSWORD) VALUES(:email, :password)");	// :varName = veilig
        $statement -> bindParam(":email", $this->email);	// $statement mag meerdere objecten in toevoegen
        $statement -> bindParam(":password", $password); // MAG GEEN THIS  / DAN ONGEHASH WW
        $result = $statement -> execute(); 
        // run de $statement	 
        return $result;
        } catch (Throwable $t ) { 					
        // Exception $e mag ook nog maar is verouderd 
        return false;
        }
  
    }
}

// Bcrypt uitleggen op EXAMEN
// Het is niet altijd beter als het sneller gaat, trager is beter! Je gaat de gebruiker bewust vertragen
// http://php.net/manual/en/function.password-hash.php
// Uw options gaan het trager laten gaan om dat je exponentieel (met machten) gaat werken waardoor aantal pogingen per uur dalen
// In Bycrypt zit standaard een random salt 
// https://medium.com/@danboterhoven/why-you-should-use-bcrypt-to-hash-passwords-af330100b861

?>