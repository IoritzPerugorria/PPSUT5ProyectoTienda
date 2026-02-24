<?php
$host = 'localhost';
$user = 'root'; // XAMPP default
$pass = '';     // XAMPP default
$db = 'blashskate';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>