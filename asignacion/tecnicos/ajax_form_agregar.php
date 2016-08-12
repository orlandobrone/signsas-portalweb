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

<h1>Agregando nuevo t&eacute;cnico</h1> 

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_agregar();" method="post" id="frm_per">

    <table class="formulario">

        <tbody>

            <tr>

                <td>Nombre T&eacute;cnico</td>

                <td><input name="nombre" type="text" id="nombre" size="40" class="required" /></td> 

            </tr>

            <tr>

                <td>Cedula</td>

                <td><input name="cedula" type="text" id="cedula" size="40" class="required" alt="integer" /></td>

            </tr>

            <tr>

                <td>ARP</td>

                <td><input name="arp" type="text" id="arp" size="40" class="required" /></td>

            </tr>

            <tr>

                <td>EPS</td>

                <td><input name="eps" type="text" id="eps" size="40" class="required" /></td>

            </tr>

            

            <tr>

                <td>Celular</td>

                <td><input name="celular" type="text" id="celular" size="40" class="required" /></td>

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

                <td>Cargo</td>

                <td>
                	<select name="cargo" id="cargo" class="required chosen-select">
                    	<option value=""></option>
                		<?  $sql = "SELECT DISTINCT (cargo) FROM tecnico ORDER BY cargo ASC";
                            $pai = mysql_query($sql);
                            while($rs_pai = mysql_fetch_assoc($pai)){
                        ?>
                            <option value="<?=$rs_pai['cargo']?>"><?=$rs_pai['cargo']?></option>
                        <? } ?>
                   </select>
                </td>

            </tr>

            
			<tr>

                <td>Estado</td>

                <td><select name="estado" id="estado" class="required chosen-select">
                    	<option value=""></option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </td>

            </tr>
            
            <tr>

                <td>Sueldo</td>

                <td><input name="sueldo" type="text" id="sueldo" size="40" class="required money" value="0" /></td>

            </tr>
            
            <tr>

                <td>Valor Plan</td>

                <td><input name="valor_plan" type="text" id="valor_plan" size="40" class="required money" value="0" /></td>

            </tr> 

            

        </tbody>

        

    </table>

    

     <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

    	<input name="agregar" type="submit" id="agregar" value="Agregar" class="btn_table"/>

        <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" class="btn_table"/>

	</div>

</form>

<script language="javascript" type="text/javascript">

	$(document).ready(function(){

		$(".btn_table").jqxButton({ theme: theme });

		

		$(".money").maskMoney({ prefix:'$', allowNegative: true, thousands:'.', decimal:',', affixesStay: false,allowZero:true});

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

				var respuesta = confirm('\xBFDesea realmente agregar este t\xE9cnico?')   

				if (respuesta)

					form.submit();

			}

		});
		
		$('#cargo').change(function(){
			var cargo = $(this).val();
			
			if(cargo == 'CONTRATISTA')
				$('#sueldo').val(0).prop('disabled', true);
			else
				$('#sueldo').prop('disabled', false);
				
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