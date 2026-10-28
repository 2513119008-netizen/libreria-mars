<?php
declare(strict_types=1);

require_once __DIR__ . '/Categoria.php';

class Producto
{
    private const CAMPOS_OBLIGATORIOS = [
        'id',
        'nombre',
        'categoria',
        'precio',
        'descripcion',
        'stock',
        'imagen'
    ];

    private int $id;
    private string $nombre;
    private Categoria $categoria;
    private float $precio;
    private string $descripcion;
    private int $stock;
    private string $imagen;

    public function __construct(
        int $id,
        string $nombre,
        Categoria $categoria,
        float $precio,
        string $descripcion,
        int $stock,
        string $imagen
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->categoria = $categoria;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->stock = $stock;
        $this->imagen = $imagen;
    }

    public function obtenerId(): int
    {
        return $this->id;
    }

    public function obtenerNombre(): string
    {
        return $this->nombre;
    }

    public function obtenerCategoria(): Categoria
    {
        return $this->categoria;
    }

    public function obtenerPrecio(): float
    {
        return $this->precio;
    }

    public function obtenerDescripcion(): string
    {
        return $this->descripcion;
    }

    public function obtenerStock(): int
    {
        return $this->stock;
    }

    public function obtenerImagen(): string
    {
        return $this->imagen;
    }
}