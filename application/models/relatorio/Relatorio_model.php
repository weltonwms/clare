<?php


class Relatorio_model extends CI_Model{
  private $itens_servico; //lista de Item_servico_composite
  private $pagamentos; //lista de Pagamento_composite
  
  function __construct() {
      parent::__construct();
  }
  
  public function set_itens_servico(array $itens_servico){
      $this->itens_servico=$itens_servico;
  }
  
  public function set_pagamentos(array $pagamentos){
      $this->pagamentos=$pagamentos;
  }
  
  public function get_itens_servico(){
      return $this->itens_servico;
  }
  
  public function get_pagamentos($operacao){
      return $this->separar_por_operacao($operacao);
  }
  
  
  private function separar_por_operacao($operacao){
      $lista=array();
      foreach($this->pagamentos as $pagamento):
          if($pagamento->get_operacao()==$operacao):
              $lista[]=$pagamento;
          endif;
      endforeach;
      
      return $lista;
  }
  
  public function get_soma_pagamentos($operacao)
  {
      $soma=0;
      foreach($this->get_pagamentos($operacao) as $pagamento):
          $soma+=$pagamento->get_valor_pago();
      endforeach;
      return $soma;
      
  }
  
  public function get_lucro()
  {
      return $this->get_soma_pagamentos(CREDITO)-$this->get_soma_pagamentos(DEBITO);
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
  
  public function get_total_pago(){
      
      $valor=0;
      foreach ($this->pagamentos as $pagamento):
          $valor+=$pagamento->get_valor_pago();
      endforeach;
      return $valor;
      
  }

}

