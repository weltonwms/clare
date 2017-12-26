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
                    $opcoes2 = array('1' => 'Dinheiro', '2' => 'Cartão', '3' => 'Boleto', '4' => "Cheque");

                    foreach ($opcoes2 as $key => $opcao):
                        echo "<option value='{$key}' ";
                        if (isset($requisicao['tipo_pagamento']) &&
                                in_array($key, $requisicao['tipo_pagamento'])
                        )
                        { echo "selected='selected'";}
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
<?php if (isset($relatorio)):?>
<button  class="btn btn-default"> Total Pago: R$: <?php echo number_format($relatorio->get_total_pago(),2,',','.'); ?></button>
<?php endif;?>
<table id="tabela"
       class="table table-bordered table-striped custab table-condensed">
    <thead class="text-primary small">
        <tr>
            <th>Svç</th>
            <th>Data Svç</th>
            <th>Estado</th>
            <th>Tipo</th>
            <th>Cliente</th>
            <th>Total Venda</th>
            <th>Lucro Venda</th>
            <th>Valor Pago</th>
            <th>Data Pg</th>
            <th>Tipo Pagamento</th>
            <th>Lucro Pg</th>

        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($relatorio)):

            foreach ($relatorio->get_pagamentos() as $pagamento):
                ?>
                <tr>
                    <td><?php echo $pagamento->get_id_servico() ?></td>
                    <td><?php echo $pagamento->get_data_servico() ?></td> 
                    <td><?php echo $pagamento->get_estado_servico() ?></td>
                    <td><?php echo $pagamento->get_tipo_servico() ?></td>
                    <td><?php echo $pagamento->get_nome_cliente() ?></td>
                    <td><?php echo $pagamento->get_total_geral_venda_formatado() ?></td>
                     <td><?php echo number_format($pagamento->get_lucro_venda(),2,',','.') ?></td>
                    <td><?php echo $pagamento->get_valor_pago_formatado() ?> </td>
                    <td><?php echo $pagamento->get_data_pagamento_formatada() ?></td>
                    <td><?php echo $pagamento->get_tipo_pagamento() ?></td>
                    <td>lucro pg</td>
                    
                </tr>  
            <?php endforeach; ?>
           
        <?php endif; ?>
    </tbody>
</table>








