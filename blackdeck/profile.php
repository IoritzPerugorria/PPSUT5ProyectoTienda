<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>BlackDeck | Tienda de Skates</title>
    <link rel="stylesheet" href="css/sell.css">
</head>

<body>

<header>
    <div class="header-top">
        <a href="index.html">
            <img src="img/logo.jpg" alt="BlackDeck Logo" class="logo">
        </a>
        
        <nav>
            <a href="shop.php">Comprar</a>
            <a href="sell.php">Vender</a>
            <a href="login.php">Login</a>
            <a href="profile.php">Perfil</a>
        </nav>
    </div>

</header>

    <form id="registroForm">
        <h2>Editar perfil</h2>
        
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellidos" placeholder="Apellidos" required>
        <input type="email" name="correo" placeholder="Correo" required>
        <input type="tel" name="telefono" placeholder="Número de teléfono" required>
        <input type="password" name="password" id="password" placeholder="Contraseña" required>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Repetir contraseña" required>
        <button type="submit">Confirmar Cambios</button>
    </form>
</body>
</html>

