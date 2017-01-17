<?php
include_once( APPPATH . 'models/generic/Generic_dao.php');
class Fornecedor_dao extends Generic_dao {

    function __construct() {
        parent::__construct();
        $this->load->model('fornecedor/Fornecedor_model', 'Fornecedor_model');
    }

    public function get_fornecedores($chave_array_igual_id = null) {
        $this->db->order_by("empresa", "asc");
        $fornecedores_banco = $this->db->get('fornecedor')->result();
        if (count($fornecedores_banco) > 0) {
            $lista = array();
            foreach ($fornecedores_banco as $fornecedor) {
                if ($chave_array_igual_id) {
                    $lista[$fornecedor->id_fornecedor] = $this->get_fornecedor($fornecedor->id_fornecedor);
                } else {
                    $lista[] = $this->get_fornecedor($fornecedor->id_fornecedor);
                }
            }

            return $lista;
        }
        return;
    }

    public function get_fornecedor($id_fornecedor) {
        $this->db->where('id_fornecedor', $id_fornecedor);
        $fornecedor_banco = $this->db->get('fornecedor')->result();
        if (count($fornecedor_banco) == 1) {
            $fornecedor = new $this->Fornecedor_model();
            $this->set_atributos($fornecedor_banco[0], $fornecedor);
            
            return $fornecedor;
        }
        return;
    }
    
    public function get_fornecedor_vazio(){
        return new $this->Fornecedor_model();
    }


    protected function get_componentes_composite()
    {
        
    }

    protected function iniciar_query()
    {
        //implementar de acordo com generic
    }

}


