<? header('Content-type: text/html; charset=iso-8859-1');

	if(empty($_POST['ide_per'])){

		echo "Por favor no altere el fuente";

		exit;

	}



	include "../extras/php/basico.php";

	include "../../conexion.php";



	$sql = sprintf("select * from inventario where id=%d",

		(int)$_POST['ide_per']

	);

	$per = mysql_query($sql);

	$num_rs_per = mysql_num_rows($per);

	if ($num_rs_per==0){

		echo "No existe material con ese ID";

		exit;

	}

	

	$rs_per = mysql_fetch_assoc($per);

	

?>

<h1>Modificando material</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_modificar();" method="post" id="frm_per">

	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />

    <table class="formulario">

        <tbody>

            <tr>

                <td>Nombre Material</td>

                <td><input name="nommat" type="text" id="nommat" size="40" class="requisssred" value="<?=$rs_per['nombre_material']?>" /></td>

            </tr>

             <tr>

                <td>C&oacute;digo</td>

                <td><input name="codigo" type="text" id="codigo" size="40" class="required" value="<?=$rs_per['codigo']?>"/></td>

            </tr>

            <tr>

                <td>Ubicaci&oacute;n</td>

                <td><input name="ubicacion" type="text" id="ubicacion" size="40" class="required" value="<?=$rs_per['ubicacion']?>"/></td>

            </tr>  

            <tr>

                <td>Descripci&oacute;n</td>

                <td><input name="descri" type="text" id="descri" size="40" class="required" value="<?=$rs_per['descripcion']?>" /></td>

            </tr>

            <tr>

                <td>Cantidad</td>

                <td><input name="cantid" type="text" id="cantid" size="40" class="required" value="<?=$rs_per['cantidad']?>" /></td>

            </tr>

            <tr>

                <td>Costo Unitario</td>

                <td><input name="cosuni" type="text" id="cosuni" size="40" class="required" alt="decimal-us"  value="<?=$rs_per['costo_unidad']?>" /></td>

            </tr>

            

        </tbody>

        <tfoot>

            <tr>

                <td colspan="2">
                	<? if(in_array(82,$_SESSION['permisos'])): ?>
                    <input name="modificar" type="submit" id="modificar" value="Modificar" />
                    <? endif; ?>

                    <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" />

                </td>

            </tr>

        </tfoot>

    </table>

</form>

<script language="javascript" type="text/javascript">

	$(document).ready(function(){

		$("#frm_per").validate({

			submitHandler: function(form) {

				var respuesta = confirm('\xBFDesea realmente modificar este material?')

				if (respuesta)

					form.submit();

			}

		});

		$('#cantid').setMask('9999999');

		$('#cosuni').setMask();

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