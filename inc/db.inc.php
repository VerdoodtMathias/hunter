<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 08/03/2018
 * Time: 15:58
 */

try {
    $conn = new PDO('mysql:host=localhost; dbname=inspiration', 'root', 'root');
} catch (Exception $e) {
    die("Something went wrong.");
}

