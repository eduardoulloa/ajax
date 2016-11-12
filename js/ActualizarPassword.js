$(function(){
	$("#passwordActual").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 16
	});
	$("#passwordNuevo").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 16
	});
	$("#passwordConfirmar").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 16
	});
	$("#actualizarPassword").on("click", function(){
		actualizarPassword();
	});
});

function validarPassword( password ) {
	var formatoPassword = /^(?!.*([A-Za-z0-9])\1{2})(?=.*[a-zA-Z])(?=.*\d)[A-Za-z0-9]+$/;
	return formatoPassword.exec( password );
}

function actualizarPassword() {
	$("#alerta").stop(true, true).fadeOut();
	var passwordActual = $("#passwordActual").val();
	var passwordNuevo = $("#passwordNuevo").val();
	var passwordConfirmar = $("#passwordConfirmar").val();
	
	if ( passwordActual == "" ) {
		$("#alerta").attr("class", "alert alert-danger d");
		//$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong> La contrase&ntilde;a actual est&aacute; vac&iacute;a.");
		$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong><ul class=\"error\"><li>La contrase&ntilde;a actual est&aacute; vac&iacute;a.</li></ul>");
		$("#alerta").stop(true, true).fadeIn();
		return false;
	}
	
	/*if ( !validarPassword(passwordActual) ) {
		$("#alerta").attr("class", "alert alert-danger d");
		//$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong> Favor de verificar la contrase&ntilde;a actual proporcionada. Debe contener tanto n&uacute;meros como letras y ser de 8 posiciones, 16 m&aacute;ximo.");
		$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong><ul class=\"error\"><li>Favor de verificar la contrase&ntilde;a actual proporcionada. Debe contener tanto n&uacute;meros como letras y ser de 8 posiciones, 16 m&aacute;ximo.</li></ul>");		
		$("#alerta").stop(true, true).fadeIn();
		return false;
	}*/	
	
	if ( passwordNuevo == "" ) {
		$("#alerta").attr("class", "alert alert-danger d");
		//$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong> La nueva contrase&ntilde;a est&aacute; vac&iacute;a.");
		$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong><ul class=\"error\"><li>La nueva contrase&ntilde;a est&aacute; vac&iacute;a.</li></ul>");
		$("#alerta").stop(true, true).fadeIn();
		return false;
	}
	
	if ( !validarPassword(passwordNuevo) ) {
		$("#alerta").attr("class", "alert alert-danger d");
		//$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong> Favor de verificar la nueva contrase&ntilde;a proporcionada. Debe contener tanto n&uacute;meros como letras y ser de 8 posiciones, 16 m&aacute;ximo.");
		$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong><ul class=\"error\"><li>Favor de verificar la nueva contrase&ntilde;a proporcionada. Debe contener tanto n&uacute;meros como letras y ser de 8 posiciones, 16 m&aacute;ximo. No se permiten caracteres especiales (, . $) o caracteres repetidos.</li></ul>");		
		$("#alerta").stop(true, true).fadeIn();
		return false;
	}
	
	if ( passwordNuevo.length < 8 || passwordNuevo.length > 16 ) {
		$("#alerta").attr("class", "alert alert-danger d");
		//$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong> Favor de verificar la nueva contrase&ntilde;a proporcionada. Debe contener tanto n&uacute;meros como letras y ser de 8 posiciones, 16 m&aacute;ximo.");
		$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong><ul class=\"error\"><li>Favor de verificar la nueva contrase&ntilde;a proporcionada. Debe contener tanto n&uacute;meros como letras y ser de 8 posiciones, 16 m&aacute;ximo.</li></ul>");		
		$("#alerta").stop(true, true).fadeIn();
		return false;
	}
	
	if ( passwordConfirmar == "" ) {
		$("#alerta").attr("class", "alert alert-danger d");
		//$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong> La contrase&ntilde;a de confirmaci&oacute;n est&aacute; vac&iacute;a.");
		$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong><ul class=\"error\"><li>La contrase&ntilde;a de confirmaci&oacute;n est&aacute; vac&iacute;a.</li></ul>");
		$("#alerta").stop(true, true).fadeIn();
		return false;
	}
	
	if ( !validarPassword(passwordConfirmar) ) {
		$("#alerta").attr("class", "alert alert-danger d");
		//$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong> Favor de verificar la contrase&ntilde;a de confirmaci&oacute;n proporcionada. Debe contener tanto n&uacute;meros como letras y ser de 8 posiciones, 16 m&aacute;ximo.");
		$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong><ul class=\"error\"><li>Favor de verificar la contrase&ntilde;a de confirmaci&oacute;n proporcionada. Debe contener tanto n&uacute;meros como letras y ser de 8 posiciones, 16 m&aacute;ximo. No se permiten caracteres especiales (, . $) o caracteres repetidos.</li></ul>");
		$("#alerta").stop(true, true).fadeIn();
		return false;
	}
	
	if ( passwordConfirmar.length < 8 || passwordConfirmar.length > 16 ) {
		$("#alerta").attr("class", "alert alert-danger d");
		//$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong> Favor de verificar la nueva contrase&ntilde;a proporcionada. Debe contener tanto n&uacute;meros como letras y ser de 8 posiciones, 16 m&aacute;ximo.");
		$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong><ul class=\"error\"><li>Favor de verificar la nueva contrase&ntilde;a proporcionada. Debe contener tanto n&uacute;meros como letras y ser de 8 posiciones, 16 m&aacute;ximo.</li></ul>");		
		$("#alerta").stop(true, true).fadeIn();
		return false;
	}	
	
	if ( passwordNuevo != passwordConfirmar ) {
		$("#alerta").attr("class", "alert alert-danger d");
		//$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong> La nueva contrase&ntilde;a no coincide con la contrase&ntilde;a de confirmaci&oacute;n.");
		$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong><ul class=\"error\"><li>La nueva contrase&ntilde;a no coincide con la contrase&ntilde;a de confirmaci&oacute;n.</li></ul>");
		$("#alerta").stop(true, true).fadeIn();
		return false;
	}
	
	if ( passwordNuevo == passwordActual ) {
		$("#alerta").attr("class", "alert alert-danger d");
		//$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong> La nueva contrase&ntilde;a no puede ser igual que la actual");
		$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong><ul class=\"error\"><li>La nueva contrase&ntilde;a no puede ser igual que la actual</li></ul>");
		$("#alerta").stop(true, true).fadeIn();
		return false;
	}
	
	if ( passwordConfirmar == passwordActual ) {
		$("#alerta").attr("class", "alert alert-danger d");
		//$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong> La contrase&ntilde;a de confirmaci&oacute;n no puede ser igual que la actual");
		$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong><ul class=\"error\"><li>La contrase&ntilde;a de confirmaci&oacute;n no puede ser igual que la actual</li></ul>");
		$("#alerta").stop(true, true).fadeIn();
		return false;
	}	
	
	passwordActual = CryptoJS.MD5(passwordActual).toString();
	passwordNuevo = CryptoJS.MD5(passwordNuevo).toString();
	passwordConfirmar = CryptoJS.MD5(passwordConfirmar).toString();
	
	$.post( BASE_PATH + "/inc/Ajax/_Login/actualizarPassword.php",
	{ idUsuario: idUsuario, passwordActual: passwordActual, passwordNuevo: passwordNuevo, passwordConfirmar: passwordConfirmar },
	function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			$("#alerta").attr("class", "alert alert-info d");
			$("#alerta").html("<strong>Cambi&oacute; la contrase&ntilde;a</strong> Puedes iniciar sesi&oacute;n con tu nueva contrase&ntilde;a.");
			$("#alerta").stop(true, true).fadeIn();			
		} else {
			if ( respuesta.codigo == 9000 || respuesta.codigo == 9500 ) {
				window.location = respuesta.URL;
			} else {
				$("#alerta").attr("class", "alert alert-danger d");
				$("#alerta").html("<strong>No se ha cambiado la contrase&ntilde;a.</strong><ul class=\"error\"><li>" + respuesta.mensaje + "</li></ul>");
				$("#alerta").stop(true, true).fadeIn();
			}
		}
	}, "json");
}