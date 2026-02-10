<?php
if ($_POST) {
    echo "<p>Skate enviado para vender</p>";
}
?>

<div class="container">
    <div class="card">
        <h2>Vender tu skate</h2>

        <form method="POST">
            <input type="text" name="skate" placeholder="Nombre del skate">
            <input type="number" name="precio" placeholder="Precio">
            <textarea name="descripcion" placeholder="Descripción"></textarea>
            <button>Subir skate</button>
        </form>
    </div>
</div>
