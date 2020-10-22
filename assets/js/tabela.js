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
    
    
    
     tabela_cliente=$('#tabela_cliente').DataTable({
        dom: "<'row'<'col-sm-6'f><'col-sm-6'l>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        iDisplayLength: 25,
        serverSide: true,
        ajax: base_url + "cliente/getDataTables",
        columns: [
            {data: "nome", name:"nome"},
            {data: "endereco", name:"endereco"},
            {data: "telefone", name:"telefone"},
            {data: "responsavel", name:"responsavel"},
            {data: "acoes"}
        ],
        "order": [0, 'desc'],
        drawCallback: gatilhoTabelaCliente,
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
    
    function gatilhoTabelaCliente() {
        $(".confirm").confirm({
		text : "Deseja realmente excluir este Cliente?",
		title : "  Exclusão de Cliente",
		confirmButton : " Excluir",
		cancelButton : " Cancelar"
	});
        
        $(".detalhe_cliente").click(function(e) {
        e.preventDefault();
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
    }
    
    
    

}); //fechamento do ready
