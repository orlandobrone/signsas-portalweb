<? header('Content-type: text/html; charset=iso-8859-1');
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}

	include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("select * from proyecto_ingresos where id=%d",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen ingresos de proyectos con ese ID";
		exit;
	}
	
	$rs_per = mysql_fetch_assoc($per);
	
?>
<!--Hoja de estilos del calendario -->
<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">

<!-- librería principal del calendario -->
<script type="text/javascript" src="../../calendario/calendar.js"></script>

<!-- librería para cargar el lenguaje deseado -->
<script type="text/javascript" src="../../calendario/calendar-es.js"></script>

<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>
<h1>Modificando costo</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
    <table class="formulario">
        <tbody>
            <tr>
                <td>Proyecto</td>
                <td>
                	<? $sqlPry = "SELECT nombre, id FROM proyectos"; 
					$qrPry = mysql_query($sqlPry);
					?>
                	<select name="proyecto" id="proyecto" class="required">
                    	<? while ($rsPry = mysql_fetch_array($qrPry)) { ?>
                        <option value="<?=$rsPry['id']?>" <? if ($rsPry['id'] == $rs_per['id_proyecto']) echo 'selected="selected"'; ?>><?=$rsPry['nombre']?></option>
                        <? } ?>
					</select>
                </td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td><input name="concepto" type="text" id="concepto" size="40" class="requisssred" value="<?=$rs_per['concepto']?>" /></td>
            </tr>
            <tr>
                <td>Descripci&oacute;n</td>
                <td><input name="descripcion" type="text" id="descripcion" size="40" class="required" value="<?=$rs_per['descripcion']?>" /></td>
            </tr>
            <? 
			$fecha_ingreso = explode(" ", $rs_per['fecha_ingreso']);
			//$fecha_ingreso = explode("-", $fecha_ingreso[0]);
			//$fecha_ingreso = $fecha_ingreso[2] . "/" . $fecha_ingreso[1] . "/" . $fecha_ingreso[0];
			?>
            <tr>
                <td>Persona de Contacto</td>
                <td><input name="fecha_ingreso" type="text" class="required" id="fecha_ingreso" size="40" readonly="readonly" value="<?=$fecha_ingreso[0]?>" />
                  <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />
				<script type="text/javascript">
					Calendar.setup({
						inputField     :    "fecha_ingreso",      // id del campo de texto
						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
						button         :    "lanzador"   // el id del botón que lanzará el calendario
					});
				</script></td>
            </tr>
            <tr>
                <td>Valor</td>
                <td><input name="valor" type="text" id="valor" size="40" class="required" value="<?=$rs_per['valor']?>" alt="decimal-us"/></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <input name="modificar" type="submit" id="modificar" value="Modificar" />
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
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente modificar a este ingreso?')
				if (respuesta)
					form.submit();
			}
		});
		
		$('input').setMask();	
	});
	
	function fn_modificar(){
		var str = $("#frm_per").serialize();
		$.ajax({
			url: 'ajax_modificar.php',
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