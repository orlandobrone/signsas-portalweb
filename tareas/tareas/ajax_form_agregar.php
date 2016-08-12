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
<h1>Agregando nueva tarea</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
    <table class="formulario">
        <tbody>
            <tr>
                <td>Hito</td>
                <td><? $qrHitos = mysql_query("SELECT nombre, id FROM hitos") or die(mysql_error()); ?>
                	<select name="hito" id="hito" class="required">
                    <? while ($rowHitos = mysql_fetch_array($qrHitos)) { ?>
                		<option value="<?=$rowHitos['id']?>"><?=($rowHitos['nombre'])?></option>
                    <? } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td><input name="nombre" type="text" id="nombre" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Usuario</td>
                <td><? $qrUsu = mysql_query("SELECT nombres, id FROM usuario") or die(mysql_error()); ?>
                	<select name="usuario" id="usuario" class="required">
                    <? while ($rowUsu = mysql_fetch_array($qrUsu)) { ?>
                		<option value="<?=$rowUsu['id']?>"><?=$rowUsu['nombres']?></option>
                    <? } ?>
                    </select></td>
            </tr>
            <tr>
                <td>Fecha Inicio</td>
                <td><input name="fecha_inicio" type="text" class="required" id="fecha_inicio" size="40" readonly="readonly" />
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
                <td><input name="fecha_fin" type="text" class="required" id="fecha_fin" size="40" readonly="readonly" />
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
                <td><textarea name="descripcion" cols="40" class="required" id="descripcion" style="width:215px"></textarea></td>
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
				var respuesta = confirm('\xBFDesea realmente agregar esta nueva tarea?')
				if (respuesta)
					form.submit();
			}
		});
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