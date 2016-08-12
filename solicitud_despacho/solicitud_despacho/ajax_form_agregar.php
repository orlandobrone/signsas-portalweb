<?  header('Content-type: text/html; charset=iso-8859-1');
	session_start();

	include "../../conexion.php";

	$sql = sprintf("INSERT INTO `solicitud_despacho` (id, fecha, estado) Values (NUll, NOW(), 'draft');");

	if(!mysql_query($sql)){
		echo "Error al insertar la nuevo Solicitud Despacho:\n$sql"; 
		exit;
	}

	$id_despacho = mysql_insert_id();
?>



<!-- JH 02/08/2013 punto 3-->



<!--Hoja de estilos del calendario -->

<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">



<!-- librería principal del calendario -->

<script type="text/javascript" src="../../calendario/calendar.js"></script>



<!-- librería para cargar el lenguaje deseado -->

<script type="text/javascript" src="../../calendario/calendar-es.js"></script>



<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->

<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>



<style>

.alert-box { margin:0 !important; } 

</style>



<div style="position:relative;"  class="box-material">



<h1>Formato de Solicitud de Despacho</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_modificar();" method="post" id="frm_per">

<input type="hidden" class="nom_hito" name="nom_hito" />

<input type="hidden" id="id_despacho" name="id_despacho" value="<?=$id_despacho?>" />



<table>

        <tbody>

        	 <tr>

                <td>Fecha:</td>

                <td>
                
                <div id="fecha_solicitud"></div>
                
                <!--<input name="fecha_solicitud" type="text" id="fecha_solicitud" readonly="readonly required" />

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "fecha_solicitud",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador"   // el id del botón que lanzará el calendario

					});

				</script>-->

                </td>

          </tr>

          <tr>

                <td>Fecha Entrega:</td>

                <td>
                <div id="fecha_entrega"></div>
                <!--<input name="fecha_entrega" type="text" id="fecha_entrega" readonly="readonly required" />

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "fecha_entrega",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador2"   // el id del botón que lanzará el calendario

					});

				</script>-->

                </td>

                <td>Prioridad:</td>

                <td>

                <select name="prioridad" id="prioridad" class="chosen-select required"> 

                 		<option value="">Seleccionar..</option>

                        <option value="CRITICA">CRITICA</option>

                        <option value="ALTA">ALTA</option>

                        <option value="MEDIA">MEDIA</option>

                        <option value="BAJA">BAJA</option>

                        <option value="GIRADO">GIRADO</option>

                        <option value="RETORNO">RETORNO</option>

                 </select>        

                </td>

            </tr> 
            
            <tr> 
				<td>Asunto</td>
                <td>
                	<select id="asunto" name="asunto" class="chosen-select required">
                    	<option value="COTIZACION">COTIZACI&Oacute;N</option>
                        <option value="COMPRA">COMPRA</option>
                    </select>
                </td>           
            </tr>

            

            <tr>

            	<td colspan="2"><h3>Responsable de la Solicitud</h3></td>

            </tr>

            

            <tr>

            	<td>Regional:</td>

                <td> 

                 <? 
				 	$sqlPry = "SELECT id_regional FROM usuario 
							   WHERE id = ".$_SESSION['id']; 					
                    $qrPry = mysql_query($sqlPry);
					$rsPry = mysql_fetch_array($qrPry);
				
					
					if($rsPry['id_regional'] == 26): 
						
						$sql4 = "SELECT * FROM regional WHERE 1";
						
					else:
					
						$query2 = '';
						$regiones = '';
						
						$regional = explode(',',$rsPry['id_regional']);
						
						if(count($regional) > 1):
							//print_r($regional);
							foreach($regional as $row2):
								$query2 .= ' id='.$row2.' OR';
							endforeach;		
							$query2 = substr($query2, 0,-2);//			
						else:
							$query2 = " id=".$rsPry['id_regional'];
						endif;
						
						$sql4 = "SELECT * FROM regional WHERE ".$query2;
						
					endif;
					
					
					
					if($_SESSION['perfil'] == 5):					
						$sql4 = "SELECT * FROM regional WHERE 1";
					endif;
					
					
					$result2 = mysql_query($sql4) or die(mysql_error());
                 ?>

                 <select name="id_regional" id="regional" class="chosen-select required var_ordenes"> 

                 		<option value="0">Seleccionar..</option>

                 	 <? while ($rsPry = mysql_fetch_array($result2)) { ?>

                        <option value="<?=$rsPry['id']?>"><?=$rsPry['region']?></option> 

                     <? } ?>

                 </select>  
                           

                </td> 

                <td colspan="2">

                	<div id="mensaje" class="alert" style="display:none;">Debe selecionar Regional y Centro Costos.</div>   

                </td>  

            </tr>

            <tr>        

                <td>Nombre:</td>

                <td>

                <select name="nombre_responsable" id="nombre_responsable" class="chosen-select required"></select>

                </td>

                

                <td>Cedula:</td>

                <td>

                 <input type="text" name="cedula_responsable" id="cedula_responsable" size="40" value="" alt="integer" class="required"/>                

                </td> 

           </tr>         

           <tr> 

                <td>Centro Costo:</td>

                <td>

                    <? $sqlPry = "SELECT * FROM linea_negocio WHERE 1 ORDER BY codigo ASC"; 

                    $qrPry = mysql_query($sqlPry);

                    ?>

                    <select name="id_centrocostos" id="centros_costos" class="chosen-select required var_ordenes">

                        <option value="0">Seleccionar..</option>

                        <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>

                        <option value="<?=$rsPry['id']?>"><?=$rsPry['codigo']?> - <?=$rsPry['nombre']?></option>

                        <? } ?>

                    </select>            

                </td>            

         

            	<td>Orden Trabajo:</td>

                <td>

                    <select name="id_proyecto" id="orden_trabajo" class="chosen-select required"></select>  

                </td>

           </tr> 

           <tr>

               <td>Hitos:</td>

               <td>                     

                 <select name="id_hito" id="hitos" class="chosen-select required"></select>            

               </td> 

           </tr>

           

        </tbody>

    </table>  

	<br />

    <table>

            <tr>

              <td>Direcci&oacute;n de entrega</td>

              <td><input name="direccion_entrega" type="text" id="direccion_entrega" size="40" class="required" /></td>

              <td>Nombre de quien recibe</td>

              <td><input name="nombre_recibe" type="text" id="nombre_recibe" size="40" class="required" /></td>

            </tr>

            <tr>

              <td>Tel&eacute;fono / Celular</td>

              <td><input name="celular" type="text" id="celular" size="40" class="required" /></td>

              <td style="display:none;">Descripci&oacute;n:</td>

              <td style="display:none;"><textarea id="descripcion_2" name="descripcion" cols="50" rows="3" style="width: 253px;"></textarea></td>

              

            </tr>   

    </table>   

</form>



	

	<h3>Agregar Materiales</h3>

   

   	<h4>Agregando salida de mercancia</h4>   

  	<p>Por favor rellene el siguiente formulario</p>

	<form action="javascript: fn_agregar();" method="post" id="form_material">

    		<input type="hidden" class="nom_hito" name="nom_hito" />

            <input type="hidden" value="<?=$id_despacho?>" name="id_despacho"/>

            <input type="hidden" value="0" name="cantidadPendiente" id="cantidadPendiente"/>

            <table class="formulario">

                <tbody>

                    <tr>

                        <td>Material</td>

                        <td>

                            <? $sqlMat = sprintf("SELECT * FROM inventario ORDER BY nombre_material ASC");

                                    $perMat = mysql_query($sqlMat);

                                    $num_rs_per_mat = mysql_num_rows($perMat); ?>

                           <select class="chosen-select" tabindex="2" name="material" id="material">

                                <option value="">Seleccione una opci&oacute;n</option>

                                <? while ($rs_per_mat = mysql_fetch_assoc($perMat)) { ?>

                                <option value="<? echo $rs_per_mat['id']; ?>"><?=$rs_per_mat['codigo'].' | '.$rs_per_mat['nombre_material']; ?></option>

                                <? } ?>

                            </select>

                        </td>
                        
                        <td>Presupuesto</td>

              			<td>
                        	<input name="presupuesto" type="text" id="presupuesto" size="40" class="required" alt="integer"/>
                        </td>

                        <!--<td>

                            <a href="javascript:" id="btn_agregar_material">Agregar Material</a>

                        </td>-->

                    </tr>

                    <tr>

                        <td>Cantidad Existente:</td>

                        <td><input type="text" name="cantidadInv" id="cantidadInv" value="0" readonly/></td>

                        

                        <td>Cantidad Solicitada:</td>

                        <td><input name="cantidad" type="text" id="cantidad" class="required solicitud" alt="zip"/></td>

                        

                    </tr>

                    <tr>

                        <td>Costo:</td>

                        <td><input type="text" name="costoInv" id="costoInv" value="0" readonly alt="signed-decimal"/></td>

                        

                        <td>Costo Solicitado:</td>

                        <td>

                            <input name="costo_solicitado" type="text" id="costo_solicitado" class="required solicitud" readonly alt="integer"/>

                        </td>

                    </tr>

                    

                    <tr>

                        <td>Descripci&oacute;n:</td>

                        <td><textarea id="descripcion" name="descripcion" cols="50" rows="3" style="width: 203px;" disabled="disabled"></textarea></td>

                       	<td>Observaci&oacute;n:</td>

                        <td><textarea id="observacion" name="observacion" cols="50" rows="3" style="width: 203px;"></textarea></td>

                    </tr>

                   

                </tbody>

                <tfoot>

                    <tr>

                        <td colspan="2">

                            <input name="agregar" type="button" id="agregarMaterial" value="Agregar" class="btn_table"/>

                        </td>

                        

                        <td colspan="2"><div class="alert-box"></div></td>

                    </tr>

                </tfoot>

            </table>

        </form>

	<div id="jqxgrid2" style="margin-top:20px; margin-bottom:20px;"></div>

 

      

    <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

        <input name="modificar" type="button" id="modificar" value="Guardar" class="btn_table" />

        <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar(<?=$id_despacho?>);"  class="btn_table"/>                   

    </div>

</div>





<div class="add-material" style="display:none;">

    <h1>Agregando nuevo material</h1>

    <p>Por favor rellene el siguiente formulario</p>

    <form action="javascript: fn_agregar_material();" method="post" id="frm_add_material">

        <table class="formulario">

            <tbody>

                <tr>

                    <td>Nombre Material</td>

                    <td><input name="nommat" type="text" id="nommat" size="40" class="required" /></td>

                </tr>

                <tr>

                    <td>Descripci&oacute;n</td>

                    <td><input name="descri" type="text" id="descri" size="40" class="required" /></td>

                </tr>

                <tr>

                    <td>Cantidad</td>

                    <td><input name="cantid" type="text" id="cantid" size="40" class="required" /></td>

                </tr>

                <tr>

                    <td>Costo Unitario</td>

                    <td><input name="cosuni" type="text" id="cosuni" size="40" class="required" alt="decimal-us" /></td>

                </tr>

            </tbody>

            <tfoot>

                <tr>

                    <td colspan="2">

                        <input name="agregar" type="submit" id="agregar" value="Agregar" class="btn_table"/>

                        <input name="cancelar" type="button" id="btn-cancelar" value="Cancelar" class="btn_table" />

                    </td>

                </tr>

            </tfoot>

        </table>

    </form>

</div>


<link rel="stylesheet" href="/js/chosen/chosen.css">

<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 
<script type="text/javascript">

$(document).ready(function () {
	
            var source =
            {

                 datatype: "json",

                 datafields: [

					 { name: 'codigo', type: 'string'},
					 { name: 'nombre_material', type: 'string'},
					 { name: 'cantidad', type: 'number'},
					 { name: 'costo', type: 'number'},	
					 { name: 'aprobado', type: 'string'},	
					 { name: 'observacion', type: 'string'},			
					 { name: 'acciones', type: 'string'},
					 { name: 'presupuesto', type: 'number'}						 

                ],

				updaterow: function (rowid, rowdata, commit) {

                    // synchronize with the server - send update command

                    // call commit with parameter true if the synchronization with the server is successful 

                    // and with parameter false if the synchronization failder.

                    commit(true);

                },

				cache: false,

			    url: 'ajax_list_materiales.php?id=<?=$id_despacho?>',

				root: 'Rows',

				sortcolumn: 'id',

                sortdirection: 'desc',

				filter: function()

				{

					// update the grid and send a request to the server.

					$("#jqxgrid").jqxGrid('updatebounddata', 'filter');

				},

				sort: function()

				{

					// update the grid and send a request to the server.

					$("#jqxgrid").jqxGrid('updatebounddata', 'sort');

				},

				root: 'Rows',

				beforeprocessing: function(data)

				{		

					if (data != null)

					{

						source.totalrecords = data[0].TotalRows;					

					}

				}

				};		

				var dataadapter = new $.jqx.dataAdapter(source, {

					loadError: function(xhr, status, error)

					{

						alert(error);

					}

				}

				);



            var dataadapter = new $.jqx.dataAdapter(source);



            $("#jqxgrid2").jqxGrid({

                width: '100%',

				height: 260,

                source: dataadapter,

                showfilterrow: true,

                pageable: true,

                filterable: true,

                theme: theme,

				sortable: true,

                columnsresize: true,

				virtualmode: true,

				autorowheight: true,

                autoheight: true,

				rendergridrows: function(obj)

				{

					 return obj.data;      

				},      

				//fn_aprobar_allitems          

                columns: [

				  { text: '-', datafield: 'acciones', filtertype: 'none', width:'10%', cellsalign: 'center', editable: false, sortable:false },

                  { text: 'C&oacute;digo', datafield: 'codigo', filtertype: 'none', filtercondition: 'equal',  columntype: 'textbox', editable: false,  width:80 },
				  
				  { text: 'Presupuesto', datafield: 'presupuesto', filtertype: 'none', columntype: 'textbox', editable: false , cellsalign: 'right', cellsformat: 'c2' },

                  { text: 'Material', datafield: 'nombre_material',  filtertype: 'none', filtercondition: 'starts_with', editable: false },

				  { text: 'Cantidad', datafield: 'cantidad', filtertype: 'none', cellsalign: 'right' },

				  { text: 'Costo', datafield: 'costo', filtertype: 'none', cellsalign: 'right', cellsformat: 'c2' },

				  { text: 'Observaci&oacute;n', datafield: 'observacion', filtertype: 'none',cellsalign: 'right'},

                  { text: 'Estado', datafield: 'aprobado', filtertype: 'none', cellsalign: 'left', width:50  }

                ]

            });			

            $("#jqxgrid2").on('cellendedit', function (event) {

				

                var args = event.args;

				var id = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'id');

				

				if(args.datafield == 'fecha'){

					var formattedDate = $.jqx.dataFormat.formatdate(args.value, 'yyyy-MM-dd');

					args.value = formattedDate

				}

				

		   		$.ajax({

					  type: 'POST',

					  dataType: 'json',

					  url: 'ajax_update_item.php',

					  data: {

						  		id_item: id,

								campo: args.datafield,

								valor: args.value

				      },

					  success: function(data){	

						  if (data.estado == true){ 

							 

						  }

					  }

				 });

		   

		    });

			//$("#excelExport").jqxButton({ theme: theme });

            //$('#clearfilteringbutton').jqxButton({ height: 25, theme: theme });

           /* $('#clearfilteringbutton').click(function () {



                $("#jqxgrid2").jqxGrid('clearfilters');

            });*/

			/*$("#excelExport").click(function () {

                $("#jqxgrid2").jqxGrid('exportdata', 'xls', 'Lista Items');           

            });*/

});

</script>      





<script language="javascript" type="text/javascript">

	$(document).ready(function(){
		
		
		$("#fecha_solicitud").jqxDateTimeInput({width: '250px', height: '25px', formatString: 'yyyy-MM-dd' });
		$("#fecha_entrega").jqxDateTimeInput({width: '250px', height: '25px', formatString: 'yyyy-MM-dd' });
		

		$(".chosen-select").chosen({width:"220px"}); 

		$('input').setMask();	

		$(".btn_table").jqxButton({ theme: theme });

		

		/* Agregar Items */

		$("#material").change(function(){

			$(".solicitud").val('');

			var idMaterial = $(this).val();

			$.getJSON('/ajax/listMaterial.php',{id:idMaterial}, function (data) {

				$.each(data, function (i, v) {					

					$('#'+i).val(v);

				});

			});

		});


		$('#cantidad').keyup(function(){	//Validad la cantidad con respecto a la disponibilidad del inventario	

			if($(this).val() != ''){

				var cantidad = parseInt($(this).val());
				var cantidadInv = parseInt($('#cantidadInv').val());
				var solicitarCompra = 0;


				/*if(cantidad <= cantidadInv){
					$('.alert-box').removeClass('warning');
					$('.alert-box').addClass('success');
					$('.alert-box').html('<span>OK:</span>&nbsp;En existencia.');
					$('.alert-box').slideDown('slow');
					$('#cantidadPendiente').val(0);
				}else{
					solicitarCompra = cantidad - cantidadInv;
					$('.alert-box').removeClass('success');
					$('.alert-box').addClass('warning');
					$('.alert-box').html('<span>Advertencia:</span>&nbsp;No hay existencia.<br/>Solicitud Compra:'+solicitarCompra);
					$('.alert-box').slideDown('slow');
					$('#cantidadPendiente').val(solicitarCompra);
				}*/				
				
				var costoInv = parseFloat($('#costoInv').val());			
				var costo_solicitado =  parseFloat(costoInv * cantidad);		
				$('#costo_solicitado').val(costo_solicitado);
				$('#costo_solicitado').setMask();

			/*}else{
				$('#costo_solicitado').val('');
				$('.alert-box').removeClass('success');
				$('.alert-box').addClass('warning');
				$('.alert-box').html('<span>Advertencia:</span>&nbsp;Debe ingresar una cantidad');
				$('.alert-box').slideDown('slow');*/
			}			

		});

		

		/* Validacion del formulario agregar materiales */

		$("#form_material").validate({

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

					var respuesta = confirm('\xBFRealmente desea agregar este material?')

					if (respuesta)

						form.submit();		

			}

		});

		$('#agregarMaterial').click(function(){
			var str = $("#form_material").serialize();

			$.ajax({
				url: 'ajax_agregar_material.php',
				data: str,
				type: 'post',
				success: function(data){
					if(data != "") {
						alert(data);
					}else{ 
						$('.alert-box').slideUp();
						$('#form_material').reset();
						$("#jqxgrid2").jqxGrid('updatebounddata');
					}

				}

			});
		});

		function fn_agregar(){ 
		
			var str = $("#form_material").serialize();

			$.ajax({
				url: 'ajax_agregar_material.php',
				data: str,
				type: 'post',
				success: function(data){
					if(data != "") {
						alert(data);
					}else{ 
						$('.alert-box').slideUp();
						$('#form_material').reset();
						$("#jqxgrid2").jqxGrid('updatebounddata');
					}

				}

			});

		};

		

		

		$('#btn_agregar_material').click(function(){

			$('.box-material').slideUp();

		 	$('.add-material').slideDown('slow');	

		});

		

		$('#btn-cancelar').click(function(){

			$('.add-material').slideUp();

		 	$('.box-material').slideDown('slow');	

		});

		

		/* Validacion del formulario agregar materiales */

		$("#frm_add_material").validate({

			rules:{

				usu_per:{

					required: true,

					remote: "/inventario/inventario/ajax_verificar_usu_per.php"

				}

			},

			messages: {

				usu_per: "x"

			},

			onkeyup: false,

			submitHandler: function(form) {

				var respuesta = confirm('\xBFDesea realmente agregar este nuevo material al Inventario?')

				if (respuesta)

					form.submit();

			}

		});

		/*--------------------------------------------------------------------------------------*/

		$('#modificar').live('click',function(){
			$("#frm_per").submit(); 
		});

		

		$("#frm_per").validate({

			submitHandler: function(form) {

				/*var respuesta = confirm('\xBFDesea realmente ingresar estos parametros?')

				if (respuesta)

					form.submit();*/					
				//$('.blockMsg').css('z-index',998);
				swal({  title: "Esta Seguro?",   
					text: "Desea realmente ingresar estos parametros!",   
					type: "warning",   
					showCancelButton: true,   
					confirmButtonColor: "#DD6B55",   
					confirmButtonText: "Si!",   
					cancelButtonText: "No, cancelar plx!",   
					closeOnConfirm: true,   
					closeOnCancel: true
				 }, function(isConfirm){   
						if (isConfirm) {     
							//swal("Deleted!", "Your imaginary file has been deleted.", "success"); 
							form.submit();  
						}else {     
							//$('.blockMsg').css('z-index',1010)  
						} 
				});
			}

		});

		

				

		$('#prioridad').blur(function(){

			var variable = $(this).val().toUpperCase();

			$(this).val(variable);

		})

		

		

		$('#cedula_consignar').change(function(){

			var nombre, banco, tipocuenta, numcuenta;

			$( "#cedula_consignar option:selected" ).each(function() {

			  nombre = $( this ).attr('nombre');

			  banco = $( this ).attr('entidad');

			  tipocuenta = $( this ).attr('tipocuenta');

			  numcuenta = $( this ).attr('numcuenta');

			});

			$('#beneficiario').val(nombre);

			$('#banco').val(banco);

			$('#tipo_cuenta').val(tipocuenta);

			$('#num_cuenta').val(numcuenta);

		});

		

		$('#nombre_responsable').change(function(){

			var cedula;

			$( "#nombre_responsable option:selected" ).each(function() {

			  cedula = $( this ).attr('cedula');

			});

			$('#cedula_responsable').val(cedula);

		});

		

		$('#hitos').change(function(){ 
			$('.nom_hito').val($("#hitos option:selected").html());
		});

		$('#orden_trabajo').change(function(){ 

			var orden;

			$('#hitos').empty();

			var proyecto = $( "#orden_trabajo" ).val();			

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

		});

		

		var regional_actual;

		$('.var_ordenes').change(function(){ 

		

			$('#orden_trabajo').empty();

			$("#orden_trabajo").trigger("chosen:updated");

			

			$('#hitos').empty();

			$("#hitos").trigger("chosen:updated");

			

			var regional = $('#regional').val();

			var centrocosto = $('#centros_costos').val(); 

			

			

			if(regional != '0' && regional_actual != regional ){

				

				$.getJSON('/anticipos/anticipo/ajax_list_responsable.php', {id_regional:regional}, function (data) {

						var options = $('#nombre_responsable');

						$('#nombre_responsable').empty();

						$('#nombre_responsable').append('<option value="">Seleccione..</option>');				

						

						$.each(data, function (i, v) { 

							options.append($("<option></option>").val(v.nombre).text(v.nombre).attr('cedula',v.cedula));

						});

						

						$("#nombre_responsable").trigger("chosen:updated");

						regional_actual = regional;

						$('#cedula_responsable').val('');

				});

				

			}

			

			if(regional != '0' && centrocosto != '0'){

			/* Get Ordenes de trabajo   */	 

				$.getJSON('/anticipos/anticipo/ajax_list_ordenes_trabajo.php', {id_regional:regional, id_centroscostos:centrocosto}, function (data) {

						var options = $('#orden_trabajo');

						$('#orden_trabajo').empty();

						$('#orden_trabajo').append('<option value="">Seleccione..</option>');				

						

						$.each(data, function (i, v) { 

							options.append($("<option></option>").val(v.id).text(v.orden));

						});

						

						$("#orden_trabajo").trigger("chosen:updated");

				});

			}else{

				$('#mensaje').show();

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

	

	

	function replaceAll( text, busca, reemplaza ){

	  while (text.toString().indexOf(busca) != -1)

		  text = text.toString().replace(busca,reemplaza);

	  return text;

	}



	

	

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

	

	function fn_agregar(){ 

		var str = $("#form_material").serialize();

		$.ajax({

			url: 'ajax_agregar_material.php',

			data: str,

			type: 'post',

			success: function(data){

				if(data != "") {

					alert(data);

				}else{ 

					$('.alert-box').slideUp();

					$('#form_material').reset();

					$("#jqxgrid2").jqxGrid('updatebounddata');

				}

			}

		});
		

	};

	

	function fn_agregar_material(){

		var str = $("#frm_add_material").serialize();

		$.ajax({

			url: '/inventario/inventario/ajax_agregar.php',

			data: str,

			type: 'post',

			success: function(data){

				if(data != "") {

					alert(data);

				}else{

					listChose();					

				}

			}

		});

	};

	

	function listChose(){

	

		$.getJSON('/ajax/choseMaterial.php', function (data) {

				var options = $('#material'); 

				$('#material').empty()

				$('#material').append('<option value="">Seleccione una opcion</option>');	

				

				$.each(data, function (i, v) {

					options.append($("<option></option>").val(v.id).text(v.label));

				});

				//$(".chosen-institucion").chosen();

				

				$("#material").trigger("chosen:updated");

				$('.add-material').slideUp();

		 		$('.box-material').slideDown('slow');

		});		

	

	}

	

	jQuery.fn.reset = function () {

	  $(this).each (function() { this.reset(); });

	}



</script>