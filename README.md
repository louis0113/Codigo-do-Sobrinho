# LogiDrone (Sistema Legado - Refatorado PT-BR)

Este projeto contém o código fonte do sistema original da LogiDrone, refatorado para utilizar **Português** e **Orientação a Objetos**. O projeto documenta uma arquitetura legada com problemas conhecidos de concorrência que foram mantidos para fins educacionais e de simulação.

## 📋 Índice

- [Arquitetura](#arquitetura)
- [Instalação](#instalação)
- [Como Rodar](#como-rodar)
- [Endpoints da API](#endpoints-da-api)
- [Erros Identificados e Soluções](#erros-identificados-e-soluções)
- [Estrutura de Arquivos](#estrutura-de-arquivos)
- [Melhorias Recomendadas](#melhorias-recomendadas)

## 🏗️ Arquitetura

- **Padrão**: MVC simplificado com classe de lógica encapsulada
- **Classe Principal**: `SistemaLogistico` (em `SistemaLogistico.php`)
- **Banco de Dados**: MySQL (Banco `logidrone_legado_pt`)
- **Linguagem**: PHP 7.4+
- **Tabelas**: `produtos`, `drones`, `pedidos`

## Instalação

### Pré-requisitos
- PHP 7.4 ou superior
- MySQL 5.7 ou superior (recomendado 8.0+)
- Composer (opcional, para gerenciamento de dependências futuro)

### Passos

1. **Clone ou extraia o projeto**
   ```bash
   cd logidrone
   ```

2. **Configure as credenciais de banco de dados** em `db.php`
   ```php
   $host = 'localhost';
   $banco = 'logidrone_legado_pt';
   $usuario = 'root';
   $senha = '';
   ```

3. **Execute o script de setup**
   ```bash
   php setup.php
   ```
   Isso irá:
   - Criar o banco de dados `logidrone_legado_pt`
   - Criar as tabelas (`produtos`, `drones`, `pedidos`)
   - Inserir dados iniciais (seed)

4. **Verifique a instalação**
   ```bash
   mysql -u root logidrone_legado_pt
   SELECT * FROM produtos;
   ```

## Como Rodar

### Servidor PHP Integrado
```bash
php -S localhost:8000
```

A API estará disponível em `http://localhost:8000`

### Servidor Alternativo
Se você está usando Apache, configure o `DocumentRoot` para apontar ao diretório do projeto.

## 🔌 Endpoints da API (Em Português)

### 1. Criar Pedido
**Método**: POST
**Endpoint**: `?acao=criar_pedido`
**Headers**: `Content-Type: application/json`

**Request**:
```json
{
  "produto_id": 1,
  "quantidade": 2
}
```

**Response (Sucesso)**:
```json
{
  "status": "Pedido criado",
  "id_pedido": 1
}
```

**Response (Erro)**:
```json
{
  "erro": "Dados inválidos"
}
```

---

### 2. Pagar Pedido
**Método**: GET
**Endpoint**: `?acao=pagar_pedido&id_pedido=1`

**Response (Sucesso)**:
```json
{
  "status": "Pagamento aceito",
  "novo_estoque": 8
}
```

**⚠️ BUGS MANTIDOS**: A lógica de pagamento é suscetível a **condições de corrida (race conditions)** se chamadas simultâneas ocorrerem (veja [Erros Identificados](#erros-identificados-e-soluções)).

---

### 3. Atualizar Drone
**Método**: POST
**Endpoint**: `?acao=atualizar_drone&id_drone=1`
**Headers**: `Content-Type: application/json`

**Request**:
```json
{
  "estado": "RETORNANDO",
  "bateria": 20
}
```

**Estados Válidos**:
- `OCIOSO` - Drone inativo/disponível
- `ENTREGANDO` - Drone em rota de entrega
- `RETORNANDO` - Drone voltando à base
- `CARREGANDO` - Drone carregando bateria

**Response**:
```json
{
  "status": "Drone atualizado"
}
```

**BUG LÓGICO**: Quando o drone retorna ao estado `RETORNANDO` ou `OCIOSO`, todos os pedidos `ENVIADO` são automaticamente marcados como `ENTREGUE` sem verificação (veja [Erros Identificados](#erros-identificados-e-soluções)).

---

### 4. Obter Rotas
**Método**: GET
**Endpoint**: `?acao=obter_rotas`

**Response**:
```json
{
  "tipo": "ColecaoDeFeatures",
  "features": [
    {
      "tipo": "Feature",
      "geometria": {
        "tipo": "Linha",
        "coordenadas": [[-34.9, -8.0], [-34.91, -8.01]]
      },
      "propriedades": {
        "id_pedido": 123,
        "tempo_estimado": "15min"
      }
    }
  ]
}
```

---

## Erros Identificados e Soluções

### 1. **Race Condition no Pagamento**

**Localização**: `SistemaLogistico.php` - Método `processarPagamento()`

**Problema**:
```php
SELECT estoque FROM produtos WHERE id = ?

UPDATE produtos SET estoque = estoque - ? WHERE id = ?
```

Se dois pedidos forem pagos simultaneamente, ambos podem ler o mesmo estoque ANTES da atualização, causando dedução incorreta.

**Cenário de Falha**:
- Estoque: 10 unidades
- Requisição A lê: 10
- Requisição B lê: 10
- A deduz para 8
- B deduz para 8 (deveria ser 6!)

**Solução**:
```php
public function processarPagamento($pedidoId) {
    $this->conexao->beginTransaction();
    
    try {
        $stmt = $this->conexao->prepare(
            "SELECT estoque FROM produtos WHERE id = ? FOR UPDATE"
        );
        $stmt->execute([$pedido['produto_id']]);
        $produto = $stmt->fetch();
        
        if ($produto['estoque'] < $pedido['quantidade']) {
            throw new Exception('Estoque insuficiente');
        }
        
        $stmt = $this->conexao->prepare(
            "UPDATE produtos SET estoque = estoque - ? WHERE id = ?"
        );
        $stmt->execute([$pedido['quantidade'], $pedido['produto_id']]);
        
        $this->conexao->commit();
        
        return ['status' => 'Pagamento aceito'];
    } catch (Exception $e) {
        $this->conexao->rollBack();
        return ['erro' => $e->getMessage()];
    }
}
```

---

### 2. **Atualização Automática Incorreta de Pedidos**

**Localização**: `SistemaLogistico.php` - Método `atualizarDrone()`

**Problema**:
```php
if ($estadoDrone === 'RETORNANDO' || $estadoDrone === 'OCIOSO') {
```

Um drone que estava entregando apenas 2 pacotes marca seus 2 pedidos como entregues, mas não os 50 de outro drone. A lógica está correta, mas:
- Falta validação de qual drone estava responsável
- Não há registro de quando foi entregue
- Não há notificação ao cliente

**Solução**:
```php
public function atualizarDrone($droneId, $dados) {
    $estadoDrone = $dados['estado'];
    $bateria = $dados['bateria'];
    
    $estadosValidos = ['OCIOSO', 'ENTREGANDO', 'RETORNANDO', 'CARREGANDO'];
    if (!in_array($estadoDrone, $estadosValidos)) {
        return ['erro' => 'Estado de drone inválido'];
    }
    
    $stmt = $this->conexao->prepare(
        "UPDATE drones SET status = ?, nivel_bateria = ? WHERE id = ?"
    );
    $stmt->execute([$estadoDrone, $bateria, $droneId]);
    
    if ($estadoDrone === 'RETORNANDO') {
        $stmt = $this->conexao->prepare(
            "UPDATE pedidos 
             SET status = 'ENTREGUE', data_entrega = NOW() 
             WHERE drone_id = ? AND status = 'ENVIADO'"
        );
        $stmt->execute([$droneId]);
    }
    
    return ['status' => 'Drone atualizado'];
}
```

### 3. **Tratamento de Erros Inadequado**

**Localização**: `db.php`

**Problema**:
```php
catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), ...);
}
```

Exibe mensagens de erro do banco de dados diretamente, incluindo credenciais ou estrutura sensível.

**Solução**:
```php
catch (\PDOException $e) {
    error_log("Erro de conexão: " . $e->getMessage());
    http_response_code(500);
    die(json_encode(['erro' => 'Erro ao conectar ao banco de dados']));
}
```

---

### 4. **Falta de Validação de Entrada**

**Localização**: `SistemaLogistico.php` - Múltiplos métodos

**Problema**:
- Não valida IDs (podem ser negativos ou strings)
- Não sanitiza entrada JSON
- Não valida ranges de bateria (0-100)

**Solução**:
```php
public function criarPedido($dados) {
    $produtoId = (int)($dados['produto_id'] ?? 0);
    $quantidade = (int)($dados['quantidade'] ?? 0);
    
    if ($produtoId <= 0 || $quantidade <= 0) {
        return ['erro' => 'Produto ID e quantidade devem ser maiores que zero'];
    }
    
}

public function atualizarDrone($droneId, $dados) {
    $droneId = (int)$droneId;
    $bateria = (int)($dados['bateria'] ?? 0);
    
    if ($bateria < 0 || $bateria > 100) {
        return ['erro' => 'Nível de bateria deve estar entre 0 e 100'];
    }
    
}
```

---

### 5. **Falta de Autenticação e Autorização**

**Problema**: Qualquer pessoa pode fazer requisições à API

**Solução**:
```php
function validarAutenticacao() {
    $token = $_GET['token'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    $tokenValido = 'seu_token_secreto_aqui';
    
    if ($token !== $tokenValido) {
        http_response_code(401);
        die(json_encode(['erro' => 'Não autorizado']));
    }
}

validarAutenticacao();
```
### 6. **Falta de Logging**

**Problema**: Nenhum registro de transações ou erros

**Solução**:
```php
private function registrarLog($acao, $dados) {
    $arquivo = 'logs/logidrone_' . date('Y-m-d') . '.log';
    $mensagem = date('Y-m-d H:i:s') . " - $acao - " . json_encode($dados) . "\n";
    file_put_contents($arquivo, $mensagem, FILE_APPEND);
}
```


## 📂 Estrutura de Arquivos

```
logidrone/
├── index.php              # Ponto de entrada da API
├── db.php                 # Configuração de banco de dados
├── SistemaLogistico.php   # Lógica principal encapsulada
├── setup.php              # Script de instalação
├── schema.sql             # Definição do banco em Português
├── README.md              # Este arquivo
├── logs/                  # Diretório para logs (criar manualmente)
└── config/                # Diretório para variáveis de ambiente (recomendado)
```


## 💡 Melhorias Recomendadas

### Curto Prazo (Crítico)

1. **Implementar Transações e Locks**
   - Usar `BEGIN TRANSACTION` e `SELECT ... FOR UPDATE`
   - Previne race conditions no pagamento

2. **Adicionar Validação de Entrada**
   - Validar tipos, ranges e presença de dados
   - Usar prepared statements com type hinting

3. **Implementar Autenticação**
   - Adicionar tokens ou JWT
   - Controlar acesso aos endpoints

4. **Melhorar Tratamento de Erros**
   - Não expor detalhes do banco
   - Retornar códigos HTTP apropriados

### Médio Prazo

5. **Adicionar Sistema de Logging**
   - Registrar todas as transações
   - Facilitar debugging e auditoria

6. **Criar Testes Unitários**
   - PHPUnit para validar lógica
   - Simular race conditions

7. **Documentar com OpenAPI/Swagger**
   - Facilitar consumo da API
   - Padronizar request/response

8. **Implementar Paginação**
   - Endpoint `obter_rotas` retorna apenas 1 rota hardcoded

### Longo Prazo

9. **Refatorar para Framework Moderno**
   - Laravel, Slim ou Symfony
   - Mais segurança e features prontas

10. **Implementar Queue System**
    - Para processamento assíncrono de pagamentos
    - Redis ou RabbitMQ

11. **Adicionar Cache**
    - Redis para rotas e produtos frequentes
    - Reduzir carga no banco

12. **Monitoramento e Alertas**
    - NewRelic, Datadog ou similar
    - Detectar anomalias em tempo real

---

## 🧪 Testando a API

### Criar Pedido
```bash
curl -X POST http://localhost:8000 \
  -H "Content-Type: application/json" \
  -d '{"produto_id": 1, "quantidade": 2}?acao=criar_pedido'
```

### Pagar Pedido
```bash
curl http://localhost:8000?acao=pagar_pedido&id_pedido=1
```

### Atualizar Drone
```bash
curl -X POST http://localhost:8000?acao=atualizar_drone&id_drone=1 \
  -H "Content-Type: application/json" \
  -d '{"estado": "ENTREGANDO", "bateria": 85}'
```

### Obter Rotas
```bash
curl http://localhost:8000?acao=obter_rotas
```

---

## 📝 Notas Importantes

- Este é um sistema **legado em refatoração** com bugs mantidos para fins educacionais
- **NÃO use em produção** sem implementar as correções de segurança
- Os bugs foram deliberadamente preservados para demonstrar problemas comuns de concorrência
- Para uma versão segura e pronta para produção, implemente todas as melhorias recomendadas

---

## 👨‍💻 Autor

Refatorado por: **Sobrinho** (2024)
Mantido para: Fins Educacionais e Simulação de Arquitetura Legada
=======
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
