<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/modelos/Categoria.php';
require_once __DIR__ . '/../src/modelos/Producto.php';
require_once __DIR__ . '/../src/modelos/Libro.php';

$novelas = new Categoria('Novelas');
$clasicos = new Categoria('Clásicos');

echo 'Categoría: ' . $novelas->obtenerNombre() . '<br>';
echo 'Categoría: ' . $clasicos->obtenerNombre() . '<br>';
echo '--------------------<br>';

$libro = new Libro(
    id: 1,
    nombre: 'La gente no existe',
    categoria: $novelas,
    autor: 'Laura Ferrero',
    genero: 'Libro de relatos',
    precio: 280.00,
    stock: 10,
    descripcion: 'Sobre el título: según la autora, significa que estamos todos vivos, pero cargados de automatismos y huidas hacia delante.'
);

echo '<h3>Datos del libro</h3>';
echo 'ID: ' . $libro->obtenerId() . '<br>';
echo 'Nombre: ' . $libro->obtenerNombre() . ' (' . $libro->obtenerCategoria()->obtenerNombre() . ')<br>';
echo 'Autor: ' . $libro->obtenerAutor() . '<br>';
echo 'Género: ' . $libro->obtenerGenero() . '<br>';
echo 'Precio: $' . number_format($libro->obtenerPrecio(), 2) . '<br>';
echo 'Stock: ' . $libro->obtenerStock() . '<br>';
echo 'Descripción: ' . $libro->obtenerDescripcion() . '<br>';
echo $libro->estaDisponible() ? 'Existe producto' : 'Agotado';