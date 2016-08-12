<? header('Content-type: text/html; charset=iso-8859-1');
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}

	include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("select * from proveedor where id=%d",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen proveedores con ese ID";
		exit;
	}
	
	$rs_per = mysql_fetch_assoc($per);
	
?>
<h1>Modificando usuario</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
    <table class="formulario" style="float:left;">
        <tbody>
            <tr>
                <td>Persona Natural / Jur&iacute;dica</td>
                <td>
                	<select name="natjur" ide="natjur" class="required">
                    	<option value=""></option>
                        <option value="N" <? if('N'==$rs_per['natural_juridico']) echo "selected='selected'";?>>Persona Natural</option>
                        <option value="J" <? if('J'==$rs_per['natural_juridico']) echo "selected='selected'";?>>Persona Jur&iacute;dica</option>
                        <option value="N/A" <? if('N/A'==$rs_per['natural_juridico']) echo "selected='selected'";?>>N/A</option>
					</select>
                </td>
            </tr>           
            <tr>
                <td>Raz&oacute;n Social *</td>
                <td><input name="nombre" type="text" id="nombre" size="40" class="required" value="<?=$rs_per['nombre']?>" /></td>
            </tr>
            <tr>
                <td>NIT *</td>
                <td><input name="nit" type="text" id="nit" size="40" class="required" value="<?=$rs_per['nit']?>" /></td>
            </tr>
            <tr>
                <td>Regimen *</td>
                <td><input name="regimen" type="text" id="regimen" size="40" class="required" value="<?=$rs_per['regimen']?>" /></td>
            </tr>
            <tr>
                <td>Contacto *</td>
                <td><input name="percon" type="text" id="percon" size="40" class="required" value="<?=$rs_per['persona_contacto']?>" /></td>
            </tr>
            <tr>
                <td>Correo</td>
                <td><input name="email" type="text" id="email" size="40" value="<?=$rs_per['email']?>" /></td>
            </tr>            
            <tr>
                <td>Otro Correo</td>
                <td><input name="otro_correo" type="text" id="otro_correo" size="40" value="<?=$rs_per['otro_email']?>" /></td>
            </tr>
            <tr>
                <td>Tel Fijo *</td>
                <td><input name="telefono" type="text" id="telefono" size="40" class="required" value="<?=$rs_per['telefono']?>" /></td>
            </tr>
       </tbody>
   </table>
   <table class="formulario" style="float:left;">
        <tbody>
            <tr>
                <td>Fax</td>
                <td><input name="fax" type="text" id="fax" size="30" value="<?=$rs_per['fax']?>" /></td>
            </tr>
             <tr>
                <td>Celular *</td>
                <td><input name="celular" type="text" id="celular" size="30" class="required" value="<?=$rs_per['celular']?>" /></td>
            </tr>
             <tr>
                <td>Direcci&oacute;n *</td>
                <td><input name="direccion" type="text" id="direccion" size="30" class="required" value="<?=$rs_per['direccion']?>" /></td>
            </tr>
             <tr>
                <td>Ciudad *</td>
                <td><input name="ciudad" type="text" id="ciudad" size="30" class="required" value="<?=$rs_per['ciudad']?>" /></td>
            </tr>
             <tr>
                <td>Plazo de Pago</td>
                <td><input name="plazo" type="text" id="plazo" size="30" value="<?=$rs_per['plazo_pago']?>" /></td>
            </tr>
             <tr>
                <td>Actividad o Producto</td>
                <td><input name="actividad" type="text" id="actividad" size="30" value="<?=$rs_per['descripcion']?>" /></td>
            </tr>
             <tr>
                <td>Banco</td>
                <td><input name="banco" type="text" id="banco" size="30" value="<?=$rs_per['banco']?>" /></td>
            </tr>
             <tr>
                <td>No. Cuenta</td>
                <td><input name="cuenta" type="text" id="cuenta" size="30" value="<?=$rs_per['cuenta_banco']?>" /></td>
            </tr>
             <tr>
                <td>Tipo de Cuenta</td>
                <td><input name="tipo_cuenta" type="text" id="tipo_cuenta" size="30" value="<?=$rs_per['tipo_cuenta']?>" /></td>
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
		
		$("#frm_per select").chosen({width:"220px"});
		$("#frm_per").validate({
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente modificar a este proveedor?')
				if (respuesta)
					form.submit();
			}
		});
		$('#telefo').setMask('(999) 999-9999');
		$('#celula').setMask('(999) 999-9999');
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