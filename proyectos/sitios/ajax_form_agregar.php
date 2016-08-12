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
<h1>Agregando sitio</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
    <table class="formulario">
        <tbody>
            <tr>
                <td>Regional</td>
                <td><input name="regional" type="text" id="regional" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Departamento</td>
                <td><input name="departamento" type="text" id="departamento" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Ciudad</td>
                <td><input name="ciudad" type="text" id="ciudad" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Nombre RB</td>
                <td><input name="nombre_rb" type="text" id="nombre_rb" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Direcci&oacute;n</td>
                <td><input name="direccion" type="text" id="direccion" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>TIPO RB(COSITE)</td>
               <td><input name="tipo_rb" type="text" id="tipo_rb" size="40" class="required" /></td>
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

<script language="javascript" type="text/javascript">
	$(document).ready(function(){
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
				var respuesta = confirm('\xBFDesea realmente agregar este sitio?')
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