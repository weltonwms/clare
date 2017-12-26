<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relatorio extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logado')) {
            redirect("login");
        }
        $this->load->model('relatorio/Relatorio_manager', 'Relatorio_manager');
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
        $dados['active'] = 'relatorio';
        $this->load->view('html_header');
        $this->load->view('cabecalho');
        $this->load->view('menu_navegacao', $dados);
        $this->load->view($view_corpo, $dados);
        $this->load->view('rodape');
        $this->load->view('html_footer');
    }

    public function index()
    {
        $this->load->model('cliente/Cliente_manager', 'Cliente_manager');
        $this->load->model('produto/Produto_manager', 'Produto_manager');
        $this->load->model('servico/Servico_manager');
        $this->load->model('fornecedor/Fornecedor_manager', 'Fornecedor_manager');
        $dados['clientes'] = $this->Cliente_manager->get_clientes();
        $dados['produtos'] = $this->Produto_manager->get_produtos();
        $dados['fornecedores'] = $this->Fornecedor_manager->get_fornecedores();
        $dados['vendedores'] = $this->Servico_manager->get_vendedores();
        $this->carrega_view('relatorio/view_relatorio', $dados);
    }

    public function fluxo()
    {

        $this->carrega_view('relatorio/view_fluxo');
    }

    public function gerar_relatorio()
    {
        $this->load->model('cliente/Cliente_manager', 'Cliente_manager');
        $this->load->model('produto/Produto_manager', 'Produto_manager');
        $this->load->model('fornecedor/Fornecedor_manager', 'Fornecedor_manager');
        $this->load->model('servico/Servico_manager');
        $dados['clientes'] = $this->Cliente_manager->get_clientes();
        $dados['produtos'] = $this->Produto_manager->get_produtos();
        $dados['fornecedores'] = $this->Fornecedor_manager->get_fornecedores(1);
        $dados['requisicao'] = $this->input->post();
        $dados['vendedores'] = $this->Servico_manager->get_vendedores();
        $dados['relatorio'] = $this->Relatorio_manager->gerar_relatorio($this->input->post());


        $this->carrega_view('relatorio/view_relatorio', $dados);
    }

    public function gerar_fluxo()
    {

        $dados['requisicao'] = $this->input->post();

        $dados['relatorio'] = $this->Relatorio_manager->gerar_fluxo($this->input->post());

        //echo "<pre>"; print_r($dados); exit();
        $this->carrega_view('relatorio/view_fluxo', $dados);
    }

    public function imprimir()
    {
        $dados['requisicao'] = $this->input->post();
        if ($this->input->post('id_fornecedor')):
            $this->load->model('fornecedor/Fornecedor_manager', 'Fornecedor_manager');
            $dados['fornecedor'] = $this->Fornecedor_manager->get_fornecedor($this->input->post('id_fornecedor'));
        endif;

        $dados['relatorio'] = $this->Relatorio_manager->gerar_relatorio($this->input->post());
        $html = $this->load->view('relatorio/relatorio_impressao', $dados, TRUE);
        $this->load->library('pdf');
        $this->pdf->createPDF($html, 'relat');
    }

}
