<?php
declare(strict_types=1);

// Uso, desde la raíz del repositorio: php entorno/verificar-entorno.php
// Comprueba PHP, pdo_mysql, MariaDB, la base de datos y sus tablas.

const SERVIDOR = '127.0.0.1';
const PUERTO = 3306;
const BASE = 'proyecto';
const USUARIO = 'app';
const CLAVE = 'app123';

const TABLAS_DEL_MODELO = [
    'categorias',
    'productos',
    'clientes',
    'usuarios',
    'pedidos',
    'detalles_pedido'
];

function informar(string $estado, string $mensaje): void
{
    echo sprintf("[%-5s] %s\n", $estado, $mensaje);
}

function describirPhp(): void
{
    $binario = PHP_BINARY !== '' ? PHP_BINARY : 'ruta desconocida';
    $ini = php_ini_loaded_file();

    informar('INFO', 'PHP ' . PHP_VERSION . ' en ' . $binario);
    informar('INFO', 'php.ini cargado: ' . ($ini !== false ? $ini : 'ninguno'));
}

function probarExtension(): bool
{
    $cargada = extension_loaded('pdo_mysql');

    informar(
        $cargada ? 'OK' : 'FALLO',
        'Extensión pdo_mysql de PHP ' . ($cargada ? 'cargada' : 'NO cargada')
    );

    if (!$cargada) {
        echo "        Este PHP no puede hablar con MySQL.\n";
        echo "        Ejecuta: bash .devcontainer/instalar-entorno.sh\n";
    }

    return $cargada;
}

function explicarError(PDOException $error): string
{
    $codigo = preg_match(
        '/\[(\d{4})\]/',
        $error->getMessage(),
        $m
    ) === 1 ? (int) $m[1] : 0;

    switch ($codigo) {
        case 1045:
            return 'Usuario o clave incorrectos. Ejecuta de nuevo: bash .devcontainer/instalar-entorno.sh';

        case 1049:
            return 'La base "' . BASE . '" no existe. Ejecuta: bash .devcontainer/instalar-entorno.sh';

        case 2002:
            return 'MariaDB no está iniciada. Ejecuta: bash .devcontainer/iniciar-mariadb.sh';

        default:
            return 'Error no catalogado: ' . $error->getMessage();
    }
}

function conectar(): ?PDO
{
    $dsn = sprintf(
        'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
        SERVIDOR,
        PUERTO,
        BASE
    );

    try {
        $pdo = new PDO(
            $dsn,
            USUARIO,
            CLAVE,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );

        informar(
            'OK',
            'Conexión establecida. Servidor: ' .
            $pdo->query('SELECT VERSION()')->fetchColumn()
        );

        return $pdo;

    } catch (PDOException $error) {
        informar('FALLO', explicarError($error));

        return null;
    }
}

function probarCodificacion(PDO $pdo): void
{
    $juego = (string) $pdo
        ->query('SELECT @@character_set_database')
        ->fetchColumn();

    informar(
        strpos($juego, 'utf8mb4') === 0 ? 'OK' : 'AVISO',
        "Codificación de la base: $juego (se espera utf8mb4)"
    );
}

function probarTablas(PDO $pdo): void
{
    $existentes = $pdo
        ->query('SHOW TABLES')
        ->fetchAll(PDO::FETCH_COLUMN);

    $faltantes = array_diff(TABLAS_DEL_MODELO, $existentes);

    if ($faltantes === []) {
        informar('OK', 'Las seis tablas del modelo existen');
    } else {
        informar(
            'AVISO',
            'Aún no hay tablas del modelo (es normal antes del Reto 2): ' .
            implode(', ', $faltantes)
        );
    }
}

echo "Verificación del entorno\n\n";

describirPhp();

$pdo = probarExtension() ? conectar() : null;

if ($pdo === null) {
    echo "\nResultado: el entorno no está listo; corrige el punto marcado como FALLO.\n";
    exit(1);
}

probarCodificacion($pdo);
probarTablas($pdo);

echo "\nResultado: el entorno está listo.\n";