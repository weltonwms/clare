$(document).ready(function() {
 $('.meu_chosen').chosen();
 
 /***********************Acao para o Botao Voltar**************************************/
	$("#voltar").click(function(){
		history.back();
	});//fechamento do click do voltar.
/*************************************************************************************/

/*********************Mascaras para os campos ****************************************/
	$('.data').mask("00/00/0000");
	//$('.money').mask('000.000.000.000.000,000', {reverse: true});

/*************************************************************************************/
        $.validator.setDefaults({ ignore: ":hidden:not(select)" }) ;
        $("#form_servico").validate({
		rules:{
			id_cliente:{required:true},
                        //id_produto:{required:true},
                        data: {required:true},
                        valor_final: {required:true},
                        estado: {required:true}
                        //qtd_produto: {required:true}
                        
			
		},
	
		messages:{
			id_cliente:{required:'Selecione o Cliente'},
                       	id_produto:{required:'Selecione o Produto'},
                        data:{required:'Digite a Data'},
			valor_final:{required:'Digite o valor Final'},
                        estado:{required:'Selecione o Estado'}
                        //qtd_produto:{required:'Digite Qtd do Produto'}
		}
	});//fechamento do validate
        
        $("#id_produto").change(function() {
        valor_fornecedor =$('#id_produto option:selected').attr('data-forn');
        valor=valor_fornecedor.replace('.',',');
        $('#valor_fornecedor').val(valor);

       
    });
    
    $("#valor_total").blur(function(){
        var valor= $(this).val().replace(',','.');
        var qtd= $("#qtd_produto").val().replace(',','.');
        if(!qtd || qtd==0){
            alert('resultado invalido');
        }
        else{
            var resultado=valor/qtd;
            resultado= resultado.toString();
            $('#valor_final').val(resultado.replace('.',','));
        }
        
        
    });

 $('.estado:contains("Orçamento")').addClass('text-danger');
include_once(base_url + "assets/js/datepicker.js");


});//fechamento do ready



