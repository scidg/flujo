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

	var addUserForm = $("#form_add_user");

	var validator = addUserForm.validate({

		rules:{
			id_cliente :{ required : true },
			username : { required : true },
			password : { required : true, selected : true}
		},
		messages:{
			username :{ required : "Este campo es requerido" },
			password : { required : "Este campo es requerido" },
			id_cliente : { required : "Este campo es requerido", selected : "Seleccione una opcion	" }
		}
	});
});
