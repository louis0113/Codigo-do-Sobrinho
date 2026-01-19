<?php

class MonitorOperacional {

    private $entregadoresAtivos;
    private $pedidosEmAndamento;
    private $alertasAtivos;
    private $metricasTempoReal;

    public function __construct($entregadores, $pedidos, $alertas, $metricas){
        $this->entregadoresAtivos = $entregadores;
        $this->pedidosEmAndamento = $pedidos;
        $this->alertasAtivos = $alertas;
        $this->metricasTempoReal = $metricas;
    }

    public function getEntregadoresAtivos(){
    return $this->entregadoresAtivos;
}
    public function setEntregadoresAtivos($entregadores){
    $this->entregadoresAtivos = $entregadores;
}
    public function getPedidosEmAndamento(){
    return $this->pedidosEmAndamento;
}
    public function setPedidosEmAndamento($pedidos){
    $this->pedidosEmAndamento = $pedidos;
}
    public function getAlertasAtivos(){
    return $this->alertasAtivos;
}
    public function setAlertasAtivos($alertas){
    $this->alertasAtivos = $alertas;
}
    public function getMetricasTempoReal(){
    return $this->metricasTempoReal;
}
    public function setMetricasTempoReal($metricas){
    $this->metricasTempoReal = $metricas;
}
    public function obterPosicaoEntregadores(){
    
    }

    public function detectarAnomalias(){
    
    }

    public function gerarDashboard(){
    
    }

    public function notificarOperador($alerta){
    
    }

    public function atualizarMetricas(){
    
    }
}

?>
