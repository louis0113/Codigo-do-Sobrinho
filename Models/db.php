<?php
require'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$host =  $_ENV['DB_HOST'] ?? 'localhost';
$banco = $_ENV['DB_NAME'];
$usuario = $_ENV['DB_USER'];
$senha = $_ENV['DB_PASS']; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$banco;charset=$charset";
$opcoes = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $conexao = new PDO($dsn, $usuario, $senha, $opcoes);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
