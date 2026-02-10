<?php
if ($_POST) {
    echo "<p>Registro enviado correctamente</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <div class="card">
        <h2>Registro</h2>

        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellidos" placeholder="Apellidos">
            <input type="email" name="correo" placeholder="Correo" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="tel" name="telefono" placeholder="Teléfono">
            <button>Registrarse</button>
        </form>
    </div>
</div>

</body>
</html>
