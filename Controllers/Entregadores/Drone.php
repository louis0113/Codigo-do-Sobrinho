<?php 

require 'EntregadorAbstrato.php';

class Drone extends EntregadorAbstrato {

    private $nivelBateria;
    private $altitudeAtual;
    private $velocidadeMaxima;
    private $autonomiaRestante;
    private $modeloDrone;

    public function __construct($id, $posicao, $status, $capacidade, $disponibilidade, $comunicacao,
        $bateria, $altitude, $velocidade, $autonomia, $modelo){
            parent::__construct($id, $posicao, $status, $capacidade, $disponibilidade, $comunicacao);
            $this->nivelBateria = $bateria;
            $this->altitudeAtual = $altitude;
            $this->velocidadeMaxima = $velocidade;
            $this->autonomiaRestante = $autonomia;
            $this->modeloDrone = $modelo;
    }

    public function getNivelBateria(){
    return $this->nivelBateria;
}
    public function setNivelBateria($bateria){
    $this->nivelBateria = $bateria;
}
    public function getAltitudeAtual(){
    return $this->altitudeAtual;
}
    public function setAltitudeAtual($altitude){
    $this->altitudeAtual = $altitude;
}
    public function getVelocidadeMaxima(){
    return $this->velocidadeMaxima;
}
    public function setVelocidadeMaxima($velocidade){
    $this->id = $velocidade;
}
    public function getAutonomiaRestante(){
    return $this->autonomiaRestante;
}
    public function setId($autonomia){
    $this->autonomiaRestante = $autonomia;
}
    public function getModeloDrone(){
    return $this->modeloDrone;
}
    public function setModeloDrone($modelo){
    $this->modeloDrone = $modelo;
}
    public function coletarProduto($pedidoId){
    
    }

    public function navegarPara($destino){
    
    }

    public function confirmarEntrega($pedidoId){
    
    }

    public function reportarStatus(){
    
    }

    public function retornarParaBase(){
    
    }

    public function verificarNivelBateria(){
    
    }

    public function ajustarAltitude($novaAltitude){
    
    }

}

?>
