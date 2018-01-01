<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pagamento extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logado')) {
            redirect("login");
        }
        $this->load->model('pagamento/Pagamento_manager');
    }

    public function cadastrar_pagamento($id_servico)
    {

        $this->valida_cadastro($id_servico);
        $dados = $this->input->post();
        $dados['id_servico'] = $id_servico;
        if ($dados['operacao'] == 1):
            unset($dados['id_fornecedor']);
        endif;
        //unset($dados['fornecedor']);
        $this->Pagamento_manager->salvar($dados);
    }

    public function editar_pagamento()
    {
        $dados = $this->valida_edicao($this->input->post());
        $this->db->where('id_pagamento', $dados['id_pagamento']);
        echo $this->db->update('pagamento', $dados);
    }

    public function excluir_pagamento($id_pagamento)
    {
        $this->Pagamento_manager->excluir($id_pagamento);
    }

    public function valida_cadastro($id_servico)
    {

        $msg = '';
        if (!$this->input->post('valor_pago') || !$this->input->post('tipo_pagamento') || !$this->input->post('operacao')):
            $msg = "Dados Requeridos não Preenchidos";
            return $this->saida_http($msg, 400);
        endif;

        $this->load->model('servico/Servico_dao');
        $servico = $this->Servico_dao->get_servico_composite($id_servico);
        if ($this->input->post('operacao') == 1):
            return $this->valida_cadastro_credito($servico);
        else:
            return $this->valida_cadastro_debito($servico);
        endif;
    }

    public function valida_cadastro_credito($servico)
    {
        $soma_pagamentos = $servico->get_soma_pagamentos(CREDITO);
        $total_venda = $servico->get_total_geral_venda();
        $request_valor = moneyBrToUsd($this->input->post('valor_pago'));
        if (($request_valor + $soma_pagamentos) > $total_venda):
            $msg = "Valores Pagos maiores que a Venda<br>";
            $restante = $total_venda - $soma_pagamentos;
            $msg.="Faltam $restante a ser pago";
            return $this->saida_http($msg, 400);

        endif;
    }

    public function valida_cadastro_debito($servico)
    {
        if (!$this->input->post('id_fornecedor')):
            $msg = "Necessário informar Fornecedor em Débitos";
            return $this->saida_http($msg, 400);
        endif;

        $soma_pagamentos = $servico->get_soma_pagamentos(DEBITO);
        $total_fornecedor = $servico->get_total_geral_fornecedor();
        $request_valor = moneyBrToUsd($this->input->post('valor_pago'));
        if (($request_valor + $soma_pagamentos) > $total_fornecedor):
            $msg = "Valores Pagos maiores que total Débito Fornecedor<br>";
            $restante = $total_fornecedor - $soma_pagamentos;
            $msg.="Faltam $restante a ser pago ao(s) fornecedor(es)";
            return $this->saida_http($msg, 400);

        endif;
    }

    public function valida_edicao($post)
    {
        $msg = '';

        if (!$this->input->post('id_pagamento') || !$this->input->post('id_servico')):
            $msg = "Identificador não enviado";
            return $this->saida_http($msg, 400);
        endif;

        if (isset($post['data']) && !$post['data']):
            $msg = "Data Vazia";
            return $this->saida_http($msg, 400);
        endif;

        if (isset($post['valor_pago']) && !$post['valor_pago']):
            $msg = "Valor Pago Vazio";
            return $this->saida_http($msg, 400);
        endif;

        if (isset($post['data']) && !preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $post['data'])):
            $msg = "Data Inválida";
            return $this->saida_http($msg, 400);
        endif;

        if (isset($post['data']) && $post['data']):
            $post['data'] = formatar_data_to_mysql($post['data']);

        endif;

        if (isset($post['valor_pago']) && $post['valor_pago']):
            $this->load->model('servico/Servico_dao');
            $servico = $this->Servico_dao->get_servico_composite($post['id_servico']);
            $pg_atual = $servico->get_pagamento($post['id_pagamento']);

            if ($pg_atual->get_operacao() == 1):
               return $this->valida_edicao_credito($servico,$pg_atual,$post);
            else:
                return $this->valida_edicao_debito($servico,$pg_atual,$post);
            endif;
        endif;
        return $post;

        
    }

    public function valida_edicao_credito($servico, $pg_atual, $post)
    {
        $soma_pagamentos = $servico->get_soma_pagamentos(CREDITO);
        $total_venda = $servico->get_total_geral_venda();

        $request_valor = moneyBrToUsd($post['valor_pago']);
        if (($request_valor + ($soma_pagamentos - $pg_atual->get_valor_pago())) > $total_venda):
            $msg = "Valores Pagos pelo Cliente maiores que a Venda<br>";
            $restante = $total_venda - $soma_pagamentos;
            $msg.="Faltam $restante a ser pago pelo Cliente";
            return $this->saida_http($msg, 400);

        endif;
        $post['valor_pago'] = $request_valor;
        return $post;
    }

    public function valida_edicao_debito($servico, $pg_atual, &$post)
    {
        $soma_pagamentos = $servico->get_soma_pagamentos(DEBITO);
        $total_fornecedor = $servico->get_total_geral_fornecedor();

        $request_valor = moneyBrToUsd($post['valor_pago']);
        if (($request_valor + ($soma_pagamentos - $pg_atual->get_valor_pago())) > $total_fornecedor):
            $msg = "Valores Pagos maiores que Total Fornecedor<br>";
            $restante = $total_fornecedor - $soma_pagamentos;
            $msg.="Faltam $restante a serem pagos ao Fornecedor";
            return $this->saida_http($msg, 400);

        endif;
        $post['valor_pago'] = $request_valor;
        return $post;
    }

    public function saida_http($msg, $status)
    {
        $this->output->set_status_header($status);
        echo $msg;
        exit();
    }

}
