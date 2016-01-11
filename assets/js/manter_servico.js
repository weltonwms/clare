$(document).ready(function() {
   
         



    $("#tabela").on('click', '.detalhe_servico', function() {
        id_servico = ($(this).attr('data-id_servico'));
        $.ajax({
            type: "GET",
            dataType: "html",
            url: base_url + "servico/detalhar_servico_ajax/" + id_servico,
            success: function(data)
            {
                $('#conteudo_modal').html(data);
                $("#modal_detalhar_servico").modal('show');

            }

        });//fechamento do ajax

    });
    
     $("#tabela").on('ready', '.estado:contains("Orçamento")', function() {
        addClass('text-danger');
        

    });




});