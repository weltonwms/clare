$(document).ready(function() {

/***********************Acao para o Botao Voltar**************************************/
	$("#voltar").click(function(){
		history.back();
	});//fechamento do click do voltar.
/*************************************************************************************/

/*********************Mascaras para os campos ****************************************/
	$('#cpf').mask("000.000.000-00");
	

/*************************************************************************************/

/*****************Regras de validação*************************************************/
	$("#form_anotacao").validate({
		rules:{
			id_fornecedor:{required:true},
                        data:{required:true},
			descricao:{required:true}
			

		},
	
		messages:{
			id_fornecedor:{required:'Selecione o Fornecedor'},
			data:{required:'Digite a Data'},
                        descricao:{required:'Digite a Descrição'}
		}
	});//fechamento do validate
        
       
        
        
        
});//fechamento do document.ready
