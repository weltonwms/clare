<?php

class Servico_model extends CI_Model {

    private $id_servico;
    private $data;
    private $id_cliente;
    private $estado;
    private $forma_pagamento;
    private $obs;
    private $tipo;

    function __construct() {
        parent::__construct();
    }

    public function cadastrar() {
        $skips = array('id_servico');
        $dados = $this->carrega_dados($skips);
        $this->db->insert('servico', $dados);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return;
    }

    public function gravar_alteracao() {
        $skips = array('id_servico');
        $dados = $this->carrega_dados($skips);
        $this->db->where('id_servico', $this->id_servico);
        $this->db->update('servico', $dados);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return;
    }

    public function excluir($id_servico) {
        $this->db->where('id_servico', $id_servico);
        $this->db->delete('servico');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return;
    }

    public function get_id_servico() {
        return $this->id_servico;
    }

    public function set_id_servico($id_servico) {
        $this->id_servico = $id_servico;
    }

    public function get_data() {
        if (preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $this->data)) { //verifica se é formato aaaa/mm/dd
            $partes = explode("-", $this->data);
            $formato_brasil = $partes[2] . "/" . $partes[1] . "/" . $partes[0];
            return $formato_brasil;
        }
        else
            return $this->data;
    }

    public function set_data($data) {
        if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $data)) { //verifica se é formato dd/mm/aaaa
            $partes = explode("/", $data);
            $formato_mysql = $partes[2] . "-" . $partes[1] . "-" . $partes[0];
            $this->data = $formato_mysql;
        } elseif ($data == null) {
            $this->data = date('Y-m-d');
        }
        else
            $this->data = $data;
    }

    public function get_id_cliente() {
        return $this->id_cliente;
    }

    public function set_id_cliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

    public function get_estado() {
        return $this->estado;
    }

    public function get_nome_estado() {
        $array = array('', 'Orçamento', 'Executado', 'Em Produção');
        return $array[$this->estado];
    }

    public function set_estado($estado) {
        $this->estado = $estado;
    }

    public function get_forma_pagamento() {
        return $this->forma_pagamento;
    }

    public function set_forma_pagamento($forma_pagamento) {
        $this->forma_pagamento = $forma_pagamento;
    }

    public function get_obs() {
        return $this->obs;
    }

    public function set_obs($obs) {
        $this->obs = $obs;
    }

    public function get_tipo() {
        return $this->tipo;
    }

    public function get_nome_tipo() {
        if ($this->tipo):
            $dados = array('', 'Revenda', 'Comissão','Venda Direta');
            return $dados[$this->tipo];
        endif;
        return;
    }

    public function set_tipo($tipo) {
        $this->tipo = $tipo;
    }
    
    public function executar_servico($id_servico){
        $this->db->set('estado', 2);
        $this->db->where('id_servico', $id_servico);
        $this->db->update('servico');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return;
    }

    private function carrega_dados(array $skips = array()) {
        $atributos = get_class_vars(get_class($this));
        $dados = array();
        foreach ($atributos as $key => $valor):
            if (in_array($key, $skips)) {
                continue;
            }
            $dados[$key] = $this->$key;
        endforeach;
        return $dados;
    }

    public function get_atributos() {
        return get_class_vars(get_class($this));
    }

}

