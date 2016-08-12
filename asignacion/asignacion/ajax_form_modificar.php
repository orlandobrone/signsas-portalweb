<?  //header('Content-type: text/html; charset=iso-8859-1');
	
	if(empty($_POST['id'])){

		echo "Por favor no altere el fuente";

		exit;

	}



	include "../extras/php/basico.php";

	include "../../conexion.php";



	$sql = sprintf("select * from asignacion where id=%d",

		(int)$_POST['id']

	);

	$per = mysql_query($sql);

	$num_rs_per = mysql_num_rows($per);

	if ($num_rs_per==0){

		echo "No existen asignacion con ese ID";

		exit;

	}

	

	$rs_per = mysql_fetch_assoc($per);

	

	

	if($rs_per['id_hito'] != 0):

		

			if($row['id_vehiculo'] != 0):

				$sql2 = "SELECT 

							h.nombre AS nombre_hitos,

							t.nombre AS nombre_tecnico,

							v.placa AS placa

						 FROM `hitos` AS h

						 INNER JOIN  tecnico AS t ON t.id = ".$rs_per['id_tecnico']."

						 INNER JOIN  vehiculos AS v ON v.id = ".$rs_per['id_vehiculo']."

						 WHERE h.id =".$rs_per['id_hito'];

			else:

				

				$sql2 = "SELECT 

							h.nombre AS nombre_hitos,

							t.nombre AS nombre_tecnico

						 FROM `hitos` AS h

						 INNER JOIN  tecnico AS t ON t.id = ".$rs_per['id_tecnico']."

						 WHERE h.id =".$rs_per['id_hito'];

			endif;

	else:

			$sql2 = "SELECT 

						nombre AS nombre_tecnico

					 FROM `tecnico` 

					 WHERE id =".$rs_per['id_tecnico'];

	endif;

		

		//echo $sql2.'<br/>';

		

	$pai2 = mysql_query($sql2); 

	$rs_pai2 = mysql_fetch_assoc($pai2);

	

?>

<!--Hoja de estilos del calendario -->

<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">



<!-- librería principal del calendario -->

<script type="text/javascript" src="../../calendario/calendar.js"></script>



<!-- librería para cargar el lenguaje deseado -->

<script type="text/javascript" src="../../calendario/calendar-es.js"></script>



<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->

<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>



<link rel="stylesheet" href="/js/chosen/chosen.css">

<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 



<style>

.list_combo{ display:none; }

</style>

<h1>Asignar</h1> 

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_modificar();" method="post" id="frm_per">

	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />

    <table class="formulario">

        <tbody>

        	 <tr>

                <td>Fecha de Inicio</td>

                <td><input name="fecini" type="text" id="fecini" size="40" class="required" readonly value="<?=$rs_per['fecha_ini']?>" />

                  <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "fecini",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador"   // el id del botón que lanzará el calendario

					});

				</script></td>

            </tr> 

            

             <tr style="display:none;">

                <td>Fecha de Finalizaci&oacute;n<br /></td>

                <td><input name="fecfin" type="text" id="fecfin" size="40" readonly value="<?=$rs_per['fecha_fin']?>"/>

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "fecfin",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",    // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador2"   // el id del botón que lanzará el calendario

					});

				</script></td>

            </tr>

        

            

            <tr>

            	<td>Hora Inicio:</td> 

                <td>

                	Actual:<?=$rs_per['hora_inicio']?>

                	<div class='horas' id="hora_inicio" name="hora_inicio" value="<?=$rs_per['hora_inicio']?>"></div>

                </td>

            </tr>

            

            <tr>

            	<td>Hora Final:</td>

                <td>

                	Actual:<?=$rs_per['hora_final']?>

                	<div class='horas' name="hora_final" value="<?=$rs_per['hora_final']?>"></div>

                </td>

            </tr>

            <tr>

                <td colspan="2">
                
                     <input type="radio" id="disponible" name="disponible" value="Disponible" class="required" <?php echo ($rs_per['libre'] == 'Disponible')? 'checked="checked"':''; ?>/>  Disponible
                     <input type="radio" id="vacaciones" name="disponible" value="Vacaciones" class="required" <?php echo ($rs_per['libre'] == 'Vacaciones')? 'checked="checked"':''; ?>/>  Vacaciones
                     <input type="radio" id="incapacitado" name="disponible" value="Incapacitado" class="required" <?php echo ($rs_per['libre'] == 'Incapacitado')? 'checked="checked"':''; ?>/>  Incapacitado
                     <input type="radio" id="operando" name="disponible" value="Operando" class="required" <?php echo ($rs_per['libre'] == 'Operando')? 'checked="checked"':''; ?>/>  Operando             


               <!--  <input type="checkbox" id="disponible" name="disponible" />  Disponible            --> 

                </td>

            </tr>

            <tr>

                <td>Orden de Trabajo</td>

                <td>

                	<? $sqlPry = "SELECT * FROM orden_trabajo ORDER BY id ASC"; 

                    $qrPry = mysql_query($sqlPry);

                    ?>

                	<select name="id_ordonetrabajo" id="id_ordonetrabajo" class="required chosen-select">

                    	<option value=""></option>

                        <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>

                        <option value="<?=$rsPry['id_proyecto']?>" <?php if($rsPry['id_proyecto'] == $rs_per['id_ordentrabajo']): echo 'selected="selected"'; endif;?>>

							<?=$rsPry['orden_trabajo']?>

                        </option>

                        <? } ?>	

                    </select>

                </td> 

            </tr>

            <tr>

                <td>Hitos</td>

                <td>
                	<input name="hito_actual" type="hidden" value="<?=$rs_per['id_hito']?>">

                	<select name="hitos" id="hitos" class="required chosen-select">

                    <?php	

					$arrayEstados = array('LIQUIDADO','EN FACTURACION','FACTURADO');
					$sqlPry = "SELECT * FROM hitos WHERE estado NOT IN('CANCELADO', 'CANCELAR','ELIMINADO')";				   
					$qrPry = mysql_query($sqlPry);
					$optionT = '';
					
					while ($row = mysql_fetch_array($qrPry)):
  							
						if($row['id'] == $rs_per['id_hito']):
  							echo '<script language="javascript">console.log("'.$row['id'].'-'.$rs_per['id_hito'].'");</script>'; 
							echo '<option value="'.$row['id'].'" selected="selected">'.utf8_encode($row['id'].'-'.$row['nombre']).'</option>';	
  
						else:
							
							$disabled = (in_array($row['estado'],$arrayEstados))?'disabled':'';
  
							echo '<option value="'.$row['id'].'" '.$disabled.'>'.utf8_encode($row['id'].'-'.$row['nombre']).'</option>';	
  
						endif;
  
					endwhile;

					?>

                    </select>

                </td> 

            </tr>

            

            <tr>

                <td>Nombres T&eacute;cnicos</td>

                <td>

                	<select name="tecnicos" id="tecnicos" class="required chosen-select" >

                    <?php

						$sqlPry = "SELECT * FROM tecnico"; 

						$qrPry = mysql_query($sqlPry);

						while ($row = mysql_fetch_array($qrPry)):
						
							$disabled = ($row['estado'] == 0)?'disabled':'';

							if($row['id'] == $rs_per['id_tecnico']):

                            	echo '<option value="'.$row['id'].'" selected="selected" '.$disabled.'>'.$row['nombre'].'</option>';	

							else:

								echo '<option value="'.$row['id'].'" '.$disabled.'>'.$row['nombre'].'</option>';	

							endif; 			

													

						 endwhile;

					?>

                    </select>

                </td> 

            </tr>

           

            <tr>

                <td>Veh&iacute;culos</td>

                <td>

                	<select name="vehiculos" id="vehiculos" class="chosen-select">

                    	<option>Selecciones...</option>

                    	<?php

						$sqlPry = "SELECT * FROM vehiculos"; 

						$qrPry = mysql_query($sqlPry);

						while ($row = mysql_fetch_array($qrPry)):

							if($row['id'] == $rs_per['id_vehiculo']):

                            	echo '<option value="'.$row['id'].'" selected="selected">'.utf8_encode($row['placa']).'</option>';	

							else:

								echo '<option value="'.$row['id'].'">'.utf8_encode($row['placa']).'</option>';	

							endif; 			

													

						 endwhile;

						?>

                    </select>

                </td>

            </tr>


            <tr>

                <td>Observaciones</td>

                <td>

                	<textarea name="observacion" id="observacion" cols="25" rows="5"><?=utf8_encode($rs_per['observacion'])?></textarea>

                </td>

            </tr>
            
            
            <? if(in_array(3004, $_SESSION['permisos'])): ?>
        	<tr>
                <td>Cambio Estado:</td>
                <td>
                	<select name="cambio_estado" id="cambio_estado">
                    	<option value="1" <?=($rs_per['estado']==1)?'selected':''?>>Eliminado</option>
                        <option value="0" <?=($rs_per['estado']==0)?'selected':''?>>NO Eliminado</option>
                    </select>					
                </td>
            </tr>
            <? endif; ?>

           

        </tbody>

        

    </table>

        

     <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
		<? if(in_array(3002, $_SESSION['permisos'])): ?>
    	<input name="modificar" type="submit" id="modificar" value="Modificar" class="btn_table"/>
		<? endif; ?>
        <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" class="btn_table"/>

	</div>

</form>

<script language="javascript" type="text/javascript">

	$(document).ready(function(){

		

		$(".btn_table").jqxButton({ theme: theme });

		$(".chosen-select").chosen({width:"320px"});

		

        $(".horas").jqxDateTimeInput({ width: '250px', height: '25px', formatString: 'HH:mm:ss', showCalendarButton: false});

		

		$("#frm_per").validate({

			submitHandler: function(form) {

				var respuesta = confirm('\xBFDesea realmente asignar estos parametros?')

				if (respuesta)

					form.submit();

			}

		});

		

		

		$( "input[name=disponible]" ).on( "click",function(){

			

			$fechaini = $('#fecini').val();

			$fechaend = $("#fecfin").val();	

			

			if($(this).is(':checked')) {  

			

				$('#hitos, #vehiculos, #id_ordonetrabajo').attr('disabled', 'disabled');

				$('#hitos, #vehiculos, #id_ordonetrabajo').trigger("chosen:updated");

			

				//if($fechaini.length > 0 && $fechaend.length > 0){
				if($fechaini.length > 0){				

					/* Listar Tecnicos */

					$.post('ajax_comparar.php',{'fechaini':$fechaini, 'fechaend':$fechaend},function(data){

						$('#tecnicos').html(data);

						$(".chosen-select").trigger("chosen:updated");

					});

					

					/* Listar Hitos por fechas */

					/*$.post('ajax_comparar_hitos.php',{'fechaini':$fechaini, 'fechaend':$fechaend},function(data){

						$('#hitos').html(data);

						$(".chosen-select").trigger("chosen:updated");

					});*/

					

					$('#agregar').show();

					

				}else{ alert('Complete la fecha'); }

			

			} else {  

				$('#hitos, #vehiculos, #id_ordonetrabajo').removeAttr('disabled');

				$('#hitos, #vehiculos, #id_ordonetrabajo').trigger("chosen:updated");

			}  

			

		});

		

		

		$("#id_ordonetrabajo").change(function(){

			

			/* Listar Vehiculos */

			$fechaini = $('#fecini').val();

			$fechaend = $("#fecfin").val();	

			

			if($fechaini.length > 0 && $fechaend.length > 0){

				
				var proyecto = $(this).val();

				$('#hitos').empty();	

				$.getJSON('/anticipos/anticipo/ajax_list_hitos_orden.php', {id_proyecto:proyecto}, function (data) { 

						if(data != null){

							var options = $('#hitos');

							$('#hitos').empty();
							$('#hitos').append('<option value="">Seleccione..</option>');				

							$.each(data, function (i, v) { 
								options.append($("<option></option>").val(v.id).text(v.orden).attr('estado',v.estado));
							});

							$("#hitos").trigger("chosen:updated");

						}else{ 

							alert('No se encontraron hitos para esta orden de trabajo');

							$('#hitos').empty();

							$('#hitos').append('<option value="">Seleccione..</option>');

							$("#hitos").trigger("chosen:updated");
						}

				});

			

				$.post('ajax_comparar_vehiculos.php',{'fechaini':$fechaini, 'fechaend':$fechaend},function(data){
					$('#vehiculos').html(data);
					$(".chosen-select").trigger("chosen:updated");
				});

				/* Listar Tecnicos */

				$.post('ajax_comparar.php',{'fechaini':$fechaini, 'fechaend':$fechaend},function(data){
					$('#tecnicos').html(data);
					$(".chosen-select").trigger("chosen:updated");
				});

				$('#agregar').show();

			}else{

				alert('Complete las fechas'); 

			}	
		});
		
		
		$('#hitos').change(function(){
			
			var estado = $('#hitos option:selected').attr('estado');			
			if(estado == 'LIQUIDADO' || estado == 'EN FACTURACION' || estado == 'FACTURADO'){
					swal({   
						title: "Oops",   
						text: 'No se puede hacer asignacion con este hito por el estado:'+estado,   
						type: "error",   
						showCancelButton: false,   
						confirmButtonColor: "#DD6B55",   
						confirmButtonText: "Ok, entendido!",   
						closeOnConfirm: true 
					}, function(){ 
						$('#hitos option:eq(0)').prop('selected', true)
						$("#hitos").trigger("chosen:updated");
					});
			}
		});
		

	});

	

	function fn_modificar(){

		var str = $("#frm_per").serialize();

		$.ajax({
			url: 'ajax_modificar.php',
			data: str,
			type: 'POST',
			dataType: 'json',
			success: function(data){

				if(!data.estado) {

					swal({   
						title: "Oops",   
						text: data.message,   
						type: "error",   
						showCancelButton: false,   
						confirmButtonColor: "#DD6B55",   
						confirmButtonText: "Ok, entendido!",   
						closeOnConfirm: true 
					}, function(){   
						$('.blockPage').css('z-index','1016');
					});

				}else{

					fn_cerrar();	

					fn_buscar();

				}

			},

			error: function(err) {

				alert(err);

			}

		});

	};

</script>