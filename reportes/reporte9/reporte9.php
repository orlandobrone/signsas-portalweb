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
    
    <!--Hoja de estilos del calendario -->
	<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">

	<!-- librería principal del calendario -->
	<script type="text/javascript" src="../../calendario/calendar.js"></script>

	<!-- librería para cargar el lenguaje deseado -->
	<script type="text/javascript" src="../../calendario/calendar-es.js"></script>

	<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
	<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>

	<?php //header('Content-type: text/html; charset=iso-8859-1');
	require_once "../../config.php"; ?>
		<?php require_once "../../tpl_top.php"; ?>
        <?php include "../../conexion.php"; ?>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        
         <script type="text/javascript">

    		$(document).ready(function () {

        
				$('#excelExport1').click(function(){
					var gett = '?fecini='+$('#fecini').val()+'&fecfin='+$('#fecfin').val();
					window.open("/reportes/reporte9/reporte_general.php"+gett);
				});
				
				$('#excelExport2').click(function(){
					var gett = '?mes='+$('#mes').val()+'&fecini='+$('#fecini2').val()+'&fecfin='+$('#fecfin2').val();
					window.open("/reportes/reporte9/reporte_tecnico.php"+gett);
				});
				
				$('#excelExport3').click(function(){
					var gett = '?mes='+$('#mes').val()+'&fecini='+$('#fecini2').val()+'&fecfin='+$('#fecfin2').val();
					window.open("/reportes/reporte9/reporte_vehiculo.php"+gett);
				});
				
				$('#excelExport4').click(function(){
					var idhito = $('#idhito').val();
					window.open("/reportes/reporte9/reporte_hitos.php?idHito="+idhito);
				});
				
				$('#excelExport5').click(function(){
					window.open("/reportes/reporte9/reporte_anticipos_hitos.php");
				});
				
				$('#excelExport6').click(function(){
					window.open("/reportes/reporte9/reporte_anticipos.php");
				});

          });

   		</script>

    	<link rel="stylesheet" href="../css/style.css" type="text/css">
        
        <div id="cuerpo">

           <h1>REPORTE GENERAL</h1>


            <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
           
             <label>Desde: </label>
             <input name="fecini" type="text" id="fecini" size="20" readonly="readonly" />

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "fecini",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador"   // el id del botón que lanzará el calendario

					});

				</script> 
                
             <label style="margin-left:30px;">Hasta: </label>   
             <input name="fecfin" type="text" id="fecfin" size="20" readonly="readonly" />

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2" />
 
				<script type="text/javascript">
 
					Calendar.setup({

						inputField     :    "fecfin",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador2"   // el id del botón que lanzará el calendario

					});

				</script> 
             <input style="margin-left:30px;" type="button" value="Exporte General" id="excelExport1" class="btn_table" />

            </div>
            
            <h1>REPORTE T&Eacute;CNICO Y VEH&Iacute;CULO</h1>


            <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
           
             <label style="margin-left:30px;">Mes: </label>
             <select name="mes" id="mes">
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
             </select>
             <label style="margin-left:30px;">ó</label>
             <label style="margin-left:30px;">Desde: </label>
             <input name="fecini2" type="text" id="fecini2" size="20" readonly="readonly" />

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador3" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "fecini2",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador3"   // el id del botón que lanzará el calendario

					});

				</script> 
                
             <label style="margin-left:30px;">Hasta: </label>   
             <input name="fecfin2" type="text" id="fecfin2" size="20" readonly="readonly" />

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador4" />
 
				<script type="text/javascript">
 
					Calendar.setup({

						inputField     :    "fecfin2",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador4"   // el id del botón que lanzará el calendario

					});

				</script> 
                 
             <input style="margin-left:30px;" type="button" value="Exporte T&eacute;cnico" id="excelExport2" class="btn_table" />
             <input style="margin-left:30px;" type="button" value="Exporte Veh&iacute;culo" id="excelExport3" class="btn_table" />

            </div>
            
            <h1>REPORTES VARIOS</h1>


            <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
             
             <input style="margin-left:30px;" type="button" value="Exporte Anticipos e Hitos" id="excelExport5" class="btn_table" />
             
             <input style="margin-left:30px;" type="button" value="Exporte Anticipos" id="excelExport6" class="btn_table" />
             
             </div>
             
             
              <h1>REPORTE HITOS</h1>


            <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
              	 <input type="text" placeholder="Ingrese el ID Hito a Exportar" id="idhito" />	
            	 <input type="button" value="Exporte Hitos" id="excelExport4" class="btn_table" />
             
             </div>
            
		</div>
     
        <?php require_once "../../tpl_bottom.php"; ?>