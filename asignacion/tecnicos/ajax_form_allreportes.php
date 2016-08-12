<? header('Content-type: text/html; charset=iso-8859-1');
	
	/*include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("select * from tecnico where id=%d",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen tecnico con ese ID";
		exit;
	}
	
	$rs_per = mysql_fetch_assoc($per);*/
	
?>
<!--Hoja de estilos del calendario -->
<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">

<!-- librería principal del calendario -->
<script type="text/javascript" src="../../calendario/calendar.js"></script>

<!-- librería para cargar el lenguaje deseado -->
<script type="text/javascript" src="../../calendario/calendar-es.js"></script>

<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>
<h1>Reporte  Funcionario / t&eacute;cnico</h1>
<p>Por favor deligencie el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
	<input type="hidden" id="ide_per" name="ide_per" value="<?=$rs_per['id']?>" />
    <table class="formulario">
        <tbody>
            <tr>
                <td>Regi&oacute;n</td>
                <td><input name="region" type="text" id="region" size="40" class="required" value="<?=$rs_per['region']?>" /></td>
            </tr>           
            <tr>
            	<td>Seleccione Mes</td>
                <td>
                	<select name="mes" id="mes">
                    	<option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </td>
            </tr>      
        </tbody>       
    </table>
    
     <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
    	  <input name="modificar" type="submit" id="modificar" value="Generar" class="btn_table"/>
        <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" class="btn_table"/>
	</div>
    
</form>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		$(".btn_table").jqxButton({ theme: theme });
		
		$("#frm_per").validate({
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea generar el reporte?')  
				if (respuesta)
					form.submit();
			}
		});
	});
	
	function fn_modificar(){
		var region = $('#region').val();
		var mes = $('#mes').val();
		window.open("/asignacion/tecnicos/export_reporte_excel.php?region="+region+"&mes="+mes);
	};
</script>