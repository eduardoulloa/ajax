<?php
	ini_set('display_errors', 0);
	$dir = explode("/", trim($_SERVER['PHP_SELF'], "/"));
	$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT']."\\".$dir[0];	
	
	include($PATH_PRINCIPAL."/inc/config.inc.php");
	require($PATH_PRINCIPAL."/inc/lib/phpmailer/class.phpmailer.php");
	
	$email = ( !empty($_POST['email']) )? $_POST['email'] : NULL;
	
	if ( !isset($email) ) {
		//echo json_encode( array( "codigo" => 1, "mensaje" => utf8_encode("Falta proporcionar un correo electrónico") ) );
		$response = array(
			'showMsg'	=> 1,
			'success'	=> false,
			'errmsg'	=> "",
			'msg'		=> 'Error del sistema. Por favor contacte a soporte.'
		);
	}
	
	$password = generarPassword();
	
	if ( empty($password) ) {
		$response = array(
			'showMsg'	=> 1,
			'success'	=> false,
			'errmsg'	=> utf8_encode("No fue posible generar contraseña."),
			'msg'		=> utf8_encode("No fue posible generar contraseña.")
		);
		$LOG->error(utf8_encode("No fue posible generar contraseña."));
	}
	
	if ( !empty($password) ) {
		$passwordEncriptado = md5($password);
		$sql = "CALL `data_acceso`.`SP_PASSWORD_TURED_RESTAURAR`('$email', '$passwordEncriptado');";
		$result = $WBD->query($sql);
		
		if ( !$WBD->error() ) {
			if ( $result->num_rows == 1 ) {
				
				$enviarEmail = true;
				
			} else {
				$LOG->error(utf8_encode("No fue posible restaurar contraseña.")." QUERY: ".$sql." No se encontraron resultados en la Base de Datos");
				$response = array(
					'showMsg'	=> 5,
					'success'	=> false,
					'errmsg'	=> "",
					'msg'		=> 'Error del sistema. Por favor contacte a soporte.'
				);				
			}
		} else {
			$LOG->error(utf8_encode("No fue posible restaurar contraseña. ")." QUERY: ".$sql." Error: ".$WBD->error() );
			$response = array(
				'showMsg'	=> 5,
				'success'	=> false,
				'errmsg'	=> "",
				'msg'		=> 'Error del sistema. Por favor contacte a soporte.'
			);
		}
		if ( $enviarEmail ) {
			include($PATH_PRINCIPAL."/inc/lib/mail/templates/password.php");
			$imagen1 = $PATH_PRINCIPAL."\\email\\fb.png";
			$imagen2 = $PATH_PRINCIPAL."\\email\\fondo4.png";
			$imagen3 = $PATH_PRINCIPAL."\\email\\logo.png";
			$imagen4 = $PATH_PRINCIPAL."\\email\\tt.png";
			$mail = new correo('', '', $LOG, $RBD, $LOG, $WBD);
			$mail->MAIL->AddAddress($email);
			$mail->MAIL->addReplyTo('sistemas@redefectiva.com', 'Sistemas');
			$mail->MAIL->IsHTML(false);
			$mail->MAIL->CharSet = 'UTF-8';
			$mail->MAIL->Subject = "Nueva Contraseña";
			$mail->MAIL->Body = $body;
			$mail->MAIL->AddAttachment($imagen1);
			$mail->MAIL->AddAttachment($imagen2);
			$mail->MAIL->AddAttachment($imagen3);
			$mail->MAIL->AddAttachment($imagen4);
			
			if ( !$mail->MAIL->Send() ) {
				$response = array(
					'showMsg'	=> 2,
					'success'	=> false,
					'errmsg'	=> "1 : ".$mail->MAIL->ErrorInfo,
					'msg'		=> 'No fue posible enviar el correo. Intente nuevamente.'
				);
				$LOG->error('Mailer error: ' . $mail->MAIL->ErrorInfo);
			} else {
				$response = array(
					'showMsg'	=> 0,
					'success'	=> true,
					'errmsg'	=> "",
					'msg'		=> 'Correo Enviado'
				);			
			}
		}
	}
	
	echo json_encode($response);
?>