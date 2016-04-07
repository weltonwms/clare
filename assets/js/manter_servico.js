$(document).ready(function () {


    $("#tabela").on('click', '.detalhe_servico', function () {
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

    $("#tabela").on('click', '.btn_imprimir', function (e) {
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




});