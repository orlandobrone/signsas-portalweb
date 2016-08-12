<? header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
?>
<h1>Agregando nueva solicitud de despacho</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
    <table class="formulario">
        <tbody>
        	<tr>
                <td>Cliente</td>
                <td>
                	<select name="cliente" ide="cliente" class="required">
                    	<option value=""></option>
						<?
                            $sqlCliente = "select * from cliente order by id asc";
                            $qrCliente = mysql_query($sqlCliente);
                            while($rowsCliente = mysql_fetch_assoc($qrCliente)){
                        ?>
                            <option value="<?=$rowsCliente['id']?>"><?=$rowsCliente['nombre']?></option>
                        <? } ?>
					</select>
                </td>
            </tr>
            <tr>
                <td>Usuario</td>
                <td><? $sqlUsuario = "SELECT nombres, id FROM usuario"; 
					$qrUsuario = mysql_query($sqlUsuario);
					?>
                	<select name="usuario" id="usuario" class="required">
                        <? while ($rsUsuario = mysql_fetch_array($qrUsuario)) { ?>
                        <option value="<?=$rsUsuario['id']?>"><?=$rsUsuario['nombres']?></option>
                        <? } ?>
					</select>
                </td>
            </tr>
            <tr>
                <td>Cotizaci&oacute;n</td>
                <td>
                	<select name="cotizacion" ide="cotizacion" class="required">
                    	<option value=""></option>
						<?
                            $sqlCot = "SELECT * FROM `cotizacion` AS coti WHERE NOT EXISTS(SELECT * FROM comercial AS come WHERE coti.id = come.id_cotizacion) order by coti.id asc";
                            $qrCot = mysql_query($sqlCot);
                            while($rowsCot = mysql_fetch_assoc($qrCot)){
                        ?>
                            <option value="<?=$rowsCot['id']?>"><?=$rowsCot['nombre']?></option>
                        <? } ?>
					</select>
                </td>
            </tr>
            <tr>
                <td>Otorgado</td>
                <td><select name="otorgado" id="otorgado">
                <option>Si</option>
                <option>No</option>
                </select></td>
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
		
		$("#frm_per select").chosen({width:"250px"});
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
				var respuesta = confirm('\xBFDesea realmente agregar a comercial?')
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