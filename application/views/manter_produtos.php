<?php echo "<script src='" . base_url('assets/plugins/jquery.confirm.js') . "'></script>"; ?>
<?php echo "<script src='" . base_url('assets/js/modalexclusao.js') . "'></script>"; ?>
<?php echo "<script src='" . base_url('assets/plugins/data_table.js') . "'></script>"; ?>
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

<a href="<?php echo base_url('produto/novo_produto') ?>" type="button"
   class="btn btn-success navbar-right"> <span
        class="glyphicon glyphicon-plus"></span> Novo Produto
</a>
<br>


<!--inicio da tabela com lista de produtos-->


<table id="tabela" class="table table-bordered table-striped custab table-condensed">
    <thead>
        <tr class="text-primary">
            <th>Nome</th>
           
            <th>Fornecedor</th>
            
            <th><span class="glyphicon glyphicon-pencil"></span> Editar</th>
            <th><span class="text-danger"><span class="glyphicon glyphicon-trash">
                    </span>Excluir</span>
            </th>

        </tr>
    </thead>

    <tbody>

        <?php
        if ($produtos):
            foreach ($produtos as $produto):
                ?>
                <tr>
                    <td><?php echo $produto->get_nome_produto(); ?></td>
                    <td><?php echo $produto->get_nome_fornecedor(); ?></td>
                    
                    <td>
                        <a href="<?php echo base_url('produto/editar') . '/' . $produto->get_id_produto() ?>">
                            <span class="glyphicon glyphicon-pencil"></span> 
                        </a>
                    </td>
                    <td class="text-center">
                        <a class="confirm_produto text-danger" 
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

