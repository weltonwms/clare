
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

    $('body').on('change', 'select[name=operacao]', function (event) {
        if (this.value == '2') {
            $("select[name=id_fornecedor]").show();
        } else {
            $("select[name=id_fornecedor]").hide();
        }
    });

    /************************************************************************
     * Eventos utilizados para Edit in Line na Tabela de Pagamentos
     * **********************************************************************
     */
    $('body').on('dblclick', '.pg_tabela td', function () {
        var coluna = $(this).index();
        oriVal = $(this).text();
        id_pagamento = $(this).parent().children().eq(0).text();
        switch (coluna) {
            case 1:
                $(this).text("");
                var input = $('#form_pagamento input[name=data]').clone();
                $(input).appendTo(this).focus();
                $(this).find('input').val(oriVal);
                $('.pg_tabela .data').mask("00/00/0000");
                break;
            case 2:
                $(this).text("");
                var input = $('#form_pagamento input[name=valor_pago]').clone();
                $(input).appendTo(this).focus();
                $(this).find('input').val(oriVal);
                $('.pg_tabela .pg_money').mask('000.000.000.000.000,00', {reverse: true});
                break;
            case 3:
                $(this).text("");
                var select = $('#form_pagamento select').parent().clone();
                select.find('select').children().eq(0).remove();
                var id = $('#form_pagamento option:contains("' + oriVal + '")').val();
                $(select.html()).appendTo(this).focus();
                $(this).find('select').val(id);
                break;
        }


    });


    $(".pg_tabela").on('focusout', 'select, input', function () {
        var $this = $(this);
        $this.parent().text(oriVal);
        $this.remove(); // Don't just hide, remove the element.
    });

    $(".pg_tabela").on('change', 'select, input', function (event) {

        var dados = {};
        dados[$(this).attr('name')] = $(this).val();
        dados['id_pagamento'] = id_pagamento;
        var id_servico = $('#pg_id_servico').text();
        dados['id_servico'] = id_servico;

        editar_pagamento(id_servico, dados);


    });

    /*****************************************************************************
     *  Fim dos Eventos de Edição IN line
     ******************************************************************************
     */
    function editar_pagamento(id_servico, dados) {
        $.ajax({
            type: "POST",
            url: base_url + "pagamento/editar_pagamento/",
            data: dados,
            success: function (data)
            {
                console.log(data);
                $('#msg_pag').html('');
                load_dados(id_servico);
            },
            statusCode: {
                400: function (data) {
                    escreve_msg(data.responseText, 'danger');
                }
            },
            error: function () {
                escreve_msg('Ocorreu um erro no Servidor', 'danger')
            },
            beforeSend: function () {
                $("table").append("<p class='pg_loading'>Carregando</p>");
            },
            complete: function () {
                $('.pg_loading').remove();
            }

        });
    }





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
                    escreve_msg(data.responseText, 'danger');
                }
            },
            error: function () {
                escreve_msg('Ocorreu um erro no Servidor', 'danger')
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
                $('#pg_total_fornecedor').text(data.total_fornecedor);
                $('.total_pago_credito').text(data.total_pago_credito);
                $('.total_restante_credito').text(data.total_restante_credito);
                $('.total_pago_debito').text(data.total_pago_debito);
                $('.total_restante_debito').text(data.total_restante_debito);
                carrega_tabela_credito(data.pagamentos_credito);
                carrega_tabela_debito(data.pagamentos_debito);
                carrega_fornecedores(data.fornecedores);

            },
            error: function () {
                escreve_msg('Ocorreu um erro no Servidor', 'danger')
            }
        });



    }

    function carrega_fornecedores(fornecedores) {
        var string = "<option value=''>Fornecedores</option>";
        $.each(fornecedores, function (key, forn) {
            string += '<option value="' + key + '" >' + forn + '</option>';
        });
        $("select[name='id_fornecedor']").html(string);
    }

    function carrega_tabela_credito(pagamentos) {
        var string = '';
        $.each(pagamentos, function (key, pag) {
            string += '<tr>' +
                    '<td>' + pag.id_pagamento + '</td>' +
                    '<td>' + pag.data + '</td>' +
                    '<td>' + pag.valor_pago + '</td>' +
                    '<td>' + pag.tipo_pagamento + '</td>' +
                    '<td><a href="#" ' + 'data-id_pagamento="' + pag.id_pagamento + ' " ' +
                    'class="text-danger exclusao_pagamento"><span class="glyphicon glyphicon-trash"></span></a> </td>' +
                    '</tr>';

        });

        $("#pg_tabela_credito tbody").html(string);
        $('#pg_tabela_credito tr').find('td:eq(0),th:eq(0)').hide();
    }

    function carrega_tabela_debito(pagamentos) {
        var string = '';
        $.each(pagamentos, function (key, pag) {
            string += '<tr>' +
                    '<td>' + pag.id_pagamento + '</td>' +
                    '<td>' + pag.data + '</td>' +
                    '<td>' + pag.valor_pago + '</td>' +
                    '<td>' + pag.tipo_pagamento + '</td>' +
                    '<td>' + pag.nome_fornecedor + '</td>' +
                    '<td><a href="#" ' + 'data-id_pagamento="' + pag.id_pagamento + ' " ' +
                    'class="text-danger exclusao_pagamento"><span class="glyphicon glyphicon-trash"></span></a> </td>' +
                    '</tr>';

        });

        $("#pg_tabela_debito tbody").html(string);
        $('#pg_tabela_debito tr').find('td:eq(0),th:eq(0)').hide();
    }

    function limpa_form() {
        $('#msg_pag').html('');
        $("#pg_data").val(getDateNow());
        $("input[name=valor_pago]").val('');
        $("select[name=tipo_pagamento]").val('');
        $("select[name=operacao]").val('');
        $("select[name=id_fornecedor]").val('');
        $("select[name=id_fornecedor]").hide();
    }

    function escreve_msg(msg, tipo) {
        var string = '<div  class="alert alert-' + tipo + ' alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '<div id="msg_pag_body">' + msg + '</div>' +
                '</div>';

        $('#msg_pag').html(string);
    }


    $('.pop-deb').popover({
        "placement": "bottom",
        "html": true,
        "trigger": 'hover',
        "content": function () {
            var div_id = "tmp-id-" + $.now();
            return details_in_popup(div_id);
        }
    });

    function details_in_popup(div_id) {
       var id_servico = $('#pg_id_servico').text();
        $.ajax({
            url: base_url + "servico/get_lista_fornecedores_a_pagar/" + id_servico,
            dataType: 'json',
            success: function (response) {
                var string = '<table class="table table-condensed table-bordered">' +
                        '<tr>' +
                        '<th>Fornecedor</th>' +
                        '<th>A Pagar</th>' +
                        '<tr>';

                $.each(response, function (key, f) {
                    string += '<tr>' +
                            '<td>' + f.nome_fornecedor + '</td>' +
                            '<td>' + f.a_pagar + '</td>' +
                            '</tr>';

                });
                string += '</table>';
                $('#' + div_id).html(string);
            }
        });
        return '<div id="' + div_id + '">Carregando...</div>';
    }




}); //fim ready


