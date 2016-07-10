<?php echo "<script src='" . base_url('assets/plugins/jquery.confirm.js') . "'></script>"; ?>
<?php echo "<script src='" . base_url('assets/js/modalexclusao.js') . "'></script>"; ?>
<?php echo "<script src='" . base_url('assets/js/tabela.js') . "'></script>"; ?>
<legend>Lista de Produtos Cadastrados</legend>

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
        <a href="<?php echo base_url('produto/novo_produto') ?>" type="button"
           class="btn btn-success navbar-right"> <span
                class="glyphicon glyphicon-plus"></span> Novo Produto
        </a>
        <br><br>
    </div>
</div>

<!--inicio da tabela com lista de produtos-->


<table id="tabela" class="table table-bordered table-striped custab table-condensed">
    <thead>
        <tr class="text-primary">
            <th>Nome</th>
            <th>Valor Un</th>
            <th>Fornecedor</th>
            <th>Ação </th>

        </tr>
    </thead>

    <tbody>

        <?php
        if ($produtos):
            foreach ($produtos as $produto):
                ?>
                <tr>
                    <td><?php echo $produto->get_nome_produto(); ?></td>
                    <td><?php echo "R$ " . number_format($produto->get_valor(), 2, ",", "."); ?></td>
                    <td><?php echo $produto->get_nome_fornecedor(); ?></td>

                    <td>
                        <a class="btn btn-default"
                            data-toggle="tooltip"
                            title="Editar"
                            href="<?php echo base_url('produto/editar') . '/' . $produto->get_id_produto() ?>">
                            <span class="glyphicon glyphicon-pencil"></span> 
                        </a>
                    
                        <a class="confirm_produto btn btn-danger"
                            data-toggle="tooltip"
                            title="Excluir"
                           href="<?php echo base_url('produto/excluir') . '/' . $produto->get_id_produto() ?>">
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

