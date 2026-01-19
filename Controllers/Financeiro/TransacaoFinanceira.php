<?php
    class TransacaoFinanceira{
        private $id;
        private $pedidoId;
        private $valor;
        private $metodoPagamento;
        private $status;
        private $timestampProcessamento;
        private $codigoAutorizacao;
        private $mensagemRetorno;

        public function  __construct($id, $idPedido, $vl, $pagamento, $stats, $timestamp, $codigo, $mensagem){
        $this->id = $id;
        $this->pedidoId= $idPedido;
        $this->valor = $vl;
        $this->metodoPagamento = $pagamento;
        $this->status = $stats;
        $this->timestampProcessamento = $timestamp;
        $this->codigoAutorizacao = $codigo;
        $this->mensagemRetorno = $mensagem;
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
    public function getValor(){
    return $this->valor;
}
    public function setValor($vl){
    $this->valor = $vl;
}
    public function getMetodoPagamento(){
    return $this->metodoPagamento;
}
    public function setMetodoPagamento($pagamento){
    $this->metodoPagamento = $pagamento;
}
    public function getStatus(){
    return $this->status;
}
    public function setStatus($stats){
    $this->status = $stats;
}
    public function getTimestampProcessamento(){
    return $this->timestampProcessamento;
}
    public function setTimestampProcessamento($timestamp){
    $this->timestampProcessamento = $timestamp;
}
    public function getCodigoAutorizacao(){
    return $this->codigoAutorizacao;
}
    public function setCodigoAutorizacao($codigo){
    $this->codigoAutorizacao = $codigo;
}
    public function getMensagemRetorno(){
    return $this->mensagemRetorno;
}
    public function setMensagemRetorno($retorno){
    $this->mensagemRetorno = $retorno;
}
        public function processar(){
        
        }

        public function estornar(){
        
        }

        public function validarDados(){
        
        }

        public function registrarAuditoria(){
        
        }

    }

?>
