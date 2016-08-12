<?php  include "../../restrinccion.php";  ?>
    
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
					if($('#fecini').val()=='' || $('#fecfin').val()==''){
						alert('Seleccione fecha desde y hasta');
						exit;
					}
						
					var gett = '?fecini='+$('#fecini').val()+'&fecfin='+$('#fecfin').val();
					window.open("/reportes/reporte10/reporte_hitos.php"+gett);
				});

          });

   		</script>

    	<link rel="stylesheet" href="../css/style.css" type="text/css">
        
        <div id="cuerpo">

           <h1>REPORTE COSTOS DIARIOS</h1>


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
             <input style="margin-left:30px;" type="button" value="Exporte Hitos" id="excelExport1" class="btn_table" />

            </div>
		</div>
     
        <?php require_once "../../tpl_bottom.php"; ?>