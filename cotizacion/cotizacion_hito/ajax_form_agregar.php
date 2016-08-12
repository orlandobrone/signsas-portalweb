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
<h1>Agregando Beneficiario</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
    <table class="formulario">
        <tbody>
            <tr>
                <td>Identificaci&oacute;n</td>
                <td><input name="identificacion" type="text" id="identificacion" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Beneficiario</td>
                <td><input name="beneficiario" type="text" id="beneficiario" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>No. Cuenta</td>
                <td><input name="num_cuenta" type="text" id="num_cuenta" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Entidad</td>
                <td><input name="entidad" type="text" id="entidad" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Tipo Cuenta</td>
                <td><input name="tipo_cuenta" type="text" id="tipo_cuenta" size="40" class="required" /></td>
            </tr>
            
        </tbody>       
    </table>
    
    <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
    	<input name="agregar" type="submit" id="agregar" value="Agregar" class="btn_table"/>
        <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" class="btn_table"/>
	</div>
</form>

<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		$(".btn_table").jqxButton({ theme: theme });
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
				var respuesta = confirm('\xBFDesea realmente agregar este Beneficiario?')
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
					$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
				}
			}
		});
	};
</script>