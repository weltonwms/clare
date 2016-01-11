<?php echo "<script src='" . base_url('assets/plugins/jquery.confirm.js') . "'></script>"; ?>
<?php echo "<script src='" . base_url('assets/js/modalexclusao.js') . "'></script>"; ?>
<?php echo "<script src='" . base_url('assets/plugins/data_table.js') . "'></script>"; ?>
<?php echo "<script src='" . base_url('assets/js/tabela.js') . "'></script>"; ?>


<legend>Lista de Clientes Cadastrados</legend>

<?php if ($this->session->flashdata('msg_confirm') != null): ?>
    <div class="alert alert-<?php echo $this->session->flashdata('status') ?> alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php $icone = $this->session->flashdata('status') == 'danger' ? 'remove' : 'ok' ?>
        <?php echo "<span class=\"glyphicon glyphicon-$icone  \"></span>&nbsp" ?>
        <?php echo $this->session->flashdata('msg_confirm') ?>
    </div>
<?php endif; ?>

<a href="<?php echo base_url('cliente/novo_cliente') ?>" type="button"
   class="btn btn-success navbar-right"> <span
        class="glyphicon glyphicon-plus"></span> Novo Cliente
</a>
<br>


<!--inicio da tabela com lista de clientes-->


<table id="tabela" class="table table-bordered   table-condensed">
    <thead>
        <tr class="text-primary">
            <th>Empresa</th>
            <th>Endereço</th>
            <th >Telefone1</th>
            <th>Responsavel</th>

            <th class="col-md-1 col-lg-1"><span class="glyphicon glyphicon-pencil"></span> Editar</th>
            <th class="col-md-1 col-lg-1"><span class="text-danger"><span class="glyphicon glyphicon-trash">
                    </span>Excluir</span>
            </th>

        </tr>
    </thead>

    <tbody>

        <?php
        if ($clientes):
            foreach ($clientes as $cliente):
                ?>
                <tr>
                    <td>
                        <a href="#" class="detalhe_cliente" 
                           data-id_cliente="<?php echo $cliente->get_id_cliente(); ?>">
                            <?php echo $cliente->get_nome(); ?>
                        </a>

                    </td>
                    <td><?php echo $cliente->get_endereco(); ?></td>
                    <td><?php echo $cliente->get_telefone(); ?></td>
                    <td><?php echo $cliente->get_responsavel(); ?></td>

                    <td>
                        <a href="<?php echo base_url('cliente/editar') . '/' . $cliente->get_id_cliente() ?>">
                            <span class="glyphicon glyphicon-pencil"></span> 
                        </a>
                    </td>
                    <td class="text-center col-md-1">
                        <a class="confirm text-danger" 
                           href="<?php echo base_url('cliente/excluir') . '/' . $cliente->get_id_cliente() ?>">
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

<!--inicio do modal detalhar Cliente-->

<div class="modal fade" id="modal_detalhar_cliente">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-th"></span> Detalhes do Cliente</h4>
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

<?php echo "<script src='" . base_url('assets/js/manter_cliente.js') . "'></script>"; ?>