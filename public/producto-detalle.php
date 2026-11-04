<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/datos/RepositorioProductos.php';
require_once __DIR__ . '/../src/utilidades/vistas.php';

$repositorio = new RepositorioProductos();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

try {
    if ($id === false || $id === null || $id <= 0) {
        throw new OutOfBoundsException('El ID del libro no es válido.');
    }

    $libro = $repositorio->buscarPorId($id);
} catch (OutOfBoundsException $error) {
    http_response_code(404);
    $mensajeError = $error->getMessage();
} catch (RuntimeException $error) {
    http_response_code(500);
    $mensajeError = $error->getMessage();
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
        <h1>Ficha del libro</h1>
    </header>

    <nav aria-label="Principal">
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="productos.php" aria-current="page">Catálogo</a></li>
            <li><a href="contacto.php">Contacto</a></li>
        </ul>
    </nav>

    <main>
        <?php if (isset($mensajeError)): ?>

            <article>
                <h2>Libro no encontrado</h2>
                <p><?= escapar($mensajeError) ?></p>
                <a class="boton" href="productos.php">Regresar al catálogo</a>
            </article>

        <?php else: ?>

            <article>
                <h2><?= escapar($libro->obtenerNombre()) ?></h2>

                <p class="autor">
                    Autor/a: <?= escapar($libro->obtenerAutor()) ?>
                </p>

                <p class="genero">
                    Género:
                    <?= escapar($libro->obtenerCategoria()->obtenerNombre()) ?>
                </p>

                <p class="precio">
                    Precio: <?= escapar($libro->obtenerPrecioFormateado()) ?>
                </p>

                <?= mostrarDisponibilidad($libro) ?>

                <h3>Descripción</h3>

                <p class="descripcion">
                    <?= escapar($libro->obtenerDescripcion()) ?>
                </p>

                <a class="boton" href="productos.php">
                    ← Regresar al catálogo
                </a>
            </article>

        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2026 Librería</p>
    </footer>
</body>
</html>