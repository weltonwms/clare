
/*
 * Os includes necessários ao datepicker foram colados usando o plugin $script
 *  caso contrário dá erro de carregamento
 */
$(document).ready(function() {
    include_css(base_url + "assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css");
   
    $script(base_url + 'assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js', function(){
	$script(base_url + "assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min.js", function(){
		$('.datepicker').datepicker({
		format: "dd/mm/yyyy",
		language: "pt-BR",
		todayHighlight: true
		});

	});
		
     });


});//fechamento do read



