<?php

include_once( APPPATH . 'models/generic/Generic_model.php');

class Servico_model extends Generic_model {

    protected $id_servico;
    protected $data;
    protected $id_cliente;
    protected $estado;
    protected $forma_pagamento;
    protected $obs;
    protected $tipo;
    protected $porcentagem_comissao;
    protected $id_vendedor;
    protected $conta_boleto;
    protected $tabela = "servico";

    function __construct()
    {
        parent::__construct();
    }

    public function get_id_servico()
    {
        return $this->id_servico;
    }

    public function set_id_servico($id_servico)
    {
        $this->id_servico = $id_servico;
    }

    public function get_data()
    {
        if (preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $this->data)) { //verifica se é formato aaaa/mm/dd
            $partes = explode("-", $this->data);
            $formato_brasil = $partes[2] . "/" . $partes[1] . "/" . $partes[0];
            return $formato_brasil;
        }
        return $this->data;
    }

    public function set_data($data)
    {
        if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $data)) { //verifica se é formato dd/mm/aaaa
            $partes = explode("/", $data);
            $formato_mysql = $partes[2] . "-" . $partes[1] . "-" . $partes[0];
            $this->data = $formato_mysql;
        } elseif ($data == null) {
            $this->data = date('Y-m-d');
        } else
            $this->data = $data;
    }

    public function get_id_cliente()
    {
        return $this->id_cliente;
    }

    public function set_id_cliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }

    public function get_estado()
    {
        return $this->estado;
    }

    public function get_nome_estado()
    {
        $array = array('', 'Orçamento', 'Executado', 'Em Produção', 'Entregue não Pago');
        return $array[$this->estado];
    }

    public function set_estado($estado)
    {
        $this->estado = $estado;
    }

    public function get_forma_pagamento()
    {
        return $this->forma_pagamento;
    }

    public function set_forma_pagamento($forma_pagamento)
    {
        $this->forma_pagamento = $forma_pagamento;
    }

    public function get_obs()
    {
        return $this->obs;
    }

    public function set_obs($obs)
    {
        $this->obs = $obs;
    }

    public function get_tipo()
    {
        return $this->tipo;
    }

    public function get_nome_tipo()
    {
        if ($this->tipo):
            $dados = array('', 'Revenda', 'Comissão', 'Venda Direta');
            return $dados[$this->tipo];
        endif;
        return;
    }

    public function set_tipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function get_porcentagem_comissao()
    {
        return $this->porcentagem_comissao;
    }

    public function set_porcentagem_comissao($porcentagem_comissao)
    {
        $this->porcentagem_comissao = $porcentagem_comissao;
    }

    public function get_id_vendedor()
    {
        return $this->id_vendedor;
    }

    public function set_id_vendedor($id_vendedor)
    {
        $this->id_vendedor = $id_vendedor;
    }

    public function get_nome_vendedor()
    {
        return $this->nome_vendedor;
    }

    public function set_nome_vendedor($nome_vendedor)
    {
        $this->nome_vendedor = $nome_vendedor;
    }

    public function set_conta_boleto($conta){
        $this->conta_boleto=$conta;
    }

    public function get_conta_boleto(){
        
        return $this->conta_boleto;
    }

    public function executar_servico()
    {
        $status = array(1 => 3, 3 => 4, 4 => 2);
        $this->estado=$status[$this->get_estado()];
        $this->db->set('estado', $this->estado);
        $this->db->where('id_servico', $this->get_id_servico());
        $this->db->update('servico');
        $this->automatizar_pagamento();
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return;
    }

    protected function after_save($dados, $nr_affected_rows)
    {
       
        $this->automatizar_pagamento();
    }

    private function automatizar_pagamento()
    {
        if ($this->estado == 2 && $this->tipo!=2):
            //exit("estado igual 2");
            $this->load->model('pagamento/Pagamento_manager');
            $this->Pagamento_manager->automatizar_pagamento($this->id_servico);
        endif;
    }

}
