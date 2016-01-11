$(document).ready(function() {

/***********************Acao para o Botao Voltar**************************************/
	$("#voltar").click(function(){
		history.back();
	});//fechamento do click do voltar.
/*************************************************************************************/

/*********************Mascaras para os campos ****************************************/
	$('#cpf').mask("000.000.000-00");
	$('.telefone').mask("(00) 0000-0000");

/*************************************************************************************/

/*****************Regras de validação*************************************************/
	$("#form_cliente").validate({
		rules:{
			nome:{required:true},
			endereco:{required:true},
			telefone:{required:true}
                        
			

		},
	
		messages:{
			nome:{required:'Digite o Nome'},
			endereco:{required:'Digite o Endereço'},
			telefone:{required:'Digite o Telefone'}
                        
		}
	});//fechamento do validate
        
       
        
        
        
});//fechamento do document.ready
