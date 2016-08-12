<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";

?>

<h1>Agregando nuevo material</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_agregar();" method="post" id="frm_per">

    <table class="formulario">

        <tbody>

            <tr>

                <td>Nombre Material</td>

                <td><input name="nommat" type="text" id="nommat" size="40" class="required" /></td>

            </tr>

            <tr>

                <td>C&oacute;digo</td>

                <td><input name="codigo" type="text" id="codigo" size="40" class="required" alt="decimal-us" /></td>

            </tr>
            
            <tr>
                <td>L&iacute;nea</td>
                <td>
                	<input name="linea" type="text" id="linea" size="40" class="required"/>
                </td>
            </tr>

            <tr>

                <td>Ubicaci&oacute;n</td>

                <td><input name="ubicacion" type="text" id="ubicacion" size="40" class="required" alt="decimal-us" /></td>

            </tr>

            <tr>

                <td>Descripci&oacute;n</td>

                <td><input name="descri" type="text" id="descri" size="40" class="required" /></td>

            </tr>

            <tr style="display:none">

                <td>Cantidad</td>

                <td><input name="cantid" type="text" id="cantid" size="40"/></td>

            </tr>

            <tr style="display:none">

                <td>Costo Unitario</td>

                <td><input name="cosuni" type="text" id="cosuni" size="40" alt="decimal-us" /></td>

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

				var respuesta = confirm('\xBFDesea realmente agregar este nuevo material?')

				if (respuesta)

					form.submit();

			}

		});

		$('#cantid').setMask('9999999');

		$('#cosuni').setMask();

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