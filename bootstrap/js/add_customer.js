/**
 * File : addUser.js
 *
 * This file contain the validation of add user form
 *
 * Using validation plugin : jquery.validate.js
 *
 * @author Kishor Mali
 */

$(document).ready(function(){

	var addUserForm = $("#form_add_customer");

	var validator = addUserForm.validate({

		rules:{
			rut_cliente :{ required : true },
			nombre_cliente : { required : true },
			telefono_1 : { required : true, digits : true },
			telefono_2 : { required : true, digits : true },
			mail_1 : { required : true, email : true },
			mail_2 : { required : true, email : true },

		},
		messages:{
			rut_cliente :{ required : "Este campo es requerido" },
			nombre_cliente : { required : "Este campo es requerido" },
			telefono_1 : { required : "Este campo es requerido" },
			telefono_2 :{ required : "Este campo es requerido" },
			mail_1 :{ required : "Este campo es requerido", email : "Por favor ingrese un mail valido"},
			mail_2 :{ required : "Este campo es requerido", email : "Por favor ingrese un mail valido"},

		}
	});
});
