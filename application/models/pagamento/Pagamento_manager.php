<?php

/*
 * Esta Classe é a classe entrada do Model. Responsável por intermediar com o
 * Controler. Ela utiliza as outras Classes Model que ajudam a realizar todo o 
 * trabalho com  o Pagamento.
 */
include_once( APPPATH . 'models/generic/Generic_manager.php');

class Pagamento_manager extends Generic_manager {

    function __construct()
    {
        parent::__construct();
        $this->load->model('pagamento/Pagamento_model', 'Pagamento_model');
    }

    protected function after_set_objeto($model, $post)
    {
        $model->set_valor_pago($post['valor_pago'], 1);
    }

    protected function get_model()
    {

        return $this->Pagamento_model;
    }

    protected function get_nome_id()
    {
        return "id_pagamento";
    }

    public function automatizar_pagamento($id_servico)
    {
        $this->load->model('servico/Servico_dao');
        $servico= $this->Servico_dao->get_servico_composite($id_servico);
        $soma_pagamentos=$servico->get_soma_pagamentos();
        $total_venda=$servico->get_total_geral_venda();
        $a_pagar=$total_venda-$soma_pagamentos;
        
        if($a_pagar>0):
            $dados['id_servico']=$id_servico;
        //manager programado para receber valores em br
            $dados['valor_pago']= moneyUsdToBr($a_pagar); 
            $dados['data']=date('d\/m\/Y');
            $dados['tipo_pagamento']=null;
            $this->cadastrar($dados);
        endif;
//        echo "total da Venda".$total_venda. "<br>";
//        echo "total de pagamentos realizados".$soma_pagamentos. "<br>";
//        echo "Falta pagar: $a_pagar";
//        exit();
    }

}
