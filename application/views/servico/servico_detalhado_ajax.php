
<table  class=" table table-condensed" >
   
    <tbody>
        <tr>
            <td class="col-md-3">
                <b>Serviço nº </b>
            </td>
            <td>
                <?php echo $servico->get_id_servico();?>
                
            </td>
            <td class="text-right <?php if($servico->get_estado()=='1')echo 'text-danger'?>">
               <?php echo $servico->get_nome_estado();?>
            </td>
        </tr>
         <tr>
            <td>
                <b>Data</b>
            </td>
            <td>
                <?php echo $servico->get_data();?>
            </td>
            <td>
                
            </td>
        </tr>
         <tr>
            <td>
                <b>Cliente</b>
            </td>
            <td>
                <?php echo $servico->get_nome_cliente();?>
            </td>
            <td class="text-right">
                <?php echo $servico->get_telefone_cliente();?>
            </td>
        </tr>
        
        <tr>
            <td>
                <b>Responsável</b>
            </td>
            <td colspan="2">
                <?php echo $servico->get_responsavel_cliente();?>
            </td>
           
        </tr>
        
        <tr>
            <td>
                <b>Forma Pagamento</b>
            </td>
            <td colspan="2">
                <?php echo $servico->get_forma_pagamento();?>
            </td>
           
        </tr>
         <tr>
            <td>
                <b>Obs:</b>
            </td>
            <td colspan="2">
                <?php echo $servico->get_obs();?>
            </td>
           
        </tr>
       
    </tbody>
</table>


<h3 class="text-center">Produto(s)</h3>
<table class=" table table-bordered" >
    <thead>
        <tr>
           <th>Item</th>
            <th>Qtd</th>
            <th>Discriminação</th>
             <th>Descrição</th>
             <th class="text-muted">Un Forn</th>
            <th class="text-muted">Total Forn</th>
            <th>Un Venda</th>
            <th>Total Venda</th>
        </tr>
    </thead>
    <tbody>

        <?php $cont=1;foreach ($servico->get_itens_servico() as $item): ?>
            <tr>
                <td><?php echo $cont ?> </td>
                <td><?php echo $item->get_qtd_produto() ?></td>
                <td><?php echo $item->get_nome_produto() ?></td>
                 <td><?php echo $item->get_descricao() ?> </td>
                <td class="text-muted"><?php echo "R$ " . number_format($item->get_valor_unitario_fornecedor(), 2, ",", "."); ?></td>
                <td class="text-muted"><?php echo "R$ " . number_format($item->get_total_fornecedor(), 2, ",", "."); ?>
                    <span class="nome_fornecedor"><?php echo $item->get_nome_fornecedor()?></span>
                
                </td>
                <td><?php echo "R$ " . number_format($item->get_valor_unitario_venda(), 2, ",", "."); ?></td>
                <td>
                    <?php echo "R$ " . number_format($item->get_total_venda(), 2, ",", "."); ?>
                   
                </td>
            </tr>
        <?php $cont++; endforeach; ?>
        <tr id="preco_total">
            <td colspan="7" align="right"> <b>Total Geral</b<</td>
            <td class="info"><?php echo "R$ " . number_format($servico->get_total_geral_venda(), 2, ",", "."); ?></td>
        </tr>
    </tbody>
</table>
