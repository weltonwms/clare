<?php

class Servico_composite extends CI_Model {

    private $servico; //objeto Servico_model
    private $itens_servico; //array de objetos tipo Item_servico_model
    private $pagamentos; //array de objetos tipo Pagamento_model
    private $cliente; //objeto Cliente_model
    private $total_geral_venda; //atributo para usar pattern single
    private $total_geral_fornecedor; //atributo para usar pattern single

    public function __construct()
    {
        parent::__construct();
        $this->load->model('item_servico/Item_servico_dao');
        $this->load->model('pagamento/Pagamento_dao');
    }

    public function set_servico(Servico_model $servico)
    {
        $this->servico = $servico;
    }

    public function set_cliente(Cliente_model $cliente)
    {
        $this->cliente = $cliente;
    }

    public function set_itens_servico(array $itens_servico)
    {
        $this->itens_servico = $itens_servico;
    }

    public function executar_servico()
    {
        $this->servico->executar_servico();
    }

    public function get_id_servico()
    {
        return $this->servico->get_id_servico();
    }

    public function get_id_cliente()
    {
        return $this->servico->get_id_cliente();
    }

    public function get_id_vendedor()
    {
        return $this->servico->get_id_vendedor();
    }

    public function get_nome_vendedor()
    {

        $nomes = array(0 => '', 1 => 'Glauber', 2 => "Maurício", 3 => "Paulo", '' => ""); //substituir por model vendedor;
        return $nomes[$this->get_id_vendedor()];
    }

    public function get_nome_cliente()
    {
        return $this->cliente->get_nome();
    }

    public function get_endereco_cliente()
    {
        return $this->cliente->get_endereco();
    }

    public function get_responsavel_cliente()
    {
        return $this->cliente->get_responsavel();
    }

    public function get_telefone_cliente()
    {
        return $this->cliente->get_telefone();
    }

    public function get_data()
    {
        return $this->servico->get_data();
    }

    public function get_estado()
    {
        return $this->servico->get_estado();
    }

    public function get_obs()
    {
        return $this->servico->get_obs();
    }

    public function get_forma_pagamento()
    {
        return $this->servico->get_forma_pagamento();
    }

    public function get_nome_estado()
    {
        return $this->servico->get_nome_estado();
    }

    public function get_tipo()
    {
        return $this->servico->get_tipo();
    }

    public function get_nome_tipo()
    {
        return $this->servico->get_nome_tipo();
    }

    public function get_porcentagem_comissao()
    {
        return $this->servico->get_porcentagem_comissao();
    }

    public function get_itens_servico()
    {
        if (!$this->itens_servico):
            $itens = $this->Item_servico_dao->get_itens_servico($this->get_id_servico());
            $this->itens_servico = $itens;
        endif;
        return $this->itens_servico;
    }

    public function get_pagamentos()
    {
        if (!$this->pagamentos):
            $pagamentos = $this->Pagamento_dao->get_pagamentos($this->get_id_servico());
            $this->pagamentos = $pagamentos;
        endif;
        return $this->pagamentos;
    }

    public function get_soma_pagamentos()
    {
        $soma = 0;
        foreach ($this->get_pagamentos() as $pagamento):
            $soma+=$pagamento->get_valor_pago();
        endforeach;
        return $soma;
    }

    public function get_array_pagamentos()
    {
        $lista = array();
        foreach ($this->get_pagamentos() as $pagamento):
            $array['id_pagamento'] = $pagamento->get_id_pagamento();
            $array['id_servico'] = $pagamento->get_id_servico();
            $array['data'] = $pagamento->get_data_formatada();
            $array['valor_pago'] = $pagamento->get_valor_pago_formatado();
            $array['tipo_pagamento'] = $pagamento->get_nome_tipo_pagamento();
            $lista[] = $array;
        endforeach;
        return $lista;
    }
    
    public function get_pagamento($id_pagamento){
         foreach ($this->get_pagamentos() as $pagamento):
            if($pagamento->get_id_pagamento()==$id_pagamento):
                return $pagamento;
            endif;
        endforeach;
    }

    public function get_email_cliente()
    {
        return $this->cliente->get_email();
    }

    public function get_total_geral_venda()
    {
        //não use isso se for forçar uma nova soma em tempo de execução.
        //Isso é para não utilizar cache sem ficar somando de novo.
        if (!$this->total_geral_venda):
            $soma = 0;
            foreach ($this->get_itens_servico() as $item):
                $soma+=$item->get_total_venda();
            endforeach;
            $this->total_geral_venda = $soma;
        endif;
        return $this->total_geral_venda;
    }

    public function get_total_geral_fornecedor()
    {
        //não use isso se for forçar uma nova soma em tempo de execução.
        //Isso é para não utilizar cache sem ficar somando de novo.
        if (!$this->total_geral_fornecedor):
            $soma = 0;
            foreach ($this->get_itens_servico() as $item):
                $soma+=$item->get_total_fornecedor();
            endforeach;
            $this->total_geral_fornecedor = $soma;
        endif;
        return $this->total_geral_fornecedor;
    }

}
