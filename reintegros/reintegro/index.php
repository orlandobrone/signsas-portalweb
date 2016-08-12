<?php  include "../../restrinccion.php";  ?>

     <!--Hoja de estilos del calendario -->
	<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">
	<!-- librería principal del calendario -->
	<script type="text/javascript" src="../../calendario/calendar.js"></script>
	<!-- librería para cargar el lenguaje deseado -->
	<script type="text/javascript" src="../../calendario/calendar-es.js"></script>
	<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
	<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>

    <?php require_once "../../config.php"; 

	define('URL_SECCION', URL_REINTEGROS);

	define('SECCION', REINTEGROS); ?>

	<?php require_once "../../tpl_top.php"; ?>

    <style>
    	table.formulario td, table.formulario th {
			padding: 3px !important;	
		}
    </style>

    <div id="cuerpo">

           <h1>SOLICITUD DE REINTEGROS <span style="color:#F00; display:block;">EN PRUEBAS</span></h1>

           <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
			 <? if(in_array(342,$_SESSION['permisos'])): ?>
             <input value="Agregar Reintegro" id="viewreintegroWindow" type="button" class="btn_table" />
             <? endif; ?>
             <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />
             <input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" />
             
             <label style="margin-left:5px;">Exportar desde: </label>
             <input name="fecini" type="text" id="fecini_e" size="9" readonly />
            
             <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador_e" />
            
             <script type="text/javascript">
                Calendar.setup({
                    inputField     :    "fecini_e",      // id del campo de texto
                    ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                    button         :    "lanzador_e"   // el id del botón que lanzará el calendario
                });
             </script> 
            
             <label>Hasta: </label>   
             <input name="fecfin" type="text" id="fecfin_e" size="9" readonly />
            
             <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2_e" />
            
             <script type="text/javascript">
                Calendar.setup({
                    inputField     :    "fecfin_e",      // id del campo de texto
                    ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                    button         :    "lanzador2_e"   // el id del botón que lanzará el calendario
                });
             </script> 

             <input type="button" value="Exportar Todo" id='excelExport2' class="btn_table" /> 

           </div>

           <div id="jqxgrid"></div>
           
           <div id="div_oculto" style="display: none;"></div>
           
           
           <!--Ventana de formulario de nuevo reintegro-->
           <div id="addreintegroWindow">
                <div>
                    <img width="14" height="14" src="https://cdn0.iconfinder.com/data/icons/fatcow/16/table_add.png" alt="" />
                    Formulario de Ingreso Reintegro
                </div>
                <div id="content_form_material" style="width:90%;">
                	
                    <h3>Seleccione la Salidad de Mercancia</h3>
                    <form id="formReintegro">
                    	<input type="hidden" value="" name="idsalida" id="idsalida"/>
                    	<input type="hidden" value="" name="idhito" id="idhito"/>
                        <input type="hidden" value="" name="idproyecto" id="idproyecto"/>
                        
                        <input type="hidden" value="" name="idreintegro" id="idreintegro"/>
        			</form>
                    <table class="formulario">
                        <tr>
                            <td>Salida Mercancia:</td>
                            <td>
                                <input type="hidden" id="id_salida" name="id_salida" class="required"/>
                                <div id="jqxWidget">
                                    <div id="jqxdropdownbutton">
                                        <div style="border-color: transparent;" id="jqxgrid_inv"></div>
                                    </div>
                                </div>             
                            </td>
                            <td>
                            	<input type="button" value="Seleccionar para Reintegro" id="btnEditar" class="btn_table" />
                            </td>
                        </tr>
                    </table>
                    
                    <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
                     
                     	<input value="Aprobar Reintegro" id="btnAprobarReintegro" type="button" class="btn_table"  style="display:none;"/>
                    </div>
                    	
                    <div id="jqxgrid_items"></div>
                </div>
            </div>
           <!--Ventana de formulario de modificar reintegro-->
           <div id="editreintegroWindow">
                <div>
                    <img width="14" height="14" src="https://cdn0.iconfinder.com/data/icons/fatcow/16/table_add.png" alt="" />
                    Vista de Reintegro
                </div>
                <div id="content_form_material" style="width:90%;">                	
                    
                    <form id="formReintegro">
                    	<input type="hidden" value="" name="idsalida" id="idsalida"/>
                    	<input type="hidden" value="" name="idhito" id="idhito"/>
                        <input type="hidden" value="" name="idproyecto" id="idproyecto"/>
                        
                        <input type="hidden" value="" name="idreintegro" id="idreintegro"/>
        			</form>            
                    	
                    <div id="jqxgrid_items_edit"></div>
                </div>
            </div>
           
           <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

        <?php require_once "../../tpl_bottom.php"; ?>

		<style>
			.sweet-alert, .sweet-overlay { z-index:99999; }
			#jqxgrid_items .jqx-grid-cell-pinned div > 1{ margin-top:-5px !important; }			
		</style>

<!--    </body>

</html>-->