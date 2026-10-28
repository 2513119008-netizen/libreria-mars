<?php

$ruta = __DIR__ . "/../datos/datos.json";

$contenido = file_get_contents($ruta);
$libros = json_decode($contenido, true);

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

$libro = null;

foreach ($libros as $item) {
    if ($item["id"] == $id) {
        $libro = $item;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería - Ficha del libro</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>

<body>
    <header>
        <h1> Ficha del libro</h1>
    </header>

    
    <nav aria-label="Principal">
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="productos.php" aria-current="page">Catálogo</a></li>
            <li><a href="contacto.php">Contacto</a></li>
        </ul>
    </nav>

    <main>
        <?php if ($libro): ?>
            <article>
                <h2><?= htmlspecialchars($libro["nombre"]) ?></h2>
                <p class="autor">Autor/a: <?= htmlspecialchars($libro["autor"]) ?></p>
                <p class="genero">Género: <?= htmlspecialchars($libro["genero"]) ?></p>
                <p class="precio">Precio: $<?= number_format($libro["precio"], 2) ?></p>
                <p>Stock: <?= htmlspecialchars($libro["stock"]) ?></p>
                <h3>Descripción</h3>
                <p class="descripcion"><?= htmlspecialchars($libro["descripcion"]) ?></p>
                <a class="boton" href="productos.php">← Regresar al catálogo</a>
            </article>
        <?php else: ?>
            <article>
                <h2>Libro no encontrado</h2>
                <p>No se encontró el libro solicitado.</p>
                <a class="boton" href="productos.php">Regresar al catálogo</a>
            </article>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2026 Librería</p>
    </footer>
</body>
</html>