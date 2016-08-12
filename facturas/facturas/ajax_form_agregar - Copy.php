<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";

?>

<div id="content_mercancia">

<h1>Agregando ingreso de mercancia</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_agregar();" method="post" id="frm_per">

    <table class="formulario">

        <tbody>

            <tr>

                <td>Material</td>

                <td><? $sqlMat = sprintf("select * from inventario order by nombre_material ASC");

							$perMat = mysql_query($sqlMat);

							$num_rs_per_mat = mysql_num_rows($perMat); ?>

                	<select name="material" class="required chosen-select" id="material">

                    	<? while ($rs_per_mat = mysql_fetch_assoc($perMat)) { ?>

                        <option value="<? echo $rs_per_mat['id']; ?>"><?php echo $rs_per_mat['codigo'].'-'.$rs_per_mat['nombre_material']; ?></option>

						<? } ?>

					</select>

                </td>

            </tr>

            <tr>

                <td>Cantidad</td> 

                <td><input name="cantidad" type="text" id="cantidad" size="40" class="required" /></td>

            </tr>

            <tr>

                <td>Costo</td>

                <td><input name="costo" type="text" id="costo" size="40" class="required" alt="decimal-us"/></td>

            </tr>

            <tr>

                <td>N&ordm; de factura</td>

                <td><input name="nfactura" type="text" id="nfactura" size="40" class="required" /></td>

            </tr>

            <tr>

                <td>Proveedor</td>

                <td><? $sqlProveedor = sprintf("select * from proveedor");

							$perProveedor = mysql_query($sqlProveedor);

							$num_rs_per_pro = mysql_num_rows($perProveedor); ?>

                	<select name="proveedor" class="required" id="proveedor">

                    	<? while ($rs_per_pro = mysql_fetch_assoc($perProveedor)) { ?>

                        <option value="<? echo $rs_per_pro['id']; ?>"><?php echo ($rs_per_pro['nombre']); ?></option>

						<? } ?>

				</select>

                 <a id="agregar_proveedor" href="javascript:">Agregrar Proveedor</a>

                </td>

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

</div>



<div id="content_proveedor" style="display:none;">



<h1>Agregando nuevo proveedor</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_agregar_proveedor();" method="post" id="frm_proveedor">

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

        </tbody>

        <tfoot>

            <tr>

                <td colspan="2">

                    <input name="agregar" type="submit" id="agregar" value="Agregar" />

                    <input name="cancelar" type="button" id="btn-cancelar" value="Volver"/>

                </td>

            </tr>

        </tfoot>

    </table>

</form>

</div>



<link rel="stylesheet" href="/js/chosen/chosen.css">

<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 

<script language="javascript" type="text/javascript">

	$(document).ready(function(){

		

		$("#frm_per select, #frm_proveedor select").chosen({width:"320px"});		

		

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

				var respuesta = confirm('\xBFDesea realmente agregar el ingreso de mercancia?')

				if (respuesta)

					form.submit();

			}

		});

		

		$('input').setMask(); 			

		

		$('#telefo').setMask('(999) 999-9999');

		$('#celula').setMask('(999) 999-9999');		

		

		$('#agregar_proveedor').click(function(){

			$('#content_mercancia').slideUp();

		 	$('#content_proveedor').slideDown('slow');	

		});

		

		$('#btn-cancelar').click(function(){

			$('#content_proveedor').slideUp();

		 	$('#content_mercancia').slideDown('slow');	

		});

		

		/* Validacion del formulario agregar materiales */

		$("#frm_proveedor").validate({

			rules:{

				usu_per:{

					required: true,

					remote: "/proveedor/proveedor/ajax_verificar_usu_per.php"

				}

			},

			messages: {

				usu_per: "x"

			},

			onkeyup: false,

			submitHandler: function(form) {

				var respuesta = confirm('\xBFDesea realmente agregar este nuevo Proveedor?')

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

	

	

	function fn_agregar_proveedor(){

		var str = $("#frm_proveedor").serialize();

		$.ajax({

			url: '/proveedor/proveedor/ajax_agregar.php',

			data: str,

			type: 'post',

			success: function(data){

				if(data != "") {

					alert(data);

				}else{

					$.getJSON('/ajax/choseProveedores.php', function (data) {

							var options = $('#proveedor'); 

							$('#proveedor').empty()

							$('#proveedor').append('<option value="">Seleccione una opcion</option>');	

							

							$.each(data, function (i, v) {

								options.append($("<option></option>").val(v.id).text(v.label));

							});						

							

							$('#content_proveedor').slideUp();

		 					$('#content_mercancia').slideDown('slow');

							

							$("#frm_per select").trigger("chosen:updated");

					});		

				}

			}

		});

	};

</script>