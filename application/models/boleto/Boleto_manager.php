<?php

include_once( APPPATH . 'models/boleto/Boleto_model.php');

class Boleto_manager extends CI_Model {

    public function getBoletos() {
//        $this->db->select("*");
//        $this->db->from("boleto");
//        $x=$this->db->get()->result();

        $this->db->select("id_servico");
        $this->db->distinct();
        $this->db->from("boleto");
        $this->db->where("estado", 1);

        $x = $this->db->get()->result_array();
        $servicos = array_column($x, "id_servico");

        if (!$servicos):
            return [];
        endif;

        $this->db->select("item_servico.descricao, produto.nome as produto_nome, "
                . "servico.data, servico.id_servico, servico.conta_boleto, cliente.nome as cliente_nome");
        $this->db->from("item_servico");
        $this->db->join('produto', 'produto.id_produto = item_servico.id_produto', 'inner');
        $this->db->join('servico', 'servico.id_servico = item_servico.id_servico', 'inner');
        $this->db->join('cliente', 'servico.id_cliente = cliente.id_cliente', 'inner');
        $this->db->where_in("item_servico.id_servico", $servicos);
        $items = $this->db->get()->result();

        $this->db->select("*");
        $this->db->from("boleto");
        $this->db->where_in("id_servico", $servicos);
        $this->db->order_by('vencimento');
        $boletos = $this->db->get()->result();
        //echo "<pre>"; print_r($boletos); exit();

        $lista = $this->estruturar($items, $boletos);
        return $lista;
    }

    private function estruturar($items, $boletos) {

        $list = [];
        foreach ($items as $item):
            if (!isset($list[$item->id_servico])):
                $obj = new stdClass();
                $obj->id_servico = $item->id_servico;
                $obj->data = $item->data;
                $obj->conta_boleto = $item->conta_boleto;
                $obj->cliente_nome = $item->cliente_nome;
                $obj->produtos = [];
                $obj->boletos = [];
                $obj->qtdNaoPagos=0;
                $obj->produtos[] = $item;
                $list[$item->id_servico] = $obj;
            else:
                $list[$item->id_servico]->produtos[] = $item;
            endif;

        endforeach;

        foreach ($boletos as $boleto):
            $list[$boleto->id_servico]->boletos[] = new Boleto_model($boleto);
            if($boleto->estado==1):
                $list[$boleto->id_servico]->qtdNaoPagos++;
            endif;
        endforeach;

        usort($list, function( $a, $b ) {
            if ($a->cliente_nome == $b->cliente_nome)
                return 0;
            return ( ( $a->cliente_nome < $b->cliente_nome ) ? -1 : 1 );
        });

       
        return $list;
    }

    public function save($post) {
        if ($post['id_boleto']):
            return $this->update($post);
        else:
            return $this->create($post);
        endif;
    }

    public function create($post) {
        $dados = [
            "id_servico" => $post['id_servico'],
            "vencimento" => $post['vencimento'],
            "nr_boleto" => $post['nr_boleto'],
            "valor_boleto" => $post['valor_boleto'],
            "estado" => $post['estado']
        ];
        return $this->db->insert('boleto', $dados);
    }

    public function update($post) {
        $id = $post['id_boleto'];

        $dados = [
            "id_servico" => $post['id_servico'],
            "vencimento" => $post['vencimento'],
            "nr_boleto" => $post['nr_boleto'],
            "valor_boleto" => $post['valor_boleto'],
            "estado" => $post['estado']
        ];
        $this->db->where('id_boleto', $id);
        return $this->db->update('boleto', $dados);
    }

    public function delete($id) {
        $this->db->where('id_boleto', $id);
        return $this->db->delete('boleto');
    }

    public function alterarEstado($id_boleto, $estado) {
        $this->db->set("estado", $estado);
        $this->db->where('id_boleto', $id_boleto);
        return $this->db->update('boleto');
    }
    
    public function create2($post){
        $this->db->trans_start();
        $this->db->insert('boleto',$post);
        $insert_id = $this->db->insert_id();
        $this->db->where('id_boleto',$insert_id);
        $last_record= $this->db->get('boleto')->result();
        $this->db->trans_complete();
        return $this->tratarItem($last_record[0]);
    }
    
    public function tratarItem($item){
        $obj= new Boleto_model($item);
        $obj->estado=$obj->getEstado();
        $obj->vencimento=$obj->getVencimento();
        if(!$obj->nr_boleto):
            $obj->nr_boleto='';
        endif;
        
        $obj->valor_boleto=$obj->getValorBoleto();
        return $obj;
    }
    
    public function tratarItens($items){
        $lista=[];
        foreach($items as $item):
            $lista[]= $this->tratarItem($item);
        endforeach;
        return $lista;
    }
    
    public function getBoletosByServico($id_servico){
        $this->db->where('id_servico',$id_servico);
        $this->db->order_by('vencimento');
        $resultado=$this->db->get('boleto')->result();
        return $this->tratarItens($resultado);
    }
    
    public function createBath($post){
        
        $id_servico=$post['id_servico'];
        $dtInicial=$post['data_inicial'];
        $intervalo= $post['intervalo'];
        $parcelas=$post['parcelas'];
        
        $valor_boleto=$post['total']/$parcelas;
        
        $dates= $this->geraBoletos($dtInicial,$parcelas,$intervalo);
        
        $this->db->trans_start();
        $ids_gravados=[];
        $registros_gravados=[];
        foreach($dates as $date):
            $registro=['vencimento'=>$date, 'id_servico'=>$id_servico,'valor_boleto'=>$valor_boleto,'estado'=>1];
            $this->db->insert('boleto',$registro);
            $ids_gravados[] = $this->db->insert_id();
        endforeach;
        
        if($ids_gravados):
            $this->db->where_in('id_boleto',$ids_gravados);
            $registros_gravados= $this->db->get('boleto')->result();
        endif;
        
        
        
        $this->db->trans_complete();
        return $this->tratarItens($registros_gravados);
    }
    
     private function geraBoletos($dtInicial,$parcelas,$interval=7){
        if(is_numeric($interval)):
            $interval="P{$interval}D";// P7D means a period of 7 day
        else:
            $interval="P7D";// P7D means a period of 7 day
        endif;
       
        
        $lista=[$dtInicial];
        for($i=1;$i<$parcelas;$i++):
           
            $date = new DateTime($lista[$i-1]);
            $date->add(new DateInterval($interval)); 
            $lista[]=$date->format("Y-m-d");
            
        endfor;
        
        return $lista;
    }

}
