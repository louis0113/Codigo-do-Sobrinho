<?php
// SistemaLogistico.php - A Lógica Legada Encapsulada

class SistemaLogistico {
    private $conexao;

    public function __construct($conexaoDb) {
        $this->conexao = $conexaoDb;
    }

    private function simularLatencia() {
        sleep(1);
    }

    public function criarPedido($dados) {
        $produtoId = $dados['produto_id'] ?? null;
        $quantidade = $dados['quantidade'] ?? 0;

        if (!$produtoId || !$quantidade) {
            return ['erro' => 'Dados inválidos'];
        }

        // Busca preço
        $stmt = $this->conexao->prepare("SELECT preco FROM produtos WHERE id = ?");
        $stmt->execute([$produtoId]);
        $produto = $stmt->fetch();

        if (!$produto) {
            return ['erro' => 'Produto não existe'];
        }

        $total = $produto['preco'] * $quantidade;

        $stmt = $this->conexao->prepare("INSERT INTO pedidos (produto_id, quantidade, preco_total, status) VALUES (?, ?, ?, 'PENDENTE')");
        $stmt->execute([$produtoId, $quantidade, $total]);

        return ['status' => 'Pedido criado', 'id_pedido' => $this->conexao->lastInsertId()];
    }

    public function processarPagamento($pedidoId) {
        // 1. Lê pedido
        $stmt = $this->conexao->prepare("SELECT * FROM pedidos WHERE id = ?");
        $stmt->execute([$pedidoId]);
        $pedido = $stmt->fetch();

        if (!$pedido || $pedido['status'] !== 'PENDENTE') {
            return ['erro' => 'Pedido inválido ou já processado'];
        }

        // 2. Verifica estoque (SEM LOCK - Race Condition mantida propositalmente)
        $stmt = $this->conexao->prepare("SELECT estoque FROM produtos WHERE id = ?");
        $stmt->execute([$pedido['produto_id']]);
        $produto = $stmt->fetch();

        if ($produto['estoque'] < $pedido['quantidade']) {
            return ['erro' => 'Estoque insuficiente'];
        }

        $this->simularLatencia();

        // 3. Deduz estoque
        $novoEstoque = $produto['estoque'] - $pedido['quantidade'];
        $stmt = $this->conexao->prepare("UPDATE produtos SET estoque = ? WHERE id = ?");
        $stmt->execute([$novoEstoque, $pedido['produto_id']]);

        // 4. Marca pago
        $stmt = $this->conexao->prepare("UPDATE pedidos SET status = 'PAGO' WHERE id = ?");
        $stmt->execute([$pedidoId]);

        return ['status' => 'Pagamento aceito', 'novo_estoque' => $novoEstoque];
    }

    public function atualizarDrone($droneId, $dados) {
        $estadoDrone = $dados['estado']; // 'ENTREGANDO', 'RETORNANDO', 'OCIOSO'
        $bateria = $dados['bateria'];

        $stmt = $this->conexao->prepare("UPDATE drones SET status = ?, nivel_bateria = ? WHERE id = ?");
        $stmt->execute([$estadoDrone, $bateria, $droneId]);

        // Lógica falha original mantida: Se está RETORNANDO ou OCIOSO, marca entregas como ENTREGUE
        if ($estadoDrone === 'RETORNANDO' || $estadoDrone === 'OCIOSO') {
            $stmt = $this->conexao->prepare("SELECT id FROM pedidos WHERE drone_id = ? AND status = 'ENVIADO'");
            $stmt->execute([$droneId]);
            $pedidos = $stmt->fetchAll();

            foreach ($pedidos as $p) {
                $stmt = $this->conexao->prepare("UPDATE pedidos SET status = 'ENTREGUE' WHERE id = ?");
                $stmt->execute([$p['id']]);
            }
        }

        return ['status' => 'Drone atualizado'];
    }

    public function obterRotas() {
        // Retorna GeoJSON complexo (mantendo o bug de contrato de API)
        return [
            'tipo' => 'ColecaoDeFeatures',
            'features' => [
                [
                    'tipo' => 'Feature',
                    'geometria' => [
                        'tipo' => 'Linha',
                        'coordenadas' => [[-34.9, -8.0], [-34.91, -8.01]]
                    ],
                    'propriedades' => [
                        'id_pedido' => 123,
                        'tempo_estimado' => '15min'
                    ]
                ]
            ]
        ];
    }
}
?>
