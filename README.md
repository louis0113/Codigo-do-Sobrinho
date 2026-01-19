# LogiDrone API

Sistema de logística inteligente com suporte para entrega por drones e motoboys, desenvolvido em PHP com arquitetura orientada a objetos.

## 📋 Descrição

LogiDrone é uma API REST para gerenciamento de entregas que integra:

- Gerenciamento de pedidos e produtos
- Controle de estoque com sistema de bloqueios
- Entregadores (Drones e Motoboys)
- Sistema de pagamentos e transações financeiras
- Monitoramento operacional em tempo real
- Gateway de APIs IoT
- Autenticação JWT

## 🚀 Tecnologias

- **PHP 8.0+**
- **MySQL**
- **Composer** (gerenciador de dependências)
- **JWT** (autenticação)
- **PDO** (conexão com banco de dados)

### Dependências

- `vlucas/phpdotenv`: Gerenciamento de variáveis de ambiente
- `firebase/php-jwt`: Autenticação com JSON Web Tokens

## 📦 Instalação

### 1. Clone o repositório

```bash
git clone <url-do-repositorio>
cd logidrone
```

### 2. Instale as dependências

```bash
composer install
```

### 3. Configure as variáveis de ambiente

Copie o arquivo `.env.example` para `.env` e configure suas credenciais:

```bash
cp .env.example .env
```

Edite o arquivo `.env`:

```env
DB_HOST=localhost
DB_USER=seu-usuario
DB_PASS=sua-senha
DB_NAME=logidrone
JWT_SECRET=sua-chave-secreta-aqui
```

### 4. Configure o banco de dados

Execute o script de setup para criar o banco e as tabelas:

```bash
php Models/setup.php
```

### 5. Crie um usuário de teste

```bash
php seed_user.php
```

Isso criará um usuário com:
- Email: `teste@example.com`
- Senha: `123456`

## 🔧 Estrutura do Projeto

```
.
├── Controllers/
│   ├── Auth.php                    # Autenticação JWT
│   ├── Conexao.php                 # Classe de conexão
│   ├── User.php                    # Gerenciamento de usuários
│   ├── Entregadores/
│   │   ├── EntregadorAbstrato.php  # Classe abstrata base
│   │   ├── Drone.php               # Entregador drone
│   │   └── Motoboy.php             # Entregador motoboy
│   ├── Enums/
│   │   ├── StatusBloqueio.php
│   │   ├── StatusConexao.php
│   │   ├── StatusPedido.php
│   │   ├── StatusTransacao.php
│   │   └── TipoPagamento.php
│   ├── Financeiro/
│   │   └── TransacaoFinanceira.php
│   ├── IoT/
│   │   ├── APIGateway.php
│   │   ├── MonitorOperacional.php
│   │   └── ReconciliadorInconsistencias.php
│   └── Logistica/
│       ├── BloqueioEstoque.php
│       ├── Cliente.php
│       ├── Estoque.php
│       ├── Pedido.php
│       ├── Produto.php
│       ├── SistemaLogistico.php
│       └── StatusHistorico.php
├── Models/
│   ├── db.php                      # Configuração do banco
│   ├── schema.sql                  # Schema principal
│   ├── schema_usuarios.sql         # Schema de usuários
│   └── setup.php                   # Script de setup
├── index.php                       # Entry point da API
├── .env.example                    # Exemplo de configuração
├── .gitignore
└── composer.json
```

## 🔐 Autenticação

A API utiliza JWT (JSON Web Tokens) para autenticação. O token tem validade de 1 hora.

### Login

**Endpoint:** `POST /login`

**Body:**
```json
{
  "email": "teste@example.com",
  "senha": "123456"
}
```

**Resposta:**
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
```

### Uso do Token

Inclua o token no header `Authorization` das requisições protegidas:

```
Authorization: Bearer {seu-token-aqui}
```

## 📡 Endpoints da API

### Públicos

- `POST /login` - Autenticação de usuário

### Protegidos (requerem autenticação)

- `POST /criarProduto` - Criar novo produto

**Body:**
```json
{
  "nome": "Nome do Produto",
  "preco": 100.00
}
```

### Em Desenvolvimento

- `PUT /atualizarpedido?id_pedido={id}` - Atualizar pedido
- `PUT /atualizar_drone?id_drone={id}` - Atualizar status do drone
- `GET /obter_rotas` - Obter rotas de entrega

## 🏗️ Arquitetura

### Padrões de Projeto

- **MVC**: Separação entre Controllers, Models e Views (API REST)
- **Abstract Class**: `EntregadorAbstrato` para polimorfismo de entregadores
- **Enums**: Tipos enumerados para status e tipos de dados
- **Repository Pattern**: Classes de domínio com responsabilidades específicas

### Entidades Principais

#### Entregadores
- `Drone`: Entregador autônomo com propriedades como bateria, altitude e autonomia
- `Motoboy`: Entregador humano com CPF, telefone e placa

#### Logística
- `Pedido`: Gestão completa do ciclo de vida do pedido
- `Produto`: Catálogo de produtos
- `Estoque`: Controle de estoque com bloqueios temporários
- `BloqueioEstoque`: Sistema de reserva de produtos

#### Financeiro
- `TransacaoFinanceira`: Processamento de pagamentos

#### IoT
- `APIGateway`: Gerenciamento de versões e roteamento
- `MonitorOperacional`: Dashboard em tempo real
- `ReconciliadorInconsistencias`: Detecção e correção de inconsistências

## 🗄️ Banco de Dados

### Tabelas Principais

- `usuarios` - Autenticação
- `produtos` - Catálogo de produtos
- `pedidos` - Pedidos realizados
- `drones` - Frota de drones

### Dados Iniciais

O sistema vem com dados de exemplo:

**Produtos:**
- Hélice Drone X1 (R$ 50,00)
- Bateria Ultra Pack (R$ 150,00)
- Controle Pro Stick (R$ 200,00)

**Drones:**
- Drone-Alfa
- Drone-Beta
- Drone-Gama

## 🔒 Segurança

- Senhas armazenadas com hash `password_hash()` (bcrypt)
- Autenticação via JWT
- Prepared Statements para prevenir SQL Injection
- Variáveis de ambiente para credenciais sensíveis

## 🚧 Funcionalidades em Desenvolvimento

- [ ] Sistema completo de atualização de pedidos
- [ ] Integração com API de geolocalização
- [ ] Sistema de rotas otimizadas
- [ ] Atualização em tempo real de status de drones
- [ ] Dashboard de monitoramento
- [ ] Sistema de notificações
- [ ] API de rastreamento para clientes

## 📝 Licença

Este projeto é open source e está disponível sob a licença MIT.

## 👥 Contribuindo

Contribuições são bem-vindas! Por favor:

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📧 Contato

Para dúvidas ou sugestões, abra uma issue no repositório.

---

**Status do Projeto:** Em desenvolvimento ativo 🚀

**Versão:** 0.1
