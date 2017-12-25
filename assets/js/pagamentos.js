
$(document).ready(function () {
    include_once(base_url + "assets/js/datepicker.js");
    $('.data').mask("00/00/0000");
    $('.pg_money').mask('000.000.000.000.000,00', {reverse: true});

    function getDateNow() {
        var d = new Date();
        var strDate = d.getDate() + "/" + (d.getMonth() + 1) + "/" + d.getFullYear();
        return strDate;
    }

    $('#myModal').on('shown.bs.modal', function (event) {
        var elementoClicado = event.relatedTarget;
        var id_servico = elementoClicado.dataset.id_servico;
        limpa_form();
        load_dados(id_servico);


    });

    $("#form_pagamento").submit(function (event) {
        event.preventDefault();
        var dados = $(this).serialize();
        var id_servico = $('#pg_id_servico').text();
        cadastrar_pagamento(id_servico, dados);

    });


    $('body').on('click', '.exclusao_pagamento', function (event) {
        event.preventDefault();
        var id_pagamento = this.dataset.id_pagamento;
        var id_servico = $('#pg_id_servico').text();
        excluir_pagamento(id_pagamento, id_servico);


    });


    function cadastrar_pagamento(id_servico, dados) {
        $.ajax({
            type: "POST",
            url: base_url + "pagamento/cadastrar_pagamento/" + id_servico,
            data: dados,
            success: function (data)
            {
                limpa_form();
                load_dados(id_servico);
            },
            statusCode: {
                400: function (data) {
                    escreve_msg(data.responseText,'danger');
                }
            },
            error:function(){
                escreve_msg('Ocorreu um erro no Servidor','danger')
            }
         
        });
    }

    function excluir_pagamento(id_pagamento, id_servico) {
        $.ajax({
            method: "GET",
            url: base_url + "pagamento/excluir_pagamento/" + id_pagamento,
            success: function (data) {
                load_dados(id_servico);
            }
        });
    }

    function load_dados(id_servico) {
        $.ajax({
            method: "GET",
            url: base_url + "servico/x3/" + id_servico,
            dataType: "json",
            success: function (data) {
                //console.log(data);
                $('#pg_id_servico').text(data.id_servico);
                $('#pg_nome_cliente').text(data.cliente_nome);
                $('#pg_total_venda').text(data.total_venda);
                $('.total_pago').text(data.total_pago);
                $('.total_restante').text(data.total_restante);
                carrega_tabela(data.pagamentos);
            },
            error:function(){
                escreve_msg('Ocorreu um erro no Servidor','danger')
            }
        });



    }

    function carrega_tabela(pagamentos) {
        var string = '';
        $.each(pagamentos, function (key, pag) {
            string += '<tr>' +
                    '<td>' + pag.data + '</td>' +
                    '<td>' + pag.valor_pago + '</td>' +
                    '<td>' + pag.tipo_pagamento + '</td>' +
                    '<td><a href="#" ' + 'data-id_pagamento="' + pag.id_pagamento + ' " ' +
                    'class="text-danger exclusao_pagamento"><span class="glyphicon glyphicon-trash"></span></a> </td>' +
                    '</tr>';

        });
        $("#pg_tabela tbody").html(string);

    }

    function limpa_form() {
         $('#msg_pag').html('');
        $("#pg_data").val(getDateNow());
        $("input[name=valor_pago]").val('');
        $("select[name=tipo_pagamento]").val('');
    }
    
    function escreve_msg(msg,tipo){
        var string='<div  class="alert alert-'+tipo+' alert-dismissible" role="alert">'+
          '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
           '<span aria-hidden="true">&times;</span>'+
           '</button>'+
           '<div id="msg_pag_body">'+msg+'</div>'+
           '</div>';
        
        $('#msg_pag').html(string);
    }




}); //fim ready


