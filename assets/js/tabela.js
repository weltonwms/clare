$(document).ready(function(){
   $.fn.dataTableExt.oStdClasses["sFilter"] = "pesquisa_tabela";
    $('#tabela').dataTable( {
	 "sDom":'ft<"row" <"col-md-4"i ><"col-md-8" p><"clearfix">',
        "sPaginationType": "bootstrap",
         "iDisplayLength" : 10,
        "bSort": false,
         
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
        },


    } );
    
     $('#tabela_mensalidades').dataTable( {
	"sDom":'ft<"row" <"col-md-4"i ><"col-md-8" p><"clearfix">',
        "bPaginate": false,
        "bSort": false,
                 
	  "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _TOTAL_ registro(s)",
            "sInfoEmpty": "<span class='text-danger'>Mostrando 0 / 0 de 0 registros</span>",
            "sInfoFiltered": "<span class='text-danger'>(filtrado de _MAX_ registros)</span>",
            "sSearch": "<span class='glyphicon glyphicon-search'></span> Pesquisar: "
            
        }


    } );




});
