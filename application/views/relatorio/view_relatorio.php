<?php
echo "<script src='" . base_url('assets/plugins/jquery.validate.js') . "'></script>";
echo "<script src='" . base_url('assets/plugins/jquery.mask.js') . "'></script>";
echo link_tag(array('href' => 'assets/plugins/chosen/chosen.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
echo "<script src='" . base_url('assets/plugins/chosen/chosen.jquery.js') . "'></script>";
echo "<script src='" . base_url('assets/js/validacao_relatorio.js') . "'></script>";
?>
<legend>Relatório Prod/Svc <a class="click_esconde" href="#"><span class="caret"</span></a></legend>

<form id='form_relatorio' action="<?php echo base_url('relatorio/gerar_relatorio') ?>" method="post">

    <?php if (isset($requisicao['id_fornecedor']) && $requisicao['id_fornecedor']): ?>
        <input type="hidden" name="empresa" value="<?php echo $fornecedores[$requisicao['id_fornecedor']]->get_empresa() ?>"/>
    <?php endif; ?>

    <div class="row esconde">


        <div class="col-md-3">
            <label class=""><span
                    class="glyphicon glyphicon-filter"></span> Cliente:</label>
            <div class="">
                <select  name="id_cliente" class="form-control meu_chosen" >
                    <option value=''>--Todos--</option>
                    <?php
                    foreach ($clientes as $cliente):
                        echo "<option value='{$cliente->get_id_cliente()}' ";
                        if (isset($requisicao['id_cliente']) &&
                                $requisicao['id_cliente'] == $cliente->get_id_cliente()
                        )
                            echo "selected='selected'";
                        echo ">";
                        echo $cliente->get_nome();
                        echo "</option>";
                    endforeach;
                    ?>
                </select>

            </div>
        </div>

        <div class="col-md-3">
            <label class=""><span
                    class="glyphicon glyphicon-filter"></span> Produto:</label>
            <div class="">
                <select  id="id_produto" name="id_produto" class="form-control meu_chosen" >
                    <option value="">--Todos--</option>
                    <?php
                    foreach ($produtos as $produto):
                        echo "<option value='{$produto->get_id_produto()}' ";
                        if (isset($requisicao['id_produto']) &&
                                $requisicao['id_produto'] == $produto->get_id_produto()
                        )
                            echo "selected='selected'";
                        echo ">";
                        echo $produto->get_nome_produto() . "  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- {$produto->get_nome_fornecedor()}";
                        echo "</option>";
                    endforeach;
                    ?>

                </select>

            </div>
        </div>

        <div class="col-md-3">
            <label class=""><span
                    class="glyphicon glyphicon-filter"></span> Fornecedor:</label>
            <div class="">
                <select  id="id_fornecedor" name="id_fornecedor" class="form-control meu_chosen" >
                    <option value="">--Todos--</option>
                    <?php
                    foreach ($fornecedores as $fornecedor):
                        echo "<option value='{$fornecedor->get_id_fornecedor()}' ";
                        if (isset($requisicao['id_fornecedor']) &&
                                $requisicao['id_fornecedor'] == $fornecedor->get_id_fornecedor()
                        )
                            echo "selected='selected'";
                        echo ">";
                        echo $fornecedor->get_empresa();
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
                    $opcoes = array('cliente' => 'Cliente', 'produto' => 'Produto',
                        'data' => 'Data', 'id_servico' => 'Serviço');
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
                    class="glyphicon glyphicon-filter"></span> Estado:</label>
            <div class="">
                <select name="estado[]" class="form-control meu_chosen" multiple="multiple" data-placeholder="--Todos--">

                    <?php
                    $opcoes2 = array('2' => 'Executado', '1' => 'Orçamento', '3' => 'Em Produção', '4' => "Entregue não pago");

                    foreach ($opcoes2 as $key => $opcao):
                        echo "<option value='{$key}' ";
                        if (isset($requisicao['estado']) &&
                                in_array($key, $requisicao['estado'])
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
            <label class=""><span
                    class="glyphicon glyphicon-filter"></span> Tipo:</label>
            <div class="">
                <select name="tipo" class="form-control">
                    <option value=''>--Todos--</option>
                    <?php
                    $opcoes3 = array('1' => 'Revenda', '2' => 'Comissão', '3' => 'Venda Direta');

                    foreach ($opcoes3 as $key => $opcao):
                        echo "<option value='{$key}' ";
                        if (isset($requisicao['tipo']) &&
                                $requisicao['tipo'] == $key
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
            <label class=""><span
                    class="glyphicon glyphicon-filter"></span> Vendedor:</label>
            <div class="">
                <select  name="id_vendedor" class="form-control meu_chosen" >
                    <option value=''>--Todos--</option>
                    <?php
                    foreach ($vendedores as $vendedor):
                        echo "<option value='{$vendedor->id}' ";
                        if (isset($requisicao['id_vendedor']) &&
                                $requisicao['id_vendedor'] == $vendedor->id
                        )
                            echo "selected='selected'";
                        echo ">";
                        echo $vendedor->nome;
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
    <?php if (isset($relatorio)): ?>
        <div class="esconde">
            <button formaction="<?php echo base_url('relatorio/imprimir') ?>" type="submit"
                    formtarget="_blank" class="btn btn-success navbar-right"> <span
                    class="glyphicon glyphicon-print"></span> Formato de Impressão
            </button>

            <br><br>
        </div>  
    <?php endif; ?>
</form> 

<table id="tabela"
       class="table table-bordered table-striped custab table-condensed">
    <thead class="text-primary small">
        <tr>
            <th>Svç</th>
            <th>Data</th>
            <th>Estado</th>
            <th>Tipo</th>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Produto</th>
            <th>Qtd</th>
            <th>Total Forn</th>
            <th>Total Venda</th>
            <th>Lucro</th>

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
                     <td><?php echo $item_servico->get_nome_vendedor() ?></td>
                    <td><?php echo $item_servico->get_nome_produto() ?> </td>
                    <td><?php echo $item_servico->get_qtd_produto() ?></td>
                    <td><?php echo $item_servico->get_total_fornecedor(TRUE) ?></td>
                    <td><?php echo $item_servico->get_total_venda(TRUE) ?></td>
                    <td><?php echo $item_servico->get_lucro(TRUE) ?></td>
                </tr>  
            <?php endforeach; ?>
            <tr>
                <td colspan='9' class="text-right"><b>Total Geral</b>&nbsp;&nbsp;&nbsp;</td>
                <td class="info"><?php echo $relatorio->get_total_geral_formatado(); ?></td>
                <td class="info"><?php echo $relatorio->get_total_lucro_formatado(); ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>








