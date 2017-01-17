<?php
include_once( APPPATH . 'models/generic/Generic_model.php');

class Cliente_model extends Generic_model{
    protected $id_cliente;
    protected $nome;
    protected $endereco;
    protected $telefone;
    protected $telefone2;
    protected $telefone3;
    protected $responsavel;
    protected $cnpj;
    protected $email;
    protected $cep;
    protected $inc_estadual;
    protected $tabela="cliente";
            
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_id_cliente() {
        return $this->id_cliente;
    }

    public function set_id_cliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

    public function get_nome() {
        return $this->nome;
    }

    public function set_nome($nome) {
        $this->nome = $nome;
    }

    public function get_endereco() {
        return $this->endereco;
    }

    public function set_endereco($endereco) {
        $this->endereco = $endereco;
    }

    public function get_telefone() {
        return $this->telefone;
    }

    public function set_telefone($telefone) {
        $this->telefone = $telefone;
    }

    public function get_responsavel() {
        return $this->responsavel;
    }

    public function set_responsavel($responsavel) {
        $this->responsavel = $responsavel;
    }
    
    public function get_cnpj() {
        return $this->cnpj;
    }

    public function set_cnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    public function get_email() {
        return $this->email;
    }

    public function set_email($email) {
        $this->email = $email;
    }
    
    public function get_telefone2() {
        return $this->telefone2;
    }

    public function set_telefone2($telefone2) {
        $this->telefone2 = $telefone2;
    }

    public function get_telefone3() {
        return $this->telefone3;
    }

    public function set_telefone3($telefone3) {
        $this->telefone3 = $telefone3;
    }
    
    public function get_cep()
    {
        return $this->cep;
    }

    public function get_inc_estadual()
    {
        return $this->inc_estadual;
    }

    public function set_cep($cep)
    {
        $this->cep = $cep;
    }

    public function set_inc_estadual($inc_estadual)
    {
        $this->inc_estadual = $inc_estadual;
    }

    
    public function is_relacionado_a_servico($id_cliente) {
        $this->db->where('id_cliente', $id_cliente);
        $result = $this->db->get('servico')->result();
        if (count($result) > 0) {
            return TRUE;
        }
        return FALSE;
        
    }
    
    
    
    


    
}


