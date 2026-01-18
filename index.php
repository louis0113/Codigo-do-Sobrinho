<?php

require 'Models/db.php';
require 'Controllers/User.php';
require 'Controllers/Auth.php';
require 'Controllers/Logistica/Produto.php';

header('Content-Type: application/json');

$request_uri = $_SERVER['REQUEST_URI'];

switch ($request_uri) {
    case '/login':
        $dados = json_decode(file_get_contents('php://input'), true);
        $userController = new User($conexao);
        $user = $userController->findByEmail($dados['email']);

        if ($user && $userController->verifyPassword($dados['senha'], $user['senha'])) {
            $token = Auth::generateToken(['id' => $user['id'], 'email' => $user['email']]);
            echo json_encode(['token' => $token]);
        } else {
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(['mensagem' => 'Credenciais inválidas']);
        }
        break;

    case '/criarProduto':
        // Este endpoint agora precisará de autenticação.
        // A lógica de autenticação será adicionada em um commit futuro.
        $dados = json_decode(file_get_contents('php://input'), true);
        $produto = new Produto(null, $dados['nome'], $dados['preco'], $conexao);
        $produto->criarProduto($dados);
        echo json_encode(['mensagem' => 'Produto criado com sucesso (sem autenticação por enquanto)']);
        break;

    case '/atualizarpedido':
        $id = $_GET['id_pedido'];
        // Lógica a ser implementada
        break;

    case 'atualizar_drone':
        $id = $_GET['id_drone'];
        $dados = json_decode(file_get_contents('php://input'), true);
        // Lógica a ser implementada
        break;

    case 'obter_rotas':
        // Lógica a ser implementada
        break;

    default:
        echo json_encode([
            'status' => 'LogiDrone API v0.3',
            'mensagem' => 'Endpoint não encontrado.'
        ]);
        break;
}
?>
