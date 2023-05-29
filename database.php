<?php
$host="localhost";
$db="twitter";
$user="root";
$pass="";

try {
    $database=new PDO("mysql:host=$host;dbname=$db", $user, $pass);
}   catch (PDOException $ex) {
    die("Erreur:" . $ex->getMessage());
}