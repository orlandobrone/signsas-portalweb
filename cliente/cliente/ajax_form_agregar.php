<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";

?>



<h1>Agregando nuevo cliente</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_agregar();" method="post" id="frm_per">

    <table class="formulario">

        <tbody>

            <tr>

                <td>Persona Natural / Jur&iacute;dica</td>

                <td><select name="natjur" id="natjur" class="required">

                		<option value=""></option>

                        <option value="N">Persona Natural</option>

                        <option value="J">Persona Jur&iacute;dica</option>

                	</select>

                </td>

            </tr>

            <tr>

                <td>Nombre</td>

                <td><input name="nombre" type="text" id="nombre" size="40" class="required" /></td>

            </tr>

            <tr>

                <td>Descripci&oacute;n</td>

                <td><input name="descri" type="text" id="descri" size="40" class="required" /></td>

            </tr>

            <tr>

                <td>Persona de Contacto</td>

                <td><input name="percon" type="text" id="percon" size="40" class="required" /></td>

            </tr>

            <tr>

                <td>Tel&eacute;fono de Contacto</td>

                <td><input name="telefo" type="text" id="telefo" size="40" class="required" /></td>

            </tr>

            <tr>

                <td>Celular de Contacto</td>

                <td><input name="celula" type="text" id="celula" size="40" class="required" /></td>

            </tr>

            <tr>

                <td>E-mail de Contacto</td>

                <td><input name="email" type="text" id="email" size="30" class="required email" /></td>

            </tr>
            
            <tr>

                <td>Suministro (d&iacute;as)</td>

                <td><input name="suministro" type="text" id="suministro" size="30" class="required" /></td>

            </tr>
            
            <tr>

                <td>Servicios (d&iacute;as)</td>

                <td><input name="servicios" type="text" id="servicios" size="30" class="required" /></td>

            </tr>
            
            <tr>

                <td>Otros Servicios (d&iacute;as)</td>

                <td><input name="otros_servicios" type="text" id="otros_servicios" size="30" class="required" /></td>

            </tr>
            
            <tr>

                <td>D&iacute;as Vencimiento Pago (d&iacute;as)</td>

                <td><input name="dias_vencimiento_pago" type="text" id="dias_vencimiento_pago" size="30" class="required" /></td>

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

				var respuesta = confirm('\xBFDesea realmente agregar a este nuevo cliente?')

				if (respuesta)

					form.submit();

			}

		});

		$('#telefo').setMask('(999) 999-9999');

		$('#celula').setMask('(999) 999-9999');
		
		$('#suministro').setMask('9999999');
		
		$('#servicios').setMask('9999999');
		
		$('#otros_servicios').setMask('9999999');
		
		$('#dias_vencimiento_pago').setMask('9999999');

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

			},

			error: function (xhr, err) {

				alert(err);

				return false;

			}

		});

	};

</script>