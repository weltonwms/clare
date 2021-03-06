$(document).ready(function() {

/***********************Acao para o Botao Voltar**************************************/
	$("#voltar").click(function(){
		history.back();
	});//fechamento do click do voltar.
/*************************************************************************************/

/*********************Mascaras para os campos ****************************************/
	$('#cpf').mask("000.000.000-00");
	$('.telefone').mask(maskBehavior, {onKeyPress:
               function(val, e, field, options) {
               field.mask(maskBehavior(val, e, field, options), options);
                        }
         });

/*************************************************************************************/

/*****************Regras de validação*************************************************/
	$("#form_fornecedor").validate({
		rules:{
			empresa:{required:true},
                        responsavel:{required:true},
			fone:{required:true}
			

		},
	
		messages:{
			empresa:{required:'Digite o Nome da Empresa'},
			responsavel:{required:'Digite o Responsavel'},
                        fone:{required:'Digite o Telefone'}
		}
	});//fechamento do validate
        
       
        
        
        
});//fechamento do document.ready

var masks = ['(00) 00000-0000', '(00) 0000-00009'],
        maskBehavior = function(val, e, field, options) {
    return val.length > 14 ? masks[0] : masks[1];
};
