$(document).ready(function () {


    $("body").on('click', '.detalhe_servico', function (e) {
        e.preventDefault();
        id_servico = ($(this).attr('data-id_servico'));
        $.ajax({
            type: "GET",
            dataType: "html",
            url: base_url + "servico/detalhar_servico_ajax/" + id_servico,
            success: function (data)
            {
                $('#conteudo_modal').html(data);
                $("#modal_detalhar_servico").modal('show');

            }

        });//fechamento do ajax

    });

    $("#tabela").on('ready', '.estado:contains("Orçamento")', function () {
        addClass('text-danger');


    });

    $("body").on('click', '.btn_imprimir', function (e) {
        var estado = $(this).attr('data-estado');
        var id_servico = $(this).attr('data-id_servico');
        if (estado == 1) {
            e.preventDefault();
            $("#form_imprimir_servico").attr("action", base_url + "servico/imprimir/" + id_servico);

            $("#modal_imprimir_servico").modal('show');
        }

    });

    $("#form_imprimir_servico").submit(function (event) {
        //alert( "Handler for .submit() called." );
        //event.preventDefault();
        $("#modal_imprimir_servico").modal('hide');
    });

    $("#tabela_ajax_servico").on('click', '.confirm', function () {
        alert("confirm");
    });




});

function gatilhoTabela() {
    $('.estado:contains("Orçamento")').addClass('text-danger');
    $('.estado:contains("Executado")').addClass('text-success');
     $(".confirm_servico").confirm({
                text : "Deseja realmente excluir este Serviço?",
		title : "  Exclusão de Serviço",
		confirmButton : " Excluir",
		cancelButton : " Cancelar"
        });
    $(".confirm_executar_servico").confirm({
		text : "Avançar o Estado deste Serviço?",
		title : " Mudar Estado do Serviço",
		confirmButton : " Confirma",
                classIconConfirmButton : "glyphicon glyphicon-ok",
                classConfirmButton : "btn btn-primary",
		cancelButton : " Cancelar"
	});
}
