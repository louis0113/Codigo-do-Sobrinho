# LogiDrone (Sistema Legado - Refatorado PT-BR)

Este projeto contém o código fonte do sistema original da LogiDrone, refatorado para utilizar **Português** e **Orientação a Objetos**.
Apesar da refatoração estrutural, a lógica interna (incluindo os bugs de concorrência e estado) foi preservada para simulação fiel.

## Arquitetura Refatorada
- **Classe Principal**: `SistemaLogistico` (em `SistemaLogistico.php`)
- **Banco de Dados**: MySQL (Banco `logidrone_legado_pt`)
- **Tabelas**: `produtos`, `drones`, `pedidos`

## Instalação
1. Certifique-se de que o MySQL está rodando.
2. Configure as credenciais no arquivo `db.php`.
3. Execute o setup para criar o banco e tabelas traduzidas:
   ```bash
   php setup.php
   ```

## Como Rodar
Inicie o servidor local:
```bash
php -S localhost:8000
```

## Endpoints da API (Novos - Em Português)

### 1. Criar Pedido
*POST* `?acao=criar_pedido`
```json
{
  "produto_id": 1,
  "quantidade": 2
}
```

### 2. Pagar Pedido (Simulação de Race Condition)
*GET* `?acao=pagar_pedido&id_pedido=1`
> **BUGS MANTIDOS**: A lógica de pagamento continua suscetível a condições de corrida se chamadas simultâneas ocorrerem.

### 3. Atualizar Drone
*POST* `?acao=atualizar_drone&id_drone=1`
```json
{
  "estado": "RETORNANDO", 
  "bateria": 20
}
```
> **NOTA**: Estados aceitos: `OCIOSO`, `ENTREGANDO`, `RETORNANDO`, `CARREGANDO`.

### 4. Obter Rotas
*GET* `?acao=obter_rotas`

## Estrutura de Arquivos
- `SistemaLogistico.php`: Classe contendo métodos como `criarPedido`, `processarPagamento`.
- `index.php`: Ponto de entrada que instancia a classe.
- `db.php`: Configuração do banco.
- `schema.sql`: Definição do banco em Português.
