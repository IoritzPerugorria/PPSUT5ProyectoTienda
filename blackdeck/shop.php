<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda | BlackDeck</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<header class="main-header">
    <div class="top-bar">Envíos gratuitos en pedidos superiores a 80€</div>
    <div class="header-content">
        <div class="logo-container">
            <img src="logo.jpg" alt="BlackDeck Logo" class="brand-logo">
            <span class="brand-name">BLACK<span>DECK</span></span>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="#" class="active">SKATES</a></li>
                <li><a href="#">TABLAS</a></li>
                <li><a href="#">ROPA</a></li>
                <li><a href="#">EQUIPO</a></li>
            </ul>
        </nav>
        <div class="user-tools">
            <span class="icon">🔍</span>
            <span class="icon">🛒 (0)</span>
        </div>
    </div>
</header>

<main class="shop-container">
    <aside class="filters">
        <h3>Filtros</h3>
        <div class="filter-group">
            <h4>Ancho de tabla</h4>
            <label><input type="checkbox"> 7.75"</label>
            <label><input type="checkbox"> 8.0"</label>
            <label><input type="checkbox"> 8.125"</label>
            <label><input type="checkbox"> 8.25"</label>
        </div>
    </aside>

    <section class="products">
        <div class="products-header">
            <h1>Skateboards Completos</h1>
            <select name="sort">
                <option value="new">Más recientes</option>
                <option value="price-asc">Precio: Menor a Mayor</option>
            </select>
        </div>

        <div class="product-grid">
            <div class="card">
                <div class="image-box">
                    <img src="https://images.unsplash.com/photo-1547447134-cd3f5c716030?auto=format&fit=crop&q=80&w=400" alt="Skate BlackDeck">
                    <div class="tag">TOP</div>
                </div>
                <div class="info">
                    <p class="category">BlackDeck x Steel Wings</p>
                    <h2 class="product-title">Classic Raven Pro 8.0"</h2>
                    <p class="price">84,95 €</p>
                    <button class="add-to-cart">COMPRAR</button>
                </div>
            </div>

            <div class="card">
                <div class="image-box">
                    <img src="https://images.unsplash.com/photo-1531565637446-32307b194362?auto=format&fit=crop&q=80&w=400" alt="Skate BlackDeck">
                </div>
                <div class="info">
                    <p class="category">BlackDeck</p>
                    <h2 class