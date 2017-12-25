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
        $dados = array(
            'id_servico' => $id_servico,
            'data' => $this->input->post('data'),
            'valor_pago' => $this->input->post('valor_pago'),
            'tipo_pagamento' => $this->input->post('tipo_pagamento'),
        );
        $this->Pagamento_manager->salvar($dados);
    }

    public function excluir_pagamento($id_pagamento)
    {
        $this->Pagamento_manager->excluir($id_pagamento);
    }

    public function valida_cadastro($id_servico)
    {

        $msg = '';
        if (!$this->input->post('valor_pago') || !$this->input->post('tipo_pagamento')):
            $msg="Dados Requeridos não Preenchidos";
            return $this->saida_http($msg, 400);
        endif;
        
        $this->load->model('servico/Servico_dao');
        $servico= $this->Servico_dao->get_servico_composite($id_servico);
        $soma_pagamentos=$servico->get_soma_pagamentos();
        $total_venda=$servico->get_total_geral_venda();
        $request_valor=  moneyBrToUsd($this->input->post('valor_pago'));
        if( ($request_valor+$soma_pagamentos) > $total_venda):
            $msg= "Valores Pagos maiores que a Venda<br>";
            $restante=$total_venda - $soma_pagamentos;
            $msg.="Faltam $restante a ser pago";
            return $this->saida_http($msg, 400);
      
        endif;
        
    }

    public function saida_http($msg, $status)
    {
        $this->output->set_status_header($status);
        echo $msg;
        exit();
    }

}
