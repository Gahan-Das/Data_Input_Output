<?php
$host = "localhost";
$db = "test";
$user = "root";    // your DB username
$pass = "";        // your DB password

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>