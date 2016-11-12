<?php
	//include($_SERVER['DOCUMENT_ROOT']."/socios/inc/config.inc.php");
	ini_set('display_errors', 0);
	$dir = explode("/", trim($_SERVER['PHP_SELF'], "/"));
	$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT']."\\".$dir[0];		
	
	
	include($PATH_PRINCIPAL."/inc/config.inc.php");
	
	
	$usuario = ( !empty($_POST['usuario']) )? $_POST['usuario'] : NULL;
	$password = ( !empty($_POST['password']) )? $_POST['password'] : NULL;
	
	if ( !isset($usuario) ) {
		echo json_encode( array( "codigo" => 1, "mensaje" => "Falta proporcionar un nombre de usuario" ) );
	}
	
	if ( !isset($password) ) {
		echo json_encode( array( "codigo" => 2, "mensaje" => utf8_encode("Falta proporcionar una contraseña") ) );
	}
	
	$usuario = $WBD->real_escape_string($usuario);
	$password = $WBD->real_escape_string($password);
	$IP = $WBD->real_escape_string($IP);
	
	$sql = "CALL `data_acceso`.`SP_LOGIN_TURED`('$usuario', '$password', '$IP', 3, $maxIntentos);";

	$result = $WBD->query($sql);
	
	if ( !$WBD->error() ) {
		if ( $result->num_rows == 1 ) {
			$row = mysqli_fetch_assoc( $result );
			if ( $row['login'] ) {
				session_start();
				$PERM = new Permisos($LOG, $RBD);
				
				$_SESSION['username_tured'] = $usuario;
				$_SESSION['idUsuario_tured'] = $row['idUsuario'];
				$_SESSION['idCliente_tured'] = $row['idCliente'];
				$_SESSION['nombre_tured'] = $row['nombre'];
				$_SESSION['paterno_tured'] = $row['paterno'];
				$_SESSION['email_tured'] = $row['correo'];
				$_SESSION['LAST_ACTIVITY_tured'] = time();

				if ( $row['idPerfil'] != -1 ) {
					$RES = $PERM->getPermisos( $row['idUsuario'], $row['idPerfil'], 3 );
					$_SESSION['Permisos_tured'] = $RES['data'];
				}
				
				if ( $row['idEstatus'] == 5 ) {
					echo json_encode( array( "codigo" => 5, "mensaje" => utf8_encode("Inicio de sesión exitoso") ) );
				}else{
					echo json_encode( array( "codigo" => 0, "mensaje" => utf8_encode("Inicio de sesión exitoso") ) );
				}
			} else {
				if ( $row['idEstatus'] == 0 ) {
					echo json_encode( array( "codigo" => 7, "mensaje" => utf8_encode("No fue posible iniciar sesión: Usuario o Contraseña incorrectos") ) );
				} else {
					echo json_encode( array( "codigo" => 6, "mensaje" => utf8_encode("El usuario se encuentra bloqueado. Por favor contacte a soporte.") ) );
				}
			}
		} else {
			$LOG->error(utf8_encode("No fue posible iniciar sesión.")." QUERY: ".$sql." No se encontraron resultados en la Base de Datos");
			echo json_encode( array( "codigo" => 4, "mensaje" => "Error del sistema. Por favor contacte a soporte." ) );
		}
	} else {
		$LOG->error(utf8_encode("No fue posible iniciar sesión. ")." QUERY: ".$sql." Error: ".$WBD->error() );
		echo json_encode( array( "codigo" => 3, "mensaje" => "El nombre de usuario o la contrase&ntilde;a es incorrecto." ) );
	}
?>