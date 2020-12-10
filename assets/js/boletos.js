    $(".addBolToServico").on("click", function (e) {
        $(".blocoAdd").show("slow");
    });

    $("#submitBoleto").on("click", function (e) {
        BoletoModel.submitItem();
    });

    $("#fbp_btnConfirm").on("click", function (e) {
        BoletoModel.submitItems();
    });

    $("#btnGeracaoBoletos").on("click", function (e) {
        var el = e.currentTarget;
        var id_servico = el.dataset.id_servico;
        var total_venda = Number.parseFloat(el.dataset.total_venda);
        $("#fbp_total").val(total_venda.toFixed(2));
        BoletoModel.inicializar(id_servico, total_venda);
        $('#modalBoletos').modal('show');
    });

    $('body').on('dblclick', '#bodyBoletos td', function (e) {
        EditInLine.start(e);
    });
    $("#bodyBoletos").on('focusout', 'select, input', function (e) {
        EditInLine.cancelEdit(e);
    });
    $("#bodyBoletos").on('change', 'select, input', function (e) {
        EditInLine.change(e);
    });
    
    $('body').on('click', '.exclusao_boleto', function (e) {
        e.preventDefault();
          EditInLine.deletar(e);
    });

    var BoletoModel = (function () {
        var items = [];
        var inicializado = false;
        var id_servico;
        var total_venda;

        function addItem(item) {
            items.push(item);
        }

        function addItems(lista) {
            lista.forEach(function (item) {
                addItem(item);
            });
        }

        function inicializar(id_svc, tot_venda) {
            if (!inicializado) {
                id_servico = id_svc;
                total_venda = tot_venda;
                executarInicializacao();
                inicializado = true;
            }
        }

        function executarInicializacao() {
            getBoletos(id_servico, function (resposta) {
                items = resposta;
                updateTable();
            });

        }

        function forceUpdateTable() {
            executarInicializacao();
            updateTable();
        }

        function updateTable() {
            var boletosMap = items.map(function (obj) {
                return '<tr>' +
                        '<td style="display:none">' + obj.id_boleto + '</td>' +
                        '<td>' + obj.vencimento + '</td>' +
                        '<td>' + obj.nr_boleto + '</td>' +
                        '<td>' + obj.valor_boleto + '</td>' +
                        '<td>' + obj.estado + '</td>' +
                        '<td><a href="#"  ' +
                    'class="text-danger exclusao_boleto"><span class="glyphicon glyphicon-trash"></span></a> </td>' +
                        '</tr>';
            });
            $("#bodyBoletos").html(boletosMap);
        }


        function submitItem() {
            var vencimento = $("#vencimento").val();
            var nr_boleto = $("#nr_boleto").val();
            var valor_boleto = $("#valor_boleto").val();
            var estado = $("#estado_boleto").val();

            if (!vencimento || !valor_boleto) {
                alert("Dados Inválidos")
                return false;
            }

            var obj = {id_servico: id_servico, estado: estado,
                valor_boleto: valor_boleto, nr_boleto: nr_boleto,
                vencimento: vencimento};

            $.ajax({
                type: "post",

                url: base_url + "boleto/createAjax",
                data: obj,
                beforeSend: function () {
                    $("#submitBoleto").attr('disabled', 'disabled');
                },
                success: function (resposta) {
                    BoletoModel.forceUpdateTable();
//                    BoletoModel.addItem(JSON.parse(resposta));
//                    BoletoModel.updateTable();
                    resetAddItem();
                    $(".blocoAdd").hide("slow");
                },
                complete: function () {
                    $("#submitBoleto").removeAttr('disabled');
                }
            });
        }


        function submitItems() {
            var parcelas = $("#fbp_parcelas").val();
            var data_inicial = $("#fbp_dataInicial").val();
            var total = $("#fbp_total").val();
            //alert('submit items')

            if (!parcelas || !data_inicial || !total) {
                alert("dados Inválidos");
                return false;
            }

            var obj = {id_servico: id_servico,
                parcelas: parcelas, data_inicial: data_inicial,
                total: total};

            $.ajax({
                type: "post",

                url: base_url + "boleto/createBath",
                data: obj,
                beforeSend: function () {
                    $("#fbp_btnConfirm").attr('disabled', 'disabled');
                },
                success: function (resposta) {
                    BoletoModel.forceUpdateTable();
//                    BoletoModel.addItems(JSON.parse(resposta));
//                    BoletoModel.updateTable();
//                    console.log(resposta)
                },
                complete: function () {
                    $("#fbp_btnConfirm").removeAttr('disabled');
                }
            });
        }

        return{
            updateTable: updateTable,
            forceUpdateTable: forceUpdateTable,
            inicializar: inicializar,
            addItem: addItem,
            addItems: addItems,
            submitItem: submitItem,
            submitItems: submitItems
        };
    })();

    var EditInLine = (function () {
        var coluna;
        var oriVal;
        var id_boleto;

        function start(e) {
            var el = e.currentTarget;
            coluna = $(el).index();
            oriVal = $(el).text();
            id_boleto = $(el).parent().children().eq(0).text();

            switch (coluna) {
                case 1:
                    appendVencimento(el);
                    break;
                case 2:
                    appendNrBoleto(el);
                    break;
                case 3:
                    appendValor(el);
                    break;
            }

        }

        function cancelEdit(e) {
            var el = e.currentTarget;
            $(el).parent().text(oriVal);
            $(el).remove();
            coluna = null;
            oriVal = null;
            id_boleto = null;
            
        }

        function change(e) {
            var dados = {};
            var el = e.currentTarget;
            var atributo = el.name;
           
            dados[atributo] = $(el).val();
            dados['id_boleto'] = id_boleto;

            editarBoleto(dados);
        }
        
        function deletar(e){
            var el = e.currentTarget;
            id_boleto = $(el).parent().parent().children().eq(0).text(); //procura ref. tag <a>
            excluirBoleto(id_boleto);
            
        }

        function appendNrBoleto(el) {
            $(el).text("");
            var input = '<input type="text" name="nr_boleto" class="form-control" placeholder="Nr Boleto">';
            $(input).appendTo(el).focus();
            $(el).find('input').val(oriVal);
        }
        
        function appendVencimento(el){
             $(el).text("");
            var input = '<input type="date" name="vencimento" class="form-control" placeholder="Vencimento">';
            $(input).appendTo(el).focus();
            var dateUs= dateBrToUsd(oriVal);
            $(el).find('input').val(dateUs);
        }
        
        function appendValor(el){
             $(el).text("");
            var input = '<input type="number" name="valor_boleto" class="form-control" placeholder="Valor">';
            $(input).appendTo(el).focus();
            var nrUs=numberBrToUsd(oriVal)
            $(el).find('input').val(nrUs);
        }

        function editarBoleto(dados) {

            $.ajax({
                type: "POST",
                url: base_url + "boleto/editAjax/",
                data: dados,
                success: function (data)
                {
                   // console.log(data);
                    BoletoModel.forceUpdateTable();

                },
                statusCode: {
                    400: function (data) {
                        console.log('error', data);
                    }
                },
                error: function () {
                    console.log('Ocorreu erro');
                },
                beforeSend: function () {
                    $(".tabelaBoletos").append("<p class='bol_loading'>Carregando</p>");
                },
                complete: function () {
                    $('.bol_loading').remove();
                }

            });

        }
        
        function excluirBoleto(id_boleto) {

            $.ajax({
                type: "DELETE",
                url: base_url + "boleto/excluirAjax/"+id_boleto,
                //data: dados,
                success: function (data)
                {
                    //console.log(data);
                    BoletoModel.forceUpdateTable();

                },
                statusCode: {
                    400: function (data) {
                        console.log('error', data);
                    }
                },
                error: function () {
                    console.log('Ocorreu erro');
                },
                beforeSend: function () {
                    $(".tabelaBoletos").append("<p class='bol_loading'>Carregando</p>");
                },
                complete: function () {
                    $('.bol_loading').remove();
                }

            });

        }
        
        
        return{
            start: start,
            cancelEdit: cancelEdit,
            change: change,
            deletar:deletar
        };
    })();

    function resetAddItem() {
        $("#vencimento").val('');
        $("#nr_boleto").val('');
        $("#valor_boleto").val('');
        $("#estado_boleto").val('1');
    }



    function getBoletos(id_servico, callback) {
        if (!id_servico) {
            return false;
        }
        $.ajax({
            type: "get",
            dataType: "json",
            url: base_url + "boleto/getBoletosAjax/" + id_servico,

            success: callback
        });

    }
    
    function dateBrToUsd(dateBr){
        var dtArray=dateBr.split('/');
        return dtArray[2]+"-"+dtArray[1]+"-"+dtArray[0];
    }
    
    function numberBrToUsd(numberBr){
        //return String
        return Number.parseFloat(numberBr.replace('.','').replace(',','.')).toFixed(2);
    }





