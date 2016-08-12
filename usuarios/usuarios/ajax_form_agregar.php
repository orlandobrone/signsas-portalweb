<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";

?>

<h1>Agregando nuevo usuario</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_agregar();" method="post" id="frm_per">

    <table class="formulario">

        <tbody>

            <tr>

              <td>Nombres</td>

              <td><input name="nombres" type="text" id="nombres" size="40" class="required" /></td>

            </tr>

            <tr>

                <td>Usuario</td>

                <td><input name="usuario" type="text" id="usuario" size="40" class="required" /></td>

            </tr>

            <tr>

                <td>Email</td>

                <td><input name="email" type="text" id="email" size="40" class="required"/></td>

            </tr>

            <tr>

                <td>Contrase&ntilde;a</td>

                <td><input name="password" type="password" id="password" size="40" class="required" /></td>

            </tr>

            <tr>

              <td>Confirmar Contrase&ntilde;a</td>

              <td><input name="confirmar" type="password" id="confirmar" size="40" class="required" /></td>

            </tr>

            <tr>

                <td>Codigo Perfil</td>

                <? $qrPerfil = mysql_query("SELECT * FROM perfiles") or die(mysql_error()); ?>

                <td><select name="codigo_perfil" id="codigo_perfil">

                <? while ($rowsPerfil = mysql_fetch_array($qrPerfil)) { ?>

                  <option value="<?=$rowsPerfil['id']?>"><?=$rowsPerfil['nombre']?></option>

                <? } ?>

                </select></td>

            </tr>

            <tr>

                <td>Regional</td>

                <? $qrRegional = mysql_query("SELECT * FROM regional") or die(mysql_error()); ?>

                <td>
                    <select name="id_regional" id="id_regional">
                    
                    	<option value="0">Todos</option>
    
                    	<? while ($rowsRegional = mysql_fetch_array($qrRegional)) { ?>
                      	<option value="<?=$rowsRegional['id']?>"><?=$rowsRegional['region']?></option>
                    	<? } ?>
    
                    </select>
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

				if ($("#password").val() == $("#confirmar").val()) {

					if ($("#password").val().length >= 8) {

						var respuesta = confirm('\xBFDesea realmente agregar a este nuevo usuario?')

						if (respuesta)

							form.submit();

					}else{

						alert("Error: la contrase\xf1a debe tener minimo 8 caracteres");		

					}

				}else{

					alert("Error: por favor confirme la contraseña");	

				}

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