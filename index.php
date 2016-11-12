<?php
	ini_set('display_errors', 0);
	if ( $_SERVER["SERVER_PORT"] != 443 ) { 
		header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']); 
		exit();
	}
	
	//include($_SERVER['DOCUMENT_ROOT']."/socios/inc/config.inc.php");
	
	$dir = explode("/", trim($_SERVER['PHP_SELF'], "/"));
	$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT']."\\".$dir[0];	
	
	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST']."/".$dir[0];
	
	include($PATH_PRINCIPAL."/inc/config.inc.php");
	//include($PATH_PRINCIPAL."/inc/config_ClaveSecreta.inc.php");
	
	session_start();
	
	if ( isset($_SESSION['LAST_ACTIVITY_tured']) && (time() - $_SESSION['LAST_ACTIVITY_tured']) > $maxSessionTime ) {
		session_unset();
		session_destroy();
		header("Location: timeout.php");
	}
	
	if ( isset($_SESSION['LAST_ACTIVITY_tured']) ) {
		$_SESSION['LAST_ACTIVITY'] = time();
		header("Location: inicio.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta charset="utf-8">
		<title>Portal Integradores de Red Efectiva</title>
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/ingreso.css">
		
        <link href="fonts/stylesheet.css" rel="stylesheet" />
        <!--[if IE]>
        <link rel='stylesheet' href="<?php echo $PATHRAIZ; ?>/css/ie/ie.css">
        <![endif]-->                                                                                   
        <!--[if lt IE 9]>
        <link rel='stylesheet' href="<?php echo $PATHRAIZ; ?>/css/ie/ie.css">
        <link rel='stylesheet' href="<?php echo $PATHRAIZ; ?>/css/ie/ie8.css">
        <![endif]-->
	</head>
	<body class="log">
<!-- Wrap all page content here -->

<!--Inicio-->
  
  
  <!--Cosas-->
  <div class="well logs" style="margin-top:130px;">
  <div class="col-xs-6">
  <form role="form">
  <fieldset> 
				<img src="img/logo.png">
                <div class="sub">Bienvenido a Tu Red</div>
                <div class="form-group"><i class="fa fa-user"></i>
                    <input type="email" id="usuario" class="form-control " placeholder="Usuario">
				</div>
				<div class="form-group"><i class="fa fa-lock"></i>
                    <input type="password" id="password" class="form-control" placeholder="Contraseña">
				</div>
                
   </fieldset>
		</form>
                
                <div class="col-xs-6">
                <a><button class="btn btn-success" id="login">Iniciar Sesión</button></a>
                </div>
                <div class="col-xs-6">
                <a href="forgot.php" class="margen">¿Olvidaste tu Usuario o Contraseña?</a>
                </div>

  <!--Esta alerta se muestra sólo cuando no se puede hacer el login-->  
  <div id="alertaError" class="alert alert-danger d ocultarSeccion" >
      <strong>No se ha iniciado sesión.</strong> Tu nombre de usuario o contraseña es incorrecto.
    </div>
  
        </div>
        </div>
    <!--Cosas-->
  
  <div id="footer">
  Tu Red. Sistema de Administración para Corresponsales de Red Efectiva.
  </div>


	<!-- script references -->
		<script src="inc/js/jquery.min.js"></script>
        <script src="inc/js/bootstrap.min.js"></script>
        <script src="inc/js/jquery.alphanum.js"></script>
        <script src="inc/js/Login/md5.js"></script>
        <script src="inc/js/Login/login.js"></script>
	</body>
</html>