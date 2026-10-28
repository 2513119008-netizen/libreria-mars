<?php
// Ruta corregida para acceder al archivo JSON desde la carpeta public/
$ruta = __DIR__ . "/../datos/datos.json";

$libros = [];

if (file_exists($ruta)) {
    $contenido = file_get_contents($ruta);
    $libros = json_decode($contenido, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        $libros = [];
        $error = "Error en el archivo datos.json: " . json_last_error_msg();
    }
} else {
    $error = "No se encontró el archivo datos/datos.json.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - Librería</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>

<body>
    <header>
        <h1>Librería</h1>
        <p>Catálogo de libros</p>
    </header>

    <nav arial-label="Principal">
        <a href="index.php" >Inicio</a>
        <a href="productos.php"  aria-current="page">Catálogo</a>
        <a href="contacto.php">Contacto</a>
    </nav>

    <main>
        <h2>Nuestros libros</h2>

        <?php if (isset($error)): ?>
            <div class="error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <section class="catalogo">
            <?php if (!empty($libros)): ?>
                <?php foreach ($libros as $libro): ?>
                    <article>
                        <h3>📖 <?= htmlspecialchars($libro["nombre"]) ?></h3>
                        <p class="autor">Autor/a: <?= htmlspecialchars($libro["autor"]) ?></p>
                        <p class="genero">Género: <?= htmlspecialchars($libro["genero"]) ?></p>
                        <p class="precio">$<?= number_format($libro["precio"], 2) ?></p>
                        <p>Stock: <?= htmlspecialchars($libro["stock"]) ?></p>
                        <a class="boton" href="producto-detalle.php?id=<?= $libro["id"] ?>">Ver ficha</a>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <article>
                    <h3>No hay libros para mostrar</h3>
                    <p>Revisa el archivo datos/datos.json.</p>
                </article>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 Librería</p>
    </footer>
</body>
</html>
