
    
    

 $(".detalhe_cliente").click(function() {
        id_cliente = ($(this).attr('data-id_cliente'));
        $.ajax({
            type: "GET",
            dataType: "html",
            url: base_url + "cliente/detalhar_cliente_ajax/" + id_cliente,
            success: function(data)
            {
                $('#conteudo_modal').html(data);
                $("#modal_detalhar_cliente").modal('show');

            }

        });//fechamento do ajax

    });
    




