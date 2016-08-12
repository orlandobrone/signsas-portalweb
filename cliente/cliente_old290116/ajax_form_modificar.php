<? header('Content-type: text/html; charset=iso-8859-1');

	if(empty($_POST['ide_per'])){

		echo "Por favor no altere el fuente";

		exit;

	}



	//include "../extras/php/basico.php";

	include "../../conexion.php";



	$sql = sprintf("select * from cliente where id=%d",

		(int)$_POST['ide_per']

	);

	$per = mysql_query($sql);

	$num_rs_per = mysql_num_rows($per);

	if ($num_rs_per==0){

		echo "No existen clientes con ese ID";

		exit;

	}

	

	$rs_per = mysql_fetch_assoc($per);

	

?>

<h1>Modificando usuario</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_modificar();" method="post" id="frm_per">

	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />

    <table class="formulario">

        <tbody>

            <tr>

                <td>Persona Natural / Jur&iacute;dica</td>

                <td>

                	<select name="natjur" id="natjur" class="required">

                    	<option value=""></option>

                        <option value="N" <? if('N'==$rs_per['natural_juridico']) echo "selected='selected'";?>>Persona Natural</option>

                        <option value="J" <? if('J'==$rs_per['natural_juridico']) echo "selected='selected'";?>>Persona Jur&iacute;dica</option>

					</select>

                </td>

            </tr>

            <tr>

                <td>Nombre</td>

                <td><input name="nombre" type="text" id="nombre" size="40" class="requisssred" value="<?=$rs_per['nombre']?>" /></td>

            </tr>

            <tr>

                <td>Descripci&oacute;n</td>

                <td><input name="descri" type="text" id="descri" size="40" class="required" value="<?=$rs_per['descripcion']?>" /></td>

            </tr>

            <tr>

                <td>Persona de Contacto</td>

                <td><input name="percon" type="text" id="percon" size="40" class="required" value="<?=$rs_per['persona_contacto']?>" /></td>

            </tr>

            <tr>

                <td>Tel&eacute;fono de Contacto</td>

                <td><input name="telefo" type="text" id="telefo" size="40" class="required" value="<?=$rs_per['telefono']?>" /></td>

            </tr>

            <tr>

                <td>Celular de Contacto</td>

                <td><input name="celula" type="text" id="celula" size="40" class="required" value="<?=$rs_per['celular']?>" /></td>

            </tr>

            <tr>

                <td>E-mail de Contacto</td>

                <td><input name="email" type="text" id="email" size="30" class="required email" value="<?=$rs_per['email']?>" /></td>

            </tr>
            
            <tr>

                <td>Suministro (d&iacute;as)</td>

                <td><input name="suministro" type="text" id="suministro" size="30" class="required" value="<?=$rs_per['suministro']?>"/></td>

            </tr>
            
            <tr>

                <td>Servicios (d&iacute;as)</td>

                <td><input name="servicios" type="text" id="servicios" size="30" class="required" value="<?=$rs_per['servicios']?>"/></td>

            </tr>
            
            <tr>

                <td>Otros Servicios (d&iacute;as)</td>

                <td><input name="otros_servicios" type="text" id="otros_servicios" size="30" class="required" value="<?=$rs_per['otros_servicios']?>"/></td>

            </tr>
            
            <tr>

                <td>D&iacute;as Vencimiento Pago (d&iacute;as)</td>

                <td><input name="dias_vencimiento_pago" type="text" id="dias_vencimiento_pago" size="30" class="required" value="<?=$rs_per['dias_vencimiento_pago']?>"/></td>

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

				var respuesta = confirm('\xBFDesea realmente modificar a este cliente?')

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