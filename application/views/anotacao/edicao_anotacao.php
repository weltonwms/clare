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
    $class_limpa="";
    if ($anotacao->get_id_anotacao()){
        echo 'Alteração de  Anotacação';
    }
    else{
        $class_limpa="limpa_state";
        echo 'Nova Anotação';
    }
    ?>


</legend>



<form method="post" action="<?php echo base_url('anotacao/salvar') ?>" id="form_anotacao">
    <input type="hidden" name="id_anotacao" value="<?php echo $anotacao->get_id_anotacao(); ?>"/>
    <div class="col-md-12">
        <div class="navbar-right ">
            
           
            <button
                    type="submit" 
                    class="btn btn-success <?php echo $class_limpa?>" 
                    id="salvar">
                <span class="glyphicon glyphicon-save"></span> Salvar e Fechar
            </button>
            <a href="<?php echo base_url('anotacao') ?>"
               class="btn btn-default">
                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
            </a>

        </div>
    </div>

    <div class="control-group col-md-6">
        <label class="control-label">Fornecedor</label>

        <select  name="id_fornecedor" class="form-control meu_chosen" >
              <option value="" >Selecione</option>
            <?php
            foreach ($fornecedores as $fornecedor):
                echo "<option value='{$fornecedor->get_id_fornecedor()}' ";
                if ($fornecedor->get_id_fornecedor() == $anotacao->get_id_fornecedor())
                    echo "selected='selected'";
                echo ">";
                echo $fornecedor->get_empresa();
                echo "</option>";
            endforeach;
            ?>
        </select>

    </div>





    <div class="control-group col-md-3">
        <label class="control-label ">Data</label> 

        <input 	id="data" type="text" class="form-control data datepicker" name='data'
                value="<?php echo ($anotacao->get_data() != '') ? $anotacao->get_data() : date('d/m/Y'); ?>">

    </div>



    <div class="control-group col-md-3">
        <label class="control-label ">Estado</label> 

        <select class="form-control " name='estado' id="estado">
            <option value="1" <?php if ($anotacao->get_estado() == '1') echo "selected='selected'"; ?>>Ativo</option>
            <option value="2" <?php if ($anotacao->get_estado() == '2') echo "selected='selected'"; ?>>Inativo</option>
        </select>

    </div>

    <div class="control-group col-md-12">
        <label class="control-label ">Descrição</label> 

        <input 	id="descricao" type="text" class="form-control" name='descricao'
                value="<?php echo $anotacao->get_descricao() ?>">

    </div>
   
    
</form>

    

