<? header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
?>
<!--Hoja de estilos del calendario -->
<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">

<!-- librería principal del calendario -->
<script type="text/javascript" src="../../calendario/calendar.js"></script>

<!-- librería para cargar el lenguaje deseado -->
<script type="text/javascript" src="../../calendario/calendar-es.js"></script>

<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>
<h1>Agregando nuevo costo</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
    <table class="formulario">
        <tbody>
            <tr>
                <td>Proyecto</td>
                <td><? $sqlPry = "SELECT nombre, id FROM proyectos"; 
					$qrPry = mysql_query($sqlPry);
					?>
                	<select name="proyecto" id="proyecto" class="required chosen-select">
                        <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>
                        <option value="<?=$rsPry['id']?>"><?=$rsPry['nombre']?></option>
                        <? } ?>
					</select>
                </td>
            </tr>
            
            <tr>
                <td>Proveedores</td>
                <td><? $sqlPry = "SELECT nombre, id FROM proveedor ORDER BY nombre ASC"; 
					$qrPry = mysql_query($sqlPry);
					?>
                	<select name="proveedor" id="proveedor" class="required chosen-select">
                        <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>
                        <option value="<?=$rsPry['id']?>"><?=$rsPry['nombre']?></option>
                        <? } ?>
					</select>
                </td>
            </tr>
            
            <tr>
                <td>T&eacute;nicos</td>
                <td><? $sqlPry = "SELECT nombre, id FROM tecnico ORDER BY nombre ASC"; 
					$qrPry = mysql_query($sqlPry);
					?>
                	<select name="tecnico" id="tecnico" class="chosen-select">
                        <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>
                        <option value="<?=$rsPry['id']?>"><?=utf8_decode($rsPry['nombre'])?></option>
                        <? } ?>
					</select>
                </td>
            </tr>
             
            <tr>
                <td>Concepto</td>
                <td>
                <?php $arrConcepto = array('Transportes', 'Alquileres Vehiculos', 'Imprevistos', 'ICA', 'Coste Financiero', 
										   'Acarreos', 'Arrendamientos', 'Reparaciones', 'Profesionales', 'Seguros',
										   'Comunicaciones Celular', 'Aseo Vigilancia', 'Asistencia Tecnica', 'Envios Correos', 
										   'Otros Servicios', 'Combustible', 'Lavado Vehiculo', 'Gastos Viaje', 'Tiquetes Aereos',
										   'Aseo Cafeteria', 'Papeleria', 'Internet', 'Taxis Buses', 'Parqueaderos', 'Caja Menor',
										   'Peajes', 'Polizas', 'Materiales', 'MOD', 'MOI', 'TOES', 'Gas'); ?>
                <select name="concepto" id="concepto">
                	<?php foreach ($arrConcepto as $i=>$data) { ?>
                	<option value="<?php echo $i+1; ?>"><?php echo $data;?></option>
                    <?php } ?>
              	</select><!--<input name="concepto" type="text" id="concepto" size="40" class="required" /></td>-->
            </tr>
            <tr>
                <td>Descripci&oacute;n</td>
                <td><input name="descripcion" type="text" id="descripcion" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Fecha de Ingreso</td>
                <td><input name="fecha_ingreso" type="text" class="required" id="fecha_ingreso" size="40" readonly="readonly" />
                  <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />
				<script type="text/javascript">
					Calendar.setup({
						inputField     :    "fecha_ingreso",      // id del campo de texto
						ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
						button         :    "lanzador"   // el id del botón que lanzará el calendario
					});
				</script></td>
            </tr>
            <tr>
                <td>Valor</td>
                <td><input name="valor" type="text" id="valor" size="40" class="required" alt="decimal-us"/></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <input name="agregar" type="submit" id="agregar" value="Agregar" />
                    <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" />
                </td>
            </tr>
        </tfoot>
    </table>
</form> 
<link rel="stylesheet" href="/js/chosen/chosen.css">
<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		
		$("#frm_per select").chosen({width:"250px"});  
		
		$("#frm_per").validate({
			rules:{
				usu_per:{
					required: true,
					remote: "ajax_verificar_usu_per.php"
				}
			},
			messages: {
				usu_per: "x"
			},
			onkeyup: false,
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente agregar a este nuevo costo?')
				if (respuesta)
					form.submit();
			}
		});
		
		$('input').setMask();	
	});
	
	function fn_agregar(){
		var str = $("#frm_per").serialize();
		$.ajax({
			url: 'ajax_agregar.php',
			data: str,
			type: 'post',
			success: function(data){
				if(data != "") {
					alert(data);
				}else{
					fn_cerrar();	
					fn_buscar();
				}
			}
		});
	};
</script>