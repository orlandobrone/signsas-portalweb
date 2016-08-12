<? header('Content-type: text/html; charset=iso-8859-1');
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}

	include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("select * from ordencompra WHERE id=%s",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen esta numero de compra";
		exit;
	}
	
	$rs_per = mysql_fetch_assoc($per);
	
?>
<h1>Modificar Factura</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
    <table class="formulario">
        <tbody>
            <tr>
                <td>Orden Compra</td>
                <td><?=$rs_per['orden_compra'];?></td>
            </tr>
            <tr>
                <td>Fecha Ingreso</td>
                <td><?=$rs_per['fecha'];?></td>
            </tr>
            <tr>
                <td>N&ordm;. Factura</td>
                <td><input name="num_factura" type="text" id="num_factura" size="40" class="required" value="<?=$rs_per['num_factura']?>"/></td>
            </tr>
            <tr>
                <td>Retenci&oacute;n</td>
                <td><input name="retencion" type="text" id="retencion" size="40" class="required" value="<?=$rs_per['retencion']?>" alt="decimal-us"/></td>
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
				var respuesta = confirm('\xBFDesea realmente modificar esta factura?')
				if (respuesta)
					form.submit();
			}
		});
		
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