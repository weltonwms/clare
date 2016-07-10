<?php


class Relatorio_model extends CI_Model{
  private $itens_servico; //lista de Item_servico_composite
  
  function __construct() {
      parent::__construct();
  }
  
  public function set_itens_servico(array $itens_servico){
      $this->itens_servico=$itens_servico;
  }
  
  public function get_itens_servico(){
      return $this->itens_servico;
  }
  
  public function get_total_geral(){
      
      $valor=0;
      foreach ($this->itens_servico as $item_servico):
          $valor+=$item_servico->get_total_venda();
      endforeach;
      return $valor;
      
  }
  
  public function get_total_geral_formatado(){
      return "R$ ". number_format($this->get_total_geral(),2,',','.');
  }
  
  public function get_total_lucro(){
      
      $valor=0;
      foreach ($this->itens_servico as $item_servico):
          $valor+=$item_servico->get_lucro();
      endforeach;
      return $valor;
      
  }
  
  public function get_total_lucro_formatado(){
      return "R$ ". number_format($this->get_total_lucro(),2,',','.');
  }

}

?>