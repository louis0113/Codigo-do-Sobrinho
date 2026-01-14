<?php
// setup.php - Script de Instalação (Refatorado)

require 'db.php'; // Só para pegar as configs, ignora o erro de conexão inicial

try {
    // 1. Conecta sem banco
    $pdo = new PDO("mysql:host=$host", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conectado ao MySQL...\n";

    // 2. Cria o banco (nome novo)
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $banco CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Banco '$banco' verificado.\n";

    // 3. Usa o banco
    $pdo->exec("USE $banco");

    // 4. Executa schema
    $sql = file_get_contents('schema.sql');
    $comandos = array_filter(array_map('trim', explode(';', $sql)));

    foreach ($comandos as $cmd) {
        if (!empty($cmd)) {
            $pdo->exec($cmd);
        }
    }
    
    echo "Tabelas (em Português!) criadas com sucesso.\n";

} catch (PDOException $e) {
    echo "Erro no setup: " . $e->getMessage() . "\n";
}
?>
