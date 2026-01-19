<?php 
    class StatusHistorico{
        
        private $id;
        private $pedidoId;
        private $statusAnterior;
        private $statusNovo;
        private $timestamp;
        private $origem;
        private $coordenadasOrigem;
        private $observacao;

        public function __construct($id, $pedidoId, $anterior, $novo, $ts, $origem, $coordenadas, $obs){
            $this->id = $id;
            $this->pedidoId = $pedidoId;
            $this->statusAnterior = $anterior;
            $this->statusNovo = $novo;
            $this->timestamp = $ts;
            $this->origem = $origem;
            $this->coordenadasOrigem = $coordenadas;
            $this->observacao = $obs;        
        }

    public function getId(){
    return $this->id;
}
    public function setId($new_id){
    $this->id = $new_id;
}
    public function getPedidoId(){
    return $this->pedidoId;
}
    public function setPedidoId($idPedido){
    $this->pedidoId = $idPedido;
}
    public function getStatusAnterior(){
    return $this->statusAnterior;
}
    public function setStatusAnterior($st_anterior){
    $this->statusAnterior = $st_anterior;
}
    public function getStatusNovo(){
    return $this->statusNovo;
}
    public function setStatusNovo($st_novo){
    $this->statusNovo = $st_novo;
}
    public function getTimestamp(){
    return $this->timestamp;
}
    public function setTimestamp($ts){
    $this->timestamp = $ts;
}
    public function getOrigem(){
    return $this->origem;
}
    public function setOrigem($origem){
    $this->origem = $origem;
}
    public function getCoordenadasOrigem(){
    return $this->coordenadasOrigem;
}
    public function setCoordenadasOrigem($coordenadas){
    $this->coordenadasOrigem = $coordenadas;
}
    public function getObservacao(){
    return $this->observacao;
}
    public function setObservacao($obs){
    $this->observacao = $obs;
}
        public function validarTransicao(){
        
        }

        public function gerarRelatorio(){
        
        }
    }

?>
