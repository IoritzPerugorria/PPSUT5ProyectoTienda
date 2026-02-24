<?php
session_start();
require 'db.php';

// Redirigir si no está logueado
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Debes iniciar sesión para vender'); window.location.href='index.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $skate = $conn->real_escape_string($_POST['skate']);
    $precio = $_POST['precio'];
    $anchura = $_POST['anchuras'];
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    
    // Subida de imagen
    $target_dir = "uploads/";
    $image_name = basename($_FILES["avatar"]["name"]);
    $target_file = $target_dir . time() . "_" . $image_name;
    
    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO products (user_id, skate, precio, anchuras, descripcion, imagen) 
                VALUES ('$user_id', '$skate', '$precio', '$anchura', '$descripcion', '$target_file')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Producto subido exitosamente'); window.location.href='profile.php';</script>";
        }
    } else {
        echo "<script>alert('Error al subir la imagen');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>BlackDeck | Vender</title>
    <link rel="stylesheet" href="css/sell.css">
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
<div class="container">
    <div class="card">
        <h2>Vender tu skate</h2>
        <form class=sellform method="POST" action="sell.php" enctype="multipart/form-data">
            <input type="text" name="skate" placeholder="Nombre del skate" required>
            <br/>
            <input type="number" step="0.01" name="precio" placeholder="Precio (en Euros)" required>
            <br/>
            <label>Elija la anchura del producto</label>
            <select name="anchuras" id="anchuras" required>
                <option value="7.75">7.75"</option>
                <option value="8.0">8"</option>
                <option value="8.125">8.125"</option>
                <option value="8.25">8.25"</option>
            </select>
            <br/>
            <textarea name="descripcion" placeholder="Descripción" required></textarea>
            <br/>
            <label for="avatar">Suba una foto del producto</label>
            <input type="file" id="avatar" name="avatar" accept=".jpg, .jpeg, .png, .webp" required>
            <br/>
            <button type="submit">Subir skate</button>
        </form>
    </div>
</div>
</body>
</html>