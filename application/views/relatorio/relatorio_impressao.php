<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Relatório de Serviço</title>
        <style>
            *{
                font-size: 11px;
            }
            table tr td{
                border: 1px solid;
                padding: 4px;
                line-height: 1.42857143;
                vertical-align: top;


            }

            thead th{
                border: 1px solid;
                background-color: #f9f9f9;
            }
            table tr.total td{
                background-color: #f9f9f9;
                border-bottom: 1px dotted;
                border-left: 0px;
                border-right:  0px;
                font-weight:bold;
            }
        </style>
    </head>
    <body>
        <div align="center">
            <?php
            $estado = array('', 'Orçamento', 'Executado', 'Em Produção', "Entregue não pago");
            if ($requisicao['estado']):
                echo "Relatório de Serviço: {$estado[$requisicao['estado']]}";
            endif;
            ?>
            <?php
            if ($requisicao['periodo_inicial'] || $requisicao['periodo_final']):
                echo "<br>Período de {$requisicao['periodo_inicial']} a {$requisicao['periodo_final']}";
            endif;
            ?>
            <?php
            $tipo = array('', 'Revenda', 'Comissão', 'Venda Direta');
            if ($requisicao['tipo']):
                echo "  - Tipo: {$tipo[$requisicao['tipo']]}";
            endif;
            if (isset($fornecedor)):
                echo "<br>Fornecedor: {$fornecedor->get_empresa()}";
            endif;
            ?>
        </div>
        <table  cellpadding="0" cellspacing="0" width='100%'>
            <thead>
                <tr>
                    <th>Svç</th>
                    <th>Data</th>
                    <th>Estado</th>
                    <th>Tipo</th>
                    <th>Cliente</th>

                    <th>Produto</th>
                    <th>Qtd</th>
                    <th>Total Forn</th>
                    <th>Total Venda</th>
                    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lucro &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($relatorio)):
                    foreach ($relatorio->get_itens_servico() as $item_servico):
                        ?>
                        <tr>
                            <td><?php echo $item_servico->get_id_servico() ?></td>
                            <td><?php echo $item_servico->get_data_servico() ?></td> 
                            <td><?php echo $item_servico->get_estado_servico() ?></td>
                            <td><?php echo $item_servico->get_tipo_servico() ?></td>
                            <td><?php echo $item_servico->get_nome_cliente() ?></td>

                            <td><?php echo $item_servico->get_nome_produto() ?> </td>
                            <td><?php echo $item_servico->get_qtd_produto() ?></td>
                            <td><?php echo $item_servico->get_total_fornecedor_formatado() ?></td>
                            <td><?php echo $item_servico->get_total_venda_formatado() ?></td>
                            <td><?php echo $item_servico->get_lucro_formatado() ?></td>
                        </tr>  
                    <?php endforeach; ?>
                    <tr class="total">
                        <td colspan='8' class="text-right"><b>Total Geral</b>&nbsp;&nbsp;&nbsp;</td>
                        <td class="info"><?php echo $relatorio->get_total_geral_formatado(); ?></td>
                        <td class="info"><?php echo $relatorio->get_total_lucro_formatado(); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <script type="text/php">


            if ( isset($pdf) ) {
            $data= date('d-m-Y');
            $texto="BlueSky System";
            $font = Font_Metrics::get_font("helvetica", "bold"); $pdf->page_text(260, 760, "{$texto} ", $font, 9, array(0,0,0));
            $font2 = Font_Metrics::get_font("helvetica", "bold"); $pdf->page_text(535, 760, " PG: {PAGE_NUM} de {PAGE_COUNT}", $font2, 9, array(0,0,0));
            $font3 = Font_Metrics::get_font("helvetica", "bold"); $pdf->page_text(30, 760, "{$data} ", $font3, 9, array(0,0,0));
            } </script>
    </body>
</html>







