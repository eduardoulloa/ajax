<?php
	ini_set('display_errors', 0);
	$dir = explode("/", trim($_SERVER['PHP_SELF'], "/"));
	$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT']."\\".$dir[0];
	
	include($PATH_PRINCIPAL."/inc/config.inc.php");
	//include($PATH_PRINCIPAL."/inc/session.ajax.inc.php");
	
	$idCadena		= ( isset($_POST['idCadena']) )? $_POST['idCadena'] : NULL;
	$idSubCadena	= ( isset($_POST['idSubCadena']) )? $_POST['idSubCadena'] : NULL;
	$idCorresponsal = ( isset($_POST['idCorresponsal']) )? $_POST['idCorresponsal'] : NULL;
	$idEquipo		= ( isset($_POST['idEquipo']) )? $_POST['idEquipo'] : NULL;
	$idOperador		= ( isset($_POST['idOperador']) )? $_POST['idOperador'] : NULL;
	$fechaInicio	= ( isset($_POST['fechaInicio']) )? $_POST['fechaInicio'] : NULL;
	$fechaFin		= ( isset($_POST['fechaFin']) )? $_POST['fechaFin'] : NULL;
	
	$sql = "CALL `redefectiva`.`SP_LOAD_FAMILIAS`();";
	$result = $RBD->query($sql);
	if ( $RBD->error() == '' ) {
		if ( mysqli_num_rows($result) > 0 ) {
			$familias = array();
			while ( $familia = mysqli_fetch_assoc($result) ) {
				$familias[] = $familia;
			}
		} else {
			echo json_encode( array( "codigo" => 2, "mensaje" => "No se encontraron resultados" ) );
			exit();
		}
	} else {
		$LOG->error("Error del sistema. QUERY: ".$sql." ".$RBD->error());
		echo json_encode( array( "codigo" => 1, "mensaje" => "Error del sistema. Por favor contacte a soporte." ) );
		exit();
	}

	$sql = "CALL `redefectiva`.`SP_GET_SUBFAMILIAS`(-1);";
	$result = $RBD->query($sql);
	if ( $RBD->error() == '' ) {
		if ( mysqli_num_rows($result) > 0 ) {
			$subfamilias = array();
			while ( $subfamilia = mysqli_fetch_assoc($result) ) {
				$subfamilias[] = $subfamilia;
			}
		} else {
			echo json_encode( array( "codigo" => 2, "mensaje" => "No se encontraron resultados" ) );
			exit();
		}
	} else {
		$LOG->error("Error del sistema. QUERY: ".$sql." ".$RBD->error());
		echo json_encode( array( "codigo" => 1, "mensaje" => "Error del sistema. Por favor contacte a soporte." ) );
		exit();
	}
	
	$sql = "CALL `redefectiva`.`SP_LOAD_CORTES`($idCadena, $idSubCadena, $idCorresponsal, '$fechaInicio', '$fechaFin', $idOperador, $idEquipo);";
	$result = $RBD->query($sql);
	if ( $RBD->error() == '' ) {
		$filas = array();
		if ( mysqli_num_rows($result) > 0 ) {
			while ( $fila = mysqli_fetch_assoc($result) ) {
				$filas[] = $fila;
			}
		} else {
			echo json_encode( array( "codigo" => 2, "mensaje" => "No se encontraron resultados" ) );
			exit();
		}
	} else {
		$LOG->error("Error del sistema. QUERY: ".$sql." ".$RBD->error());
		echo json_encode( array( "codigo" => 1, "mensaje" => "Error del sistema. Por favor contacte a soporte." ) );
		exit();
	}
	
	$reporte = array();
	foreach( $familias as $familia ) {
		$reporte[$familia['idFamilia']] = array();
		foreach( $subfamilias as $subfamilia ) {
			if ( $subfamilia["idFamilia"] == $familias["idFamilia"] ) {
			
			}
		}
	}
	
?>