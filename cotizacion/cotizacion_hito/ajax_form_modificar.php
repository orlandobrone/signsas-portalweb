<? header('Content-type: text/html; charset=iso-8859-1');
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}
	
	include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("select * from beneficiarios where id=%d",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen un Beneficiario con ese ID";
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
<h1>Modificando Beneficiario</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
      <table class="formulario">
        <tbody>
            <tr>
                <td>Identificaci&oacute;n</td>
                <td><input name="identificacion" type="text" id="identificacion" size="40" class="required"  value="<?=$rs_per['identificacion']?>"/></td>
            </tr>
            <tr>
                <td>Beneficiario</td>
                <td><input name="beneficiario" type="text" id="beneficiario" size="40" class="required"  value="<?=$rs_per['beneficiario']?>"/></td>
            </tr>
            <tr>
                <td>No. Cuenta</td>
                <td><input name="num_cuenta" type="text" id="num_cuenta" size="40" class="required"  value="<?=$rs_per['num_cuenta']?>"/></td>
            </tr>
            <tr>
                <td>Entidad</td>
                <td><input name="entidad" type="text" id="entidad" size="40" class="required"  value="<?=$rs_per['entidad']?>"/></td>
            </tr>
            <tr>
                <td>Tipo Cuenta</td>
                <td><input name="tipo_cuenta" type="text" id="tipo_cuenta" size="40" class="required"  value="<?=$rs_per['tipo_cuenta']?>"/></td>
            </tr>
            
        </tbody>       
    </table>
    
    <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
    	<input name="agregar" type="submit" id="agregar" value="Modificar" class="btn_table" onclick="fn_modificar();"/>
        <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" class="btn_table"/>
	</div>
</form>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		$(".btn_table").jqxButton({ theme: theme });
		$("#frm_per").validate({
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente modificar este beneficiario?')
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
					$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
				}
			}
		});
	};
</script>