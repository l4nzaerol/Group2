<?php
$host = "localhost";
$dbname = "taskkmanagement";
$username = "root"; // Change this if needed
$password = "040604"; // Change this if needed

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>