<? header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
?>
<h1>Agregando nuevo proveedor</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
    <table class="formulario" style="float:left;">
        <tbody>
            <tr>
                <td>Persona Natural / Jur&iacute;dica</td>
                <td><select name="natjur" id="natjur" class="required">
                		<option value=""></option>
                        <option value="N">Persona Natural</option>
                        <option value="J">Persona Jur&iacute;dica</option>
                        <option value="N/A">N/A</option>
                	</select>
                </td>
            </tr>
            <tr>
                <td>Raz&oacute;n Social *</td>
                <td><input name="nombre" type="text" id="nombre" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>NIT *</td>
                <td><input name="nit" type="text" id="nit" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Regimen *</td>
                <td><input name="regimen" type="text" id="regimen" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Contacto *</td>
                <td><input name="percon" type="text" id="percon" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Correo</td>
                <td><input name="email" type="text" id="email" size="40" /></td>
            </tr>            
            <tr>
                <td>Otro Correo</td>
                <td><input name="otro_correo" type="text" id="otro_correo" size="40"/></td>
            </tr>
            <tr>
                <td>Tel Fijo *</td>
                <td><input name="telefono" type="text" id="telefono" size="40" class="required" /></td>
            </tr>
       </tbody>
   </table>
   <table class="formulario" style="float:left;">
        <tbody>
            <tr>
                <td>Fax</td>
                <td><input name="fax" type="text" id="fax" size="30"/></td>
            </tr>
             <tr>
                <td>Celular *</td>
                <td><input name="celular" type="text" id="celular" size="30" class="required" /></td>
            </tr>
             <tr>
                <td>Direcci&oacute;n *</td>
                <td><input name="direccion" type="text" id="direccion" size="30" class="required" /></td>
            </tr>
             <tr>
                <td>Ciudad *</td>
                <td><input name="ciudad" type="text" id="ciudad" size="30" class="required" /></td>
            </tr>
             <tr>
                <td>Plazo de Pago</td>
                <td><input name="plazo" type="text" id="plazo" size="30"/></td>
            </tr>
             <tr>
                <td>Actividad o Producto</td>
                <td><input name="actividad" type="text" id="actividad" size="30"/></td>
            </tr>
             <tr>
                <td>Banco</td>
                <td><input name="banco" type="text" id="banco" size="30"/></td>
            </tr>
             <tr>
                <td>No. Cuenta</td>
                <td><input name="cuenta" type="text" id="cuenta" size="30"/></td>
            </tr>
             <tr>
                <td>Tipo de Cuenta</td>
                <td><input name="tipo_cuenta" type="text" id="tipo_cuenta" size="30"/></td>
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
				var respuesta = confirm('\xBFDesea realmente agregar a este nuevo proveedor?')
				if (respuesta)
					form.submit();
			}
		});
		$('#telefo').setMask('(999) 999-9999');
		$('#celula').setMask('(999) 999-9999');
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