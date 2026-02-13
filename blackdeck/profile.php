<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>BlackDeck | Tienda de Skates</title>
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>



<header>
    <div class="header-top">
<<<<<<< HEAD
        <a href="index.php">
            <img src="img/logo.jpg" alt="BlackDeck Logo" class="logo">
=======
        <a href="index.html">
            <img src="img/logo.jpg" alt="Blashskate Logo" class="logo">
>>>>>>> 034aa6c498b31598012d061faf2bed959957ea3d
        </a>

        <form class="header-search" action="shop.php" method="GET">
            <input type="text" name="search" placeholder="Buscar tablas, trucks, zapas..." aria-label="Buscar">
            <button type="submit">
                <i class="fas fa-search"></i> 🔍
            </button>
        </form>
        
        <nav>
            <a href="shop.php">Comprar</a>
            <a href="sell.php">Vender</a>
            <a href="register.php">Regístrate</a>
             <a href="profile.php">Perfil</a>
        </nav>
    </div>
</header>

<div class="topTitles">

    <h2>Editar perfil</h2>

    <h2>Tus productos</h2>

</div>

<div class="profilegrid">

    <div>
        <form id="registroForm">
            <h2>Editar perfil</h2>
            
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellidos" placeholder="Apellidos" required>
            <input type="email" name="correo" placeholder="Correo" required>
            <input type="tel" name="telefono" placeholder="Número de teléfono" required>
            <input type="password" name="password" id="password" placeholder="Contraseña" required>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Repetir contraseña" required>
            <button type="submit">Confirmar Cambios</button>
        </form>
    </div>


    <div>
        <section class="products">

            

            <div class="product">
                <div class="product-card">
                    <div class="image-box">
                        <img src="https://images.unsplash.com/photo-1547447134-cd3f5c716030?auto=format&fit=crop&q=80&w=400" alt="Skate BlackDeck">
                        <div class="tag">TOP</div>
                    </div>
                    <div class="info">
                        <p class="category">BlackDeck x Steel Wings</p>
                        <h2 class="product-title">Classic Raven Pro 8.0"</h2>
                        <p class="price">84,95 €</p>
                        <button class="add-to-cart">EDITAR</button>
                    </div>
                </div>
                <div class="product-card">
                    <div class="image-box">
                        <img src="https://images.unsplash.com/photo-1547447134-cd3f5c716030?auto=format&fit=crop&q=80&w=400" alt="Skate BlackDeck">
                        <div class="tag">TOP</div>
                    </div>
                    <div class="info">
                        <p class="category">BlackDeck x Steel Wings</p>
                        <h2 class="product-title">Classic Raven Pro 8.0"</h2>
                        <p class="price">84,95 €</p>
                        <button class="add-to-cart">EDITAR</button>
                    </div>
                </div>
                <div class="product-card">
                    <div class="image-box">
                        <img src="https://images.unsplash.com/photo-1547447134-cd3f5c716030?auto=format&fit=crop&q=80&w=400" alt="Skate BlackDeck">
                        <div class="tag">TOP</div>
                    </div>
                    <div class="info">
                        <p class="category">BlackDeck x Steel Wings</p>
                        <h2 class="product-title">Classic Raven Pro 8.0"</h2>
                        <p class="price">84,95 €</p>
                        <button class="add-to-cart">EDITAR</button>
                    </div>
                </div>
                <div class="product-card">
                    <div class="image-box">
                        <img src="https://images.unsplash.com/photo-1547447134-cd3f5c716030?auto=format&fit=crop&q=80&w=400" alt="Skate BlackDeck">
                        <div class="tag">TOP</div>
                    </div>
                    <div class="info">
                        <p class="category">BlackDeck x Steel Wings</p>
                        <h2 class="product-title">Classic Raven Pro 8.0"</h2>
                        <p class="price">84,95 €</p>
                        <button class="add-to-cart">EDITAR</button>
                    </div>
                </div>
                
            </div>

        </section>
    </div>
</div>

</body>
</html>