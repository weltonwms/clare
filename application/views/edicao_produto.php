<?php
echo "<script src='" . base_url('assets/plugins/jquery.validate.js') . "'></script>";
echo "<script src='" . base_url('assets/plugins/jquery.mask.js') . "'></script>";
echo "<script src='" . base_url('assets/js/validacao_produto.js') . "'></script>";
echo link_tag(array('href' => 'assets/plugins/chosen/chosen.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
echo "<script src='" . base_url('assets/plugins/chosen/chosen.jquery.js') . "'></script>";
?>
<legend>Alteração de Produto</legend>


<form method="post" id="form_produto" class="form-horizontal">
    <input type="hidden" name="id_produto" value="<?php echo $produto->get_id_produto(); ?>"/>
    <div class="row">
        <div class=" col-md-6">
            <fieldset>
                <legend>Produto</legend>


                <div class="form-group ">

                    <label class="control-label col-md-4" for="nome">Nome</label> 
                    <div class="col-md-8">
                        <input id="nome" name="nome" placeholder="Nome"
                               value="<?php echo $produto->get_nome_produto() ?>"
                               class="form-control" type="text">
                    </div>

                </div>
                <div class="form-group ">
                    <label class="control-label col-md-4">Valor Un</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            <input name="valor" id="valor" type="text"
                                   class="form-control money" 
                                   value="<?php echo $produto->get_valor() ?>" > 
                        </div>
                    </div>

                </div>



                <div class="form-group">
                    <label class="control-label col-md-4">Fornecedor</label>
                    <div class="col-md-8">
                        <select  name="id_fornecedor" class="form-control meu_chosen" >
                            <?php
                            foreach ($fornecedores as $fornecedor):
                                echo "<option value='{$fornecedor->get_id_fornecedor()}' ";
                                if ($fornecedor->get_id_fornecedor() == $produto->get_id_fornecedor())
                                    echo "selected='selected'";
                                echo ">";
                                echo $fornecedor->get_empresa();
                                echo "</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
            </fieldset>



        </div>


    </div>
    <div class="control-group col-md-7 col-md-offset-5">
        <button formaction="<?php echo base_url('produto/gravar_alteracao') ?>"
                type="submit" class="btn btn-success" id="salvar">
            <span class="glyphicon glyphicon-save"></span> Salvar
        </button>
        <button id="voltar"
                type="button" class="btn btn-default">
            <span class="glyphicon glyphicon-arrow-left"></span> Voltar
        </button>

    </div>



</form>
