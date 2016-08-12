<? header('Content-type: text/html; charset=iso-8859-1');
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}

	include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("select * from comercial where id=%d",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen comerciales con ese ID";
		exit;
	}
	
	$rs_per = mysql_fetch_assoc($per);
	
?>
<h1>Modificando solicitud de despacho</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
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
                            <option value="<?=$rowsCliente['id']?>" <? if($rowsCliente['id']==$rs_per['id_cliente']) echo "selected='selected'";?>><?=$rowsCliente['nombre']?></option>
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
                        <option value="<?=$rsUsuario['id']?>" <? if ($rsUsuario['id'] == $rs_per['id_usuario']) echo 'selected="selected"'; ?>><?=$rsUsuario['nombres']?></option>
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
                            <option value="<?=$rowsCot['id']?>" <? if($rowsCot['id']==$rs_per['id_cotizacion']) echo "selected='selected'";?>><?=$rowsCot['nombre']?></option>
                        <? } ?>
					</select>
                </td>
            </tr>
            <tr>
                <td>Otorgado</td>
                <td><select name="otorgado" id="otorgado">
                <option <? if($rs_per['otorgado'] == 'Si') echo "selected='selected'";?>>Si</option>
                <option <? if($rs_per['otorgado'] == 'No') echo "selected='selected'";?>>No</option>
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
		
		$("#frm_per select").chosen({width:"250px"});
		$("#frm_per").validate({
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente modificar la solicitud de despacho?')
				if (respuesta)
					form.submit();
			}
		});
		$('#telefono').setMask('999-9999');
		$('#celular').setMask('(999) 999-9999');
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