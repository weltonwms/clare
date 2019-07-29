$(document).ready(function () {
    
     tabela_cliente=$('#tabela_cliente').DataTable({
        dom: "<'row'<'col-sm-6'f><'col-sm-6'l>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        iDisplayLength: 25,
        serverSide: true,
        ajax: base_url + "servico/getDataTables",
        columns: [
            {data: "id_servico", name:"id_servico"},
            {data: "cliente", name:"cliente"},
            {data: "dt", name:"data"},
            {data: "estado", name:"estado"},
            {data: "tipo", name:"tipo"},
            {data: "vendedor", name:"vendedor"},
            {data: "acoes"}
        ],
        "order": [0, 'desc'],
        drawCallback: gatilhoTabela,
        "bStateSave": true,
        "columnDefs": [{
                "targets": [-1],
                "orderable": false
            }],
         processing:true,
        oLanguage: {
            
            'sProcessing': "<div id='loader'>Carregando...</div>",
            "sSearch": "<span class='glyphicon glyphicon-search'></span> Pesquisar: ",
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "<span class='text-danger'>Mostrando 0 / 0 de 0 registros</span>",
            "sInfoFiltered": "<span class='text-danger'>(filtrado de _MAX_ registros)</span>",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        }
       
    });

    $("body").on('click', '.detalhe_servico', function (e) {
        e.preventDefault();
        var id_servico = ($(this).attr('data-id_servico'));
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
        $.ajax({
            type: "GET",
            dataType: "html",
            url: url,
            success: function ()
            {

                tabela_cliente.ajax.reload(null, false);

            }

        });//fechamento do ajax


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


$('body').on('submit', "#form_imprimir_servico", function (event) {
    //alert( "Handler for .submit() called." );
    //event.preventDefault();
    $("#modal_imprimir_servico").modal('hide');
});


}); //fim ready




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
                    tabela_cliente.ajax.reload(null, false);

                }

            });//fechamento do ajax

        }
    });



} //fim do gatilho



