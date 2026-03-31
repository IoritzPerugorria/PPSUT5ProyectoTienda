<?php
session_start();
require 'db.php';

// Token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Error de validación de seguridad (CSRF).");
    }
    $user_id = $_SESSION['user_id'];
    $skate = substr($_POST['skate'], 0, 150);
    $precio = substr($_POST['precio'], 0, 10);
    $anchura = substr($_POST['anchuras'], 0, 20);
    $descripcion = substr($_POST['descripcion'], 0, 300);


    $upload_success = false;
    $target_file = "";
    $max_file_size = 5 * 1024 * 1024;
    $allowed_mime_types = ['image/jpeg', 'image/png', 'image/webp'];
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['avatar']['tmp_name'];
        $file_name = $_FILES['avatar']['name'];
        $file_size = $_FILES['avatar']['size'];

        if ($file_size > $max_file_size) {
            echo "<script>alert('Error: El archivo supera el límite de 5MB.');</script>";
        } else {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $file_tmp_path);
            $finfo = null;

            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if (!in_array($mime_type, $allowed_mime_types) || !in_array($file_extension, $allowed_extensions)) {
                echo "<script>alert('Error: El archivo debe ser una imagen real (JPG, PNG, WEBP).');</script>";
            } else {
                $new_file_name = bin2hex(random_bytes(16)) . '.' . $file_extension;

                $target_dir = "../uploads/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }

                $target_file = $target_dir . $new_file_name;

                if (move_uploaded_file($file_tmp_path, $target_file)) {
                    $upload_success = true;
                } else {
                    echo "<script>alert('Error del servidor al guardar la imagen.');</script>";
                }
            }
        }
    } else {
        echo "<script>alert('Error en la subida del archivo o no se seleccionó ninguna imagen.');</script>";
    }

    if ($upload_success) {
        $sql = "INSERT INTO products (user_id, skate, precio, anchuras, descripcion, imagen) 
                VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("isdsss", $user_id, $skate, $precio, $anchura, $descripcion, $target_file);

            if ($stmt->execute()) {
                echo "<script>alert('Producto subido exitosamente'); window.location.href='profile.php';</script>";
            } else {
                echo "<script>alert('Error al guardar en la base de datos.');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error interno en la base de datos.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Blashskate</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/sell.css">
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
    <div class="container">
        <div class="card">
            <h2>Vender tu skate</h2>
            <form class="sellform" method="POST" action="sell.php" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <input type="text" name="skate" placeholder="Nombre del skate" required>
                <br />
                <input type="number" step="0.01" name="precio" placeholder="Precio (en Euros)" required>
                <br />
                <label>Elija la anchura del producto</label>
                <select name="anchuras" id="anchuras" required>
                    <option value="7.75">7.75"</option>
                    <option value="8.0">8"</option>
                    <option value="8.125">8.125"</option>
                    <option value="8.25">8.25"</option>
                </select>
                <br />
                <textarea name="descripcion" placeholder="Descripción" required></textarea>
                <br />
                <label for="avatar">Suba una foto del producto (Máx. 5MB)</label>
                <input type="file" id="avatar" name="avatar" accept=".jpg, .jpeg, .png, .webp" required>
                <br />
                <button type="submit">Subir skate</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('avatar').addEventListener('change', function (e) {
            const file = this.files[0];

            if (file) {
                const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert("Por favor, sube solo formatos de imagen válidos (JPG, PNG, WEBP).");
                    this.value = '';
                    return;
                }

                const maxSize = 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert("El archivo es demasiado grande. El límite es de 5MB.");
                    this.value = '';
                    return;
                }
            }
        });
    </script>
</body>

</html>