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
	
	$sql = "CALL `data_acceso`.`SP_LOGIN_SOCIO`('$usuario', '$password', '$IP', 2, $maxIntentos);";
	//var_dump($sql);
	$result = $WBD->query($sql);
	
	if ( !$WBD->error() ) {
		if ( $result->num_rows == 1 ) {
			$row = mysqli_fetch_assoc( $result );
			if ( $row['login'] ) {
				session_start();
				$PERM = new Permisos($LOG, $RBD);
				$_SESSION['username'] = $usuario;
				$_SESSION['idGrupo'] = $row['idGrupo'];
				$_SESSION['idUsuario'] = $row['idUsuario'];
				$_SESSION['LAST_ACTIVITY'] = time();
				if ( $row['idPerfil'] != -1 ) {
					$RES = $PERM->getPermisos( $row['idUsuario'], $row['idPerfil'], 2 );
					$_SESSION['Permisos'] = $RES['data'];
				}
				echo json_encode( array( "codigo" => 0, "mensaje" => utf8_encode("Inicio de sesión exitoso") ) );
			} else {
				if ( $row['idEstatus'] == 0 ) {
					echo json_encode( array( "codigo" => 5, "mensaje" => utf8_encode("No fue posible iniciar sesión: Usuario o Contraseña incorrectos") ) );
				} else {
					echo json_encode( array( "codigo" => 6, "mensaje" => utf8_encode("El usuario se encuentra bloqueado. Por favor contacte a soporte.") ) );
				}
			}
		} else {
			$LOG->error(utf8_encode("No fue posible iniciar sesión.")." QUERY: ".$sql." No se encontraron resultados en la Base de Datos");
			echo json_encode( array( "codigo" => 4, "mensaje" => "Error del sistema. Por favor contacto a soporte." ) );
		}
	} else {
		$LOG->error(utf8_encode("No fue posible iniciar sesión. ")." QUERY: ".$sql." Error: ".$WBD->error() );
		echo json_encode( array( "codigo" => 3, "mensaje" => "Error del sistema. Por favor contacto a soporte." ) );
	}
?>