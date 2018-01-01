<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Servico extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logado')) {
            redirect("login");
        }
        $this->load->model('servico/Servico_manager');
    }

    /*     * *************************************************************************
     * O metodo carrega_view() carrega os arquivos php que estao na passta view
     * e representa o layout. Recebe como parâmetro obrigatório o nome do arquivo
     * do corpo que será carregado e opcionamente um array de dados para 
     * introduzir na visão do corpo
     * *************************************************************************
     */

    public function carrega_view($view_corpo, $dados = null)
    {
        $dados['active'] = 'servico';
        $this->load->view('html_header');
        $this->load->view('cabecalho');
        $this->load->view('menu_navegacao', $dados);
        $this->load->view($view_corpo, $dados);
        $this->load->view('rodape');
        $this->load->view('html_footer');
    }

    public function index()
    {
        //$this->output->enable_profiler(TRUE);
        $dados['servicos'] = $this->Servico_manager->get_servicos();
        //echo "<pre>"; print_r($dados); exit();
        $this->carrega_view('servico/manter_servicos', $dados);
    }

    public function ajax()
    {
        $servicos = $this->Servico_manager->get_servicos();
        $dados['data'] = array();
        //$servico = $servicos[0];
        foreach ($servicos as $servico):
            $arr = array();

            $arr['id'] = $servico->get_id_servico() . " <a class='detalhe_servico' href='' data-id_servico='{$servico->get_id_servico()}'><span class='glyphicon glyphicon-eye-open'> </span></a>";
            $arr['cliente'] = $servico->get_nome_cliente();
            $arr['data'] = $servico->get_data();
            $arr['estado'] = "<span class='estado'>{$servico->get_nome_estado()}</span>";
            if ($servico->get_estado() != 2):
                $arr['estado'].='<a class="confirm_executar_servico" data-toggle="tooltip" title="Avançar Estado do Serviço"';
                $arr['estado'].='href="' . base_url('servico/executar_servico') . '/' . $servico->get_id_servico() . '">';
                $arr['estado'].='<span class="glyphicon glyphicon-ok"></span> </a>';
            endif;
            $arr['tipo'] = $servico->get_nome_tipo();
            $arr['vendedor'] = $servico->get_nome_vendedor();
            $arr['extn'] = $servico->get_id_servico();
            $arr['acoes'] = ' <a target="_blank" class="btn_imprimir btn btn-default" 
                           data-id_servico="' . $servico->get_id_servico() . '"' .
                    'data-estado="' . $servico->get_estado() . '"' .
                    'data-toggle="tooltip"
                           title="Imprimir"
                           href="' . base_url('servico/imprimir') . '/' . $servico->get_id_servico() . '">
                            <span class="glyphicon glyphicon-print"></span> 
                           </a>
                           
                   
                        <a class="btn btn-default"
                            data-toggle="tooltip"
                           title="Editar"
                            href="' . base_url('servico/editar') . '/' . $servico->get_id_servico() . '">
                            <span class="glyphicon glyphicon-pencil"></span> 
                        </a>
                        
                        <span title="Pagamentos" data-toggle="tooltip">
                        <a class="btn btn-success" data-toggle="modal" data-target="#myModal"
                            
                            data-id_servico="'.$servico->get_id_servico().'" >
                            <span class="glyphicon glyphicon-usd"></span>
                         </a>
                         </span>
                         
                        <a class="confirm_servico btn btn-danger" 
                            data-toggle="tooltip"
                            title="Excluir"
                           href="' . base_url('servico/excluir') . '/' . $servico->get_id_servico() . '">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                        

                        ';
            $dados['data'][] = $arr;

        endforeach;
        echo json_encode($dados);
        exit();
    }

    public function salvar_servico($redirect_back=null)
    {

        $retorno = $this->Servico_manager->salvar($this->input->post());

        if ($retorno['status'] > 0) {
            $this->session->set_flashdata('status', 'success');
            $this->session->set_flashdata('msg_confirm', "{$retorno['acao_executada']} com Sucesso!");
        } elseif ($retorno['acao_executada'] != 'alteracao' && $retorno['status'] == 0) {
            $this->session->set_flashdata('status', 'danger');
            $this->session->set_flashdata('msg_confirm', 'Não foi Possível Salvar Serviço!');
        }
        
        if($redirect_back):
            $id_servico=$retorno['acao_executada']=='cadastro'?$retorno['status']:$this->input->post('id_servico');
            redirect(base_url("servico/editar/$id_servico"));
        else:
            //exit('redirecionar para servicos');
            redirect(base_url('servico'));
        endif;
        
    }

    public function editar($id_servico = null)
    {

        $this->load->model('cliente/Cliente_manager', 'Cliente_manager');
        $this->load->model('produto/Produto_manager', 'Produto_manager');
        $dados['clientes'] = $this->Cliente_manager->get_clientes();
        $dados['produtos'] = $this->Produto_manager->get_produtos();
        $dados['servico'] = $this->Servico_manager->get_servico($id_servico);
        $dados['vendedores'] = $this->Servico_manager->get_vendedores();
        $this->carrega_view('servico/edicao_servico', $dados);
    }

    public function excluir($id_servico)
    {
        $retorno = $this->Servico_manager->excluir($id_servico);
        if ($retorno) {
            $this->session->set_flashdata('status', 'success');
            $this->session->set_flashdata('msg_confirm', 'Serviço Excluído com Sucesso!');
        } else {
            $this->session->set_flashdata('status', 'danger');
            $this->session->set_flashdata('msg_confirm', 'Não foi possível Excluir Serviço!');
        }
        redirect(base_url('servico'));
    }

    public function imprimir($id_servico)
    {
        $imprimir_total = $this->input->get('imprimir_total') == "" ? 1 : $this->input->get('imprimir_total');
        $dados['servico'] = $this->Servico_manager->get_servico($id_servico);
        $dados['imprimir_total'] = $imprimir_total;
        $html = $this->load->view('servico/impressao_servico', $dados, TRUE);
        $this->load->library('pdf');
        $this->pdf->createPDF($html, 'relat');
    }

    public function manter_itens_servico()
    {
        //echo "<pre>"; print_r($this->input->post()); exit();
        $retorno = $this->Servico_manager->manter_itens_servico($this->input->post());
        $id_servico = $retorno['id_servico'];
        //echo "<pre>"; print_r($retorno); exit();
        if ($retorno['status']) {
            $this->session->set_flashdata('status', 'success');
            $this->session->set_flashdata('msg_confirm', 'Serviço Salvo com Sucesso!');
        } elseif ($retorno['acao_executada'] != 'alteracao' && !$retorno['status']) {
            $this->session->set_flashdata('status', 'danger');
            $this->session->set_flashdata('msg_confirm', 'Não foi Possível Salvar Serviço!');
        }
        redirect(base_url("servico/editar/$id_servico"));
    }

    public function excluir_item_servico($id_item_servico, $id_servico)
    {
        $retorno = $this->Servico_manager->excluir_item_servico($id_item_servico);
        if ($retorno) {
            $this->session->set_flashdata('status', 'success');
            $this->session->set_flashdata('msg_confirm', 'Item de Serviço Excluído com Sucesso!');
        } else {
            $this->session->set_flashdata('status', 'danger');
            $this->session->set_flashdata('msg_confirm', 'Não foi possível Excluir Item de Serviço!');
        }
        redirect(base_url("servico/editar/$id_servico"));
    }

    public function clonar()
    {
        $retorno = $this->Servico_manager->clonar($this->input->post());
        if ($retorno) {
            $this->session->set_flashdata('status', 'success');
            $this->session->set_flashdata('msg_confirm', 'Serviço Clonado com Sucesso!');
        } else {
            $this->session->set_flashdata('status', 'danger');
            $this->session->set_flashdata('msg_confirm', 'Não foi possível Clonar o Serviço!');
        }
        redirect(base_url('servico'));
    }

    public function executar_servico($id_servico)
    {
        $retorno = $this->Servico_manager->executar_servico($id_servico);
        if ($retorno) {
            $this->session->set_flashdata('status', 'success');
            $this->session->set_flashdata('msg_confirm', 'Estado Mudado com Sucesso!');
        } else {
            $this->session->set_flashdata('status', 'danger');
            $this->session->set_flashdata('msg_confirm', 'Não foi possível Mudar o Estado!');
        }
        redirect(base_url('servico'));
    }

    public function detalhar_servico_ajax($id_servico)
    {
        $dados['servico'] = $this->Servico_manager->get_servico($id_servico);
        $this->load->view('servico/servico_detalhado_ajax', $dados);
    }

   
    public function x3($id_servico)
    {
        
        $x = $this->Servico_manager->get_servico($id_servico);
        $dados['id_servico'] = $x->get_id_servico();
        $dados['cliente_nome'] = $x->get_nome_cliente();
        $dados['total_venda'] = number_format($x->get_total_geral_venda(), 2, ",", ".");
        $dados['total_pago_credito'] = number_format($x->get_soma_pagamentos(CREDITO), 2, ",", ".");
        $restante_credito=$x->get_total_geral_venda()-$x->get_soma_pagamentos(CREDITO);
        $dados['total_restante_credito'] = number_format($restante_credito, 2, ",", ".");
        $dados['pagamentos_credito'] = $x->get_array_pagamentos(CREDITO);
        
         $dados['total_fornecedor'] = number_format($x->get_total_geral_fornecedor(), 2, ",", ".");
         $dados['fornecedores'] = $x->get_array_fornecedores_servico();
         $dados['pagamentos_debito'] = $x->get_array_pagamentos(DEBITO);
         $dados['total_pago_debito'] = number_format($x->get_soma_pagamentos(DEBITO), 2, ",", ".");
         $restante_debito=$x->get_total_geral_fornecedor()-$x->get_soma_pagamentos(DEBITO);
        $dados['total_restante_debito'] = number_format($restante_debito, 2, ",", ".");
        echo json_encode($dados);
     }

   

    public function teste1()
    {
        $this->load->model("datatables/Data_tables");
        $colunas = array('id_servico', 'cliente', 'data', 'estado', 'tipo');
        $tabela = "xTemp";
        $this->Data_tables->inicializar($this->input->post(), $colunas, $tabela);
        $saida = $this->Data_tables->get_saida();
        echo json_encode($saida);
    }

    public function teste2()
    {
        $this->load->model('fornecedor/Fornecedor_dao');
        echo "<pre>";
        print_r($this->Fornecedor_dao->get_fornecedor(5));
        echo "fal";
    }

}
