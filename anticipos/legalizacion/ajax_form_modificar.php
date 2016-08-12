<? 	header('Content-type: text/html; charset=iso-8859-1');

	if(empty($_POST['ide_per'])){

		echo "Por favor no altere el fuente";

		exit;

	}



	include "../extras/php/basico.php";

	include "../../conexion.php";



	$sql = sprintf("select * from legalizacion where id=%d",

		(int)$_POST['ide_per']

	);

	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen esta legalizaci&oacute;n con ese ID";
		exit;
	}
	$rs_per = mysql_fetch_assoc($per);

	

	$letters = array('.','$',',');

	$fruit   = array('');

	$valor_legalizado = 0;

	$reintegro = 0;

	$valor_pagar = 0; 

	

	$resultado = mysql_query("SELECT pagado FROM items WHERE id_legalizacion =".(int)$_POST['ide_per']) or die(mysql_error());

	$total = mysql_num_rows($resultado);

	while ($rows = mysql_fetch_assoc($resultado)):

		if($rows['pagado'] != 0):

			$valor = explode(',00',$rows['pagado']);

			$valor2 = str_replace($letters, $fruit, $valor[0] );

			$valor_legalizado += $valor2;

		endif;

	endwhile;

	$valor = substr($rs_per['valor_fa'],0, -3);
	$valor_fondo = str_replace($letters, $fruit, $valor);		

	if($valor_legalizado != 0 ):			

		$reintegro = $valor_fondo - $valor_legalizado;

	endif;

	

	if($valor_legalizado > $valor_fondo):			

		$valor_pagar = $valor_legalizado - $valor_fondo;

		$reintegro = 0;

	endif;

	

	$valor_pagar = $valor_pagar.',00';

	$valor_reintegro = $reintegro.',00';

	$valor_legalizado = $valor_legalizado.',00';

	

?>

<!--Hoja de estilos del calendario -->

<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">



<!-- librería principal del calendario -->

<script type="text/javascript" src="../../calendario/calendar.js"></script>



<!-- librería para cargar el lenguaje deseado -->

<script type="text/javascript" src="../../calendario/calendar-es.js"></script>



<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->

<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>

<h1>Modificando Legalizaci&oacute;n</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_modificar();" method="post" id="frm_per">

	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />   

     <table class="formulario">

        <tbody>

           

            <tr>

                <td>Responable</td>

                <td><input name="responsable" type="text" id="responsable" size="40" class="required" value="<?=$rs_per['responsable']?>"/></td> 

            </tr>

            <tr>

                <td>Fecha</td>

                <td><input name="fecha" type="text" id="fecha" readonly value="<?=$rs_per['fecha']?>"/>

                  <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "fecha",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador"   // el id del botón que lanzará el calendario

					});

				</script>

               </td>

            </tr>

            <tr>

                <td>No. de Anticipo</td>

                <td><input name="id_anticipo" type="text" id="id_anticipo" size="40" class="required" alt="integer" value="<?=$rs_per['id_anticipo']?>"/></td>

            </tr>

            <tr>

                <td>Valor fondo / anticipo</td>

                <td><input name="valor_fa" type="text" id="valor_fa" size="40" class="required" alt="decimal" value="<?=$rs_per['valor_fa']?>"/></td>

            </tr>

            <tr>

                <td>Valor Legalizado</td>

                <td><input name="valor_legalizado" type="text" id="valor_legalizado" size="40" class="required" alt="decimal" value="$<?=$valor_legalizado?>"/></td>

            </tr>

            <tr>

                <td>Valor a Pagar</td>

                <td><input name="valor_pagar" type="text" id="valor_pagar" size="40" class="required" alt="decimal" value="<?=$valor_pagar?>"/></td>

            </tr>

            <tr>

                <td>Legalizaci&oacute;n (L) o Reintego(R)</td>

                <td><input name="lega_rein" type="text" id="lega_rein" size="40" class="required" alt="decimal" value="<?=$valor_reintegro?>"/></td>

            </tr>

            

        </tbody>

        <tfoot>

            <tr>

                <td colspan="2">

                <?php if(in_array(202,$_SESSION['permisos']) && $rs_per['estado']==0):?>

                    <input name="agregar" type="submit" id="agregar" value="Modificar" />

                <?php endif; ?>

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

				var respuesta = confirm('\xBFDesea realmente modificar esta legalizacion?')  

				if (respuesta)

					form.submit();

			}

		});

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

					$("#jqxgrid").jqxGrid('updatebounddata', 'cells');

				}

			},

			error: function(err) {

				alert(err);

			}

		});

	};

</script>