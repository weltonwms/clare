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
        
        
        
        
         $(".confirm_anotacao").confirm({
                text : "Deseja realmente excluir esta Anotação?",
		title : "  Exclusão de Anotação",
		confirmButton : " Excluir",
		cancelButton : " Cancelar"
        });
        
        
         $(".confirm_item_servico").confirm({
		text : "Deseja realmente excluir este Item de Serviço?",
		title : "  Exclusão de Item de Serviço",
		confirmButton : " Excluir",
		cancelButton : " Cancelar"
	});
        
        $(".confirm_boleto").confirm({
		text : "Deseja realmente excluir este Boleto?",
		title : "  Exclusão de Boleto",
		confirmButton : " Excluir",
		cancelButton : " Cancelar"
	});
        
        
       
});
