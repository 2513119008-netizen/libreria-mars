<?php
declare(strict_types=1);

require_once __DIR__ . '/../modelos/Producto.php';

class RepositorioProductos
{
    private string $rutaArchivo;

    public function __construct(
        ?string $rutaArchivo = null
    ) {
        $this->rutaArchivo = $rutaArchivo
            ?? __DIR__ . '/../../datos/datos.json';
    }

    public function obtenerTodos(): array
    {
        if (!file_exists($this->rutaArchivo)) {
            throw new RuntimeException(
                'No se encontró el archivo de productos.'
            );
        }

        $contenido = file_get_contents($this->rutaArchivo);

        if ($contenido === false) {
            throw new RuntimeException(
                'No se pudo leer el archivo de productos.'
            );
        }

        try {
            $registros = json_decode(
                $contenido,
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $error) {
            throw new RuntimeException(
                'El archivo JSON contiene datos inválidos.',
                0,
                $error
            );
        }

        if (!is_array($registros)) {
            throw new RuntimeException(
                'La estructura del archivo JSON no es válida.'
            );
        }

        $productos = [];

        foreach ($registros as $registro) {
            if (!is_array($registro)) {
                throw new RuntimeException(
                    'Uno de los registros del JSON no es válido.'
                );
            }

            try {
                $productos[] = Producto::desdeArreglo($registro);
            } catch (InvalidArgumentException $error) {
                throw new RuntimeException(
                    $error->getMessage(),
                    0,
                    $error
                );
            }
        }

        return $productos;
    }

    public function buscarPorId(int $id): Producto
    {
        foreach ($this->obtenerTodos() as $producto) {
            if ($producto->obtenerId() === $id) {
                return $producto;
            }
        }

        throw new OutOfBoundsException(
            "No se encontró un libro con el ID {$id}."
        );
    }
}