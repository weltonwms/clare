<?php

/*
 * Esta Classe é a classe entrada do Model Relatorio. Responsável por intermediar com o
 * Controler. .
 */

class Relatorio_manager extends CI_Model {
    //protected $result_query; //array com resultado da query
     
    function __construct() {
        parent::__construct();
       
        $this->load->helper('util');
        $this->load->model('item_servico/Item_servico_composite');
        $this->load->model('item_servico/Item_servico_model');
        $this->load->model('servico/Servico_model');
        $this->load->model('cliente/Cliente_model');
        $this->load->model('produto/Produto_model');
        $this->load->model('relatorio/Relatorio_model');
    }

   public function gerar_relatorio($post){
       $lista = array();
       $query=$this->executar_query($post);
       /*
       $this->result_query=$query;
       $lista = $this->montar_objetos_composite();
       echo "<pre>"; print_r($lista); exit();
       */
       foreach($query as $valor):
          
           $composite= new $this->Item_servico_composite();
           $cliente= new $this->Cliente_model();
           $item_servico=new $this->Item_servico_model();
           $servico=new $this->Servico_model();
           $produto=new $this->Produto_model();
           $item_servico->set_id_item($valor->id_item);
           $item_servico->set_id_servico($valor->id_servico);
           $item_servico->set_id_produto($valor->id_produto);
           $item_servico->set_descricao($valor->descricao);
           $item_servico->set_qtd_produto($valor->qtd_produto);
           $item_servico->set_total_venda($valor->total_venda);
           $item_servico->set_total_fornecedor($valor->total_fornecedor);
           
           $servico->set_id_servico($valor->id_servico);
           $servico->set_data($valor->data);
           $servico->set_estado($valor->estado);
           $servico->set_tipo($valor->tipo);
           $servico->set_porcentagem_comissao($valor->porcentagem_comissao);
           $cliente->set_nome($valor->nome_cliente);
           
           $produto->set_nome($valor->nome_produto);
           $produto->set_id_fornecedor($valor->id_fornecedor);
           
           $composite->set_cliente($cliente);
           $composite->set_item_servico($item_servico);
           $composite->set_servico($servico);
           $composite->set_produto($produto);
           
           $lista[]=$composite;
          
       endforeach;
        
       $relatorio= new $this->Relatorio_model();
       $relatorio->set_itens_servico($lista);
       //echo "<pre>"; print_r($relatorio); exit();
       return $relatorio;
    
      
   }
   
   private function executar_query($post){
       //echo "<pre>"; print_r($post['estado']); exit();
       $this->db->select('*, p.nome nome_produto, 
           c.nome nome_cliente');
       $this->db->from('item_servico i');
       $this->db->join('servico s', 'i.id_servico = s.id_servico', 'inner');
       $this->db->join('produto p', 'i.id_produto = p.id_produto', 'inner');
       $this->db->join('fornecedor f', 'p.id_fornecedor = f.id_fornecedor', 'inner');
       $this->db->join('cliente c', 's.id_cliente = c.id_cliente', 'inner');
       if($post['id_cliente']):
             $this->db->where('s.id_cliente', $post['id_cliente']);
       endif;
       if($post['id_produto']):
            $this->db->where('i.id_produto', $post['id_produto']);
       endif;
      
        if($post['id_fornecedor']):
            $this->db->where('p.id_fornecedor', $post['id_fornecedor']);
       endif;
       
       if($post['periodo_inicial']):
          $periodo_inicial = formatar_data_to_mysql($post['periodo_inicial']);
          $this->db->where('s.data >=', $periodo_inicial);
       endif;
       if($post['periodo_final']):
           $periodo_final = formatar_data_to_mysql($post['periodo_final']);
           $this->db->where('s.data <=',$periodo_final);
       endif;
       if(isset($post['estado']) && !empty($post['estado'][0])):
            $this->db->where_in('s.estado', $post['estado']);
       endif;
       
       if($post['tipo']):
            $this->db->where('s.tipo', $post['tipo']);
       endif;
        if($post['ordenado_por']):
           $ordem=array('cliente'=>'c.nome', 'produto'=>'p.nome','data'=>'s.data','id_servico'=>'s.id_servico');
           $this->db->order_by($ordem[$post['ordenado_por']]);
       endif;
       
       $resultado = $this->db->get()->result();
       //echo "<pre>"; echo $this->db->last_query(); exit();
       //echo "<pre>"; print_r($resultado); exit();
       return $resultado;
   }
   
   /*
   protected function set_atributos($objeto_banco, $objeto) {

        $attr = $objeto->get_atributos();
        foreach ($attr as $key => $valor):

            $metodo = "set_$key";
            if (method_exists($objeto, $metodo)):
                $objeto->$metodo(isset($objeto_banco->$key) ? $objeto_banco->$key : null);
            endif;
        endforeach;
        $this->after_set_atributos($objeto_banco,$objeto);
    }
    
    protected function after_set_atributos($objeto_banco,$objeto){
        if($objeto instanceof Produto_model):
            $objeto->set_nome($objeto_banco->nome_produto);
        endif;
        
        if($objeto instanceof Cliente_model):
            $objeto->set_nome($objeto_banco->nome_cliente);
        endif;
    }

        protected function montar_objetos_composite() {
        $array = array();
        foreach ($this->result_query as $objeto_banco):
            $array[] = $this->montar_objeto_composite($objeto_banco);
        endforeach;
        return $array;
    }

    private function montar_objeto_composite($objeto_banco) {
        $componentes = $this->get_componentes_composite();
        $objeto_composite = $componentes[0];
        unset($componentes[0]);
        foreach ($componentes as $componente):
            $this->set_atributos($objeto_banco, $componente);
        endforeach;

        foreach ($componentes as $componente):
            $classe = get_class($componente);
            $classe_limpa = strtolower(str_replace("_model", "", $classe));
            $metodo = "set_" . $classe_limpa;
            $objeto_composite->$metodo($componente);
        endforeach;

        return $objeto_composite;
    }
    
    protected function get_componentes_composite() {

        $componentes = array(
            new Item_servico_composite(),
            new Item_servico_model(),
            new Cliente_model(),
            new Servico_model(),
            new Produto_model
        );
        return $componentes;
    }
    * 
    */
}

