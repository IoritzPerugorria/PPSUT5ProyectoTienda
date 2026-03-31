<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = substr($_POST['email'], 0, 150);
    $password = substr($_POST['password'], 0, 255);

    $sql = "SELECT * FROM users WHERE correo = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['nombre'];
            $_SESSION['is_admin'] = $user['is_admin'];
            header("Location: profile.php");
            exit();
        } else {
            echo "<script>alert('Credenciales incorrectas'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Credenciales incorrectas'); window.location.href='index.php';</script>";
    }
}
?>