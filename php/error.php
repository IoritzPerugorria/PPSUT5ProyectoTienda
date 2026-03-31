<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <title>Error</title>
    <link rel="stylesheet" href="../css/error.css">
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

    <body>
        <div class="errorBox">
            <h1 class="errorText">Ha ocurrido un error inesperado</h1>
        </div>
    </body>
</body>

</html>