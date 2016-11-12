<?php
	ini_set('display_errors', 0);
	$dir = explode("/", trim($_SERVER['PHP_SELF'], "/"));
	$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT']."\\".$dir[0];	
	
	include($PATH_PRINCIPAL."/inc/config.inc.php");
	
	$email = ( !empty($_POST['email']) )? $_POST['email'] : NULL;
	
	if ( !isset($email) ) {
		echo json_encode( array( "codigo" => 1, "mensaje" => utf8_encode("Falta proporcionar un correo electrónico") ) );
	}
	
	$email = $RBD->real_escape_string($email);
	
	$sql = "CALL `data_acceso`.`SP_SOCIO_FIND`(0, '$email', 2);";
	$result = $RBD->query($sql);
	
	if ( !$RBD->error() ) {
		if ( $result->num_rows == 1 ) {
			$row = mysqli_fetch_assoc( $result );
			if ( $row['existe'] ) {
				echo json_encode( array( "codigo" => 0, "mensaje" => utf8_encode("Enviar correo") ) );
			} else {
				echo json_encode( array( "codigo" => 4, "mensaje" => utf8_encode("No enviar correo") ) );
			}
		} else {
			$LOG->error(utf8_encode("No fue posible recuperar contraseña: ")." QUERY: ".$sql." Error: No se encontraron resultados en la Base de Datos");
			echo json_encode( array( "codigo" => 3, "mensaje" => "Error del sistema. Por favor contacto a soporte." ) );
		}
	} else {
		$LOG->error(utf8_encode("No fue posible recuperar contraseña: ")." QUERY: ".$sql." ".$RBD->error());
		echo json_encode( array( "codigo" => 2, "mensaje" => "Error del sistema. Por favor contacto a soporte." ) );
	}
?>
