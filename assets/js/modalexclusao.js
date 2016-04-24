$(document).ready(function() {

	$(".confirm").confirm({
		text : "Deseja realmente excluir este Cliente?",
		title : "  Exclusão de Cliente",
		confirmButton : " Excluir",
		cancelButton : " Cancelar"
	});
        
       
        
        $(".confirm_fornecedor").confirm({
		text : "Deseja realmente excluir este Fornecedor?",
		title : "  Exclusão de Fornecedor",
		confirmButton : " Excluir",
		cancelButton : " Cancelar"
	});
        
        $(".confirm_produto").confirm({
		text : "Deseja realmente excluir este Produto?",
		title : "  Exclusão de Produto",
		confirmButton : " Excluir",
		cancelButton : " Cancelar"
	});
        
        
        $(".confirm_servico").confirm({
                text : "Deseja realmente excluir este Serviço?",
		title : "  Exclusão de Serviço",
		confirmButton : " Excluir",
		cancelButton : " Cancelar"
        });
        
        
         $(".confirm_item_servico").confirm({
		text : "Deseja realmente excluir este Item de Serviço?",
		title : "  Exclusão de Item de Serviço",
		confirmButton : " Excluir",
		cancelButton : " Cancelar"
	});
        
         $(".confirm_executar_servico").confirm({
		text : "Colocar este Serviço como Executado?",
		title : " Mudar Estado do Serviço",
		confirmButton : " Confirma",
                classIconConfirmButton : "glyphicon glyphicon-ok",
                classConfirmButton : "btn btn-primary",
		cancelButton : " Cancelar"
	});
        
       
});
