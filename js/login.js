$(function(){
	$("#usuario").alphanum({
		allow				: '-_',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 16
	});
	$("#password").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 16
	});
	$("#email").alphanum({
		allow				: "@.-_",
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 100
	});
	$("#login").on("click", function(){
		login();
	});
	$("#recuperarPassword").on("click", function( event ){
		buscarEmail();
	});
	$("#usuario").keyup(function(event){
		if ( event.keyCode == 13 ) {
			$("#login").click();
		}
	});
	$("#password").keyup(function(event){
		if ( event.keyCode == 13 ) {
			$("#login").click();
		}
	});
});

function validarEmail(email) {
	var formatoEmail = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
	return formatoEmail.exec(email);
}

function login() {
	$("#alertaError").stop(true, true).fadeOut();
	var usuario = $("#usuario").val();
	var password = $("#password").val();

	if ( usuario == "" || usuario == null ) {
		$("#alertaError").html("<strong>Error: </strong> Falta proporcionar un nombre de usuario");
		$("#alertaError").stop(true, true).fadeIn();
		return false;
	}
	
	if ( password == "" || password == null ) {
		$("#alertaError").html("<strong>Error: </strong> Falta proporcionar una contrase\u00F1a");
		$("#alertaError").stop(true, true).fadeIn();
		return false;
	}
	
	password = CryptoJS.MD5(password).toString();
	
	$.post( "inc/Ajax/_Login/login.php",
	{ usuario: usuario, password: password },
	function( respuesta ){
		if ( respuesta.codigo == 0 ) {
			window.location = "inicio.php";
			
		}else if(respuesta.codigo == 5){
			window.location = "cambio.php";
		} else {
			if ( respuesta.codigo == 6 ) {
				$("#alertaError").html("<strong>No se ha iniciado sesi\u00F3n.</strong> " + respuesta.mensaje);
				$("#alertaError").stop(true, true).fadeIn();
			/*} else if ( respuesta.codigo == 5 ) {
				$("#alertaError").html("<strong>No se ha iniciado sesi\u00F3n.</strong> Tu nombre de usuario o contrase\u00F1a es incorrecto.");
				$("#alertaError").stop(true, true).fadeIn();*/
			
			}else if( respuesta.codigo == 7){
				$("#alertaError").html("<strong>No se ha iniciado sesi\u00F3n.</strong> " + respuesta.mensaje);
				$("#alertaError").stop(true, true).fadeIn();
				
			} else {
				$("#alertaError").html("<strong>No se ha iniciado sesi\u00F3n.</strong> " + respuesta.mensaje);
				$("#alertaError").stop(true, true).fadeIn();
			}
		}
	}, "json");
}

function buscarEmail() {
	$("#alerta").stop(true, true).fadeOut();
	var email = $("#email").val();
	
	if ( email == "" || email == null ) {
		$("#alerta").attr("class", "alert alert-danger");
		$("#alerta").html("<strong>&iexcl;No enviado!</strong> Falta proporcionar un correo electr\u00F3nico");
		$("#alerta").stop(true, true).fadeIn();		
		return false;
	}
	
	if ( !validarEmail(email) ) {
		$("#alerta").attr("class", "alert alert-danger");
		$("#alerta").html("<strong>&iexcl;No enviado!</strong> El formato del correo electr\u00F3nico es incorrecto");
		$("#alerta").stop(true, true).fadeIn();		
		return false;
	}
	$("#recuperarPassword").off();
	$.post( "inc/Ajax/_Login/buscarEmail.php",
	{ email: email },
	function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			enviarEmail( email );
		} else {
			if ( respuesta.codigo == 4 ) {
				$("#alerta").attr("class", "alert alert-danger");
				$("#alerta").html("<strong>&iexcl;No enviado!</strong> El correo que ingresaste no coincide con nuestra base de datos.");
				$("#alerta").stop(true, true).fadeIn();
			} else {
				$("#alerta").attr("class", "alert alert-danger");
				$("#alerta").html("<strong>&iexcl;No enviado!</strong> " + respuesta.mensaje);
				$("#alerta").stop(true, true).fadeIn();
			}
			$("#recuperarPassword").on("click", function( event ){
				buscarEmail();
			});
		}
	}, "json");
}

function enviarEmail( email ) {
	$("#alerta").stop(true, true).fadeOut();
	if ( email == "" || email == null ) {
		$("#alerta").attr("class", "alert alert-danger");
		$("#alerta").html("<strong>&iexcl;No enviado!</strong> Falta proporcionar un correo electr\u00F3nico");
		$("#alerta").stop(true, true).fadeIn();		
		return false;
	}
	
	if ( !validarEmail(email) ) {
		$("#alerta").attr("class", "alert alert-danger");
		$("#alerta").html("<strong>&iexcl;No enviado!</strong> El formato del correo electr\u00F3nico es incorrecto");
		$("#alerta").stop(true, true).fadeIn();			
		return false;
	}
	
	$.post( "inc/Ajax/_Login/enviarEmail.php",
	{ email: email },
	function( respuesta ) {
		if ( respuesta.success ) {
			$("#alerta").attr("class", "alert alert-info");
			$("#alerta").html("<strong>&iexcl;Enviado!</strong> Se ha enviado un correo electr&oacute;nico con tu contrase&ntilde;a.");
			$("#alerta").stop(true, true).fadeIn();		
			setTimeout(function(){
				window.location = "index.php";
			}, 10000);
		} else {
			if ( respuesta.showMsg == 2 ) {
				$("#alerta").attr("class", "alert alert-danger");
				$("#alerta").html("<strong>&iexcl;No enviado!</strong> " + respuesta.msg);
				$("#alerta").stop(true, true).fadeIn();
			} else {
				$("#alerta").attr("class", "alert alert-danger");
				$("#alerta").html("<strong>&iexcl;No enviado!</strong> " + respuesta.msg);
				$("#alerta").stop(true, true).fadeIn();
			}
			$("#recuperarPassword").on("click", function( event ){
				buscarEmail();
			});
		}
	}, "json");
}