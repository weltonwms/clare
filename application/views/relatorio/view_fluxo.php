<?php
echo "<script src='" . base_url('assets/plugins/jquery.validate.js') . "'></script>";
echo "<script src='" . base_url('assets/plugins/jquery.mask.js') . "'></script>";
echo link_tag(array('href' => 'assets/plugins/chosen/chosen.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
echo "<script src='" . base_url('assets/plugins/chosen/chosen.jquery.js') . "'></script>";
echo "<script src='" . base_url('assets/js/validacao_relatorio.js') . "'></script>";
?>
<legend>Relatório de Fluxo<a class="click_esconde" href="#"><span class="caret"</span></a></legend>

<form id='form_relatorio' action="<?php echo base_url('relatorio/gerar_fluxo') ?>" method="post">



    <div class="row esconde">




        <div class="col-md-2">
            <label class=""><span
                    class="glyphicon glyphicon-filter"></span> Período Inicial:</label>
            <div class="">
                <input type="text" name="periodo_inicial" 
                       value="<?php if (isset($requisicao['periodo_inicial'])) echo $requisicao['periodo_inicial'] ?>"
                       class="form-control data datepicker"/>

            </div>
        </div>



        <div class="col-md-2">
            <label class=""><span
                    class="glyphicon glyphicon-filter"></span> Período Final:</label>
            <div class="">
                <input type="text" name="periodo_final" 
                       value="<?php if (isset($requisicao['periodo_final'])) echo $requisicao['periodo_final'] ?>"
                       class="form-control data datepicker"/>

            </div>
        </div>





        <div class="col-md-2">
            <label class=""><span
                    class="glyphicon glyphicon-filter"></span> Tipo Pagamento:</label>
            <div class="">
                <select name="tipo_pagamento[]" class="form-control meu_chosen" multiple="multiple" data-placeholder="--Todos--">

                    <?php
                    $opcoes2 = array('1' => 'Dinheiro', '2' => 'Cartão', '3' => 'Boleto', 
                        '4' => "Cheque",'5'=>"Dep. BB",'6'=>"Dep. Itaú",'7'=>"Dep. Caixa");

                    foreach ($opcoes2 as $key => $opcao):
                        echo "<option value='{$key}' ";
                        if (isset($requisicao['tipo_pagamento']) &&
                                in_array($key, $requisicao['tipo_pagamento'])
                        ) {
                            echo "selected='selected'";
                        }
                        echo ">";
                        echo $opcao;
                        echo "</option>";
                    endforeach;
                    ?>

                </select>

            </div>
        </div>

        <div class="col-md-3">
            <label class=""><span
                    class="glyphicon glyphicon-filter"></span> Ordenador Por:</label>
            <div class="">
                <select name="ordenado_por" class="form-control">
                    <option value=''>--Selecione--</option>
                    <?php
                    $opcoes = array('servico' => 'Serviço', 'data_pagamento' => 'Dt Pagamento');

                    foreach ($opcoes as $key => $opcao):
                        echo "<option value='{$key}' ";
                        if (isset($requisicao['ordenado_por']) &&
                                $requisicao['ordenado_por'] == $key
                        )
                            echo "selected='selected'";
                        echo ">";
                        echo $opcao;
                        echo "</option>";
                    endforeach;
                    ?>


                </select>

            </div>
        </div>





        <div class="col-md-2">
            <label>&nbsp;</label>
            <div>
                <button type="submit" class=" form-control btn btn-default ">Executar</button>
            </div>
        </div>



    </div><!--Fechamento da Row-->
<br>

</form>











<!--aqui está outra coisa -->

<?php if(isset($relatorio)):?>

<div class="row">
    <div class="col-md-9">
        <div class="pull-right">
            <button class="btn btn-success">Total Crédito: R$: <?php echo number_format($relatorio->get_soma_pagamentos(CREDITO),2,',','.')?></button>
            <button class="btn btn-danger">Total Débito: R$: <?php echo number_format($relatorio->get_soma_pagamentos(DEBITO),2,',','.')?></button>
            <button class="btn">Total Lucro: R$: <?php echo number_format($relatorio->get_lucro(),2,',','.')?></button>
        </div>
    </div>
</div>
<?php endif;?>
<br>
<div class="row">
<div class="col-md-6">
    <div class="panel panel-success">
        <!-- Default panel contents -->
        <div class="panel-heading">
            Créditos (Pg Clientes)


        </div>

        <!-- Table -->

        <table class="table">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Pago em</th>
                    <th>Serviço</th>
                </tr>
            </thead>

            <tbody>
         <?php
        if (isset($relatorio)):
            foreach ($relatorio->get_pagamentos(CREDITO) as $pagamento):
         ?>
                <tr>
                    <td><?php echo $pagamento->get_tipo_pagamento() ?></td>
                    <td><?php echo $pagamento->get_valor_pago_formatado() ?></td> 
                    <td><?php echo $pagamento->get_data_formatada() ?></td>
                    <td>
                        <?php echo $pagamento->get_id_servico() ?>
                        (<?php echo $pagamento->get_nome_cliente() ?> )
                    </td>
                </tr>  
            <?php endforeach; ?>
           
        
                <tr class="active">

                    <td colspan="3" class="text-center"><b>Total </b></td>
                    <td class="info">R$ <?php echo number_format($relatorio->get_soma_pagamentos(CREDITO),2,',','.')?></td>
                </tr>
                
            <?php endif; ?>
            </tbody>
    </div>
</table>


</div>
</div> <!--fim col-md-->


<div class="col-md-6">
    <div class="panel panel-danger">
        <!-- Default panel contents -->
        <div class="panel-heading">Débitos (Pg Fornecedores)</div>

        <!-- Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Pago em</th>
                    <th>Serviço</th>
                    <th>Fornecedor</th>
                </tr>
            </thead>

            <tbody>
                 <?php
        if (isset($relatorio)):
            foreach ($relatorio->get_pagamentos(DEBITO) as $pagamento):
         ?>
                <tr>
                    <td><?php echo $pagamento->get_tipo_pagamento() ?></td>
                    <td><?php echo $pagamento->get_valor_pago_formatado() ?></td> 
                    <td><?php echo $pagamento->get_data_formatada() ?></td>
                    <td>
                        <?php echo $pagamento->get_id_servico() ?>
                        
                    </td>
                     <td><?php echo $pagamento->get_nome_fornecedor() ?></td>
                </tr>  
            <?php endforeach; ?>
           
        
                
                <tr class="active">
                    <td colspan="4" class="text-center"><b>Total</b></td>
                    <td class="info">R$ <?php echo number_format($relatorio->get_soma_pagamentos(DEBITO),2,',','.')?></td>
                </tr>
         <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


</div> <!-- fim row -->












