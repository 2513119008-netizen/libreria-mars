<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

try {
    require_once __DIR__ . '/../src/datos/RepositorioProductos.php';
    require_once __DIR__ . '/../src/utilidades/vistas.php';

    $repositorio = new RepositorioProductos();
    $libros = $repositorio->obtenerTodos();

} catch (Throwable $error) {
    echo '<h2>Encontramos un error</h2>';
    echo '<p>' . htmlspecialchars($error->getMessage()) . '</p>';
    exit;
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

    <nav aria-label="Principal">
        <a href="index.php">Inicio</a>
        <a href="productos.php" aria-current="page">Catálogo</a>
        <a href="contacto.php">Contacto</a>
    </nav>

    <main>
        <h2>Nuestros libros</h2>

        <?php if (isset($mensajeError)): ?>
            <div class="error">
                <?= escapar($mensajeError) ?>
            </div>
        <?php endif; ?>

        <section class="catalogo">
            <?php if (!empty($libros)): ?>

                <?php foreach ($libros as $libro): ?>
                    <?php mostrarTarjetaProducto($libro); ?>
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