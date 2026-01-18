<?php

require 'Models/db.php';

$email = 'teste@example.com';
$senha = '123456';

$hash = password_hash($senha, PASSWORD_DEFAULT);

try {
    $stmt = $conexao->prepare("INSERT INTO usuarios (email, senha) VALUES (?, ?)");
    $stmt->execute([$email, $hash]);
    echo "Usuário de teste criado com sucesso!\n";
} catch (PDOException $e) {
    echo "Erro ao criar usuário de teste: " . $e->getMessage() . "\n";
}


