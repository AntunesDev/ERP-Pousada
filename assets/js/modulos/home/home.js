$(document).ready(function(){

  console.log("hello from the home js directory");

  document.querySelector('#alertaError').onclick = function(){
    swal("Funcionalidade Bloqueada!", "Você não tem permissão para realizar esta operação.", "error")
  };

  document.querySelector('#alertaSuccess').onclick = function(){
    swal("Sucesso!", "Operação realizada com sucesso.", "success")
  };

  document.querySelector('#alertaWarning').onclick = function(){
    swal("Alerta!", "Tem certeza que deseja realizar esta operação?.", "warning")
  };

  $('#alertaModal').on('click', function(){
	   $("#Modal").modal({
				backdrop: 'static',
				keyboard: false
			});

      setTimeout(function() {
        $("#Modal").modal('hide');
      }, 3000);
  });

  // will run if create product form was submitted
  $(document).on('click', '#insert-mvc', function(){

      // get form data
      //var form_data=JSON.stringify($(this).serializeObject());
      var rand1 = Math.floor((Math.random() * 1000) + 1);
      var rand2 = Math.floor((Math.random() * 1000) + 1);
      var form_data = {"title" : "Testando "+ rand1, "content" : "Conteudo teste " + rand2};

      // submit form data to api
      $.ajax({
          url: BASE_URL+"home/savepost",
          type : "POST",
          //contentType : 'application/json',
          dataType : 'json',
          data : form_data,
          success : function(result) {
              swal("Sucesso!", "Post guardado com Sucesso.", "success")
          },
          error: function(xhr, resp, text) {
              console.log(xhr, resp, text);
          }
      });

      return false;
  });


});
