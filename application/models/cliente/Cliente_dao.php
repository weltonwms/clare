<?php

class Cliente_dao extends CI_Model{
    
    function __construct() {
        parent::__construct();
        $this->load->model('cliente/Cliente_model','Cliente_model');
    }
    
    public function get_clientes(){
         $this->db->order_by("nome", "asc"); 
         $clientes_banco=$this->db->get('cliente')->result();
         if(count($clientes_banco)>0){
             $lista=array();
             foreach ($clientes_banco as $cliente){
                 $lista[]=  $this->get_cliente($cliente->id_cliente);
             }
             
             return $lista;
         }
         return;
    }
    
    public function get_cliente($id_cliente){
        $this->db->where('id_cliente',$id_cliente);
        $cliente_banco=$this->db->get('cliente')->result();
        if(count($cliente_banco)==1){
            $cliente=  new $this->Cliente_model();
            $cliente->set_id_cliente($cliente_banco[0]->id_cliente);
            $cliente->set_nome($cliente_banco[0]->nome);
            $cliente->set_endereco($cliente_banco[0]->endereco);
            $cliente->set_telefone($cliente_banco[0]->telefone);
            $cliente->set_telefone2($cliente_banco[0]->telefone2);
            $cliente->set_telefone3($cliente_banco[0]->telefone3);
            $cliente->set_responsavel($cliente_banco[0]->responsavel);
            $cliente->set_cnpj($cliente_banco[0]->cnpj);
            $cliente->set_email($cliente_banco[0]->email);
            return $cliente;
        }
        return;
    }
    
    public function get_cliente_vazio(){
        return new $this->Cliente_model();
    }
    
    
}

?>
