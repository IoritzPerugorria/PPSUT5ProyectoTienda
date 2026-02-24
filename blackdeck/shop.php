<?php
session_start();
require 'db.php';

// --- LÓGICA: COMPRAR PRODUCTO ---
if (isset($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    
    $conn->query("DELETE FROM products WHERE id = $delete_id");

    
    header("Location: shop.php");
    exit();
}

// Lógica de búsqueda y filtros
$where = "1=1";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $where .= " AND p.skate LIKE '%$search%'";
}

if (isset($_GET['sizes']) && is_array($_GET['sizes'])) {
    $sizes = array_map(function($size) use ($conn) {
        return "'" . $conn->real_escape_string($size) . "'";
    }, $_GET['sizes']);
    
    $where .= " AND p.anchuras IN (" . implode(",", $sizes) . ")";
}

// Obtener productos y saber si el creador es admin
$sql = "SELECT p.*, u.is_admin FROM products p 
        JOIN users u ON p.user_id = u.id 
        WHERE $where 
        ORDER BY p.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>BlackDeck | Tienda</title>
    <link rel="stylesheet" href="css/shop.css">
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
                <a href="profile.php">Perfil</a>
            <?php else: ?>
                <a href="register.php">Regístrate</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="shop-container">
    <aside class="filters">
        <form method="GET" action="shop.php">
            <?php if(isset($_GET['search'])): ?>
                <input type="hidden" name="search" value="<?= htmlspecialchars($_GET['search']) ?>">
            <?php endif; ?>
            
            <h3>< Filtros</h3>
            <div class="filter-group">
                <h4>Ancho de tabla</h4>
                <?php 
                $checked_sizes = isset($_GET['sizes']) ? $_GET['sizes'] : []; 
                $available_sizes = ['7.75', '8.0', '8.125', '8.25'];
                foreach($available_sizes as $size): 
                ?>
                    <label>
                        <input type="checkbox" name="sizes[]" value="<?= $size ?>" onchange="this.form.submit()" <?= in_array($size, $checked_sizes) ? 'checked' : '' ?>> <?= $size ?>"
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
                <?php while($row = $result->fetch_assoc()): ?>
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
                            <a href="shop.php?delete=<?= $row['id'] ?>" onclick="return confirm('¿Seguro que deseas comprar este producto?')"  style="text-decoration: none;">
                                <button class="add-to-cart">COMPRAR</button>
                            </a>    
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No se encontraron productos.</p>
            <?php endif; ?>
        </div>
    </section>
</main>
</body>
</html>