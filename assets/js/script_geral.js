
$(document).ready(function () {
  $("body").on('click', '.limpa_state', function (e) {
        localStorage.clear();
      
    });
    
    $("body").tooltip({
    selector: '[data-toggle="tooltip"]'
    });
  
});//fechamento do read
