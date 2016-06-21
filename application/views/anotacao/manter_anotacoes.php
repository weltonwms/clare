<?php echo "<script src='" . base_url('assets/plugins/jquery.confirm.js') . "'></script>"; ?>
<?php echo "<script src='" . base_url('assets/js/modalexclusao.js') . "'></script>"; ?>
<?php echo "<script src='" . base_url('assets/js/tabela.js') . "'></script>"; ?>


<legend>Lista de Anotações</legend>

<?php if ($this->session->flashdata('msg_confirm') != null): ?>
    <div class="alert alert-<?php echo $this->session->flashdata('status') ?> alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php $icone = $this->session->flashdata('status') == 'danger' ? 'remove' : 'ok' ?>
        <?php echo "<span class=\"glyphicon glyphicon-$icone  \"></span>&nbsp" ?>
        <?php echo $this->session->flashdata('msg_confirm') ?>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-md-12">
        <a href="<?php echo base_url('anotacao/editar') ?>" type="button"
           class="btn btn-success navbar-right"> <span
                class="glyphicon glyphicon-plus"></span> Nova Anotação
         </a>
        <br><br>
    </div>
</div>

<!--inicio da tabela com lista de servicos-->


<table id="tabela" 
       class="table table-bordered table-striped  table-condensed">
    <thead>
        <tr class="text-primary">
            <th class="col-md-1">cod</th>
            <th>Descrição</th>


            <th>Data</th>
            <th>Estado</th>
            <th>Fornecedor</th>
            <th >
                Ação
            </th>


        </tr>
    </thead>

    <tbody>
            <?php
        if ($anotacoes):
            
            foreach ($anotacoes as $anotacao):
                ?>
                <tr>
                    <td>
                        <a href="#" class="" 
                           data-id_anotacao="<?php echo $anotacao->get_id_anotacao(); ?>">
                               <?php echo $anotacao->get_id_anotacao(); ?>
                        </a>
                    </td>
                    <td><?php echo $anotacao->get_descricao(); ?></td>


                    <td><?php echo $anotacao->get_data(); ?></td>
                    <td class="estado">
                        <?php echo $anotacao->get_nome_estado(); ?>


                    </td>
                    <td><?php echo $anotacao->get_nome_fornecedor(); ?></td>
                    <td class="">
                                          
                        <a class="btn btn-default"
                            data-toggle="tooltip"
                           title="Editar"
                            href="<?php echo base_url('anotacao/editar') . '/' . $anotacao->get_id_anotacao() ?>">
                            <span class="glyphicon glyphicon-pencil"></span> 
                        </a>
                   
                        <a class="confirm_servico btn btn-danger" 
                            data-toggle="tooltip"
                           title="Excluir"
                           href="<?php echo base_url('anotacao/excluir') . '/' . $anotacao->get_id_anotacao() ?>">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </td>

                </tr>
                <?php
            endforeach;
            
        endif;
        ?>

       
    </tbody>


</table>



