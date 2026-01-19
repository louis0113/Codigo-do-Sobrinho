<?php
class APIGateway{

    private $versaoAtual;
    private $versoesSuportadas;
    private $mapasCompatibilidade;

    
    public function __construct($atual, $suportadas, $mapas){
        $this->versaoAtual = $atual;
        $this->versoesSuportadas = $suportadas;
        $this->mapasCompatibilidade = $mapas;
    }
    
    public function getVersaoAtual(){
    return $this->versaoAtual;
}
    public function setVersaoAtual($atual){
    $this->versaoAtual = $atual;
}
    public function getVersoesSuportadas(){
    return $this->versoesSuportadas;
}
    public function setVersoesSuportadas($versoes){
    $this->versoesSuportadas = $versoes;
}
    public function getMapasCompatibilidade(){
    return $this->mapasCompatibilidade;
}
    public function setMapasCompatibilidade($mapas){
    $this->mapasCompatibilidade = $mapas;
}
    public function rotearRequisicao($requisicao){
    
    }

    public function traduzirVersao($requisicao, $versaoOrigem, $versaoDestino){
    
    }

    public function validarAutenticacao($token){
    
    }


    public function aplicarRateLimiting($clienteId){
        
    }

    public function registrarMetrica($endpoint, $latencia){

    }
}
?>
