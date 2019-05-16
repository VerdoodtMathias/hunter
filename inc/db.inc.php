<?php


try {
    $conn = new PDO('mysql:host=localhost; dbname=inspiration', 'root', 'root');
} catch (Exception $e) {
    die("Something went wrong.");
}

