<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";

	

/**

 * Verifica que una fecha esté dentro del rango de fechas establecidas

 * @param $start_date fecha de inicio

 * @param $end_date fecha final

 * @param $evaluame fecha a comparar

 * @return true si esta en el rango, false si no lo está

 */

function check_in_range($start_date, $end_date, $evaluame) {

    $start_ts = strtotime($start_date);

    $end_ts = strtotime($end_date);

    $user_ts = strtotime($evaluame);

    return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));

}







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

.list_combo, .hora_vehicular{ display:none; }

</style>

<h1>Asignar</h1> 

<p>Por favor rellene el siguiente formulario</p>



<form action="javascript: fn_agregar();" method="post" id="frm_per">

    <table class="formulario">

        <tbody>

        

        	<tr>

                <td>Fecha de Inicio</td>

                <td><input name="fecini" type="text" id="fecini" size="40" class="required fechas" />

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

                <td><input name="fecfin" type="text" id="fecfin" size="40" class="fechas" />

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

                <td><div class='horas' name="hora_inicio" id="hora_inicio"></div>

                </td>

            </tr>

            

            <tr>

            	<td>Hora Final:</td>

                <td><div class='horas' name="hora_final" id="hora_final"></div></td>

            </tr>
            
           <tr>
            	<td colspan="2"><label id="horastraba" style="color:red;"></label></td>
            </tr>

            <tr>
            	<td colspan="2">

                 <input type="checkbox" id="almuerzo" name="almuerzo"/>  Descontar hora de almuerzo 

                </td>

            </tr>

            <tr>

                <td colspan="2">

                 <input type="radio" id="disponible" name="disponible" value="Disponible" class="required"/>  Disponible
                 <input type="radio" id="vacaciones" name="disponible" value="Vacaciones" class="required"/>  Vacaciones
                 <input type="radio" id="incapacitado" name="disponible" value="Incapacitado" class="required"/>  Incapacitado
                 <input type="radio" id="operando" name="disponible" value="Operando" class="required"/>  Operando           
                 
                 <input type="radio" id="operando" name="disponible" value="Compensatorio" class="required"/>  Compensatorio              

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

                        <option value="<?=$rsPry['id_proyecto']?>"><?=$rsPry['orden_trabajo']?></option>

                        <? } ?>	

                    </select>

                </td> 

            </tr>

            

            

            <tr>

                <td>Hitos</td>

                <td>

                	<select name="hitos" id="hitos" class="required chosen-select" ></select>

                </td> 

            </tr>

            

            <tr>

                <td>Nombres T&eacute;cnicos</td>

                <td>

                	<select name="tecnicos" id="tecnicos" class="required chosen-select" ></select>

                </td> 

            </tr>

           

            <tr>

                <td>Veh&iacute;culos</td>

                <td>

                	<select name="vehiculos" id="vehiculos" class="chosen-select"></select>

                </td>

            </tr>

            

            

            <tr>

                <td>Observaciones</td>

                <td>

                	<textarea name="observacion" id="observacion" cols="25" rows="5"></textarea>

                </td>

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
		
		var send = true;

		$(".btn_table").jqxButton({ theme: theme });

		$(".chosen-select").chosen({width:"270px"});

		

		// Create jqxDateTimeInput and set its format string to Time. 

        // Set the showCalendarButton option to hide the calendar's button.

        $(".horas").jqxDateTimeInput({ width: '250px', height: '25px', formatString: 'HH:mm:ss', showCalendarButton: false}); 

		

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

				var respuesta = confirm('\xBFDesea realmente asignar estos parametros?')

				if (respuesta)

					form.submit();

			}

		});

		

		

		/*$( "input[name=disponible]" ).on( "click",function(){

			

			$fechaini = $('#fecini').val();

			//$fechaend = $("#fecfin").val(); //FGR

			

			if($(this).is(':checked')) {  

				$('#vehiculos').attr('disabled', 'disabled');
				$('#vehiculos').trigger("chosen:updated");
				
				$.post('ajax_list_ots.php',function(data){ //JH
					$('#id_ordonetrabajo').html(data);
					$('#id_ordonetrabajo').trigger("chosen:updated");
				});

				//if($fechaini.length > 0 && $fechaend.length > 0){
				if($fechaini.length > 0){ //FGR				

					// Listar Tecnicos 

					//$.post('ajax_comparar.php',{'fechaini':$fechaini, 'fechaend':$fechaend},function(data){
					$.post('ajax_comparar.php',{'fechaini':$fechaini},function(data){ //FGR

						$('#tecnicos').html(data);

						$(".chosen-select").trigger("chosen:updated");

					});
					
					/* Listar Hitos por fechas */

					/*$.post('ajax_comparar_hitos.php',{'fechaini':$fechaini, 'fechaend':$fechaend},function(data){

						$('#hitos').html(data);

						$(".chosen-select").trigger("chosen:updated");

					});*/ /*

					

					$('#agregar').show();

					

				}else{ alert('Complete la fecha'); }

			

			} else {  

				$('#hitos, #vehiculos, #id_ordonetrabajo').removeAttr('disabled');

				$('#hitos, #vehiculos, #id_ordonetrabajo').trigger("chosen:updated");

			}  

			

		}); */ //FGR Se comentó funcionalidad de disponible

		

		

		$("#id_ordonetrabajo").change(function(){

			

			/* Listar Vehiculos */

			$fechaini = $('#fecini').val();

			$fechaend = $("#fecfin").val();	

			

			//if($fechaini.length > 0 && $fechaend.length > 0){
			if($fechaini.length > 0){

				

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

			

				//$.post('ajax_comparar_vehiculos.php',{'fechaini':$fechaini, 'fechaend':$fechaend},function(data){
				$.post('ajax_comparar_vehiculos.php',{'fechaini':$fechaini},function(data){ //FGR

					$('#vehiculos').html(data);

					$(".chosen-select").trigger("chosen:updated");

				});

				/* Listar Tecnicos */

				//$.post('ajax_comparar.php',{'fechaini':$fechaini, 'fechaend':$fechaend},function(data){
				$.post('ajax_comparar.php',{'fechaini':$fechaini},function(data){ //FGR

					$('#tecnicos').html(data);

					$(".chosen-select").trigger("chosen:updated");

				});

				$('#agregar').show();

			}else{

				alert('Complete la fecha'); 

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


		/*$("#vehiculos").change(function(){

			var value = $(this).val(); 

			if(value != ''){

				$('.hora_vehicular').slideDown();

			}else{

				$('.hora_vehicular').slideUp();

			}

		});*/
	});

	

	function fn_agregar(){
		
		console.log(send)
		if(send){

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
	
						//fn_buscar();
	
						$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
	
					}
	
				}
	
			});
		}else{
			alert('Debe corregir la hora asignada');
		}

	};
	
	$("#hora_final").change(function(){
		horastrabaj();
	});
	
	$("#hora_inicio").change(function(){
		horastrabaj();
	});
	
	$('#almuerzo').click(function() {
        horastrabaj();
    });
	
	
	function horastrabaj(){	
	
		$.ajax({
			url: 'horasdiferencia.php',
			data: {hora2:$('#hora_inicio').val(),hora1:$('#hora_final').val()},
			type: 'get',
			dataType: "json",
			success: function(data){

				if(data.estado){
					send = true;
					var diffe = parseFloat(data.valor).toFixed(2);
					if ($('#almuerzo').is(':checked'))
						diffe -= 1;
					$("#horastraba").empty();
					$("#horastraba").append("Horas trabajadas: "+diffe);
				}else{
					send = false;
					$("#horastraba").empty();
					$("#horastraba").append(data.valor);
				}
			}
		});
		
		/*$.post("horasdiferencia.php",{hora2:$('#hora_inicio').val(),hora1:$('#hora_final').val()},function(respuesta){
			var diffe = parseFloat(respuesta).toFixed(2);
			if ($('#almuerzo').is(':checked'))
				diffe -= 1;
			$("#horastraba").empty();
			$("#horastraba").append("Horas trabajadas: "+diffe);
		});*/
	};

</script>