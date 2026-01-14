<?php
// index.php - A API Refatorada (Consumidor da Classe)

require 'db.php';
require 'SistemaLogistico.php'; // Importa a classe

header('Content-Type: application/json');

$acao = $_GET['acao'] ?? ''; // 'action' virou 'acao'
$sistema = new SistemaLogistico($conexao);

switch ($acao) {
    case 'criar_pedido':
        $dados = json_decode(file_get_contents('php://input'), true);
        echo json_encode($sistema->criarPedido($dados));
        break;

    case 'pagar_pedido':
        $id = $_GET['id_pedido'];
        echo json_encode($sistema->processarPagamento($id));
        break;

    case 'atualizar_drone':
        $id = $_GET['id_drone'];
        $dados = json_decode(file_get_contents('php://input'), true);
        echo json_encode($sistema->atualizarDrone($id, $dados));
        break;

    case 'obter_rotas':
        echo json_encode($sistema->obterRotas());
        break;

    default:
        echo json_encode([
            'status' => 'LogiDrone API v0.2 (Legacy Refatorado)',
            'mensagem' => 'Use ?acao=criar_pedido, pagar_pedido, etc.'
        ]);
        break;
}
?>
