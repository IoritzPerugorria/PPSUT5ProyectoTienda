<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Blashskate | Tienda de Skates</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<header>
    <div class="header-top">
        <a href="index.html">
            <img src="img/logo.jpg" alt="Blashskate Logo" class="logo">
        </a>
        
        <nav>
            <a href="shop.php">Comprar</a>
            <a href="sell.php">Vender</a>
            <a href="login.php">Login</a>
        </nav>
    </div>

    
</header>


<div class="container">
    <div class="hero">
        <h2>BLASHSKATE</h2>
        <p>Skates urbanos y street: diseñados por ti, armados por expertos.</p>
    </div>

    <div class="login-box">
        <h3 class="login-title">Iniciar sesión</h3>

        <form action="login.php" method="POST">
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar sesión</button>
        </form>

        <p class="register-text">
        ¿No tienes cuenta?
        <a href="register.php">Regístrate</a>
        </p>
    </div>
<div class="social">
    <span>@blashskate_</span>
    <a href="https://www.instagram.com/blashskate_" target="_blank">Instagram</a>
    <a href="https://www.facebook.com/blashskate_" target="_blank">Facebook</a>
    <a href="https://www.youtube.com/@blashskate_" target="_blank">YouTube</a>
    <a href="https://x.com/blashskate_" target="_blank">X</a>
</div>

</div>

</body>
</html>
