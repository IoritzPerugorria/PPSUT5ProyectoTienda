<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellidos = $conn->real_escape_string($_POST['apellidos']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (nombre, apellidos, correo, telefono, password) VALUES ('$nombre', '$apellidos', '$correo', '$telefono', '$hashed_password')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registro exitoso. Inicia sesión.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Las contraseñas no coinciden.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro | Blashskate</title>
    <link rel="stylesheet" href="../css/register.css"> 
</head>
<body>
    <header>
    <div class="header-top">
        <a href="index.php"><img src="img/logo.jpg" alt="Blashskate Logo" class="logo"></a>
        
        <form class="search-container" method="GET" action="shop.php">
            <input type="text" id="searchInput" name="search" placeholder="Buscar productos..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit" style="display:none;">Buscar</button>
        </form>
        
        <nav>
            <a href="shop.php">Comprar</a>
            <a href="sell.php">Vender</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="profile.php"><?= htmlspecialchars($_SESSION['username']) ?></a>
            <?php else: ?>
                <a href="register.php">Regístrate</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
    <form id="registroForm" method="POST" action="register.php">
        <h2>Registrarse</h2>
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellidos" placeholder="Apellidos" required>
        <input type="email" name="correo" placeholder="Correo" required>
        <input type="tel" name="telefono" placeholder="Número de teléfono" required>
        <input type="password" name="password" id="password" placeholder="Contraseña" required>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Repetir contraseña" required>
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>