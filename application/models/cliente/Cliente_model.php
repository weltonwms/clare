<?php


class Cliente_model extends CI_Model{
    private $id_cliente;
    private $nome;
    private $endereco;
    private $telefone;
    private $telefone2;
    private $telefone3;
    private $responsavel;
    private $cnpj;
    private $email;
    
    
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

            
    public function cadastrar(){
        $dados=array(
            'nome'=>  $this->nome,
            'endereco'=>  $this->endereco,
            'telefone'=>$this->telefone,
            'telefone2'=>$this->telefone2,
            'telefone3'=>$this->telefone3,
            'responsavel'=>  $this->responsavel,
            'cnpj'=>  $this->cnpj,
            'email'=> $this->email
        );
        $this->db->insert('cliente',$dados);
        if($this->db->affected_rows()>0){
            return $this->db->insert_id();
        }
        return;
    }
    
    public function excluir($id_cliente){
        $this->db->where('id_cliente',$id_cliente);
        $this->db->delete('cliente');
        if($this->db->affected_rows()>0){
             return TRUE;
        }
        return;
      
    }
    
    public function gravar_alteracao(){
        $dados=array(
            'nome'=>  $this->nome,
            'endereco'=>  $this->endereco,
            'telefone'=>$this->telefone,
            'telefone2'=>$this->telefone2,
            'telefone3'=>$this->telefone3,
            'responsavel'=>  $this->responsavel,
            'cnpj'=>  $this->cnpj,
            'email'=> $this->email
        );
        $this->db->where('id_cliente',  $this->id_cliente);
        $this->db->update('cliente',$dados);
        if($this->db->affected_rows()>0){
            return TRUE;
        }
        return;
    
    }
    
    public function is_relacionado_a_servico($id_cliente) {
        $this->db->where('id_cliente', $id_cliente);
        $result = $this->db->get('servico')->result();
        if (count($result) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    


    
}


