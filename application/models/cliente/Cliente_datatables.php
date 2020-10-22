<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Classe responsável por receber requisições do Datatables e processar os dados para o mesmo
 */
class Cliente_datatables extends CI_Model {

    private function start() {
        $this->db->select('c.id_cliente, c.nome, c.endereco, c.telefone,'
                . 'c.responsavel');
                
        $this->db->from('cliente c');
        

    }

    private function pesquisa($search) {
        $this->db->like('c.nome', $search);
        $this->db->or_like('c.endereco', $search);
        $this->db->or_like('c.telefone', $search);
        $this->db->or_like('c.responsavel', $search);
        
    }

    /**
     * Método de entrada da classe. 
     * @param array $req parâmetros de requisição do Datatables
     * @return string json utilizado por Datatables
     */
    public function getTable($req) {
        $total = $this->db->count_all('cliente');
        $recordsFiltered = $total;

        $this->start();
        if ($req['search']['value']):
            $this->pesquisa($req['search']['value']);
            $recordsFiltered = $this->db->get()->num_rows(); //zera a query, por isso é necessário repetir a pesquisa
            $this->start();
            $this->pesquisa($req['search']['value']);
        endif;

        $order = $req['columns'][$req['order']['0']['column']]['name'];
        $direction = $req['order']['0']['dir'];
        $this->db->order_by($order, $direction);

        $this->db->limit($req["length"], $req["start"]);
        $clientes = $this->db->get()->result();

        $resposta = new stdClass();
        $resposta->draw = $req['draw'];
        $resposta->recordsTotal = (int) $total;
        $resposta->recordsFiltered = (int) $recordsFiltered;
        $resposta->data = $this->outputList($clientes);
//        $resposta->debug = $req;
//        $resposta->qu = $this->db->last_query();

        return json_encode($resposta);
        
    }

    private function outputList($clientes) {
       
        foreach ($clientes as $item):

           

            $edit = ' <a class="btn btn-default"
                            data-toggle="tooltip"
                            title="Editar"
                            href="' . base_url("cliente/editar/" . $item->id_cliente) . '">
                            <span class="glyphicon glyphicon-pencil"></span> 
                        </a>';
            $delete = ' <a class="confirm btn btn-danger" 
                           data-toggle="tooltip"
                            title="Excluir"
                            href="' . base_url("cliente/excluir/" . $item->id_cliente) . '">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>';

           
            $item->acoes = $edit . $delete;
           
            $item->nome = $item->nome . " <a class='detalhe_cliente'  href='#' data-id_cliente='{$item->id_cliente}'><span class='glyphicon glyphicon-eye-open'> </span></a>";
        endforeach;
        return $clientes;
    }

}
