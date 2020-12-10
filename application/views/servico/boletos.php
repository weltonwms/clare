<!-- Modal -->

<div class="modal fade" id="modalBoletos" tabindex="-1" role="dialog" aria-labelledby="modalBoletosLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalBoletosLabel">Geração de Boletos</h4>
            </div>
            <div class="modal-body">




                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="fbp_parcelas">Parcelas</label>
                        <select class="form-control" id="fbp_parcelas">
                            <option value="">--Selecione--</option>
                            <?php for ($i = 1; $i < 13; $i++): ?>
                                <option><?php echo $i ?></option>
                            <?php endfor ?>

                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fbp_dataInicial">Data Inicial</label>
                        <input type="date" value="<?php echo date('Y-m-d') ?>"
                               class="form-control"  id="fbp_dataInicial" placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fbp_total">Total</label>
                        <input type="number" class="form-control" id="fbp_total"  placeholder="">
                    </div>
                    <div class="form-group col-md-2">

                        <label for="">Confirmar</label>
                        <button class="form-control btn btn-default" id="fbp_btnConfirm">
                            <span class="glyphicon glyphicon-ok"></span>
                        </button>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-default pull-right addBolToServico" 
                                >
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </div>
                </div>

                <div class="row blocoAdd" style="display: none">

                    <div class="form-group col-md-3">
                        <label for="vencimento">Vencimento</label>
                        <input type="date" class="form-control"  id="vencimento" placeholder="Vencimento">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Nr Boleto</label>
                        <input type="text" class="form-control"  id="nr_boleto" placeholder="Nr Boleto">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="">Valor</label>
                        <input type="number" class="form-control"  id="valor_boleto" placeholder="Valor">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="estado_boleto">Estado</label>
                        <select class="form-control"  id="estado_boleto">
                            <option value="1">Não Pago</option>
                            <option value="2">Pago</option>
                        </select>
                    </div>

                    <div class="form-group col-md-2">

                        <label for="">Confirmar</label>
                        <button class="form-control btn btn-default" id="submitBoleto">
                            <span class="glyphicon glyphicon-ok"></span>
                        </button>
                    </div>

                </div>

                <br><br>
                <table class="table tabelaBoletos">
                    <thead>
                        <tr>
                            <th style="display: none">id</th>
                            <th>Vencimento</th>
                            <th>Nr Boleto</th>
                            <th>Valor</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="bodyBoletos">


                    </tbody>
                </table>




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

            </div>
        </div>
    </div>
</div> <!-- Fim Modal -->

<?php echo "<script src='" . base_url('assets/js/boletos.js') . "'></script>"; ?>
