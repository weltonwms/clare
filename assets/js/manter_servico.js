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



    $("body").on('click', '.confirm_executar_servico', function (e) {
        e.preventDefault();
        var url = e.currentTarget.attributes['href'].value;
        $.confirm({
         title: "Avanço de Estado do Serviço",
        text: "Deseja Realmente Avançar o estado do Serviço?",
         confirmButton: "Avançar",
        cancelButton: " Cancelar",
         confirm: function () {
             
             $.ajax({
                type: "GET",
                dataType: "html",
                url: url,
                success: function ()
                {
                    
                    table_ajax.ajax.reload(null, false);

                }

            });//fechamento do ajax
        },
        cancel: function () {
            // nothing to do
        }
    });


    });


}); //fim ready






$("body").on('click', '.btn_imprimir', function (e) {
    var estado = $(this).attr('data-estado');
    var id_servico = $(this).attr('data-id_servico');
    if (estado == 1) {
        e.preventDefault();
        $("#form_imprimir_servico").attr("action", base_url + "servico/imprimir/" + id_servico);
        $("#modal_imprimir_servico").modal('show');
    }
});


$('body').on('submit',"#form_imprimir_servico",function (event) {
    //alert( "Handler for .submit() called." );
    //event.preventDefault();
    $("#modal_imprimir_servico").modal('hide');
});




function gatilhoTabela() {
    $('.estado:contains("Orçamento")').addClass('text-danger');
    $('.estado:contains("Executado")').addClass('text-success');

    $(".confirm_servico").confirm({
        text: "Deseja realmente excluir este Serviço?",
        title: "  Exclusão de Serviço",
        confirmButton: "<span class='glyphicon glyphicon-trash'></span> Excluir",
        cancelButton: " Cancelar",
        "confirmButtonClass": "btn btn-danger",
        confirm: function (o) {
            var url = o.context.href; //descobri o href dentro do context inspencionando.
            $.ajax({
                type: "GET",
                dataType: "html",
                url: url,
                success: function ()
                {
                    table_ajax.ajax.reload(null, false);

                }

            });//fechamento do ajax

        }
    });



} //fim do gatilho
