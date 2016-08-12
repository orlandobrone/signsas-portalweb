<? header('Content-type: text/html; charset=iso-8859-1');
   include "../../conexion.php";
?>

<h1>Agregando Responsable</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_agregar();" method="post" id="frm_per">

    <table class="formulario">

        <tbody>

            <tr>
              <td>Regi&oacute;n</td>
              <td>
              	 <? $sqlPry = "SELECT * FROM regional ORDER BY region ASC"; 
                    $qrPry = mysql_query($sqlPry);
                 ?>
                 <select class="chosen-select required var_ordenes" name="regional">
                 	 <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>

                        <option value="<?=$rsPry['id']?>" <?php echo ($rsPry['id']==$rs_per['id_regional'])? 'selected="selected"': '';?>><?=$rsPry['region']?></option> 

                     <? } ?>
                 </select>   
              </td>
            </tr>

            <tr>
                <td>Nombre</td>
                <td>
                	<input name="nombre" type="text" id="nombre" size="40" class="required" />
                </td>
            </tr>
            
            <tr>
                <td>Cedula</td>
                <td>
                	<input name="cedula" type="text" id="cedula" size="40" class="required" alt="integer" />
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
				var respuesta = confirm('\xBFDesea realmente agregar esta nueva regional?')
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