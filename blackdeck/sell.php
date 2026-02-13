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
        <a href="index.php">
            <img src="img/logo.jpg" alt="BlackDeck Logo" class="logo">
        </a>
        
        <nav>
            <a href="shop.php">Comprar</a>
            <a href="sell.php">Vender</a>
            <a href="register.php">Regístrate</a>
             <a href="profile.php">Perfil</a>
        </nav>
    </div>

</header>

<div class="container">
    <div class="card">
        <h2>Vender tu skate</h2>

        <form method="POST">
            <input type="text" name="skate" placeholder="Nombre del skate">
            <br/>
            <input type="number" name="precio" placeholder="Precio (en Euros)">
            <br/>
            <label>Elija la anchura del producto</label>
            

            <select name="anchuras" id="anchuras">
                <option value="775">7.75"</option>
                <option value="8">8"</option>
                <option value="8125">8.125"</option>
                <option value="825">8.25"</option>
            </select>
            <br/>
            <textarea name="descripcion" placeholder="Descripción"></textarea>
            <br/>

            <label for="product_image">Suba una foto del producto</label>
            
            <input type="file" id="avatar" name="avatar" accept=".jpg, .jpeg, .png, .webp">
            <br/>
            <button>Subir skate</button>
        </form>
    </div>
</div>
