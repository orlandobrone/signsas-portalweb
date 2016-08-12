<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";

?>

<!--Hoja de estilos del calendario -->

<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">



<!-- librería principal del calendario -->

<script type="text/javascript" src="../../calendario/calendar.js"></script>



<!-- librería para cargar el lenguaje deseado -->

<script type="text/javascript" src="../../calendario/calendar-es.js"></script>



<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->

<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>

<h1>Agregando nuevo precio de ACPM</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_agregar();" method="post" id="frm_per">

    <table class="formulario">

        <tbody>
        
        	 <tr>
            	  <td>Departamento:</td>
                  <td colspan="3">
						  <? $sqlPry = "SELECT * FROM ps_state"; 
                          $qrPry = mysql_query($sqlPry);
                          ?>
                          <select name="departamento" id="departamento" class="required chosen-select">
                              <option value=""></option>
							  <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>
                              <option value="<?=$rsPry['id']?>"><?=$rsPry['name']?></option>
                              <? } ?>
                          </select>
                  </td>            
             </tr>

            <tr>

                <td>Valor ACPM</td>

                <td><input name="value_acpm" type="text" id="value_acpm" size="40" class="required money" /></td>

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
		$(".money").maskMoney({ prefix:'$', allowNegative: true, thousands:'', decimal:',', affixesStay: false});
		

		$("#frm_per").validate({

			submitHandler: function(form) {

				var respuesta = confirm('\xBFDesea realmente agregar a este nuevo costo de ACPM?')

				if (respuesta)

					form.submit();

			}

		});

		

		//$('input').setMask();	

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
				}

			}

		});

	};

</script>