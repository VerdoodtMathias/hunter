<?php

class Db {
    private static $conn;

    public static function getInstance() {
        if (self::$conn == null) {
            self::$conn = new PDO('mysql:host=localhost;dbname=bramwi1q_inspiration', 'bramwi1q_bramwi1q', 'Miamiheat0423');
            return self::$conn;
        } else {
            return self::$conn;
        }
    }
}