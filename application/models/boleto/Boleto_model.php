<?php

class Boleto_model {

    public $id_boleto;
    public $id_servico;
    public $vencimento;
    public $nr_boleto;
    public $valor_boleto;
    public $estado;

    public function __construct($obj = null) {
        if ($obj) {
            $this->id_boleto = $obj->id_boleto;
            $this->id_servico = $obj->id_servico;
            $this->vencimento = $obj->vencimento;
            $this->nr_boleto = $obj->nr_boleto;
            $this->valor_boleto = $obj->valor_boleto;
            $this->estado = $obj->estado;
        }
    }
    
    public function getEstado(){
        if($this->isVencido()){
            return "Vencido";
        }
        return $this->estado==2?"Pago":"Aberto";
    }
    
    public function getVencimento(){
        if (preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $this->vencimento)) { //verifica se é formato aaaa/mm/dd
            $partes = explode("-", $this->vencimento);
            $formato_brasil = $partes[2] . "/" . $partes[1] . "/" . $partes[0];
            return $formato_brasil;
        }
        return $this->vencimento;
    }
    
    public function getValorBoleto($cifrao=false){
        $valor= number_format($this->valor_boleto, 2, ",", ".");
        if($cifrao){
            return "R$ ".$valor;
        }
        return $valor;
    }
    
    public function isVencido(){
        $hoje=date("Y-m-d");
        if($hoje>$this->vencimento && $this->estado==1){
            return true;
        }
        return false;
    }
    
    public function getCssStatus(){
        $css="";
        if($this->isVencido()){
            $css="danger";
        }
        
        if($this->estado==2){
            $css="success";
        }
        return $css;
    }

}
