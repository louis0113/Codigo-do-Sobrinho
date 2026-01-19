<?php

require 'Models/db.php';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conectado ao MySQL...\n";

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$banco` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Banco '$banco' verificado.\n";

    $pdo->exec("USE `$banco`");

    $sql = file_get_contents(__DIR__ . '/Models/schema_usuarios.sql');
    $comandos = array_filter(array_map('trim', explode(';', $sql)));

    foreach ($comandos as $cmd) {
        if (!empty($cmd)) {
            $pdo->exec($cmd);
        }
    }
    echo "Tabela 'usuarios' criada/verificada.\n";

    $email = 'teste@example.com';
    $senha = '123456';
    $hash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO usuarios (email, senha) VALUES (?, ?)");
    $stmt->execute([$email, $hash]);

    echo "Usuário de teste criado com sucesso!\n";

} catch (PDOException $e) {
    echo "Erro ao criar usuário de teste: " . $e->getMessage() . "\n";
}


