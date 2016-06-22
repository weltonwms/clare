<?php
include_once( APPPATH . 'models/generic/Generic_dao.php');
class Anotacao_dao extends Generic_dao {

   

    function __construct() {
        parent::__construct();
        
        $this->load->model('anotacao/Anotacao_model');
        $this->load->model('anotacao/Anotacao_composite');
        $this->load->model('fornecedor/Fornecedor_dao');
         
    }

    public function get_anotacoes() {

        $lista = array();
        $this->db->order_by("id_anotacao", "desc");
        $anotacoes_banco = $this->db->get('anotacao')->result();
        if (count($anotacoes_banco) > 0) {
            foreach ($anotacoes_banco as $anotacao) {
                $lista[] = $this->get_anotacao($anotacao->id_anotacao);
            }
        }
        return $lista;
    }

    public function get_anotacao($id_anotacao) {
        $this->db->where('id_anotacao', $id_anotacao);
        $anotacao_banco = $this->db->get('anotacao')->result();
        if (count($anotacao_banco) > 0) {
            $anotacao = new $this->Anotacao_model();
            $this->set_atributos($anotacao_banco[0], $anotacao);
            return $anotacao;
        }
        return $this->get_anotacao_vazia();
    }

    public function get_anotacao_vazia() {
        return new $this->Anotacao_model();
    }

    public function get_anotacoes_composite() {

       return $this->get_objetos_composite();
    }

    public function get_anotacao_composite($id) {
       return $this->get_objeto_composite($id,"id_anotacao");
    }

    protected function iniciar_query() {
        $this->db->select("*");
        $this->db->from("anotacao a");
        $this->db->join("fornecedor f", "a.id_fornecedor=f.id_fornecedor", "left");
    }
  
    protected function get_componentes_composite() {

        $componentes = array(
            new Anotacao_composite(),
            new Anotacao_model(),
            new Fornecedor_model()
        );
        return $componentes;
    }

}
