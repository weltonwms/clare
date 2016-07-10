<?php
echo "<script src='" . base_url('assets/plugins/jquery.validate.js') . "'></script>";
echo "<script src='" . base_url('assets/plugins/jquery.mask.js') . "'></script>";
echo "<script src='" . base_url('assets/js/validacao_servico.js') . "'></script>";
echo "<script src='" . base_url('assets/plugins/jquery.confirm.js') . "'></script>";
echo "<script src='" . base_url('assets/js/modalexclusao.js') . "'></script>";
echo link_tag(array('href' => 'assets/plugins/chosen/chosen.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
echo "<script src='" . base_url('assets/plugins/chosen/chosen.jquery.js') . "'></script>";
?>

<legend>
    <?php
    $class_limpa = "";
    if ($servico->get_id_servico()) {
        echo 'Alteração de  Serviço';
    } else {
        $class_limpa = "limpa_state";
        echo 'Novo Serviço';
    }
    ?>


</legend>

<?php if ($this->session->flashdata('msg_confirm') != null): ?>
    <div class="alert alert-<?php echo $this->session->flashdata('status') ?> alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php $icone = $this->session->flashdata('status') == 'danger' ? 'remove' : 'ok' ?>
        <?php echo "<span class=\"glyphicon glyphicon-$icone  \"></span>&nbsp" ?>
        <?php echo $this->session->flashdata('msg_confirm') ?>
    </div>
<?php endif; ?>


<form method="post" action="<?php echo base_url('servico/manter_itens_servico') ?>" id="form_servico">
    <input type="hidden" name="id_servico" value="<?php echo $servico->get_id_servico(); ?>"/>
    <div class="col-md-12">
        <div class="navbar-right ">
            <?php if ($servico->get_id_servico()): ?>
                <button formaction="<?php echo base_url('servico/clonar') ?>"
                        type="submit" class="btn btn-default limpa_state" id="Clonar">
                    <span class=" text-danger glyphicon glyphicon-heart"></span> Clonar
                </button>
            <?php endif; ?>
            <button formaction="<?php echo base_url('servico/salvar_servico') ?>"
                    type="submit" 
                    class="btn btn-success <?php echo $class_limpa ?>" 
                    id="salvar">
                <span class="glyphicon glyphicon-save"></span> Salvar e Fechar
            </button>
            <a href="<?php echo base_url('servico') ?>"
               class="btn btn-default">
                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
            </a>

        </div>
    </div>

    <div class="control-group col-md-5">
        <label class="control-label">Cliente</label>

        <select  name="id_cliente" id="id_cliente" class="form-control meu_chosen" >
            <option value="" >Selecione</option>
            <?php
            foreach ($clientes as $cliente):
                echo "<option value='{$cliente->get_id_cliente()}' ";
                if ($cliente->get_id_cliente() == $servico->get_id_cliente())
                    echo "selected='selected'";
                echo ">";
                echo $cliente->get_nome();
                echo "</option>";
            endforeach;
            ?>
        </select>

    </div>





    <div class="control-group col-md-2">
        <label class="control-label ">Data Servico</label> 

        <input 	id="data" type="text" class="form-control data datepicker" name='data'
                value="<?php echo ($servico->get_data() != '') ? $servico->get_data() : date('d/m/Y'); ?>">

    </div>



    <div class="control-group col-md-2">
        <label class="control-label ">Estado</label> 

        <select class="form-control " name='estado' id="estado">
            <option value="" >Selecione</option>
            <option value="1" <?php if ($servico->get_estado() == '1') echo "selected='selected'"; ?>>Orçamento</option>
            <option value="3" <?php if ($servico->get_estado() == '3') echo "selected='selected'"; ?>>Em Produção</option>
            <option value="4" <?php if ($servico->get_estado() == '4') echo "selected='selected'"; ?>>Entregue não Pago</option>
            <option value="2" <?php if ($servico->get_estado() == '2') echo "selected='selected'"; ?>>Executado</option>
        </select>

    </div>

    <div class="control-group col-md-3">
        <label class="control-label ">Forma Pagamento</label> 

        <input 	id="forma_pagamento" type="text" class="form-control" name='forma_pagamento'
                value="<?php echo $servico->get_forma_pagamento() ?>">

    </div>
    <div class="control-group col-md-2">
        <label class="control-label ">Tipo</label> 

        <select class="form-control " name='tipo' id="tipo">
            <option value="" >Selecione</option>
            <option value="1" <?php if ($servico->get_tipo() == '1') echo "selected='selected'"; ?>>Revenda</option>
            <option value="2" <?php if ($servico->get_tipo() == '2') echo "selected='selected'"; ?>>Comissão</option>
            <option value="3" <?php if ($servico->get_tipo() == '3') echo "selected='selected'"; ?>>Venda Direta</option>
        </select>

    </div>

    <div class="control-group col-md-10">
        <label class="control-label ">Obs:</label> 

        <input 	id="obs" type="text" class="form-control" name='obs'
                value="<?php echo $servico->get_obs() ?>">

    </div>

    <br><br>









    <!--inicio do modal de adicionar ou alterar Item de Serviço-->

    <div class="modal fade" id="modal_manter_item_servico">
        <div class="modal-dialog largura_ideal">
            <div class="modal-content">


                <input type="hidden" name="id_item" id="id_item" value=""/>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Adicionar Produto</h4>
                </div>
                <div class="modal-body altura_minima">
                    <div class="form-group col-md-12">
                        <label class="control-label ">Produto</label>

                        <select  id="id_produto" name="id_produto" class="form-control meu_chosen" >
                            <option data-forn="" value="">--Selecione--</option>
                            <?php
                            foreach ($produtos as $produto):
                                echo "<option value='{$produto->get_id_produto()}' ";
                                echo "data-forn='{$produto->get_valor()}'";
                                echo ">";
                                echo $produto->get_nome_produto() . "  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- {$produto->get_nome_fornecedor()}";
                                echo "</option>";
                            endforeach;
                            ?>

                        </select>


                    </div> 



                    <div class="form-group col-md-6">
                        <label class="control-label">Descrição</label>

                        <input id="descricao" type="text"
                               value=""
                               class="form-control" name='descricao' placeholder="Descricao">

                    </div>


                    <div class="form-group col-md-6">
                        <label class="control-label">Qtd</label>

                        <input id="qtd_produto" type="text"
                               value=""
                               class="form-control" name='qtd_produto' placeholder="Qtd">

                    </div>

                    <div class="form-group col-md-6" >
                        <label class="control-label text-success">Valor Un Fornecedor</label>

                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            <input name="" id="valor_unitario_fornecedor" type="text"
                                   class="form-control" style="background-color:azure"> 
                        </div>

                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label " >Un Venda</label>

                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            <input id="valor_unitario_venda" type="text"
                                   class="form-control money" name='' placeholder="000.000,00">
                        </div>

                    </div>

                    <div class="form-group col-md-6" >
                        <label class="control-label text-success ">Total Fornecedor</label>

                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            <input id="total_fornecedor" type="text" name="total_fornecedor"
                                   class="form-control " style="background-color:azure">
                        </div>

                    </div>

                    <div class="form-group col-md-6">
                        <label class="control-label ">Valor Total</label>

                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            <input id="total_venda" type="text" name="total_venda"
                                   class="form-control" >
                        </div>

                    </div>


                </div> <!-- /.modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button id="btn_submit_tudo"  class="btn btn-success <?php echo $class_limpa ?>">Salvar</button>
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


</form>




<br><br><br><br>
<div class="row">
    <div class="col-md-12" style="">
        <btn href="<?php echo base_url('') ?>" type="button"
             id="btn_adicionar_item_servico" class="btn btn-default navbar-right"> <span
                class="glyphicon glyphicon-plus"></span> Novo Item
        </btn>
        <table class="table table-bordered table-striped custab table-condensed">
            <thead>
                <tr class="text-primary">
                    <th>Item</th>
                    <th>Qtd</th>
                    <th class="col-md-6">Nome Produto</th>
                    <th>Descrição</th>

                    <th >Total Forn</th>
                    <th>Total Venda</th>

                    <th><span class="glyphicon glyphicon-pencil"></span> Editar</th>
                    <th><span class="text-danger"><span class="glyphicon glyphicon-trash">
                            </span>Excluir</span>
                    </th>

                </tr>
            </thead>

            <tbody>
                <?php
                $cont = 1;
                foreach ($servico->get_itens_servico() as $item_servico):
                    ?> 
                    <tr>
                        <td><?php echo $cont ?> </td>
                        <td><?php echo $item_servico->get_qtd_produto() ?></td>
                        <td><?php echo $item_servico->get_nome_produto_fornecedor() ?></td>
                        <td><?php echo $item_servico->get_descricao() ?></td>

                        <td><?php echo "R$ " . number_format($item_servico->get_total_fornecedor(), 2, ",", "."); ?></td>
                        <td><?php echo "R$ " . number_format($item_servico->get_total_venda(), 2, ",", "."); ?></td>
                        <td>
                            <a data-id_item="<?php echo $item_servico->get_id_item() ?>" 
                               data-id_produto="<?php echo $item_servico->get_id_produto() ?>"
                               data-qtd_produto="<?php echo $item_servico->get_qtd_produto() ?>"
                               data-descricao="<?php echo $item_servico->get_descricao() ?>"
                               data-valor_unitario_venda="<?php echo number_format($item_servico->get_valor_unitario_venda(), 3, ",", "."); ?>"
                               data-valor_unitario_fornecedor="<?php echo number_format($item_servico->get_valor_unitario_fornecedor(), 3, ",", "."); ?>"
                               data-total_venda="<?php echo number_format($item_servico->get_total_venda(), 3, ",", "."); ?>"
                               data-total_fornecedor="<?php echo number_format($item_servico->get_total_fornecedor(), 3, ",", "."); ?>"
                               class="editar_item_servico"
                               href="#">
                                <span class="glyphicon glyphicon-pencil"></span> 
                            </a>

                        </td>
                        <td>
                            <a class="confirm_item_servico text-danger" 
                               href="<?php
                               echo base_url('servico/excluir_item_servico') . '/' .
                               $item_servico->get_id_item() . '/' . $servico->get_id_servico()
                               ?>">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>

                        </td>
                    </tr>

                    <?php
                    $cont++;
                endforeach;
                ?>
                <tr >
                    <td colspan="3"></td>
                    <td class="text-center info"><b>Total Geral</b></td>
                    <td class="info"><?php echo "R$ " . number_format($servico->get_total_geral_fornecedor(), 2, ",", "."); ?></td>
                    <td class="info"><?php echo "R$ " . number_format($servico->get_total_geral_venda(), 2, ",", "."); ?></td>
                    <td colspan="2"></td>
                </tr>

            </tbody>


        </table>
    </div>
</div>

<script>


    $("#btn_adicionar_item_servico").click(function () {
        if (pre_validar()) {
            $('.modal-title').html('Adicionar Item de servico');
            $("#id_item").val('');
            $("#id_produto").val('').trigger("chosen:updated");
            $("#qtd_produto").val('');
            $("#descricao").val('');
            $("#valor_unitario_venda").val('');
            $("#total_venda").val('');
            $("#valor_unitario_fornecedor").val('');
            $("#total_fornecedor").val('');
            $("#modal_manter_item_servico").modal('show');
        }
    });

    $("#btn_submit_tudo").click(function () {
        $("#form_servico").submit();
    });

    $(".editar_item_servico").click(function () {
        if (pre_validar()) {
            id_item = ($(this).attr('data-id_item'));
            id_produto = ($(this).attr('data-id_produto'));
            qtd_produto = ($(this).attr('data-qtd_produto'));
            descricao = ($(this).attr('data-descricao'));
            valor_unitario_fornecedor = ($(this).attr('data-valor_unitario_fornecedor'));
            total_fornecedor = ($(this).attr('data-total_fornecedor'));
            valor_unitario_venda = ($(this).attr('data-valor_unitario_venda'));
            total_venda = ($(this).attr('data-total_venda'));

            $('.modal-title').html('Alterar Item de Serviço');

            $("#id_item").val(id_item);
            $("#id_produto").val(id_produto).trigger("chosen:updated");
            $("#qtd_produto").val(qtd_produto);
            $("#descricao").val(descricao);
            $("#valor_unitario_fornecedor").val(valor_unitario_fornecedor);
            $("#total_fornecedor").val(total_fornecedor);
            $("#valor_unitario_venda").val(valor_unitario_venda);
            $("#total_venda").val(total_venda);
            $("#modal_manter_item_servico").modal('show');
        }
    });

    function pre_validar() {
        var validator = $("#form_servico").validate();
        var v1 = validator.element("#id_cliente");
        var v2 = validator.element("#data");
        var v3 = validator.element("#estado");
        return v1 && v2 && v3;

    }






</script>