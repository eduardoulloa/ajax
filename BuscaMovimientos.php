<?php
	
	
	ini_set('display_errors', 0);
	$dir = explode("/", trim($_SERVER['PHP_SELF'], "/"));
	$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT']."\\".$dir[0];
	
	
	include($PATH_PRINCIPAL."/_Reportes/inc/config.inc.php");
	include($PATH_PRINCIPAL."/_Reportes/inc/session.ajax.inc.php");
	
	
	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST']."/".$dir[0];
	
	
	
	/*$idpais		= (isset($_GET['idPais']))?$_GET['idPais']: -2;
	$idedo		= (isset($_GET['idEdo']))?$_GET['idEdo']: -2;
	$idcd		= (isset($_GET['idMun']))?$_GET['idMun']: -2;
	$idcol		= (isset($_GET['idCol']))?$_GET['idCol']: -2;
	$status		= (isset($_GET['status']))?$_GET['status']:0;
	$idCadena	= (isset($_GET['idCadena']) AND $_GET["idCadena"] >=0)? $_GET["idCadena"] : -1;
	$idSubCad	= (isset($_GET['idSubCad']) AND $_GET["idSubCad"] >=0)? $_GET["idSubCad"] : -1;
	$idCor		= (isset($_GET['idCor']) AND $_GET["idCor"] >=0)? $_GET["idCor"] : -1;*/
	
	$fec1 = (isset($_GET['fec1']))?$_GET['fec1']: '0000-01-01';
	$fec2 = (isset($_GET['fec2']))?$_GET['fec2']: 'NOW';
	$numCuenta = (isset($_GET['numCuenta']))?$_GET['numCuenta']: -1;
	
	global $RBD;
	
	$start	= (!empty($_GET["iDisplayStart"]))? $_GET["iDisplayStart"] : 0;
	$cant	= (!empty($_GET["iDisplayLength"]))? $_GET["iDisplayLength"] : 20;

	$colsort	= (isset($_REQUEST['iSortCol_0']) AND $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$strToFind	= (!empty($_REQUEST['sSearch']))? $_REQUEST['sSearch'] : '';
	
	$strToFind = $RBD->real_escape_string($strToFind);
	$strToFind = utf8_decode($strToFind);
	
	$Result = $RBD->query("CALL `redefectiva`.`SP_REPORTE_MOVIMIENTO`('$fec1', '$fec2', $start, $cant, $numCuenta, $colsort, '$ascdesc', '$strToFind')");
	//$Result = $RBD->query("CALL `redefectiva`.`SP_LOAD_CORRESPONSALES_SOCIO`('$cadenas', $idSubCad, $idCor, $idpais, $idedo, $idcd, $idcol, $start, $cant, $colsort, '$ascdesc', '$strToFind', $idUsuario, $idGrupo)");
	
	//$Result = $RBD->query("SELECT * FROM `redefectiva`.`ops_movimiento` WHERE 1");
	
	if($RBD->error() == ''){
		if(mysqli_num_rows($Result) > 0 ){

			$data = array();
			while($row=mysqli_fetch_assoc($Result)){
				$id = $row["idsMovimiento"];

				/*$data[] = array(
					$row["idCorresponsal"],
					(!preg_match('!!u', $row["nombreCorresponsal"]))? utf8_encode($row["nombreCorresponsal"]) : $row["nombreCorresponsal"],
					(!preg_match('!!u', utf8_encode($row["nombreEntidad"])))? utf8_encode($row["nombreEntidad"]) : utf8_encode($row["nombreEntidad"]),
					$row["telefono1"],
					$row["email"],
					(!preg_match('!!u', utf8_encode($row["descEstatus"])))? utf8_encode($row["descEstatus"]) : utf8_encode($row["descEstatus"]),
					'<a href="#" onclick="verCorresponsal('.$id.')">Ver</a>'
				);*/
				
				$tipoMov = $row["descTipoMovimiento"];
				if ($tipoMov == "Cancelacion"){
					$tipoMov = "Reverso";
				}
				
				$data[] = array(
					$row["idsOperacion"],
					$row["fecAppMov"],
					"$".number_format($row["comCorresponsal"],2,'.',''),
					$tipoMov,
					"$".number_format($row["cargoMov"],2,'.',''),
					"$".number_format($row["abonoMov"],2,'.',''),
					"$".number_format($row["saldoFinal"],2,'.','')
				);
			}

			$sqlcount = $RBD->query("SELECT FOUND_ROWS() AS total");
			$res = mysqli_fetch_assoc($sqlcount);
			$iTotal = $res["total"];

			$iTotalDisplayRecords = ($iTotal < $cant)? $iTotal : $cant;
			$output = array(
				"sEcho"					=> intval($_GET['sEcho']),
				"iTotalRecords"			=> $iTotal,
				"iTotalDisplayRecords"	=> $iTotal,
				"aaData"				=> $data
			);

			echo json_encode($output);
		}
		else{
			$output = array(
				"sEcho"					=> intval($_GET['sEcho']),
				"iTotalRecords"			=> 0,
				"iTotalDisplayRecords"	=> 0,
				"aaData"				=> array(),
				"codigo"                => 100
			);
			echo json_encode( $output );
			//echo json_encode( array( "codigo" => 100 ) );
		}
	}
	else{

    	$output = array(
			"sEcho"					=> intval($_GET['sEcho']),
			"iTotalRecords"			=> 0,
			"iTotalDisplayRecords"	=> 0,
			"aaData"				=> array($RBD->error())
		);
		echo json_encode($output);
	}
		
?>