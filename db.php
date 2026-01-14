<?php
// db.php - Conexão simples (Refatorada)
$host = 'localhost';
$banco = 'logidrone_legado_pt'; // Mudamos o nome para refletir a nova versão
$usuario = 'root';
$senha = ''; 
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
    // Mantendo o comportamento inseguro original de exibir o erro
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
