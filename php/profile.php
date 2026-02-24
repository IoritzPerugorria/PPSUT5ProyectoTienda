<?php
session_start();
require 'db.php';

// Si no está logueado, fuera
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$is_admin = $_SESSION['is_admin'];

// --- LÓGICA: CERRAR SESIÓN ---
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// --- LÓGICA: BORRAR PRODUCTO ---
if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];
    if ($is_admin) {
        $conn->query("DELETE FROM products WHERE id = $delete_id");
    } else {
        $conn->query("DELETE FROM products WHERE id = $delete_id AND user_id = $user_id");
    }
    header("Location: profile.php");
    exit();
}

// --- LÓGICA: ACTUALIZAR PERFIL ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellidos = $conn->real_escape_string($_POST['apellidos']);
    $telefono = $conn->real_escape_string($_POST['telefono']);

    // Si escribió una nueva contraseña, la actualizamos
    $password_query = "";
    if (!empty($_POST['password'])) {
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password_query = ", password = '$hashed_password'";
    }

    $sql = "UPDATE users SET nombre='$nombre', apellidos='$apellidos', telefono='$telefono' $password_query WHERE id=$user_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('¡Perfil actualizado correctamente!');</script>";
    } else {
        echo "<script>alert('Error al actualizar el perfil.');</script>";
    }
}

// --- OBTENER DATOS ACTUALIZADOS ---
$user_query = $conn->query("SELECT * FROM users WHERE id = $user_id");
$user_data = $user_query->fetch_assoc();

// Obtener productos (Admins ven todos, usuarios ven los suyos)
if ($is_admin) {
    $products_query = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
} else {
    $products_query = $conn->query("SELECT * FROM products WHERE user_id = $user_id ORDER BY created_at DESC");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Perfil | Blashskate</title>
    <link rel="stylesheet" href="../css/profile.css">
</head>

<body>
    <header>
        <div class="header-top">
            <a href="index.php"><img src="../img/logo.jpg" alt="Blashskate Logo" class="logo"></a>
            <form class="search-container" method="GET" action="shop.php">
                <input type="text" id="searchInput" name="search" placeholder="Buscar productos..."
                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="submit" style="display:none;">Buscar</button>
            </form>
            <nav class="header_nav">
                <a href="shop.php">Comprar</a>
                <a href="sell.php">Vender</a>
                <a href="profile.php">Perfil (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
            </nav>
        </div>
    </header>



    <div class="main-container">
        <div class="left-column">
            <div class="topTitles">
                <h2>Tu Perfil</h2>
            </div>
            <div class="profile-data">
            </div>
        </div>

        <div class="right-column">
            <div class="topTitles">
                <h2>Tus productos publicados</h2>
            </div>
        </div>
    </div>


    <div class="profilegrid">
        <div>
            <form id="registroForm" action="profile.php" method="POST">
                <h2>Datos actuales</h2>
                <br>
                <label style="color:white; font-size:12px;">Nombre:</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($user_data['nombre']) ?>" required>

                <label style="color:white; font-size:12px;">Apellidos:</label>
                <input type="text" name="apellidos" value="<?= htmlspecialchars($user_data['apellidos']) ?>" required>

                <label style="color:white; font-size:12px;">Correo (No editable):</label>
                <input type="email" value="<?= htmlspecialchars($user_data['correo']) ?>" disabled
                    style="background:#ccc;">

                <label style="color:white; font-size:12px;">Teléfono:</label>
                <input type="tel" name="telefono" value="<?= htmlspecialchars($user_data['telefono']) ?>">

                <label style="color:white; font-size:12px;">Nueva Contraseña (dejar en blanco para no cambiar):</label>
                <input type="password" name="password" placeholder="Escribe para cambiar contraseña">

                <button type="submit" name="update_profile" style="background-color: #516a7b;">Guardar Cambios</button>
                <button type="button" onclick="window.location.href='profile.php?logout=1'"
                    style="background-color: #ff6060; margin-top:15px;">Cerrar Sesión</button>
            </form>
        </div>

        <div>
            <section class="products">
                <div class="product">
                    <?php if ($products_query->num_rows > 0): ?>
                        <?php while ($row = $products_query->fetch_assoc()): ?>
                            <div class="product-card">
                                <div class="image-box">
                                    <img src="<?= htmlspecialchars($row['imagen']) ?>"
                                        alt="<?= htmlspecialchars($row['skate']) ?>">
                                </div>
                                <div class="info">
                                    <p class="category">Anchura: <?= htmlspecialchars($row['anchuras']) ?>"</p>
                                    <h2 class="product-title"><?= htmlspecialchars($row['skate']) ?></h2>
                                    <p class="price"><?= number_format($row['precio'], 2) ?> €</p>
                                    <a href="profile.php?delete=<?= $row['id'] ?>"
                                        onclick="return confirm('¿Seguro que deseas eliminar este producto?')"
                                        style="text-decoration: none;">
                                        <button class="add-to-cart" style="background-color: #ec6161;">ELIMINAR</button>
                                    </a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <h3 class="no_prodcuts" style="color: white;">No tienes productos publicados.</h3>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
</body>

</html>