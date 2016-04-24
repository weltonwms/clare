<?php

class Data_tables extends CI_Model {

    private $colunas;
    private $params_datatable;
    private $tabela;
    private $count_all;
    private $count_filtered;
    private $objetos_banco;

    public function inicializar($params_datatable, $colunas, $tabela) {
        $this->colunas = $colunas;
        $this->params_datatable = $params_datatable;
        $this->tabela = $tabela;

        $this->construir_tabela_temporaria();
        //$this->preparar_query_inicial();
        $this->preparar_query_pesquisa();
        $this->preparar_query_ordem();
        $this->preparar_query_paginacao();
        $this->executar_query();
        $this->set_count_all();
        $this->set_count_filtered();
    }

    private function construir_tabela_temporaria() {
        //$this->preparar_query_inicial();
        // $base=$this->db->get_compiled_select();
       // echo "<pre>"; print_r($this->params_datatable);exit();
       
        $sql = "CREATE TEMPORARY TABLE xTemp(id_servico int( 11 ) ,cliente varchar( 200 ) , data varchar( 20 ),estado varchar( 20 ),tipo varchar( 20 ) )  ENGINE = Memory ";
        $this->db->query($sql);
       
        $this->load->model('servico/Servico_manager', 'Servico_manager');
        $servicos = $this->Servico_manager->get_servicos();
        /*
        $array=array();
        for($i=0;$i<8000;$i++){
            $sqlx=array('id_servico'=>"7",'cliente'=>"paulo",'data'=>"09/09/2000",'estado'=>"estad",'tipo'=>"tip");
            //$sqlx[] = "INSERT into xTemp values(7,'pULO','09/09/2000','ESTado','tipo')";
            $array[]=$sqlx;
            //$this->db->query($sqlx);
        }
        $this->db->insert_batch('xTemp', $array); 
        */
      
        
        foreach ($servicos as $servico):
            $sqlx = "INSERT into xTemp values({$servico->get_id_servico()},'{$servico->get_nome_cliente()}','{$servico->get_data()}','{$servico->get_nome_estado()}','{$servico->get_nome_tipo()}')";
            $this->db->query($sqlx);
        endforeach;
       /*
          $sql2="select *from xTemp";
          $resultado=$this->db->query($sql2)->result();
          echo $this->db->last_query();
          echo "<pre>"; print_r($resultado); exit();
         */
    }

    private function preparar_query_inicial() {
        $this->db->select("*");
        $this->db->from("servico");
        $this->db->join("cliente", "servico.id_cliente=cliente.id_cliente", "LEFT");
        // $resultado=  $this->db->get()->result();
        // echo "<pre>"; print_r($resultado); exit();
    }

    private function preparar_query_pesquisa() {
        $i = 0;
        foreach ($this->colunas as $item) {
            if ($this->params_datatable['search']['value']) {
                //exit('pesquisa');
                ($i === 0) ? $this->db->like($item, $this->params_datatable['search']['value']) : $this->db->or_like($item, $this->params_datatable['search']['value']);
            }

            $i++;
        }
    }

    private function preparar_query_ordem() {
        if (isset($this->params_datatable['order'])) {
            //echo "<pre>"; print_r($this->params_datatable['order']);exit('ordem');
            $this->db->order_by($this->colunas[$this->params_datatable['order']['0']['column']], $this->params_datatable['order']['0']['dir']);
        }
    }

    private function preparar_query_paginacao() {
        if ($this->params_datatable['length'] != -1) {
            $this->db->limit($this->params_datatable['length'], $this->params_datatable['start']);
        }
    }

    private function executar_query() {
        $this->objetos_banco = $this->db->get($this->tabela)->result();
    }

    private function set_count_filtered() {
        //$this->preparar_query_inicial();
        $this->preparar_query_pesquisa();
        $query = $this->db->get($this->tabela);
        $this->count_filtered = $query->num_rows();
    }

    private function set_count_all() {
        $this->db->from($this->tabela);
        $this->count_all = $this->db->count_all_results();
    }

    public function get_saida() {
        $this->load->model("datatables/Data_tables_writer");
        //$data=$this->Data_tables_writer->set_objetos_banco($this->objetos_banco);

        $data = $this->tratar_objetos_banco();
        $output = array(
            "draw" => $this->params_datatable['draw'],
            "recordsTotal" => $this->count_all,
            "recordsFiltered" => $this->count_filtered,
            "data" => $data,
        );
        return $output;
    }

    private function tratar_objetos_banco() {
        $array = array();
        foreach ($this->objetos_banco as $objeto):
            $row = array();
            foreach ($this->colunas as $coluna):
                $row[] = $objeto->$coluna;
            endforeach;
            $row[] = "action";
            $array[] = $row;
        endforeach;
        return $array;
    }

}
