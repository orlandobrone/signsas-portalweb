<? header('Content-type: text/html; charset=iso-8859-1');
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}

	include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("select * from ingreso_mercancia where id=%d",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen ingreso de mercancia con ese ID";
		exit;
	}
	
	$rs_per = mysql_fetch_assoc($per);
	
?>
<h1>Modificar ingreso de mercancia</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
    <table class="formulario">
        <tbody>
            <tr>
                <td>Material</td>
                <td>
                	<? $sqlMat = sprintf("select * from inventario");
							$perMat = mysql_query($sqlMat);
							$num_rs_per_mat = mysql_num_rows($perMat); ?>
                	<select name="material" class="required" id="material">
                    	<? while ($rs_per_mat = mysql_fetch_assoc($perMat)) { ?>
                        <option value="<? echo $rs_per_mat['id']; ?>" <? if ($rs_per_mat['id'] == $rs_per['id_material']) echo 'selected="selected"'; ?>><?php echo ($rs_per_mat['nombre_material']); ?></option>
						<? } ?>
					</select>
                </td>
            </tr>
            <tr>
                <td>Cantidad</td>
                <td><input name="cantidad" type="text" id="cantidad" size="40" class="requisssred" value="<?=$rs_per['cantidad']?>" /></td>
            </tr>
            <tr>
                <td>Costo</td>
                <td><input name="costo" type="text" id="costo" size="40" class="required" value="<?=$rs_per['costo']?>" alt="decimal-us"/></td>
            </tr>
            <tr>
                <td>N&ordm; de factura</td>
                <td><input name="nfactura" type="text" id="nfactura" size="40" class="required" value="<?=$rs_per['nfactura']?>" /></td>
            </tr>
            <tr>
                <td>Proveedor</td>
                <td><? $sqlProveedor = sprintf("select * from proveedor");
							$perProveedor = mysql_query($sqlProveedor);
							$num_rs_per_pro = mysql_num_rows($perProveedor); ?>
                	<select name="proveedor" class="required" id="proveedor">
                    	<? while ($rs_per_pro = mysql_fetch_assoc($perProveedor)) { ?>
                        <option value="<? echo $rs_per_pro['id']; ?>" <? if ($rs_per_pro['id'] == $rs_per['id_proveedor']) echo 'selected="selected"'; ?>><?php echo ($rs_per_pro['nombre']); ?></option>
						<? } ?>
				</select></td>
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
		
		$("#frm_per select").chosen({width:"320px"});
		
		$("#frm_per").validate({
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente modificar el ingreso de mercancia?')
				if (respuesta)
					form.submit();
			}
		});
		$('#telefo').setMask('(999) 999-9999');
		$('#celula').setMask('(999) 999-9999');
		
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