/*
 *  Document   : formsValidation.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Forms Validation page
 */

var FormsValidation = function() {

    return {
        init: function() {
            /*
             *  Jquery Validation, Check out more examples and documentation at https://github.com/jzaefferer/jquery-validation
             */

            /* Initialize Form Validation */
            $('#form-validation').validate({
                errorClass: 'help-block animation-pullUp', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error'); e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    'val-username': {
                        required: true,
                        minlength: 3
                    },
                    'val-email': {
                        required: true,
                        email: true
                    },
                    'val-password': {
                        required: true,
                        minlength: 5
                    },
                    'val-confirm-password': {
                        required: true,
                        equalTo: '#val-password'
                    },
                    'val-suggestions': {
                        required: true,
                        minlength: 5
                    },
                    'val-skill': {
                        required: true
                    },
                    'val-website': {
                        required: true,
                        url: true
                    },
                    'val-digits': {
                        required: true,
                        digits: true
                    },
                    'val-number': {
                        required: true,
                        number: true
                    },
                    'val-range': {
                        required: true,
                        range: [1, 5]
                    },
                    'val-terms': {
                        required: true
                    }
                },
                messages: {
                    'val-username': {
                        required: 'Please enter a username',
                        minlength: 'Your username must consist of at least 3 characters'
                    },
                    'val-email': 'Please enter a valid email address',
                    'val-password': {
                        required: 'Please provide a password',
                        minlength: 'Your password must be at least 5 characters long'
                    },
                    'val-confirm-password': {
                        required: 'Please provide a password',
                        minlength: 'Your password must be at least 5 characters long',
                        equalTo: 'Please enter the same password as above'
                    },
                    'val-suggestions': 'What can we do to become better?',
                    'val-skill': 'Please select a skill!',
                    'val-website': 'Please enter your website!',
                    'val-digits': 'Please enter only digits!',
                    'val-number': 'Please enter a number!',
                    'val-range': 'Please enter a number between 1 and 5!',
                    'val-terms': 'You must agree to the service terms!'
                }
            });
			
			
			/* Initialize Form Validation */
            $('#create-empresa-form').validate({
                errorClass: 'help-block animation-pullUp', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error'); e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    'razaosocial': {
                        required: true,
						minlength: 5
                    },
					'nomefantasia': {
                        required: true,
						minlength: 3
                    },
                    'cnpj': {
                        required: true,
                        digits: true,
						minlength: 14
                    },
					'cep': {
                        required: true,
                        digits: true,
						minlength: 8
                    },
					'logradouro': {
                        required: true,
                        minlength: 5
                    },
					'numero': {
                        required: true,
                        digits: true
                    },
					'bairro': {
                        required: true,
                        minlength: 3
                    },
					'cidade': {
                        required: true
                    },
					'estado': {
                        required: true
                    },
					'telefone': {
                        required: true,
                        digits: true,
						minlength: 10
                    },
					'email': {
                       	email: true
                    }
                },
                messages: {
                    'razaosocial': {
                        required: 'Por favor digite a sua Razão Social',
						minlength: 'A sua Razão Social é muito curta'
                    },
					'nomefantasia': {
                        required: 'Por favor digite o seu Nome Fantasia',
						minlength: 'O seu Nome Fantasia é muito curto'
                    },
					'cnpj': {
                        required: 'Por favor digite o seu CNPJ',
						digits: 'Digite somente números',
						minlength: 'O seu CNPJ é muito curto'
                    },
					'cep': {
                        required: 'Por favor digite o seu CEP',
						digits: 'Digite somente números',
						minlength: 'O seu CEP é muito curto'
                    },
					'logradouro': {
                        required: 'Por favor digite o seu Logradouro',
						minlength: 'O seu Logradouro é muito curto'
                    },
					'numero': {
                        required: 'Por favor digite o seu Número',
						digits: 'Digite somente números'
                    },
					'bairro': {
                        required: 'Por favor digite o seu Nome Fantasia',
						minlength: 'O seu Nome Fantasia é muito curto'
                    },
					'cidade': 'Selecione uma Cidade',
					'estado':  'Selecione um Estado',
					'telefone': {
                        required: 'Por favor digite o seu Telefone',
						digits: 'Digite somente números',
						minlength: 'O seu Telefone é muito curto'
                    },
                    'email': 'Digite um endereço válido de e-mail'
                }
            });
			
			
			
			
			/* Initialize Form Validation */
            $('#update-empresa-form').validate({
                errorClass: 'help-block animation-pullUp', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error'); e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    'razaosocial': {
                        required: true,
						minlength: 5
                    },
					'nomefantasia': {
                        required: true,
						minlength: 3
                    },
                    'cnpj': {
                        required: true,
                        digits: true,
						minlength: 14
                    },
					'cep': {
                        required: true,
                        digits: true,
						minlength: 8
                    },
					'logradouro': {
                        required: true,
                        minlength: 5
                    },
					'numero': {
                        required: true,
                        digits: true
                    },
					'bairro': {
                        required: true,
                        minlength: 3
                    },
					'cidade': {
                        required: true
                    },
					'estado': {
                        required: true
                    },
					'telefone': {
                        required: true,
                        digits: true,
						minlength: 10
                    },
					'email': {
                       	email: true
                    }
                },
                messages: {
                    'razaosocial': {
                        required: 'Por favor digite a sua Razão Social',
						minlength: 'A sua Razão Social é muito curta'
                    },
					'nomefantasia': {
                        required: 'Por favor digite o seu Nome Fantasia',
						minlength: 'O seu Nome Fantasia é muito curto'
                    },
					'cnpj': {
                        required: 'Por favor digite o seu CNPJ',
						digits: 'Digite somente números',
						minlength: 'O seu CNPJ é muito curto'
                    },
					'cep': {
                        required: 'Por favor digite o seu CEP',
						digits: 'Digite somente números',
						minlength: 'O seu CEP é muito curto'
                    },
					'logradouro': {
                        required: 'Por favor digite o seu Logradouro',
						minlength: 'O seu Logradouro é muito curto'
                    },
					'numero': {
                        required: 'Por favor digite o seu Número',
						digits: 'Digite somente números'
                    },
					'bairro': {
                        required: 'Por favor digite o seu Nome Fantasia',
						minlength: 'O seu Nome Fantasia é muito curto'
                    },
					'cidade': 'Selecione uma Cidade',
					'estado':  'Selecione um Estado',
					'telefone': {
                        required: 'Por favor digite o seu Telefone',
						digits: 'Digite somente números',
						minlength: 'O seu Telefone é muito curto'
                    },
                    'email': 'Digite um endereço válido de e-mail'
                }
            });
			
			
			/* Initialize Form Validation */
            $('#config-empresa-form').validate({
                errorClass: 'help-block animation-pullUp', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error'); e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    'certificado': {
                        required: true
                    },
					'senha': {
                        required: true
                    }
                },
                messages: {
                    'certificado': {
                        required: 'Você esqueceu do seu Certificado'
                    },
					'senha': {
                        required: 'Por favor digite a Senha do Certificado'
                    }
                }
            });
			
			
			
			
			/* Initialize Form Validation */
            $('#formbaixalote').validate({
                errorClass: 'help-block animation-pullUp', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.input-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.input-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.input-group').removeClass('has-success has-error'); e.closest('.input-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    'dataini': {
                        required: true
                    }/*,
					'datafim': {
                        required: true
                    }*/
                },
                messages: {
                    'dataini': {
                        required: 'selecionar uma data'
                    }/*,
					'datafim': {
                        required: 'selecionar uma data'
                    }*/
                }
            });
			
			
			/* Initialize Form Validation */
            $('#formfinalizaVenda').validate({
                errorClass: 'help-block animation-pullUp', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error'); e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
					'NomeCliente': {
						minlength: 5
                    },
                    'CpfCliente': {
                        digits: true,
						minlength: 11
                    },
					'FormaPgto': {
                        required: true
                    }
                },
                messages: {
					'NomeCliente': {
						minlength: 'nome muito curto'
                    },
                    'CpfCliente': {
                        digits: 'somente números',
						minlength: 'cpf muito curto'
                    },
					'FormaPgto': {
                        required: 'selecione uma forma de pagamento'
                    }					
                }
            });
			
			/* Initialize Form Validation */
            $('#formDescontoProduto').validate({
                errorClass: 'help-block animation-pullUp', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error'); e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
					'Justificativa': {
						required: true
                    },
					'senhaGerencial': {
                        required: true
                    }
                },
                messages: {
					'Justificativa': {
						required: 'Digite uma Justificativa'
                    },
					'senhaGerencial': {
                        required: 'Senha não pode estar vazia'
                    }					
                }
            });
			
	
			/* Initialize Form Validation */
            $('#formImpPadrao').validate({
                errorClass: 'help-block animation-pullUp', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error'); e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
					'impPadrao': {
                        required: true
                    }
                },
                messages: {
					'impPadrao': {
                        required: 'selecione uma Impressora'
                    }					
                }
            });
        }
    };
}();