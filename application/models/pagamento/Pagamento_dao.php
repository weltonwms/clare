<?php
include_once( APPPATH . 'models/generic/Generic_dao.php');
class Pagamento_dao extends Generic_dao {

    function __construct() {
        parent::__construct();
        $this->load->model('pagamento/Pagamento_model');
    }
   
    
    public function get_pagamentos($id_servico=null)
    {
        $this->iniciar_query($id_servico);
        $this->executar_query();
        $lista = $this->montar_objetos();
        return $lista;
    }
    
    protected function iniciar_query($id_servico=null) {
        $this->db->select("*");
        $this->db->from("pagamento");
        if($id_servico):
             $this->db->where('id_servico', $id_servico);
        endif;
        
        $this->db->order_by("id_pagamento", "asc");
    }
    
    protected function get_componentes_composite() {
         return array(
            new Pagamento_model(),
           
       );
    }

}
