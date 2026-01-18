<?php

abstract class EntregadorAbstrato {

    private $id;
    private $posicaoAtual;
    private $statusConexao;
    private $capacidadeMaxima;
    private $statusDisponibilidade;
    private $ultimaComunicacao;

    public function __construct($id, $posicao,$status, $capacidade, $disponibilidade, $comunicacao){
        $this->id = $id;
        $this->posicaoAtual = $posicao;
        $this->statusConexao = $status;
        $this->capacidadeMaxima = $capacidade;
        $this->statusDisponibilidade = $disponibilidade;
        $this->ultimaComunicacao = $comunicacao;
    }

    abstract public function coletarProduto($pedidoId) : bool;
    abstract public function navegarPara($destino) : void;
    abstract public function confirmarEntrega ($pedidoId) : bool;
    abstract public function reportarStatus();

    public function getId(): string{
    return $this->id;
}

    public function setId($new_id){
    $this->id = $new_id;
}
    public function getPosicaoAtual(){
    return $this->posicaoAtual;
}
    public function setPosicaoAtual($posicao){
    $this->posicaoAtual = $posicao;
}
    public function getStatusConexao(){
    return $this->statusConexao;
}
    public function setStatusConexao($status){
    $this->statusConexao = $status;
}
    public function getCapacidadeMaxima(){
    return $this->capacidadeMaxima;
}
    public function setCapacidadeMaxima($capacidade){
    $this->capacidadeMaxima = $capacidade;
}
    public function getStatusDisponibilidade(){
    return $this->statusDisponibilidade;
}
    public function setStatusDisponibilidade($capacidadeStatus){
    $this->statusDisponibilidade = $capacidadeStatus;
}
    public function getUltimaComunicacao(){
    return $this->ultimaComunicacao;
}
    public function setUltimaComunicacao($comunicacao){
    $this->ultimaComunicacao = $comunicacao;
}
    public function validarComunicacao(){
    
    }

    public function ativarModoRecuperacao(){
    
    }
        
}


?>
