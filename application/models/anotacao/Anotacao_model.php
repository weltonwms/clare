<?php
include_once( APPPATH . 'models/generic/Generic_model.php');

class Anotacao_model extends Generic_model{
    protected $id_anotacao;
    protected $id_fornecedor;
    protected $descricao;
    protected $data;
    protected $estado;
    protected $tabela="anotacao";
            
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_id_anotacao() {
        return $this->id_anotacao;
    }

    public function get_descricao() {
        return $this->descricao;
    }

    public function get_id_fornecedor() {
        return $this->id_fornecedor;
    }

     public function get_data() {
        if (preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $this->data)) { //verifica se é formato aaaa/mm/dd
            $partes = explode("-", $this->data);
            $formato_brasil = $partes[2] . "/" . $partes[1] . "/" . $partes[0];
            return $formato_brasil;
        }
        return $this->data;
    }

    public function get_estado() {
        return $this->estado;
    }
    
   public function get_nome_estado() {
        $array = array('', 'Ativo', 'Inativo');
        return $array[$this->estado];
    }

    public function set_id_anotacao($id_anotacao) {
        $this->id_anotacao = $id_anotacao;
    }

    public function set_descricao($descricao) {
        $this->descricao = $descricao;
    }

    public function set_id_fornecedor($id_fornecedor) {
        $this->id_fornecedor = $id_fornecedor;
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

    public function set_estado($estado) {
        $this->estado = $estado;
    }


    
    
    


    
}


