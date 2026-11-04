<?php
declare(strict_types=1);

require_once __DIR__ . '/../modelos/Producto.php';

function escapar(string $texto): string
{
    return htmlspecialchars(
        $texto,
        ENT_QUOTES,
        'UTF-8'
    );
}

function mostrarDisponibilidad(Producto $producto): string
{
    if ($producto->estaDisponible()) {
        return '<p class="disponibilidad disponible">Disponible: '
            . $producto->obtenerStock()
            . ' ejemplares</p>';
    }

    return '<p class="disponibilidad agotado">Agotado</p>';
}

function mostrarTarjetaProducto(Producto $producto): void
{
    ?>
    <article>
        <h3>📖 <?= escapar($producto->obtenerNombre()) ?></h3>

        <p class="autor">
            Autor/a: <?= escapar($producto->obtenerAutor()) ?>
        </p>

        <p class="genero">
            Género: <?= escapar($producto->obtenerCategoria()->obtenerNombre()) ?>
        </p>

        <p class="precio">
            <?= escapar($producto->obtenerPrecioFormateado()) ?>
        </p>

        <?= mostrarDisponibilidad($producto) ?>

        <a class="boton" href="producto-detalle.php?id=<?= $producto->obtenerId() ?>">
            Ver ficha
        </a>
    </article>
    <?php
}