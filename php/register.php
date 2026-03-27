<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = substr($conn->real_escape_string($_POST['nombre']), 0, 100);
    $apellidos = substr($conn->real_escape_string($_POST['apellidos']), 0, 100);
    $correo = substr($conn->real_escape_string($_POST['correo']), 0, 150);
    $telefono = substr($conn->real_escape_string($_POST['telefono']), 0, 20);
    $password = substr($conn->real_escape_string($_POST['password']), 0, 255);
    $confirm_password = substr($conn->real_escape_string($_POST['confirm_password']), 0, 255);

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $email_query = $conn->query("SELECT * FROM users");

        $stopQuery = FALSE;

        if ($email_query->num_rows > 0) {
            while ($row = $email_query->fetch_assoc()) {
                $correoExistente = htmlspecialchars($row['correo']);
                if ($correoExistente == $correo) {
                    echo "<script>alert('Error: No se ha podido registrar al usuario');</script>";
                    $stopQuery = TRUE;
                    break;
                }
            }
        }
        
        if (!$stopQuery) {
            $sql = "INSERT INTO users (nombre, apellidos, correo, telefono, password) VALUES (?, ?, ?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) { //Cambiar formato de los mensajes (quitar echo)

                $stmt->bind_param("sssss", $nombre, $apellidos, $correo, $telefono, $hashed_password);
                $stmt->execute();

                echo "<script>alert('Registro exitoso. Inicia sesión.'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Error: Ha sucedido un error');</script>";
            }
            $stmt->close();
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
            <a href="index.php"><img src="../img/logo.jpg" alt="Blashskate Logo" class="logo"></a>

            <form class="search-container" method="GET" action="shop.php">
                <input type="text" id="searchInput" name="search" maxlength="100" placeholder="Buscar productos..."
                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="submit" style="display:none;">Buscar</button>
            </form>

            <nav class="header_nav">
                <a href="shop.php">Comprar</a>
                <a href="sell.php">Vender</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="profile.php"><?= htmlspecialchars($_SESSION['username']) ?></a>
                <?php else: ?>
                    <a href="register.php">Regístrate</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <form id="registroForm" method="POST" action="register.php">
        <h2>Registrarse</h2>
        <input type="text" name="nombre" placeholder="Nombre" maxlength="100" required>
        <input type="text" name="apellidos" placeholder="Apellidos" maxlength="100" required>
        <input type="email" name="correo" placeholder="Correo" maxlength="150" required>
        <input type="tel" name="telefono" placeholder="Número de teléfono" maxlength="20" required>
        <input type="password" name="password" id="password" placeholder="Contraseña" maxlength="255" required>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Repetir contraseña" maxlength="255" required>
        <button type="submit">Registrarse</button>
    </form>
</body>

</html>