<?php echo "<script src='" . base_url('assets/plugins/jquery.confirm.js') . "'></script>"; ?>
<?php echo "<script src='" . base_url('assets/js/modalexclusao.js') . "'></script>"; ?>
<?php echo "<script src='" . base_url('assets/plugins/data_table.js') . "'></script>"; ?>
<?php echo "<script src='" . base_url('assets/js/tabela.js') . "'></script>"; ?>
<?php echo "<script src='" . base_url('assets/js/manter_servico.js') . "'></script>"; ?>

<legend>Lista de Servicos</legend>

<?php if ($this->session->flashdata('msg_confirm') != null): ?>
    <div class="alert alert-<?php echo $this->session->flashdata('status') ?> alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php $icone = $this->session->flashdata('status') == 'danger' ? 'remove' : 'ok' ?>
        <?php echo "<span class=\"glyphicon glyphicon-$icone  \"></span>&nbsp" ?>
        <?php echo $this->session->flashdata('msg_confirm') ?>
    </div>
<?php endif; ?>

<a href="<?php echo base_url('servico/editar') ?>" type="button"
   class="btn btn-success navbar-right"> <span
        class="glyphicon glyphicon-plus"></span> Novo Servico
</a>
<br>


<!--inicio da tabela com lista de servicos-->


<table id="tabela" class="table table-bordered table-striped custab table-condensed">
    <thead>
        <tr class="text-primary">
            <th class="col-md-1">Cód Serv</th>
            <th>Cliente</th>
            
            
            <th>Data</th>
            <th>Estado</th>
            <th>Tipo</th>
            <th class="text-center col-md-1"><span class="glyphicon glyphicon-print"></span> Imprimir</th>
            <th class="text-center col-md-1"><span class="glyphicon glyphicon-pencil"></span> Editar</th>
            <th class="text-center col-md-1"><span class="text-danger"><span class="glyphicon glyphicon-trash">
                    </span>Excluir</span>
            </th>


        </tr>
    </thead>

    <tbody>

        <?php
        if ($servicos):
            foreach ($servicos as $servico):
                ?>
                <tr>
                    <td>
                        <a href="#" class="detalhe_servico" 
                          data-id_servico="<?php echo $servico->get_id_servico(); ?>">
                        <?php echo $servico->get_id_servico(); ?>
                        </a>
                    </td>
                    <td><?php echo $servico->get_nome_cliente(); ?></td>
                   
                   
                    <td><?php echo $servico->get_data(); ?></td>
                    <td class="estado">
                        <?php echo $servico->get_nome_estado(); 
                            if($servico->get_estado()!=2):?>
                        <a class="confirm_executar_servico" 
                           data-teste="teste"
                           href="<?php echo base_url('servico/executar_servico') . '/' . $servico->get_id_servico() ?>">
                                <span class='glyphicon glyphicon-ok'></span>
                        </a>
                        <?php endif;?>
                    
                    
                    </td>
                    <td><?php echo $servico->get_nome_tipo(); ?></td>
                    <td class="text-center">
                        <a target="_blank" 
                           href="<?php echo base_url('servico/imprimir') . '/' . $servico->get_id_servico() ?>">
                            <span class="glyphicon glyphicon-print"></span> 
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="<?php echo base_url('servico/editar') . '/' . $servico->get_id_servico() ?>">
                            <span class="glyphicon glyphicon-pencil"></span> 
                        </a>
                    </td>
                    <td class="text-center">
                        <a class="confirm_servico text-danger" 
                           href="<?php echo base_url('servico/excluir') . '/' . $servico->get_id_servico() ?>">
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


<!--inicio do modal detalhar Serviço-->

<div class="modal fade" id="modal_detalhar_servico">
    <div class="modal-dialog largura_ideal">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-th"></span> Detalhes do Serviço</h4>
            </div>
            <div class="modal-body">
                <div id="conteudo_modal"></div>

            </div> <!-- /.modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>

            </div>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
 $('.estado:contains("Orçamento")').addClass('text-danger');
 $('.estado:contains("Executado")').addClass('text-success');
</script>
