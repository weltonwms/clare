<?php

include_once( APPPATH . 'models/generic/Generic_model.php');

class Pagamento_model extends Generic_model {

    protected $id_pagamento;
    protected $id_servico;
    protected $data;
    protected $valor_pago;
    protected $tipo_pagamento;
    protected $tabela = "pagamento";

    function __construct()
    {
        parent::__construct();
       
    }

    public function get_id_pagamento()
    {
        return $this->id_pagamento;
    }

    public function get_id_servico()
    {
        return $this->id_servico;
    }

    public function get_data()
    {
        return $this->data;
    }
    
    public function get_data_formatada(){
        $date = DateTime::createFromFormat('Y-m-d', $this->data);
        return $date->format('d\/m\/Y');
    }

    public function get_valor_pago()
    {
        return $this->valor_pago;
    }
    
     public function get_valor_pago_formatado()
    {
        return number_format($this->valor_pago, 2, ",", ".");
    }

    public function get_tipo_pagamento()
    {
        return $this->tipo_pagamento;
    }
    
     public function get_nome_tipo_pagamento()
    {
         if($this->tipo_pagamento):
             $nomes=array('','Dinheiro','Cartão','Boleto','Cheque');
             return $nomes[$this->tipo_pagamento];
         endif;
        
    }
    

    public function set_id_pagamento($id_pagamento)
    {
        $this->id_pagamento = $id_pagamento;
    }

    public function set_id_servico($id_servico)
    {
        $this->id_servico = $id_servico;
    }

    public function set_data($data)
    {
       if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $data)) { //verifica se é formato dd/mm/aaaa
            $partes = explode("/", $data);
            $formato_mysql = $partes[2] . "-" . $partes[1] . "-" . $partes[0];
            $this->data = $formato_mysql;
        } elseif ($data == null) {
            $this->data = date('Y-m-d');
        }
        else{
            $this->data = $data;
        }
    }

    public function set_valor_pago($valor_pago,$tratar_valor=null)
    {
        if ($tratar_valor) {
            $valor_pago = str_replace(".", "", $valor_pago);
            $valor_pago = str_replace(",", ".", $valor_pago);
        }
        $this->valor_pago = $valor_pago;
    }

    public function set_tipo_pagamento($tipo_pagamento)
    {
        $this->tipo_pagamento = $tipo_pagamento;
    }


}
