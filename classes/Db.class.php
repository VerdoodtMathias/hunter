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