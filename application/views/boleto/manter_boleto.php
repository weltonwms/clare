<?php
echo "<script src='" . base_url('assets/plugins/jquery.confirm.js') . "'></script>";
echo "<script src='" . base_url('assets/js/modalexclusao.js') . "'></script>";

?>

<legend>Gerenciamento de Boletos</legend>

<div class="row">
    <div class="col-md-12">
        <button class="btn btn-success btn-sm pull-right"
                data-backdrop="static" data-keyboard="false"
                data-toggle="modal" data-target="#myModal">
            <span class="glyphicon glyphicon-plus"></span> Novo
        </button>
    </div>

</div>
<br>




<?php foreach ($items as $key=>$item): ?>

    <div class="panel  panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-10">  Cliente: <b><?php echo $item->cliente_nome ?></b> | Serviço: <?php echo $item->id_servico ?></div>
                <div class="col-md-2">  
                    <button class="btn btn-default btn-xs pull-right addBolToServico" 
                            data-id_servico="<?php echo $item->id_servico ?>">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>

                </div>
            </div>

        </div>
        <div class="panel-body">
            <p>
                <b>Produto(s):</b>
                <?php foreach ($item->produtos as $produto): ?>
                    <?php echo $produto->produto_nome . " " . $produto->descricao ?><br>
                <?php endforeach; ?>
            </p>
        </div>

        <!-- Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Vencimento</th>
                    <th>Nr Boleto</th>
                    <th>Valor</th>
                    <th>Estado</th>
                    <th >Ação</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($item->boletos as $boleto): ?>
                    <tr>
            <input type="hidden" id='<?php echo "bol_".$boleto->id_boleto?>'
                   value='<?php echo json_encode($boleto)?>'>
                        <td><?php echo $boleto->getVencimento() ?></td>
                        <td><?php echo $boleto->nr_boleto ?></td>
                        <td><?php echo $boleto->getValorBoleto(TRUE) ?></td>
                        <td class="<?php echo $boleto->getCssStatus() ?>">
                            <?php echo $boleto->getEstado() ?> 
                            <?php if ($boleto->estado == 1): ?>
                                <a href="<?php echo base_url('boleto/alterarEstado/').$boleto->id_boleto ?>" 
                                   class="alterarEstado" data-toggle="tooltip" title="Colocar Estado como Pago">
                                    <span class="glyphicon glyphicon-ok"></span> 
                                </a>
                                
                            <?php endif; ?>
                        </td>
                        <td>
                           
                            <a href="#" class="btn btn-default btn-xs editBoleto"
                               data-id_boleto="<?php echo $boleto->id_boleto?>">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                           
                            <a class="btn btn-danger btn-xs confirm_boleto text-danger"
                               href="<?php echo base_url('boleto/excluir') . '/' .$boleto->id_boleto?> ">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

    </div>

<?php //echo $items[$key-1]->cliente_nome?>
<?php echo (isset($items[$key+1]) && $item->cliente_nome!=$items[$key+1]->cliente_nome)?"<br><br>":""?>

<?php endforeach ?>





<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edição de Boleto</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('boleto/save') ?>" id="formBoleto">
                    <input type="hidden" name="id_boleto" value="" id="id_boleto">
                    <input type="hidden" name="scrollTop" id="scrollTop" value="<?php echo $this->session->flashdata('scrollTop')  ;?>">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="id_servico">Cód. Serviço</label>
                            <input type="text" class="form-control" name="id_servico" id="id_servico" placeholder="Cód Serviço">
                        </div>
                    </div>

                    <div class="row">

                        <div class="form-group col-md-3">
                            <label for="vencimento">Vencimento</label>
                            <input type="date" class="form-control" name="vencimento" id="vencimento" placeholder="Vencimento">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Nr Boleto</label>
                            <input type="text" class="form-control" name="nr_boleto" id="nr_boleto" placeholder="Nr Boleto">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Valor</label>
                            <input type="number" class="form-control" name="valor_boleto" id="valor_boleto" placeholder="Valor">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="estado">Estado</label>
                            <select class="form-control" name="estado" id="estado">
                                <option value="1">Não Pago</option>
                                <option value="2">Pago</option>
                            </select>
                        </div>

                    </div>





                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="submitBoleto">Salvar</button>
            </div>
        </div>
    </div>
</div>



<script>
    function resetFormBoleto(){
        $("#id_boleto").val('');
        $("#id_servico").val('');
        $("#vencimento").val('');
        $("#nr_boleto").val('');
        $("#valor_boleto").val('');
        $("#estado").val('');
    }
    
    function submitFormBoleto(){
        var errors= validar();
        if(errors.length===0){
            $("#scrollTop").val($(window).scrollTop());
            $("#formBoleto").submit();
        }
        else{
            alert(errors.join('\n'));
        }
        
    }
    
    function editFormBoleto(e){
        e.preventDefault();
        var elemento= e.currentTarget;
        var id= "#bol_"+elemento.dataset.id_boleto;
        var boleto=JSON.parse($(id).val());
        
        $("#id_boleto").val(boleto.id_boleto);
        $("#id_servico").val(boleto.id_servico);
        $("#vencimento").val(boleto.vencimento);
        $("#nr_boleto").val(boleto.nr_boleto);
        $("#valor_boleto").val(boleto.valor_boleto);
        $("#estado").val(boleto.estado);
        
        $('#myModal').modal({
            keyboard: false,
            backdrop:"static",
            show:true
        });
    }
    
    function addBolToServico(e){
        e.preventDefault();
        var elemento= e.currentTarget;
        var id_servico=elemento.dataset.id_servico;
        $("#id_servico").val(id_servico);
        $('#myModal').modal({
            keyboard: false,
            backdrop:"static",
            show:true
        });
    }
    
    function validar(){
        var errors= [];
        
        if(!$("#id_servico").val()){
            errors.push('Cód. Serviço Obrigatório');
        }
        if(!$("#vencimento").val()){
            errors.push('Vencimento Obrigatório');
        }
        if(!$("#nr_boleto").val()){
            errors.push('Nr Boleto Obrigatório');
        }
        if(!$("#valor_boleto").val()){
            errors.push('Valor Obrigatório');
        }
        if(!$("#estado").val()){
            errors.push('Estado Obrigatório');
        }
        
        return errors;
    }
    
    function submitAlterarEstado(e){
        e.preventDefault();
        var url = e.currentTarget.attributes['href'].value;
        $.ajax({
            type: "GET",
            dataType: "html",
            url: url,
            success: function ()
            {
                $("#scrollTop").val($(window).scrollTop());
                document.location.reload();

            }

        });//fechamento do ajax
        
    }
    
    function scrollPage(){
        var position= $("#scrollTop").val() | 0;
        $(window).scrollTop(position);
    }
    
    $("#submitBoleto").on("click",submitFormBoleto);
    $(".editBoleto").on("click",editFormBoleto);
    $(".alterarEstado").on("click",submitAlterarEstado);
    $('#myModal').on('hidden.bs.modal', resetFormBoleto);
    $(".addBolToServico").on("click",addBolToServico);
    
    //$(document).ready(scrollPage);
    scrollPage();
    
</script>




























































