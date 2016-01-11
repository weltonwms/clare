


$(document).ready(function() {
    $('.meu_chosen').chosen();

    /***********************Acao para o Botao Voltar**************************************/
    $("#voltar").click(function() {
        history.back();
    });//fechamento do click do voltar.
    /*************************************************************************************/

    /*********************Mascaras para os campos ****************************************/
    $('.data').mask("00/00/0000");
    $('.money').mask('000.000.000.000.000,00', {reverse: true});

    /*************************************************************************************/
    $.validator.setDefaults({ignore: ":hidden:not(select)"});
    $('.click_esconde').click(function(event) {
        event.preventDefault();
        $(".esconde").slideToggle('slow', function() {
            
        });

    });
    
   
    include_once(base_url + "assets/js/datepicker.js");
















});//fechamento do read