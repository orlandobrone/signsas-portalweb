<? header('Content-type: text/html; charset=iso-8859-1');
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}

	include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("select * from tareas where id=%d",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen tareas con ese ID";
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
<h1>Modificando tarea</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
    <table class="formulario">
        <tbody>
            <tr>
                <td>Hito</td>
                <td><? $qrHitos = mysql_query("SELECT nombre, id FROM hitos") or die(mysql_error()); ?>
                	<select name="hito" id="hito" class="required">
                    <? while ($rowHitos = mysql_fetch_array($qrHitos)) { ?>
                		<option value="<?=$rowHitos['id']?>" <? if ($rowHitos['id']==$rs_per['id_hito']) echo "selected='selected'"; ?>><?=($rowHitos['nombre'])?></option>
                    <? } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td><input name="nombre" type="text" id="nombre" size="40" class="requisssred" value="<?=$rs_per['nombre']?>" /></td>
            </tr>
            <tr>
                <td>Usuario</td>
                <td><? $qrUsu = mysql_query("SELECT nombres, id FROM usuario") or die(mysql_error()); ?>
                	<select name="usuario" id="usuario" class="required">
                    <? while ($rowUsu = mysql_fetch_array($qrUsu)) { ?>
                		<option value="<?=$rowUsu['id']?>" <? if ($rowUsu['id']==$rs_per['id_usuario']) echo "selected='selected'";?>><?=$rowUsu['nombres']?></option>
                    <? } ?>
                    </select></td>
            </tr>
            <? 
			$fecha_inicio = explode(" ", $rs_per['fecha_inicio']);
			$fecha_inicio = explode("-", $fecha_inicio[0]);
			$fecha_inicio = $fecha_inicio[2] . "/" . $fecha_inicio[1] . "/" . $fecha_inicio[0];
			
			$fecha_fin = explode(" ", $rs_per['fecha_final']);
			$fecha_fin = explode("-", $fecha_fin[0]);
			$fecha_fin = $fecha_fin[2] . "/" . $fecha_fin[1] . "/" . $fecha_fin[0];
			
			?>
            <tr>
                <td>Fecha de inicio</td>
                <td><input name="fecha_inicio" type="text" class="required" id="fecha_inicio" size="40" readonly="readonly" value="<?=$fecha_inicio?>" />
                  <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />
				<script type="text/javascript">
					Calendar.setup({
						inputField     :    "fecha_inicio",      // id del campo de texto
						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
						button         :    "lanzador"   // el id del botón que lanzará el calendario
					});
				</script></td>
            </tr>
            <tr>
                <td>Fecha Fin</td>
                <td><input name="fecha_fin" type="text" class="required" id="fecha_fin" size="40" readonly="readonly" value="<?=$fecha_fin?>" />
                  <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2" />
				<script type="text/javascript">
					Calendar.setup({
						inputField     :    "fecha_fin",      // id del campo de texto
						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
						button         :    "lanzador2"   // el id del botón que lanzará el calendario
					});
				</script></td>
            </tr>
            <tr>
                <td>Descripci&oacute;n</td>
                <td><textarea name="descripcion" cols="40" class="required" id="descripcion" style="width:215px"><?=$rs_per['descripcion']?></textarea></td>
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
				var respuesta = confirm('\xBFDesea realmente modificar esta tarea?')
				if (respuesta)
					form.submit();
			}
		});
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