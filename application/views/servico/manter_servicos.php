<?php echo "<script src='" . base_url('assets/plugins/jquery.confirm2.js') . "'></script>"; ?>
<?php echo "<script src='" . base_url('assets/plugins/jquery.mask.js') . "'></script>";?> <!--utilizado em pagamentos.js -->
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
<div class="row">
    <div class="col-md-12">
        <a href="<?php echo base_url('servico/editar') ?>" type="button"
           class="btn btn-success navbar-right"> <span
           class="glyphicon glyphicon-plus"></span> Novo Servico
         </a>
        <br><br>
    </div>
</div>

<!--inicio da tabela com lista de servicos-->



<?php $this->load->view('servico/pagamentos')?>
<table id="tabela_cliente" 
       class="table table-bordered table-striped custab table-condensed table-hover">
     <thead>
            <tr>
                <th>Cód Sv</th>
                <th>Cliente</th>
                <th>Data</th>
                <th>Estado</th>
                <th>Tipo</th>
                <th>Vendedor</th>
                <th>Ações</th>
            </tr>
        </thead>

    <tbody>
<!-- Carregamento de responsabilidade do Datatables Ajax-->

       
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

<!--inicio do modal Impressão de Serviço-->

<div class="modal fade" id="modal_imprimir_servico">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" id="form_imprimir_servico" target="__blank">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-th"></span> Imprimir Serviço</h4>
                </div>
                <div class="modal-body">
                    <p><b>Deseja Imprimir Valor Total?</b></p>
                    <label class="radio-inline">
                        <input value='1' type="radio" name="imprimir_total">Sim
                    </label>
                    <label class="radio-inline">
                        <input value="0" type="radio" name="imprimir_total" checked="checked">Não
                    </label>

                </div> <!-- /.modal-body -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" >
                        <span class="glyphicon glyphicon-print"></span> Imprimir
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>

                </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



