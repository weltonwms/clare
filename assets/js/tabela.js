$(document).ready(function () {
    //$.fn.dataTableExt.oStdClasses["sFilter"] = "pesquisa_tabela";
    $('#tabela').dataTable({
        "dom": "<'row'<'col-sm-6'f><'col-sm-6'l>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "iDisplayLength": 25,
        "bStateSave": true,
        "columnDefs": [{
                "targets": [-1],
                "orderable": false
            }],
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "<span class='text-danger'>Mostrando 0 / 0 de 0 registros</span>",
            "sInfoFiltered": "<span class='text-danger'>(filtrado de _MAX_ registros)</span>",
            "sSearch": "<span class='glyphicon glyphicon-search'></span> Pesquisar: ",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        }
    }); //fechamento datatable #tabela

    $('#tabela_ajax_servico').dataTable({
        "dom": "<'row'<'col-sm-6'f><'col-sm-6'l>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "iDisplayLength": 25,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": base_url + "servico/teste1",
            "type": "POST"
        },
        "bStateSave": true,
        "columnDefs": [{
                "targets": [-1],
                "orderable": false
            }],
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "<span class='text-danger'>Mostrando 0 / 0 de 0 registros</span>",
            "sInfoFiltered": "<span class='text-danger'>(filtrado de _MAX_ registros)</span>",
            "sSearch": "<span class='glyphicon glyphicon-search'></span> Pesquisar: ",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        }
    }); //fechamento datatable #tabela_ajax_servico

























     table_ajax=$('#tabela-ajax').DataTable({
        "dom": "<'row'<'col-sm-6'f><'col-sm-6'l>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "iDisplayLength": 25,
        "ajax": base_url + "servico/ajax",
        "columns": [
            {"data": "id"},
            {"data": "cliente"},
            {"data": "data"},
            {"data": "estado"},
            {"data": "tipo"},
            {"data": "vendedor"},
            {"data": "acoes"}
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




























}); //fechamento do ready
