<?php

/*
 * Esta Classe é a classe entrada do Model Relatorio. Responsável por intermediar com o
 * Controler. .
 */

class Relatorio_manager extends CI_Model {

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
       
       foreach($query as $valor):
          
           $composite= new $this->Item_servico_composite();
           $cliente= new $this->Cliente_model();
           $item_servico=new $this->Item_servico_model();
           $servico=new $this->Servico_model();
           $produto=new $this->Produto_model();
           $item_servico->set_id($valor->id);
           $item_servico->set_id_servico($valor->id_servico);
           $item_servico->set_id_produto($valor->id_produto);
           $item_servico->set_qtd_produto($valor->qtd_produto);
           $item_servico->set_valor_final($valor->valor_final);
           
           $servico->set_id_servico($valor->id_servico);
           $servico->set_data($valor->data);
           $servico->set_estado($valor->estado);
           $servico->set_tipo($valor->tipo);
            
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
       return $relatorio;
       
       
       
      
   }
   
   private function executar_query($post){
       
       $this->db->select('i.id, i.id_servico, i.id_produto, i.qtd_produto, 
           i.valor_final, s.data, s.estado, s.tipo, p.nome nome_produto, 
           p.id_fornecedor, c.nome nome_cliente');
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
       if($post['estado']):
            $this->db->where('s.estado', $post['estado']);
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
}

