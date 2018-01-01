
<?php echo "<script src='" . base_url('assets/js/pagamentos.js') . "'></script>"; ?>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pagamentos Realizados sobre Serviço</h4>
            </div>
            <div class="modal-body">

                <div class="row bg-info info_pagamento">
                    <p class="col-md-3"><b>Serviço Nº:</b> <span id="pg_id_servico"></span></p>
                    <p class="col-md-5"><b>Cliente:</b> <span id="pg_nome_cliente"></span></p>
                    <p class="col-md-4"><b>Total Venda:</b> R$ <span id="pg_total_venda"> </span> </p>
                     <p class="col-md-offset-8 col-md-4"><b>Total Fornecedor:</b> R$ <span id="pg_total_fornecedor"> </span> </p>
                </div>
                <br>
                <form class="form-inline" id="form_pagamento" method="POST">
                    <div class="form-group">
                        <label class="sr-only" for="">Data</label>
                        <input name="data" type="text" class="form-control input-sm data datepicker" 
                               value="<?php echo date('d\/m\/Y') ?>" id="pg_data" placeholder="Data">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="">Valor Pago</label>
                        <input name="valor_pago" type="text" class="form-control input-sm pg_money" 
                               id="" placeholder="Valor Pago">
                    </div>

                    <div class="form-group">
                        <label class="sr-only" for="">Tipo de Pagameneto</label>
                        <select name="tipo_pagamento" class="form-control input-sm">
                            <option value="">Tipo Pagamento</option>
                            <option value="1">Dinheiro</option>
                            <option value="2">Cartão</option>
                            <option value="3">Boleto</option>
                            <option value="4">Cheque</option>
                            <option value="5">Dep. BB</option>
                            <option value="6">Dep. Itaú</option>
                            <option value="7">Dep. Caixa</option>
                        </select> 
                    </div>
                    
                     <div class="form-group">
                        <label class="sr-only" for="">Operação</label>
                        <select name="operacao" class="form-control input-sm">
                            <option value="">Operação</option>
                            <option value="1">Crédito</option>
                            <option value="2">Débito</option>
                           
                        </select> 
                    </div>
                    
                    <div class="form-group">
                        <label class="sr-only" for="">Fornecedor</label>
                        <select name="id_fornecedor" class="form-control input-sm" style="display:none">
                            
                           
                        </select> 
                    </div>

                    <button type="submit" class="btn btn-default">Incluir</button>
                </form>

                <div id="msg_pag">
                     
                </div>
               

                <br>
<span class="label label-success">Crédito</span>
<button class="btn btn-default btn-sm"> Total Pago: R$:<b> <span class="total_pago_credito"></span></b></button>
<button class="btn btn-default btn-sm"> Restante a Pagar: R$:<b> <span class="total_restante_credito"></span></b></button>

                <table id="pg_tabela_credito" class="pg_tabela table table-condensed table-bordered">
                    <thead>
                        <tr  class="success">
                            <th>id</th>
                            <th>Data</th>
                            <th>Valor Pago</th>
                            <th>Tipo Pagamento</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    <tbody>


                    </tbody>

                </table>


<span class="label label-danger">Débito</span>
<button class="btn btn-default btn-sm"> Total Pago: R$: <b><span class="total_pago_debito">90,00</span></b></button>
<button class="btn btn-default btn-sm"> Restante a Pagar: R$: <b><span class="total_restante_debito">90,00</span></b></button>
                <table id="pg_tabela_debito" class="pg_tabela table table-condensed table-bordered">
                    <thead>
                        <tr  class="danger">
                            <th>id</th>
                            <th>Data</th>
                            <th>Valor Pago</th>
                            <th>Tipo Pagamento</th>
                            <th>Fornecedor</th>
                            <th>Ações</th>
                        </tr>

                    </thead>

                    <tbody>
                       
                   

                    </tbody>

                </table>



            </div><!-- /.modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
