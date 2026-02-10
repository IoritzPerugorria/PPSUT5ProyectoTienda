<?php
if ($_POST) {
    echo "<p>Login enviado</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <div class="card">
        <h2>Login</h2>

        <form method="POST">
            <input type="email" name="correo" placeholder="Correo">
            <input type="password" name="password" placeholder="Contraseña">
            <button>Entrar</button>
        </form>
    </div>
</div>

</body>
</html>
