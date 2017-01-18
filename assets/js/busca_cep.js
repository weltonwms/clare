$(document).ready(function () {

    $("#cep").keyup(function () {
        if (this.value.length == 8) {
            $('#cep').css({'background': "url('../assets/imgs/preload.GIF') no-repeat right", 'background-size': '30px 30px'});
            $('body').append("<div class='fundo_preload teste modal-backdrop fade in'></div>");
            $.getJSON("//viacep.com.br/ws/" + this.value + "/json/?callback=?", function (dados) {

                if (!("erro" in dados)) {
                    var string_endereco= dados.logradouro+' '+dados.complemento+' ';
                    string_endereco+=dados.bairro+' '+dados.localidade+' - '+dados.uf+' '+dados.unidade;
                    $("#endereco").val(string_endereco);
                } else {

                    alert("CEP não encontrado.");
                }
            }).done(function () {
                $('#cep').css('background', "url()");
                $('.fundo_preload').remove();
            }).fail(function () {
                $('#cep').css('background', "url()");
                $('.fundo_preload').remove();
                console.log('falha de rede ou erro lançado pelo webservice');
                
            });
        }
    });
});
