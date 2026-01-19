<?php

class BloqueioEstoque{

    private $id;
    private $pedidoId;
    private $produtoId;
    private $quantidade;
    private $timestampCriacao;
    private $timestampExpiracao;
    private $status;

    public function __construct($id, $idPedido, $idProduto, $qt, $tsCriacao, $tsExp, $status){
        $this->id = $id;
        $this->pedidoId = $idPedido;
        $this->produtoId = $idProduto;
        $this->quantidade = $qt;
        $this->timestampCriacao = $tsCriacao;
        $this->timestampExpiracao = $tsExp;
        $this->status = $status;
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
    public function getProdutoId(){
    return $this->produtoId;
}
    public function setProdutoID($idProduto){
    $this->produtoId = $idProduto;
}
    public function getQuantidade(){
    return $this->quantidade;
}
    public function setQuantidade($qt){
    $this->quantidade = $qt;
}
    public function getTimestampCriacao(){
    return $this->timestampCriacao;
}
    public function setTimestampCriacao($ts_criacao){
    $this->timestampCriacao = $ts_criacao;
}
    public function getTimestampExpiracao(){
    return $this->timestampExpiracao;
}
    public function setTimestampExpiracao($ts_expiracao){
    $this->timestampExpiracao = $ts_expiracao;
}
    public function getStatus(){
    return $this->status;
}
    public function setStatus($stats){
    $this->status = $stats;
}
    public function verificarExpiracao(){
    
    }

    public function renovarBloqueio($novoTimeout){
    
    }

    public function cancelar(){
    
    }

}
?>
