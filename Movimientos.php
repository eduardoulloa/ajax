<?php 


	ini_set('display_errors', 0);
	$dir = explode("/", trim($_SERVER['PHP_SELF'], "/"));
	$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT']."\\".$dir[0];

	include($PATH_PRINCIPAL."/inc/config.inc.php");
	include($PATH_PRINCIPAL."/inc/session.inc.php");

	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST']."/".$dir[0];
	
 ?>
 <!DOCTYPE html>
<html>           
  <head>                      
    <title>                   
    </title>                      
    <meta http-equiv="X-UA-Compatible" content="IE=edge">                      
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />               
    <link rel="stylesheet" href="<?php echo $PATHRAIZ; ?>/css/font-awesome.min.css">                      
    <link rel="stylesheet" href="<?php echo $PATHRAIZ; ?>/css/bootstrap.min.css">                      
    <link rel="stylesheet" href="<?php echo $PATHRAIZ; ?>/css/integrador.css">     
	<link rel="stylesheet" href="<?php echo $PATHRAIZ; ?>/css/jquery.dataTables.min.css" />
    <link href="<?php echo $PATHRAIZ; ?>/fonts/stylesheet.css" rel="stylesheet" />
	<link href="<?php echo $PATHRAIZ; ?>/assets/datepicker/css/datepicker.css" rel="stylesheet"/>	
    <!--[if IE]>
    <link rel='stylesheet' href="<?php echo $PATHRAIZ; ?>/css/ie/ie.css">
    <![endif]-->                                                                                   
    <!--[if lt IE 9]>
    <link rel='stylesheet' href="<?php echo $PATHRAIZ; ?>/css/ie/ie.css">
    <link rel='stylesheet' href="<?php echo $PATHRAIZ; ?>/css/ie/ie8.css">
    <![endif]-->                 
  </head>           
  <body id="boxed-bg" class="boxed">                   
    <div class="page-box">                           
      <div class="page-box-content"> 
<?php include($PATH_PRINCIPAL."/inc/menu.php");	 ?>
<section id="main">
  
  <div class="container">                                               
    <div class="section cadena">
      <div class="well" id="contenedor">               <h3>Reporte de tus Movimientos</h3>                                                                                     
        <h5 style="margin-bottom:30px;">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</h5>                                                                                      
        <form class="form-horizontal" method="POST" action="ReporteMovimientosExcel.php">                                                                                                                                                 
          <div class="form-group buscar">
            <div class="col-xs-6">                                                                                                                                                       
              <select class="form-control" id="numCuenta" name="numCuenta"> 
				<option>--Elige una Cuenta--                                                                                     
                </option>  
				<?php
						//Variable para adquirir todos los números de cuenta.
						$RBD;
						$idUsuario = $_SESSION['idUsuario_tured'];
						$Result = $RBD->query("CALL `redefectiva`.`SP_LOAD_CUENTAS_SALDO`($idUsuario)");
						
						if($RBD->error() == ''){
							if(mysqli_num_rows($Result) > 0 ){
								
								while($row=mysqli_fetch_assoc($Result)){
									if($row["idCorresponsal"] == -1){
										echo "<option value=\"".$row["numCuenta"]."\">".codificarUTF8($row["numCuenta"])." - ".codificarUTF8($row["nombreCadena"])." - ".codificarUTF8($row["nombreSubCadena"])."</option>";
									}else{
										echo "<option value=\"".$row["numCuenta"]."\">".codificarUTF8($row["numCuenta"])." - ".codificarUTF8($row["nombreCorresponsal"])."</option>";
									}
								}
								
							}
						}
				?>                                                                                                                                                                               
              </select>                                                                                                                                 
            </div> 
			
				
					
            <div class="col-xs-3">                                                                                                                                                       
              <input type="text" class="form-control m-bot15" data-date-format="yyyy-mm-dd" id="fechaInicio" placeholder="Fecha de Inicio" name="fechaInicio">                                                                                                                                 
            </div>                                                                                                                                 
            <div class="col-xs-3">                                                                                                                                                       
              <input type="text" class="form-control m-bot15" data-date-format="yyyy-mm-dd" id="fechaFin" placeholder="Fecha Final" name="fechaFin">                                                                                                                                 
            </div>                                                                                                           
          </div>                                                                                                                                                                                    
          <div class="form-group buscar">                                                                                                                                 
            <div class="col-xs-12">                                                                                                                                                       
              <button type="button" class="btn btn-success pull-right" id="botonMovimientos">                    Consultar Reporte                                                                                                                                                          
                                                                                                                                                       
              </button>              
            </div>                                                                                                                                                     
          </div>
		  
		<div class="alert alert-movimientos ocultarSeccion" id="alerta">                                                                                           
                                                                                    
        </div>
		
		<div class="row ocultarSeccion" id="divExportar">
			<div class="col-xs-12">                                                                                                                                                       
			  <input type="submit" class="btn btn-success pull-right" value="Exportar" id="exportar"/>               
			</div>               
         </div>
        </form>                                                                
        
                                         
      </div> 
	   
    </div>                              
  </div>                                    
  <!--Tabla-->                      
</section>

<?php include("footer.php"); ?>  