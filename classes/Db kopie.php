<!--<?php

    abstract class Db {
        private static $conn;

            public static function getInstance(){
                $config = parse_ini_file('config/config.ini');

                if(self::$conn != null){
                    return self::$conn;
                }
                else {
                    self::$conn = new PDO('mysql:host=localhost;dbname='.$config['db_name'], $config['db_user'], $config['db_password']);
                    return self::$conn;
                }

            }
        }

?>-->

<?php

class db
{
    private static $conn;
    public static function getInstance(){
       
        if( is_null( self::$conn ) ){
   
            
            self::$conn= new PDO('mysql:host=localhost; dbname=hunter', 'root', 'root', null);
            return self::$conn;
        } else {
            return self::$conn;
        }
    }
}
?>