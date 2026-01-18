<?php

require 'Controllers/Logistica/Produto.php';

header('Content-Type: application/json');
$banana = new Produto(1, "Banana", 2.50);

$request_uri = $_SERVER['REQUEST_URI'];

// A função encode estava incompleta e causando um erro fatal.
// function encode($obj, $method){
//     json_encode($obj->)
// }

switch ($request_uri) {
    case '/' :

        break;

    case '/criarProduto':
        $dados = json_decode(file_get_contents('php://input'), true);
        echo json_encode($banana->criarProduto($dados));
        break;

    case '/atualizarpedido':
        $id = $_GET['id_pedido'];
        // TODO: Inicializar o objeto $sistema antes de usar.
        // echo json_encode($sistema->processarPagamento($id));
        break;

    case 'atualizar_drone':
        $id = $_GET['id_drone'];
        $dados = json_decode(file_get_contents('php://input'), true);
        // TODO: Inicializar o objeto $sistema antes de usar.
        // echo json_encode($sistema->atualizarDrone($id, $dados));
        break;

    case 'obter_rotas':
        // TODO: Inicializar o objeto $sistema antes de usar.
        // echo json_encode($sistema->obterRotas());
        break;

    default:
        echo json_encode([
            'status' => 'LogiDrone API v0.2 (Legacy Refatorado)',
            'mensagem' => 'Use ?acao=criar_pedido, pagar_pedido, etc.'
        ]);
        break;
}
?>
