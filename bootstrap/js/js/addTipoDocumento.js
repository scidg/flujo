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

	var form = $("#form");

	var validator = form.validate({

		rules:{
			nombre_tipo_documento :{ required : true }
		},
		messages:{
			nombre_tipo_documento :{ required : "Este campo es requerido" }
		}
	});
});
