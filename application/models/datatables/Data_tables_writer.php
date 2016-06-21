<?php

class Data_tables_writer extends CI_Model{
    private $objetos_banco;
    private $model="servico/Servico_model";
    private $metodos=array("get_id_servico","get_id_cliente","get_data","get_nome_estado","get_nome_tipo");
    private $colunas=array('id_servico', 'id_cliente', 'data', 'estado', 'tipo');
    
    public function inicializar(){
        $this->load->model($this->model,'x');
        $array = array();
        $array_data=array();
        $i=0;
        foreach($this->objetos_banco as $obj):
            $objeto_model= new $this->x();
            $this->set_atributos_objeto_model($objeto_model,$obj);
            $array_data[]=$this->construir_row($objeto_model);
            
             $array[]=$objeto_model;
        $i++;
        endforeach;
        return $array_data;
        //echo "<pre>"; print_r($array_data); exit();
        
    }
    
    private function set_atributos_objeto_model($objeto_model,$objeto_banco){
        foreach($this->colunas as $coluna):
            $metodo="set_".$coluna;
            $objeto_model->$metodo($objeto_banco->$coluna);
        endforeach;
       
    }
    
    private function construir_row($objeto_model){
        $row=array();
        foreach ($this->metodos as $metodo):
            $row[]=$objeto_model->$metodo();
        endforeach;
         $row[] = $this->reproduzir_html_acoes();
        //echo "<pre>"; print_r($row); exit();
        return $row;
        
    }
    
    public function set_objetos_banco($objetos){
        $this->objetos_banco=$objetos;
        return $this->inicializar();
        //echo "<pre>"; print_r($this->objetos_banco); exit();
    }
    
    private function reproduzir_html_acoes(){
        $html="<a class='btn btn-default confirm_servico' data-id_servico='126' data-toggle='tooltip' title='Editar' href='#'> <span class='glyphicon glyphicon-pencil'></span></a>";
               
        //echo $html; exit();
        return $html;
    }
}
