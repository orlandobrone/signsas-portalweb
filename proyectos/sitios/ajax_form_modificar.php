<? header('Content-type: text/html; charset=iso-8859-1');
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}
	
	include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("select * from sitios where id=%d",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen un SITIO con ese ID";
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
<h1>Modificando  Proyecto</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
    <table class="formulario">
        <tbody>
            <tr>
                <td>Regional</td>
                <td><input name="regional" type="text" id="regional" size="40" class="requisssred" value="<?=$rs_per['regional']?>" /></td>
            </tr>
            <tr>
                <td>Departamento</td>
                <td><input name="departamento" type="text" id="departamento" size="40" class="required" value="<?=$rs_per['departamento']?>" /></td>
            </tr>
            <tr>
                <td>Ciudad</td>
                <td><input name="ciudad" type="text" id="ciudad" size="40" class="required" value="<?=$rs_per['ciudad']?>" /></td>

            </tr>
            <tr>
                <td>Nombre RB</td>
                <td><input name="nombre_rb" type="text" id="nombre_rb" size="40" class="required" value="<?=$rs_per['nombre_rb']?>" /></td>
            </tr>
            <tr>
                <td>Direcci&oacute;n</td>
                <td><input name="direccion" type="text" id="direccion" size="40" class="required" value="<?=$rs_per['direccion']?>" /></td>
            </tr>
            <tr>
                <td>Tipo RB</td>
                <td><input name="tipo_rb" type="text" id="tipo_rb" size="40" class="required" value="<?=$rs_per['tipo_rb']?>" /></td>

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
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		$("#frm_per").validate({
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente modificar este sitio?')
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