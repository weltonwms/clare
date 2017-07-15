$(document).ready(function () {
    $('.meu_chosen').chosen();

    /***********************Acao para o Botao Voltar**************************************/
    $("#voltar").click(function () {
        history.back();
    });//fechamento do click do voltar.
    /*************************************************************************************/

    /*********************Mascaras para os campos ****************************************/
    $('.data').mask("00/00/0000");
    //$('.money').mask('000.000.000.000.000,000', {reverse: true});

    /*************************************************************************************/
    $.validator.setDefaults({ignore: ":hidden:not(select)"});
    $("#form_servico").validate({
        rules: {
            id_cliente: {required: true},
            //id_produto:{required:true},
            estado: {required: true},
            qtd_produto: {required: true},
            data: {required: true},
            total_venda: {required: true},
            total_fornecedor: {required: true}



        },
        messages: {
            id_cliente: {required: 'Selecione o Cliente'},
            id_produto: {required: 'Selecione o Produto'},
            data: {required: 'Digite a Data'},
            estado: {required: 'Selecione o Estado'},
            qtd_produto: {required: 'Digite Qtd do Produto'},
            total_venda: {required: 'Digite o total da Venda'},
            total_fornecedor: {required: 'Digite o total do Fornecedor'}
        }
    });//fechamento do validate
    
   
    $("#tipo").change(function () {
       var tipo=$(this).val();
       //alert(tipo);
       if(tipo==2){
           $(".bloco_porcentagem").show('slow');
          
       }
       else{
           $(".bloco_porcentagem").hide('slow');
         
       }
       
    });
     $("#tipo").trigger('change');

    $("#id_produto").change(function () {
        valor_fornecedor = $('#id_produto option:selected').attr('data-forn');
        valor = valor_fornecedor.replace('.', ',');
        $('#valor_unitario_fornecedor').val(valor);
        
        var valor_unitario_fornecedor = parseFloat(valor_fornecedor);
        var qtd = ler_valor("#qtd_produto");
        if(qtd && valor_unitario_fornecedor){
            var total_fornecedor = valor_unitario_fornecedor * qtd;
            escrever_valor(total_fornecedor, '#total_fornecedor');
        }
       
    });


    $("#qtd_produto").blur(function () {
        
        var qtd = ler_valor(this);
        var valor_unitario_fornecedor = ler_valor('#valor_unitario_fornecedor');
        var total_fornecedor = ler_valor('#total_fornecedor');
        var valor_unitario_venda = ler_valor('#valor_unitario_venda');
        var total_venda = ler_valor('#total_venda');
        
        if (qtd) {
           if(valor_unitario_venda){
                    total_venda = valor_unitario_venda * qtd;
                    escrever_valor(total_venda, '#total_venda');
                }
                
           if(valor_unitario_fornecedor){
               
                total_fornecedor = valor_unitario_fornecedor * qtd;
                escrever_valor(total_fornecedor, '#total_fornecedor');
           }
           
//           if (total_fornecedor) {
//                valor_unitario_fornecedor = total_fornecedor * qtd;
//                escrever_valor(valor_unitario_fornecedor, '#valor_unitario_fornecedor');
//            }
        }
        
        
   
        
  
     
    }); //fim blur qtd

    $("#valor_unitario_fornecedor").blur(function () {
        var valor_unitario_fornecedor = ler_valor(this);
        var qtd = ler_valor("#qtd_produto");
        if(qtd && valor_unitario_fornecedor){
            var total_fornecedor = valor_unitario_fornecedor * qtd;
            escrever_valor(total_fornecedor, '#total_fornecedor');
        }

    });
    
    $("#total_fornecedor").blur(function () {
        var total_fornecedor = ler_valor(this);
        var qtd = ler_valor("#qtd_produto");
        if (total_fornecedor && qtd) {
            var valor_unitario_fornecedor = total_fornecedor / qtd;
            escrever_valor(valor_unitario_fornecedor, '#valor_unitario_fornecedor');
        }
    });

    $("#valor_unitario_venda").blur(function () {
        var valor_unitario_venda = ler_valor(this);
        var qtd = ler_valor("#qtd_produto");
        if(qtd && valor_unitario_venda){
            var total_venda = valor_unitario_venda * qtd;
            escrever_valor(total_venda, '#total_venda');
        }
    });

    $("#total_venda").blur(function () {
        var total_venda = ler_valor(this);
        var qtd = ler_valor("#qtd_produto");
        if (total_venda && qtd) {
            var valor_unitario_venda = total_venda / qtd;
            escrever_valor(valor_unitario_venda, '#valor_unitario_venda');
        }
    });

    $('.estado:contains("Orçamento")').addClass('text-danger');
    include_once(base_url + "assets/js/datepicker.js");


});//fechamento do ready

function escrever_valor(valor, campo, naoFixar) {
    if (!naoFixar) {
        var num_dec=retr_dec(valor); //numero de decimais
        if(num_dec <2){
            valor = valor.toFixed(2);
        }
    }
    var valor_formatado = valor.toString().replace('.', ',');
    $(campo).val(valor_formatado);
}

function ler_valor(campo) {
    var valor = $(campo).val().replace('.', '').replace(',', '.');
    //alert(valor);
    return parseFloat(valor);
}

function retr_dec(num) {
   var numero= num.toString();
  return (numero.split('.')[1] || []).length;
}



