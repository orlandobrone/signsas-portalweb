<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";

?>

<!--Hoja de estilos del calendario -->

<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">





<!-- The main CSS file -->

<link href="/js/upload/assets/css/style.css" rel="stylesheet" />



<!-- librería principal del calendario -->

<script type="text/javascript" src="../../calendario/calendar.js"></script>



<!-- librería para cargar el lenguaje deseado -->

<script type="text/javascript" src="../../calendario/calendar-es.js"></script>



<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->

<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>

<h1>Agregando nuevo veh&iacute;culo</h1>

<style>

#frm_per input{

	width:80px;

}

table.formulario, #upload { margin:0 !important; }

</style>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_agregar();" method="post" id="frm_per" style="float:left; width:338px;margin-right: 30px;">

    <table class="formulario">

        <tbody>

           

            <tr>

                <td>Placa:</td>

                <td><input name="placa" type="text" id="placa" size="6" class="required" /></td> 

            </tr>

            <tr>

                <td>Marca:</td>

                <td><input name="marca" type="text" id="marca" size="40" class="required" /></td>

            </tr>

            

           <tr>

                <td>Fecha Vencimiento SOAT:</td>

                <td><input name="soat" type="text" id="soat" size="40" class="required fechas" />

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "soat",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador"   // el id del botón que lanzará el calendario

					});

				</script></td>

            </tr> 

            

            <tr>

                <td>Fecha revisi&oacute;n TM:</td>

                <td><input name="tm" type="text" id="tm" size="40" class="required fechas" />

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "tm",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador2"   // el id del botón que lanzará el calendario

					});

				</script></td>

            </tr> 

            

            <tr>

                <td>Fecha &uacute;ltimo cambio de aceite:</td>

                <td><input name="aceite" type="text" id="aceite" size="40" class="required fechas" />

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador3" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "aceite",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador3"   // el id del botón que lanzará el calendario

					});

				</script></td>

            </tr> 

            

            <tr>

                <td>Regi&oacute;n</td>

                <td><input type="hidden" name="lugeje" type="text" id="lugeje" size="40" />

                	<select name="region" id="region" class="required chosen-select">

                    	<option value=""></option>

						<?

                            $sql = "select * from regional ORDER BY region ASC";

                            $pai = mysql_query($sql);

                            while($rs_pai = mysql_fetch_assoc($pai)){

                        ?>

                            <option value="<?=$rs_pai['region']?>"><?=$rs_pai['region']?></option>

                        <? } ?>

					</select>

                </td>

            </tr>

            <tr>

                <td>Valor Hora:</td>

                <td><input name="valor_hora" type="text" id="valor_hora" size="40" class="required" alt="integer" /></td>

            </tr>
            
            <tr>

                <td>Estado:</td> 
                <td>
                	<select name="estado" id="estado" class="required chosen-select">
                    	<option value="0">Activo</option>
                        <option value="1">No Activo</option>
                    </select>
				</td>
            </tr>

        </tbody>

    </table>

    <div id="plantillas">

    

    </div>

</form>



<form id="upload" method="post" action="/upload.php" enctype="multipart/form-data" style="float:left;margin-left: 65px;">

	<h3 style="color:#FFF;">Plantillas (Suba aca sus archivos):</h3>

    <div id="drop">Coloque aqu&iacute;

        <a>Buscar</a>

        <input type="file" name="upl" multiple />

    </div>



    <ul>

        <!-- The file uploads will be shown here -->

    </ul>



</form>



<div style="clear:both;"></div>



<div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

    	<input name="agregar" type="submit" id="agregar" value="Agregar" class="btn_table"/>

        <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" class="btn_table"/>

</div>

                







<!-- Our main JS file -->

<script src="/js/upload/assets/js/script.js"></script>





<script language="javascript" type="text/javascript">

	$(document).ready(function(){

		

		$('input').setMask();

		

		$(".btn_table").jqxButton({ theme: theme });

		

		$('#agregar').click(function(){

			$('#frm_per').submit();

		});

		

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

				var respuesta = confirm('\xBFDesea realmente agregar a este nuevo veh\xCDculo?')

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