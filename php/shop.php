<?php
session_start();
require 'db.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Error de validación de seguridad (CSRF).");
    }

    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Debes iniciar sesión para realizar esta acción'); window.location.href='index.php';</script>";
        exit();
    }

    $delete_id = (int) $_POST['delete_id'];

    $sql_img = "SELECT imagen FROM products WHERE id = ?";
    $stmt_img = $conn->prepare($sql_img);
    $stmt_img->bind_param("i", $delete_id);
    $stmt_img->execute();
    $res_img = $stmt_img->get_result();
    
    if ($product = $res_img->fetch_assoc()) {
        $image_path = $product['imagen'];
        
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);
        
        if ($stmt->execute()) {
            if (!empty($image_path) && file_exists($image_path)) {
                unlink($image_path);
            }
            echo "<script>alert('Compra realizada con éxito'); window.location.href='shop.php';</script>";
        }
        $stmt->close();
    }
    $stmt_img->close();
    exit();
}

$conditions = [];
$params = [];
$types = "";

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $conditions[] = "p.skate LIKE ?";
    $params[] = "%" . trim($_GET['search']) . "%";
    $types .= "s";
}

if (isset($_GET['sizes']) && is_array($_GET['sizes']) && count($_GET['sizes']) > 0) {
    $placeholders = [];
    foreach ($_GET['sizes'] as $size) {
        $placeholders[] = "?";
        $params[] = $size;
        $types .= "s";
    }
    $conditions[] = "p.anchuras IN (" . implode(",", $placeholders) . ")";
}

$whereClause = count($conditions) > 0 ? implode(" AND ", $conditions) : "1=1";

$sql = "SELECT p.*, u.is_admin 
        FROM products p 
        JOIN users u ON p.user_id = u.id 
        WHERE $whereClause 
        ORDER BY p.created_at DESC";

$stmt = $conn->prepare($sql);
if (!$stmt) { die("Error en la consulta"); }

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>BlackDeck | Tienda</title>
    <link rel="stylesheet" href="../css/shop.css">
    <link rel="stylesheet" href="../css/common.css">
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

    <main class="shop-container">
        <aside class="filters">
            <form method="GET" action="shop.php">
                <?php if (isset($_GET['search'])): ?>
                    <input type="hidden" name="search" value="<?= htmlspecialchars($_GET['search']) ?>">
                <?php endif; ?>
                <h3>Filtros</h3>
                <div class="filter-group">
                    <h4>Ancho de tabla</h4>
                    <?php
                    $checked_sizes = $_GET['sizes'] ?? [];
                    $available_sizes = ['7.75', '8.0', '8.125', '8.25'];
                    foreach ($available_sizes as $size): ?>
                        <label>
                            <input type="checkbox" name="sizes[]" value="<?= $size ?>" onchange="this.form.submit()"
                                <?= in_array($size, $checked_sizes) ? 'checked' : '' ?>> <?= $size ?>"
                        </label>
                    <?php endforeach; ?>
                </div>
            </form>
        </aside>

        <section class="products">
            <div class="products-header">
                <h1>Skateboards Completos</h1>
            </div>
            <div class="product">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="product-card">
                            <div class="image-box">
                                <img src="<?= htmlspecialchars($row['imagen']) ?>" alt="<?= htmlspecialchars($row['skate']) ?>">
                                <div class="tag" style="background: <?= $row['is_admin'] ? '#ec6161' : '#000' ?>;">
                                    <?= $row['is_admin'] ? 'NUEVO' : 'SEGUNDA MANO' ?>
                                </div>
                            </div>
                            <div class="info">
                                <p class="category"><?= htmlspecialchars($row['anchuras']) ?>"</p>
                                <h2 class="product-title"><?= htmlspecialchars($row['skate']) ?></h2>
                                <p class="price"><?= number_format($row['precio'], 2) ?> €</p>
                                <form method="POST" action="shop.php" onsubmit="return confirm('¿Seguro que deseas comprar este producto?')">
                                    <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                    <button type="submit" class="add-to-cart">COMPRAR</button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-results-container">
                        <p>No se encontraron productos.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>

