<?php
session_start();
require 'db.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$is_admin = $_SESSION['is_admin'];

// Cerrar sesion

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Error de validación de seguridad (CSRF).");
    }
    session_destroy();
    header("Location: index.php");
    exit();
}

// Borrar producto

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Error de validación de seguridad (CSRF).");
    }

    $delete_id = (int) $_POST['delete_id'];

    if ($is_admin) {
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
    } else {
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $delete_id, $user_id);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: profile.php");
    exit();
}

// Actualizar perfil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Error de validación de seguridad (CSRF).");
    }

    $nombre = substr($_POST['nombre'], 0, 100);
    $apellidos = substr($_POST['apellidos'], 0, 100);
    $telefono = substr($_POST['telefono'], 0, 20);
    $password = substr($_POST['password'], 0, 255);

    $password_query = "";
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET nombre=?, apellidos=?, telefono=?, password=? WHERE id=?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssi", $nombre, $apellidos, $telefono, $hashed_password, $user_id);
            $stmt->execute();
            echo "<script>alert('¡Perfil actualizado correctamente!');</script>";
        }
    } else {
        $sql = "UPDATE users SET nombre=?, apellidos=?, telefono=? WHERE id=?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssi", $nombre, $apellidos, $telefono, $user_id);
            $stmt->execute();
            echo "<script>alert('¡Perfil actualizado correctamente!');</script>";
        }
    }
}

$user_query = $conn->query("SELECT * FROM users WHERE id = $user_id");
$user_data = $user_query->fetch_assoc();

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
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>

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
<div class="profilegrid">
    <div>
        <form id="registroForm" action="profile.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

            <h2>Datos actuales</h2>
            <br>
            <label style="color:white; font-size:12px;">Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($user_data['nombre']) ?>" required>

            <label style="color:white; font-size:12px;">Apellidos:</label>
            <input type="text" name="apellidos" value="<?= htmlspecialchars($user_data['apellidos']) ?>" required>

            <label style="color:white; font-size:12px;">Correo (No editable):</label>
            <input type="email" value="<?= htmlspecialchars($user_data['correo']) ?>" disabled style="background:#ccc;">

            <label style="color:white; font-size:12px;">Teléfono:</label>
            <input type="tel" name="telefono" value="<?= htmlspecialchars($user_data['telefono']) ?>">

            <label style="color:white; font-size:12px;">Nueva Contraseña (dejar en blanco para no cambiar):</label>
            <input type="password" name="password" placeholder="Escribe para cambiar contraseña">

            <button type="submit" name="update_profile" style="background-color: #516a7b;">Guardar Cambios</button>

        </form>

        <form action="profile.php" method="POST"
            style="margin-top: 15px; width: 300px; margin-left: auto; margin-right: auto;">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <button type="submit" name="logout" style="background-color: #ff6060; width: 100%;">Cerrar Sesión</button>
        </form>
    </div>

    <div>
        <section class="products">
            <div class="product">
                <?php if ($products_query->num_rows > 0): ?>
                    <?php while ($row = $products_query->fetch_assoc()): ?>
                        <div class="product-card">
                            <div class="image-box">
                                <img src="<?= htmlspecialchars($row['imagen']) ?>" alt="<?= htmlspecialchars($row['skate']) ?>">
                            </div>
                            <div class="info">
                                <p class="category">Anchura: <?= htmlspecialchars($row['anchuras']) ?>"</p>
                                <h2 class="product-title"><?= htmlspecialchars($row['skate']) ?></h2>
                                <p class="price"><?= number_format($row['precio'], 2) ?> €</p>

                                <form action="profile.php" method="POST"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');">
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                    <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="add-to-cart"
                                        style="background-color: #ec6161;">ELIMINAR</button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-results-container">
                        <h3 style="color: white;">No tienes productos publicados.</h3>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>
</body>

</html>