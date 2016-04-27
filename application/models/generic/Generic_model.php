<?php


class Generic_model extends CI_Model{
    protected $tabela;
    protected $identificador;
    
    public function cadastrar(){
        $identificador=  $this->get_identificador();
        $skips = array($identificador);
        $dados = $this->carrega_dados($skips);
        $this->db->insert($this->tabela, $dados);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return;
    }
    
    public function alterar(){
        $identificador=  $this->get_identificador();
        $skips = array($identificador);
        $dados = $this->carrega_dados($skips);
        $this->db->where($identificador, $this->$identificador);
        $this->db->update($this->tabela, $dados);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return;
    }
    
    public function excluir($id){
       $identificador=  $this->get_identificador();
       $this->db->where($identificador, $id);
       $this->db->delete($this->tabela);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return;
    }
    
    protected function carrega_dados(array $skips = array()) {
        $atributos =  $this->get_atributos();
        $dados = array();
        $skips_interno=array('tabela',  'identificador');
        foreach ($atributos as $key => $valor):
            if (in_array($key, $skips)|| in_array($key, $skips_interno)) {
                continue;
            }
            $dados[$key] = $this->$key;
        endforeach;
        return $dados;
    }
    
    
    
    protected function get_identificador(){
        $atributos=$this->get_atributos();
        reset($atributos);
        return key($atributos);
    }
    
    public function get_atributos() {
        return get_class_vars(get_class($this));
    }
    
        
    
   
}
