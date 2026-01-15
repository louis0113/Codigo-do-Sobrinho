<?php
class Pedido {

    private  $id;
    private  $clienteId;
    private  $dataCriacao;
    private  $status;
    private  $valorTotal;
    private  $enderecoEntrega;
    private  $tipoPagamento;
    private  $timestamp;
    
       public function __construct($id,$clienteId, $dataCriacao, $status, $valorTotal, $enderecoEntrega, $tipoPagamento, $timestamp) {
    $this->id = $id;
    $this->clienteId = $clienteId;
    $this->dataCriacao = $dataCriacao;
    $this->status = $status;
    $this->valorTotal = $valorTotal;
    $this->endrecoEntrega = $endrecoEntrega;
    $this->tipoPagamento = $tipoPagamento;
    $this->timestamp = $timestamp;
}

    public function getId(){
    return $this->id;
}
    public function setId($new_id){
    $this->id = $new_id;
}
    public function getClienteId(){
    return $this->clienteId;
}
    public function setClienteId($idCliente){
    $this->clienteId = $idCliente;
}
    public function getDataCriacao(){
    return $this->dataCriacao;
}
    public function setDataCriacao($criacaoData){
    $this->dataCriacao = $criacaoData;
}
    public function getStatus(){
    return $this->status;
}
    public function setStatus($stats){
    $this->status = $stats;
}
    public function getValorTotal(){
    return $this->valorTotal;
}
    public function setValorTotal($total){
    $this->valorTotal = $total;
}
    public function getEnderecoEntrega(){
    return $this->enderecoEntrega;
}
    public function setEnderecoEntrega($entrega){
    $this->enderecoEntrega = $entrega;
}
    public function getTipoPagamento(){
    return $this->tipoPagamento;
}
    public function setTipoPagamento($pagamento){
    $this->tipoPagamento = $pagamento;
}
    public function getTimestamp(){
    return $this->timestamp;
}
    public function setTimestamp($time){
    $this->timestamp = $time;
}

    public function validarEstoque(){

}

    public function processarPagamento(){

}

    public function atribuirEntregador(){

}

    public function atualizarStatus($novoStatus, $origem){

}

    public function obterHistoricoStatus(){

}
    
    public function calcularRota() {

}
}
?>
