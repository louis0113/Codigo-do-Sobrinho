<?php

require 'EntregadorAbstrato.php';

class Motoboy extends EntregadorAbstrato {

    private $nome;
    private $cpf;
    private $telefone;
    private $placa;
    private $versaoApp;

    public function __construct($id, $posicao, $status, $capacidade, $disponibilidade, $comunicacao,
        $nome, $cpf, $telefone, $placa, $versao){
            parent::__construct($id, $posicao, $status, $capacidade, $disponibilidade, $comunicacao);
            $this->nome = $nome;
            $this->cpf = $cpf;
            $this->telefone = $telefone;
            $this->placa = $placa;
            $this->versaoApp = $versao;
    }

    public function getNome(){
    return $this->nome;
}
    public function setNome($nome){
    $this->nome = $nome;
}
    public function getCpf(){
    return $this->cpf;
}
    public function setCpf($cpf){
    $this->cpf = $cpf;
}
    public function getTelefone(){
    return $this->telefone;
}
    public function setTelefone($telefone){
    $this->telefone = $telefone;
}
    public function getPlaca(){
    return $this->placa;
}
    public function setPlaca($placa){
    $this->placa = $placa;
}
    public function getVersaoApp(){
    return $this->versaoApp;
}
    public function setVersaoApp($versao){
    $this->versaoApp = $versao;
}

    public function coletarProduto($pedidoId){
    
    }

    public function navegarPara($destino){
    
    }

    public function confirmarEntrega($pedidoId){
    
    }

    public function reportarStatus() {
    
    }

    public function verificarCompatibilidadeAPI(){
    
    }
}
?>
