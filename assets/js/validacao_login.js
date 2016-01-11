$(document).ready(function() {
	$("#form_login").validate({
		rules:{
			usuario:{required:true, minlength:4},
			senha:{required:true, minlength:4},
                        senha_antiga:{required:true, minlength:4},
                        senha_nova:{required:true, minlength:4},
                        senha_confirmacao:{required:true, minlength:4}
		},
	
		messages:{
			usuario:{required:'Campo Usuario Obrigatório',minlength: "Nome curto demais"},
			senha:{required:'Campo Senha Obrigatório',minlength: "Digite senha maior que 3 digitos"},
                        senha_antiga:{required:'Digite a Senha Atual',minlength: "Digite senha maior que 3 digitos"},
			senha_nova:{required:'Digite a Senha Nova',minlength: "Digite senha maior que 3 digitos"},
                        senha_confirmacao:{required:'Digite Confirmação de Senha',minlength: "Digite senha maior que 3 digitos"}
		}
	});//fechamento do validate
});//fechamento do document.ready
