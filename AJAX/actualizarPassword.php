<?php
	ini_set('display_errors', 0);
	$dir = explode("/", trim($_SERVER['PHP_SELF'], "/"));
	$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT']."\\".$dir[0];
	
	include($PATH_PRINCIPAL."/inc/config.inc.php");
	include($PATH_PRINCIPAL."/inc/session.ajax.inc.php");
	
	$idUsuario = !empty( $_POST['idUsuario'] )? $_POST['idUsuario'] : -500;
	$passwordActual = !empty($_POST['passwordActual'])? $_POST['passwordActual'] : NULL;
	$passwordNuevo = !empty($_POST['passwordNuevo'])? $_POST['passwordNuevo'] : NULL;
	
	if ( $idUsuario <= -500 ) {
		echo json_encode( array( "codigo" => 1,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un ID de Usuario" ) );
		exit();
	}
	
	if ( !isset($passwordActual) ) {
		echo json_encode( array( "codigo" => 2, "mensaje" => "Falta proporcionar la contraseña actual" ) );
		exit();
	}
	
	if ( !isset($passwordNuevo) ) {
		echo json_encode( array( "codigo" => 3, "mensaje" => "Falta proporcionar la contraseña nueva" ) );
		exit();
	}
	
	$idUsuario = $WBD->real_escape_string($idUsuario);
	$passwordActual = $WBD->real_escape_string($passwordActual);
	$passwordNuevo = $WBD->real_escape_string($passwordNuevo);
	
	$sql = "CALL `data_acceso`.`SP_PASSWORD_TURED_UPDATE`($idUsuario, '$passwordActual', '$passwordNuevo');";
	$result = $WBD->query($sql);
	
	if ( !$WBD->error() ) {
		if ( $result->num_rows == 1 ) {
			$row = mysqli_fetch_assoc( $result );
			if ( $row['actualizado'] ) {
				echo json_encode( array( "codigo" => 0, "mensaje" => "Actualización de contraseña exitosa." ) );
			} else {
				echo json_encode( array( "codigo" => 6, "mensaje" => "La contraseña actual es incorrecta." ) );
			}
		} else {
			$LOG->error(utf8_encode("No fue posible actualizar contraseña.")." QUERY: ".$sql." No se encontraron resultados en la Base de Datos");
			echo json_encode( array( "codigo" => 5, "mensaje" => "Error del sistema. Por favor contacto a soporte." ) );
		}
	} else {
		$LOG->error(utf8_encode("No fue posible actualizar contraseña. ")." QUERY: ".$sql." Error: ".$WBD->error() );
		echo json_encode( array( "codigo" => 4, "mensaje" => "Error del sistema. Por favor contacto a soporte." ) );
	}
	
?>