<? header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
?>
<h1>Agregando salida de mercancia</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
    <table class="formulario">
        <tbody>
            <tr>
                <td>Materiales</td>
                <td><? $sqlMat = sprintf("select * from inventario");
							$perMat = mysql_query($sqlMat);
							$num_rs_per_mat = mysql_num_rows($perMat); ?>
                	<select name="material" class="required" id="material" onchange="javascript: cargar_costo_unidad(this.value);">
                    	<option value="">Seleccione una opci&oacute;n</option>
                    	<? while ($rs_per_mat = mysql_fetch_assoc($perMat)) { ?> 
                        <option value="<? echo $rs_per_mat['id']; ?>"><?=$rs_per_mat['codigo'].'->'.$rs_per_mat['nombre_material']; ?></option>
						<? } ?>
					</select>
                </td>
            </tr>
            <tr>
                <td>Cantidad</td>
                <td><input type="hidden" name="costo_unidad" id="costo_unidad" value="0" /> <input type="hidden" name="cantidadInv" id="cantidadInv" value="0" />                 
                <input name="cantidad" type="text" id="cantidad" value="0" size="40" class="required" onkeyup="javascript: $('#costo').val(parseInt(this.value)*parseFloat($('#costo_unidad').val()));" /></td>
            </tr>
            <tr>
                <td>Costo</td>
                <td><input name="costo" type="text" id="costo" size="40" class="required" readonly="readonly" alt="decimal-us" /></td>
            </tr>
            <tr>
                <td>Proyectos</td>
                <td><? $sqlPry = "SELECT nombre, id FROM proyectos"; 
					$qrPry = mysql_query($sqlPry);
					?>
                	<select name="proyecto" id="proyecto" class="required">
                        <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>
                        <option value="<?=$rsPry['id']?>"><?=$rsPry['nombre']?></option>
                        <? } ?>
					</select></td>
            </tr>
            <tr>
              <td>Solicitud Despacho</td>
              <td><? $sqlSol = "SELECT descripcion, id FROM solicitud_despacho"; 
					$qrSol = mysql_query($sqlSol);
					?>
                	<select name="solicitud_despacho" id="solicitud_despacho" class="required">
                        <? while ($rsSol = mysql_fetch_array($qrSol)) { ?>
                        <option value="<?=$rsSol['id']?>"><?=$rsSol['descripcion']?></option>
                        <? } ?>
					</select></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
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
		$("#material").chosen({width:"220px"}); 
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
				if (parseFloat($('#cantidadInv').val()) < parseFloat($('#cantidad').val())) {
					alert("Error: la cantidad no est\xe1 disponible en el inventario.");
				}else{
					var respuesta = confirm('\xBFDesea realmente agregar la salida de mercancia?')
					if (respuesta)
						form.submit();
				}
			}
		});
		$('#costo').setMask();
	
	});
	
	function fn_agregar(){
		var str = $("#frm_per").serialize();
		$.ajax({
			url: 'ajax_agregar.php',
			data: str,
			type: 'post',
			success: function(data){
				console.log(data) 
				if(!data.estado){				
					swal("Error", data.msj, "error");
				}else{
					fn_cerrar();	
					fn_buscar();
				}
			}
		});
	};
</script>