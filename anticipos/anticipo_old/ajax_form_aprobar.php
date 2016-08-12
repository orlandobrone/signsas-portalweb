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
<h1>Aprobando anticipo</h1>
<?php
$sql7 = "SELECT count(1) AS cuenta FROM `hitos` AS h, items_anticipo AS i WHERE i.id_anticipo = ".$_POST['ide_ant']." AND i.id_hitos = h.id AND h.estado NOT IN ('PENDIENTE','EN EJECUCIÓN')";

        $pai7 = mysql_query($sql7); 

		$rs_pai7 = mysql_fetch_assoc($pai7);
		
		if($rs_pai7['cuenta'])
			echo '<p style="color:red;">&iexcl;Atenci&oacute;n! Est&aacute; a punto de aprobar un anticipo cuyos hitos asociados pueden estar ejecutados.</p>';
?>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
	<input value="<?=$_POST['ide_ant']?>" type="hidden" id="id" name="id"/>
    <table class="formulario">
        <tbody>
            <tr> 
                <td>Seleccione el banco de la transacci&oacute;n</td>
            </tr>
            <tr>
                <td><? $sqlPry = "SELECT * FROM bancos"; 
					$qrPry = mysql_query($sqlPry);
					?>
                	<select name="nombre_banco" id="nombre_banco" class="required chosen-select">
                        <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>
                        <option value="<?=$rsPry['id']?>"><?=$rsPry['nombre_banco']?></option>
                        <? } ?>
					</select>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <input name="aprobar" type="submit" id="aprobar" value="Aprobar" />
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
		
		$('input').setMask();	
	});
	
	function fn_agregar(){
		var str = $("#frm_per").serialize();
		$.ajax({
			url: 'ajax_aprobar_anticipo.php',
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