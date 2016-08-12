<?php  include "../../restrinccion.php";  ?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin t?tulo</title>
        <script language="javascript" type="text/javascript" src="../extras/js/jquery-1.3.2.min.js"></script>
        <script language="javascript" type="text/javascript" src="../extras/js/jquery.blockUI.js"></script>
        <script language="javascript" type="text/javascript" src="../extras/js/jquery.validate.1.5.2.js"></script>
        <script language="javascript" type="text/javascript" src="../extras/js/mask.js"></script>
        <link href="../extras/css/estilo.css" rel="stylesheet" type="text/css" />
        <link href="../extras/php/PHPPaging.lib.css" rel="stylesheet" type="text/css" />
        <script language="javascript" type="text/javascript" src="index.js"></script>
    </head>
    <body>-->
	<?php //header('Content-type: text/html; charset=iso-8859-1');
	require_once "../../config.php"; ?>
		<?php require_once "../../tpl_top.php"; ?>
        <?php include "../../conexion.php"; ?>
        <?php 
		$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';		
	
		if ($usuario != '*' && $usuario != 0) {
						
			$otorgado = 0;
			$noOtorogado = 0;
			
			$qrCostos = mysql_query("SELECT * FROM comercial WHERE id_usuario = {$usuario} AND otorgado = 'Si' "); 
			$rowsCostos = mysql_fetch_array($qrCostos);			
			$otorgado = mysql_num_rows($qrCostos);
			
			$qrCostos = mysql_query("SELECT * FROM comercial WHERE id_usuario = {$usuario} AND otorgado = 'No' "); 
			$rowsCostos = mysql_fetch_array($qrCostos);			
			$noOtorogado = mysql_num_rows($qrCostos);
			
			
		}else if($usuario == 0){
			
			$otorgado = 0;
			$noOtorogado = 0; 
			
			$qrCostos = mysql_query("SELECT * FROM comercial WHERE otorgado = 'Si' "); 
			$rowsCostos = mysql_fetch_array($qrCostos);			
			$otorgado = mysql_num_rows($qrCostos);
			
			$qrCostos = mysql_query("SELECT * FROM comercial WHERE otorgado = 'No' "); 
			$rowsCostos = mysql_fetch_array($qrCostos);			
			$noOtorogado = mysql_num_rows($qrCostos);
			
		}
		
		
		?>
    	<link rel="stylesheet" href="../css/style.css" type="text/css">
        
        <link href='../js/fullcalendar/fullcalendar.css' rel='stylesheet' />
        <link href='../js/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script> 
        <script src='../js/jquery-ui-1.10.2.custom.min.js'></script>
        <script src='../js/fullcalendar/fullcalendar.min.js'></script>       
      
               
        <script type="text/javascript">
           
		   $(document).ready(function() {
			
				var date = new Date();
				var d = date.getDate();
				var m = date.getMonth();
				var y = date.getFullYear();
				
				$('#calendar').fullCalendar({
					editable: false,
					eventDrop: function(event, delta) {
						alert(event.title + ' was moved ' + delta + ' days\n' +
							'(should probably update your database)');
					},
					loading: function(bool) {
						if (bool) $('#loading').show();
						else $('#loading').hide();
					}
					
				});
				
				$('#usuario').change(function(){ 
						$('#calendar').fullCalendar('removeEvents');	
						var idUser = $(this).val();
						$('#calendar').fullCalendar( 'addEventSource', "json-events.php?iduser="+idUser);
				});
				
				
				$('#vehiculo').change(function(){ 
						$('#calendar').fullCalendar('removeEvents');	
						var idVehi = $(this).val();						
						var source2 = {
							url: "json-events-vehi.php?idvehi="+idVehi,
							color: '#009933',
							textColor: 'black'
						};						
						
						$('#calendar').fullCalendar('addEventSource', source2); 
				});
				
				
				$('#reset_calendar').click(function(){
					$('#calendar').fullCalendar('removeEvents');	
				})
				
			});
		   
    	</script>
        
        <style>
			#calendar {
				width: 800px;
				margin: 0 auto;
				}
		</style>
        
        <form id="formPry" name="formPry" action="reporte2.php?tab=<?=$_GET['tab']?>" method="post">
        	T&eacute;cnicos:
        	<select name="usuario" id="usuario">
            	<option value="">Seleccione</option>               
            	<?
					$sql = "select * from tecnico order by id asc";
					$qrPry = mysql_query($sql);
					$nombrePry = "";
					while($rs_pry = mysql_fetch_assoc($qrPry)){
				?>
					<option value="<?=$rs_pry['id']?>" <? if ($usuario == $rs_pry['id']){ echo 'selected="selected"'; $nombrePry = $rs_pry['nombres']; } ?>><?=utf8_encode($rs_pry['nombre'])?></option>
				<? } ?>
            </select>
            
            Vehiculos:
            <select name="vehiculo" id="vehiculo">
            	<option value="">Seleccione</option>               
            	<?
					$sql = "select * from vehiculos order by id asc";
					$qrPry = mysql_query($sql);
					$nombrePry = "";
					while($rs_pry = mysql_fetch_assoc($qrPry)){
				?>
					<option value="<?=$rs_pry['id']?>" <? if ($usuario == $rs_pry['id']){ echo 'selected="selected"'; $nombrePry = $rs_pry['nombres']; } ?>><?=$rs_pry['placa']?></option>
				<? } ?>
            </select>
            
            <input type="button" id="reset_calendar" value="Reiniciar Calendario" />
        </form>
		<div style="position: relative; margin-top:20px;">
			<div id='calendar'></div>
        </div>
        <?php require_once "../../tpl_bottom.php"; ?>