$(document).ready(function() {
 $('.meu_chosen').chosen();
 
 /***********************Acao para o Botao Voltar**************************************/
	$("#voltar").click(function(){
		history.back();
	});//fechamento do click do voltar.
/*************************************************************************************/

/*********************Mascaras para os campos ****************************************/
	$('.data').mask("00/00/0000");
	$('.money').mask('000.000.000.000.000,00', {reverse: true});
        $('.money2').mask('000.000.000.000.000,000', {reverse: true});

/*************************************************************************************/
        $.validator.setDefaults({ ignore: ":hidden:not(select)" }) ;
        $("#form_produto").validate({
		rules:{
			nome:{required:true},
                        valor:{required:true},
                        id_fornecedor: {required:true}
                        
			
		},
	
		messages:{
			nome:{required:'Digite o Nome do Produto'},
                       	valor:{required:'Digite o valor'},
                        id_fornecedor:{required:'Selecione o Fornecedor'}
			
		}
	});//fechamento do validate









});//fechamento do ready