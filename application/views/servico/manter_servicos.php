<?php echo "<script src='" . base_url('assets/plugins/jquery.confirm.js') . "'></script>"; ?>
<?php echo "<script src='" . base_url('assets/js/modalexclusao.js') . "'></script>"; ?>
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


<table id="tabela" data-order='[[ 0, "desc" ]]'
       class="table table-bordered table-striped custab table-condensed">
    <thead>
        <tr class="text-primary">
            <th class="col-md-1">Cód Serv</th>
            <th>Cliente</th>


            <th>Data</th>
            <th>Estado</th>
            <th>Tipo</th>
             <th>Vendedor</th>
            <th >
                Ação
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
                        if ($servico->get_estado() != 2):
                            ?>
                            <a class="confirm_executar_servico" 
                                data-toggle="tooltip" title="Avançar Estado do Serviço"
                               href="<?php echo base_url('servico/executar_servico') . '/' . $servico->get_id_servico() ?>">
                                <span class='glyphicon glyphicon-ok'></span>
                            </a>
        <?php endif; ?>
                  


                    </td>
                    <td><?php echo $servico->get_nome_tipo(); ?></td>
                      <td>
                        <?php echo $servico->get_nome_vendedor() ?>
                    </td>
                    <td class="">
                       
                        <a target="_blank" class="btn_imprimir btn btn-default" 
                           data-id_servico="<?php echo $servico->get_id_servico(); ?>"
                           data-estado="<?php echo $servico->get_estado(); ?>"
                           data-toggle="tooltip"
                           title="Imprimir"
                           href="<?php echo base_url('servico/imprimir') . '/' . $servico->get_id_servico() ?>">
                            <span class="glyphicon glyphicon-print"></span> 
                         
                        </a>
                           
                   
                        <a class="btn btn-default"
                            data-toggle="tooltip"
                           title="Editar"
                            href="<?php echo base_url('servico/editar') . '/' . $servico->get_id_servico() ?>">
                            <span class="glyphicon glyphicon-pencil"></span> 
                        </a>
                   
                        <a class="confirm_servico btn btn-danger" 
                            data-toggle="tooltip"
                           title="Excluir"
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



<script>
    $('.estado:contains("Orçamento")').addClass('text-danger');
    $('.estado:contains("Executado")').addClass('text-success');
    
</script>

<?php // echo "<pre>"; print_r($servicos);
