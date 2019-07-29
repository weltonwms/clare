<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Classe responsável por receber requisições do Datatables e processar os dados para o mesmo
 */
class Servico_datatables extends CI_Model {

    private function start() {
        $this->db->select('s.id_servico, s.estado as id_estado, DATE_FORMAT(s.data, "%d/%m/%Y") as dt,'
                . 'c.nome as cliente, v.nome as vendedor,'
                . 'st.tipo, se.estado');
        $this->db->from('servico s');
        $this->db->join('cliente c', 's.id_cliente=c.id_cliente', 'left');
        $this->db->join('vendedor v', 's.id_vendedor=v.id', 'left');
        $this->db->join('servico_tipo st', 'st.id=s.tipo', 'left');
        $this->db->join('servico_estado se', 'se.id=s.estado', 'left');

    }

    private function pesquisa($search) {
        $this->db->like('c.nome', $search);
        $this->db->or_like('v.nome', $search);
        $this->db->or_like('s.id_servico', $search);
        $this->db->or_like('DATE_FORMAT(data, "%d/%m/%Y")', $search);
        $this->db->or_like('st.tipo', $search);
        $this->db->or_like('se.estado', $search);
    }

    /**
     * Método de entrada da classe. 
     * @param array $req parâmetros de requisição do Datatables
     * @return string json utilizado por Datatables
     */
    public function getTable($req) {
        $total = $this->db->count_all('servico');
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
        $servicos = $this->db->get()->result();

        $resposta = new stdClass();
        $resposta->draw = $req['draw'];
        $resposta->recordsTotal = (int) $total;
        $resposta->recordsFiltered = (int) $recordsFiltered;
        $resposta->data = $this->outputList($servicos);
//        $resposta->debug = $req;
//        $resposta->qu = $this->db->last_query();

        return json_encode($resposta);
        
    }

    private function outputList($servicos) {
        $list = array();
        foreach ($servicos as $item):

            $imprimir = ' <a target="_blank" class="btn_imprimir btn btn-default" 
                           data-id_servico="' . $item->id_servico . '" 
                            data-estado="' . $item->id_estado . '"
                            data-toggle="tooltip"
                           title="Imprimir"
                          href="' . base_url("servico/imprimir/" . $item->id_servico) . '">
                            <span class="glyphicon glyphicon-print"></span> 
                           </a>';
            $pagamentos = '<span title="Pagamentos" data-toggle="tooltip">
                        <a class="btn btn-success" data-toggle="modal" data-target="#myModal"
                            
                            data-id_servico="' . $item->id_servico . '" >
                            <span class="glyphicon glyphicon-usd"></span>
                         </a>
                         </span>';

            $edit = ' <a class="btn btn-default"
                            data-toggle="tooltip"
                            title="Editar"
                            href="' . base_url("servico/editar/" . $item->id_servico) . '">
                            <span class="glyphicon glyphicon-pencil"></span> 
                        </a>';
            $delete = ' <a class="confirm_servico btn btn-danger" 
                           data-toggle="tooltip"
                            title="Excluir"
                            href="' . base_url("servico/excluir/" . $item->id_servico) . '">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>';

            $estado = "<span class='estado'>{$item->estado}</span>";
            if ($item->id_estado != 2):
                $estado .= '<a class="confirm_executar_servico" data-toggle="tooltip" title="Avançar Estado do Serviço"';
                $estado .= 'href="' . base_url("servico/executar_servico/" . $item->id_servico) . '">';
                $estado .= '<span class="glyphicon glyphicon-ok"></span> </a>';
            endif;
            $item->acoes = $imprimir . $edit . $pagamentos . $delete;
            $item->estado = $estado;
            $item->id_servico = $item->id_servico . " <a class='detalhe_servico'  href='#' data-id_servico='{$item->id_servico}'><span class='glyphicon glyphicon-eye-open'> </span></a>";
        endforeach;
        return $servicos;
    }

}
