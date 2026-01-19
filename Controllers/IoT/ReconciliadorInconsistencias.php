<?php 

class ReconciliadorInconsistencias{
    
    private $frequenciaVerificacao;
    private $inconsistenciasDetectadas;
    private $acoesCorretivas;


    public function __construct($frequencia, $inconsistencia, $acoes){
        
        $this->frequenciaVerificacao = $frequencia;
        $this->inconsistenciaDetectadas = $inconsistencia;
        $this->acoesCorretivas = $acoes;
    }

    public function getFrequenciaVerificacao(){
    return $this->frequenciaVerificacao;
}
    public function setFrequenciaVerificacao($frequencia){
    $this->frequenciaVerificacao = $frequencia;
}
    public function getInconsistenciaDetectadas(){
    return $this->inconsistenciaDetectadas;
}
    public function setInconsistenciaDetectadas($inconsistencia){
    $this->inconsistenciaDetectadas = $inconsistencia;
}
    public function getAcoesCorretivas(){
    return $this->acoesCorretivas;
}
    public function setAcoesCorretivas($acoes){
    $this->acoesCorretivas = $acoes;
}
    public function executarVerificacao(){
    
    }

    public function identificarInconsistencias(){
    
    }

    public function classificarInconsistencia($inconsistencia){
    
    }

    public function executarCorrecao($inconsistencia){
    
    }

    public function escalarParaOperador($inconsistencia){
    
    }

    public function registrarAuditoria($acao, $resultado){
    
    }
}

?>
