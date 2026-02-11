
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="css/register.css"> 
</head>
<body>
    <header>
    <div class="header-top">
        <a href="index.php">
            <img src="img/logo.jpg" alt="Blashskate Logo" class="logo">
        </a>
        
        <nav>
            <a href="shop.php">Comprar</a>
            <a href="sell.php">Vender</a>
            <a href="register.php">Regístrate</a>
        </nav>
    </div>

    
</header>
    <form id="registroForm">
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

