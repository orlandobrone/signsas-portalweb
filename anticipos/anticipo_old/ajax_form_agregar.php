<?  header('Content-type: text/html; charset=iso-8859-1');
	session_start();

	include "../../conexion.php";
	
	$sql = sprintf("INSERT INTO `anticipo` (`id`, `fecha`, `prioridad`, `nombre_responsable`, `cedula_responsable`, `id_regional`, `id_centroscostos`, `giro`, `total_anticipo`, `banco`, `tipo_cuenta`, `num_cuenta`, `cedula_consignar`, `beneficiario`, `observaciones`, `id_ordentrabajo`, `estado`, `fecha_edit`, publicado) 

				    VALUES (NULL, NOW(), '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'draft');");

	if(!mysql_query($sql)){

		echo "Error al insertar la nueva anticipo:\n$sql"; 

		exit;

	}

	$id_anticipo = mysql_insert_id();
	
	$obj = new TaskCurrent();
	
	$valor_concepto = $obj->getValorConceptoFinanciero(14);
	
	$obj->setLogEvento('Anticipo',$id_anticipo,'Borrador');

?>

<!--Hoja de estilos del calendario -->

<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">



<!-- librería principal del calendario -->

<script type="text/javascript" src="../../calendario/calendar.js"></script>



<!-- librería para cargar el lenguaje deseado -->

<script type="text/javascript" src="../../calendario/calendar-es.js"></script>



<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->

<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>



<style>

table{ table-layout: fixed;word-wrap: break-word; }

</style>



<h1>Formato de Solicitud de Anticipo <span style="color:#FF0000; display:none;">En matenimiento</span></h1> 



<div style="float:left; width:556px; margin-right:10px;">

<p>Por favor diligencie el siguiente formulario</p>

<form action="javascript: fn_modificar();" method="post" id="frm_per">

<input type="hidden" name="total_anticipo" id="total_anticipo"/>



    <table>

        <tbody>

        	 <tr>

                 <td>ID Anticipo:</td>

                 <td>

                    <input type="text" id="id" name="id" value="<?=$id_anticipo?>" readonly />

                 </td>

             </tr>

        	 <tr>

                <td width="20%">Fecha:</td>

                <td width="30%"><input name="fecha" type="text" id="fecha" readonly />

                  <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "fecha",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador"   // el id del botón que lanzará el calendario

					});

				</script>

                </td>

                <td width="20%">Prioridad:</td>

                <td width="30%">

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
            	<td><div class="fechaaprobado" style="display:none">Fecha Aprobado:</div></td>
                <td><div class="fechaaprobado" style="display:none"><input name="fechaapr" type="text" id="fechaapr" readonly />
                    <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2" /></div>
    
                    <script type="text/javascript">
    
                        Calendar.setup({
    
                            inputField     :    "fechaapr",      // id del campo de texto
    
                            ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
    
                            button         :    "lanzador2"   // el id del botón que lanzará el calendario
    
                        });
    
                    </script>
                </td>
            </tr>

            <tr>

            	<td colspan="2"><h3>Responsable del Anticipo</h3></td>

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

                 <select name="regional" id="regional" class="chosen-select required var_ordenes"> 

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

                <select name="nombre_responsable" id="nombre_responsable" class="nombre_responsable chosen-select required"></select>

                </td>

                

                <td>Cedula:</td>

                <td>

                 <input type="text" name="cedula_responsable" id="cedula_responsable" size="40" value="" alt="integer" class="cedula_responsable required"/>                

                </td> 

           </tr>         

           <tr> 

                <td>Centro Costo:</td>

                <td> 

                    <select name="centros_costos" id="centros_costos" class="centros_costos chosen-select required var_ordenes">
                        <option value="0">Seleccionar..</option>
                    </select>            
                </td>            


            	<td>Orden Trabajo:</td>

                <td>

                    <select name="orden_trabajo" id="orden_trabajo" class="orden_trabajo chosen-select required"></select>  

                </td>

           </tr> 

        </tbody>

    </table>  
    
    <h3>Tipo de Item Hito:</h3>
    
    <table>
    
    	 <tr>
           		<td>Transferencia</td> <td><input type="radio" class="typeInv" name="opcionivn" value="d" checked></td>
                <td>Inventario ACPM</td> <td><input type="radio" class="typeInv" name="opcionivn" value="i"></td>
         </tr>
    </table>

    <h3>Consignar a:</h3>

    <table>

             <tr>

            	<td style="width:220px;">CEDULA:</td>

                <td>

              		<!--<input type="text" name="cedula_consignar" id="cedula_consignar" size="30" alt="integer" class="required" />-->      

                    <? $sqlPry = "SELECT * FROM beneficiarios ORDER BY identificacion ASC"; 

                    $qrPry = mysql_query($sqlPry);

                    ?>
                   

                    <select id="cedula_consignar" name="cedula_consignar"  class="cedula_consignar chosen-select required">

                        <option value="0">Seleccionar..</option>

                        <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>

                            <option value="<?=$rsPry['identificacion']?>" 

                                nombre="<?=$rsPry['nombre']?>"

                                entidad="<?=$rsPry['entidad']?>"

                                numcuenta="<?=$rsPry['num_cuenta']?>"

                                tipocuenta="<?=$rsPry['tipo_cuenta']?>"><?=$rsPry['identificacion']?></option>

                        <? } ?>

                    </select>    

                </td>  

                

                <td>BENEFICIARIO:</td>

                <td>

              		<input type="text" name="beneficiario" id="beneficiario" size="30" class="required"/>       

                </td>       

            </tr>

                    

            <tr>

            	<td>BANCO:</td>

                <td>

                 	<input type="text" name="banco" id="banco" size="30"  class="required" />               

                </td>

                

                <td>TIPO CUENTA:</td>

                <td>

              		<input type="text" name="tipo_cuenta" id="tipo_cuenta" size="30" class="required"/>       

                </td> 

            </tr>

            <tr>    

                <td>No. CUENTA:</td>

                <td>

              		<input type="text" name="num_cuenta" id="num_cuenta" size="30" class="required"/>       

                </td> 

                <td>OBSERVACIONES:</td>

                <td>

              		<input type="text" name="observaciones" id="observaciones" size="30" value="<?=$rs_per['observaciones']?>"/>       

                </td>  

            </tr>   
            <tr>
            	<td>TIPO BANCO</td>
                <td colspan="3">
                	<input type="radio" name="opcionbanco" value="Bancolombia" class="required"/> Bancolombia.                   
                    <input type="radio" name="opcionbanco" value="Otros Bancos" class="required"/> Otros Bancos.
                    <input type="radio" name="opcionbanco" value="Giro Efectivo" class="required giro_check"/> Giro Efectivo.
                </td>
            </tr>    

      </table> 

      <h3>Informaci&oacute;n Cotizaci&oacute;n</h3>

        <table>

            <tbody>          	

                <tr>

                  <td>Valor cotizado:</td>

                  <td>

                     <input type="text" name="v_cotizado" id="v_cotizado" readonly style="background:#CCC"/> 

                  </td>            

                </tr>       

            </tbody>   

       </table>  

       <br />

</form>

</div>



<form action="javascript: fn_agregar_item();" method="post" id="frm_item">

	<input type="hidden" id="id" name="id" value="<?=$id_anticipo?>" />
    <input type="hidden" id="centro_costo_item" name="centro_costo_item" />
	<input type="hidden" id="tipoingreso" name="tipoingreso" value="transferencia"/>
    
	<h3>Informaci&oacute;n del Anticipo</h3>

    <table style="width:100%">

        <tbody>          	

            <tr>

              <td>Valor del Giro (Aplica para Efecty, etc):</td>

              <td>
                 <input type="text" name="giro" id="giro" value="0" alt="decimal"/> 
              </td> 

              <td>Total Anticipo:</td>

              <td><input type="text" name="total_anticipo" id="total_anticipo" readonly style="background:#CCC"/>  
                  <input type="hidden"  id="test_total"/>               
              </td>           

        	</tr>       

        </tbody>   

   </table>

   <h4>Agregar Item</h4>   

   <table style="width:100%;">

        <tbody>       

           <tr>
                  <td>Hitos:</td>
                  <td colspan="2">                     
                      <select name="hitos" id="hitos" class="hitos chosen-select required"></select>            
                  </td> 
                  <td>RTe Fte ACPM: <?=$valor_concepto*1000?>%</td>
           </tr>
           
          
           
           <tr class="invacpm">
           		<td colspan="4">
           			<div id="jqxgrid_invacpm" style="margin-top:20px; margin-bottom:20px;"></div>
                </td>
           </tr>	
           <tr class="invacpm">      	  
                 
                 <td>
                  	  Galones<input type="text" name="galones" id="galones2" value="0" alt="integer" class="reset required valor_total_galon" style="width:110px" readonly/>
                 </td>
                 <td>    
					  Total
                      <input type="text" name="acpm2" id="acpm2" value="0" alt="decimal" class="required reset" style="width:120px" readonly />               
                 </td>
           </tr>
           
           <tr class="transferencia">                
                  <td width="120">Valor ACPM para el suministro:</td> 
                  <td>
                  	  Galones<input type="text" name="galones" id="galones" value="0" alt="integer" class="reset required valor_total_galon" style="width:110px"/>
                  </td>
                  <td>    
                      V. Gal&oacute;n<input type="text" name="valor_galon" id="valor_galon" value="0" alt="decimal" class="required valor_total_galon reset" style="width:110px"/>
                   </td>
                  <td>    
					  Total
                      <input type="text" name="acpm" id="acpm" value="0" alt="decimal" class="required reset" style="width:120px" readonly />               
                  </td>
		   </tr>
           <tr class="transferencia">       

                  <td>Valor Viaticos - TOES :</td>
                  <td>
                      <input type="text" name="toes" id="toes" value="0" alt="decimal" class="required reset" />                  </td> 
                  <td>Valor Transporte - Trasiego o Mular:</td>
                  <td>
                      <input type="text" name="valor_transporte" value="0" id="valor_transporte" alt="decimal" class="required reset"/>      
                      <input type="hidden" name="valor_hito" id="valor_hito" value="0" alt="decimal" class="required reset" />                 
                  </td>  
           </tr> 

           <tr>
                <td colspan="2">
                	<br/>
                    <input name="agregar" type="submit" id="agregar" value="Agregar Item" class="btn_table transferencia"/>
                    <br/>
                    <input name="agregarACPM" type="submit" id="agregarACPM" value="Agregar ACPM" class="btn_table invacpm"/>
                </td>
           </tr>

    	  </tbody>	

    	</table>

	</form>

	<div id="jqxgrid2" style="margin-top:20px; margin-bottom:20px;"></div>

</div>  

      

<div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

    <input name="modificar" type="submit" id="modificar" value="Guardar" class="btn_table" />

    <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar(<?=$id_anticipo?>);"  class="btn_table"/>                   

</div>

<style>
	.invacpm{ display:none; }
</style>

<script type="text/javascript">

$(document).ready(function () {

			$('.valor_total_galon').change(function(){
		   
			   var galones = $('#galones').val();
			   var valor_galon = $('#valor_galon').val();
			   var total_neto = 0;
			   var retencion = 0;
			   var concepto = <?=($valor_concepto!='')?$valor_concepto:0?>
			   
			   var res = valor_galon.split(",00");
			   valor_galon = parseInt(res[0].replace('.',''));
			   
			   total_neto = galones * valor_galon;
			   retencion = total_neto * concepto;
			   
			   total = total_neto - retencion;
			   
			   console.log(parseInt(total)) 
			   
			   $('#acpm').val(parseInt(total)+',00');		   
			});

            var source = {
                 datatype: "json",
                 datafields: [
					 { name: 'i.id', type: 'number'},
					 { name: 'id_hitos', type: 'number'},
					 
					 { name: 'cant_galones', type: 'number'},
					 { name: 'valor_galon', type: 'number'},
					 { name: 'acpm', type: 'number'},
					 
					 { name: 'valor_transporte', type: 'number'},
					 { name: 'toes', type: 'number'},
					 { name: 'total_hito', type: 'number'},
                     //{ name: 'valor_hito', type: 'string'},			
					 { name: 'acciones', type: 'string'}						 
                ],

				updaterow: function (rowid, rowdata, commit) {

                    // synchronize with the server - send update command

                    // call commit with parameter true if the synchronization with the server is successful 

                    // and with parameter false if the synchronization failder.

                    commit(true);

                },

				cache: false,

			    url: 'ajax_list_items.php?id=<?=$id_anticipo?>',

				root: 'Rows',

				sortcolumn: 'i.id',

                sortdirection: 'desc',

				filter: function()

				{

					// update the grid and send a request to the server.

					$("#jqxgrid2").jqxGrid('updatebounddata', 'filter');

				},

				sort: function()

				{

					// update the grid and send a request to the server.

					$("#jqxgrid2").jqxGrid('updatebounddata', 'sort');

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

				});

            var dataadapter = new $.jqx.dataAdapter(source);

            $("#jqxgrid2").jqxGrid({
                width: '100%',
				height: 260,
                source: dataadapter,
				editable: false,
                showfilterrow: false,
                pageable: true,
                filterable: false,
                theme: theme,
				sortable: true,
                rowsheight: 40,
                columnsresize: true,
				virtualmode: true,
				
				showstatusbar: true,
                statusbarheight: 50,
				showaggregates: true,
				
				rendergridrows: function(obj){  return obj.data;   },                
                columns: [

				  { text: '-', datafield: 'acciones', filtertype: 'none', width:40, cellsalign: 'center', editable: false },

                   { text: 'Item', datafield: 'i.id', filtertype: 'textbox', filtercondition: 'equal', width: 60,  columntype: 'textbox', editable: false },

                  { text: 'Hito', datafield: 'id_hitos',  filtertype: 'textbox', filtercondition: 'starts_with',  width: 150, editable: false },
				  
				  { text: 'Valor Gal. ACPM', datafield: 'valor_galon', filtertype: 'none', width: 120, cellsalign: 'right',cellsformat: 'c2'  },

				  { text: 'Cant. Galones', datafield: 'cant_galones', filtertype: 'none', width: 80, cellsalign: 'right', aggregates: ['sum'], aggregatesrenderer: function (aggregates) {
					  	  //console.log(aggregates)	;				  	
                          var renderstring = "";
                          $.each(aggregates, function (key, value) {
                              var name = key == 'sum' ? 'Total Galones' : 'Max';
                              renderstring += '<div style="position: relative; margin: 4px; overflow: hidden;">' + name + ':<br/> ' + value +'</div>';
                          });
                          return renderstring;
                      } 
				  },
				  
				  { text: 'Neto ACPM', datafield: 'acpm', filtertype: 'none', width: 100, cellsalign: 'right',cellsformat: 'c2', aggregates: ['sum'], aggregatesrenderer: function (aggregates) {
					  	  //console.log(aggregates)	;				  	
                          var renderstring = "";
                          $.each(aggregates, function (key, value) {
                              var name = key == 'sum' ? 'Total ACPM' : 'Max';
                              renderstring += '<div style="position: relative; margin: 4px; overflow: hidden;">' + name + ':<br/> ' + value +'</div>';
                          });
                          return renderstring;
                      } 
				  },	 
				  
				  { text: 'Valor Transporte', datafield: 'valor_transporte', filtertype: 'none', width:130, cellsalign: 'right', cellsformat: 'c2' },

                  { text: 'TOES', datafield: 'toes', filtertype: 'none', width: 130, cellsalign: 'right',cellsformat: 'c2'  },

				  { text: 'Neto Hito', datafield: 'total_hito', filtertype: 'none', width: 130, cellsalign: 'right' ,cellsformat: 'c2', aggregates: ['sum'], aggregatesrenderer: function (aggregates) {
					  	  //console.log(aggregates)	;				  	
                          var renderstring = "";
                          $.each(aggregates, function (key, value) {
                              var name = key == 'sum' ? 'Total Hito' : 'Max';
                              renderstring += '<div style="position: relative; margin: 4px; overflow: hidden;">' + name + ':<br/> ' + value +'</div>';
                          });
                          return renderstring;
                      } 
				  }
                  /*{ text: 'Valor Cotizado', datafield: 'valor_hito', filtertype: 'none', width: 130, cellsalign: 'right' }*/
                ]

            });			

            $("#jqxgrid2").on('cellendedit', function (event) {

                var args = event.args;
				var id = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'id');

				if(args.datafield == 'fecha'){
					var formattedDate = $.jqx.dataFormat.formatdate(args.value, 'yyyy-MM-dd');
					args.value = formattedDate;
				}

		   		$.ajax({
					  type: 'POST',
					  dataType: 'json',
					  url: 'ajax_update_item.php',
					  data: {	id_item: id,
								campo: args.datafield,
								valor: args.value
				      },
					  success: function(data){	
						  if (data.estado == true){}
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
			
			/*$("#agregar").click(function(){
				updateItemsACPM();
			});*/
			
			// Modulo de salida acpm			
			
		
					
			$(".typeInv").click(function(){	
			
				$('.reset').val(0);							
				if($(this).val() == 'i'){
					$('#tipoingreso').val('invacpm');
					$('.transferencia').hide();
					$('.invacpm').show();					
					
					$('#prioridad option, .giro_check').attr('disabled','disabled');					
					$('#prioridad option[value=GIRADO]').removeAttr('disabled','disabled').attr('selected','selected');
					$('#giro').attr('readonly','readonly')
					$('.fechaaprobado').show();
					
				}else{	
					$('#tipoingreso').val('transferencia');				
					$('.invacpm').hide();  
					$('.transferencia').show();
					
					$('#giro').removeAttr('readonly','readonly')
					
					$('#prioridad option, .cedula_consignar, .cedula_consignar option, .giro_check').removeAttr('disabled','disabled');
					$('.fechaaprobado').hide();
				}			
				$("#jqxgrid_invacpm").jqxGrid({ editable: false });
				getloadbeneficiarios($(this).val());
			});
			
			
			var getloadbeneficiarios = function(tipoitem){
				
				loaderSpinner();
				
				$.getJSON('ajax_list_beneficiarios.php', {tipo_item:tipoitem}, function (data) {

					  var options = $('.cedula_consignar');

					  $('.cedula_consignar').empty();
					  $('.cedula_consignar').append('<option value="">Seleccione..</option>');				
					  
					  if(data.length > 0){
						  $.each(data, function (i, v) { 
							  options.append($("<option></option>")
												.val(v.identificacion)
												.text(v.identificacion)
												.attr('nombre',v.beneficiario)
												.attr('entidad',v.entidad)
												.attr('numcuenta',v.num_cuenta)
												.attr('tipocuenta',v.tipo_cuenta)
											);
						  });
						  stoploaderSpinner();						  
					  }else{
						  stoploaderSpinner();
						  alert('No tiene ningun reintegro de ACPM');
					  }
					  $('.chosen-select').trigger("chosen:updated");					 
				});				
			};
			
			$('.cedula_consignar').change(function(){
				
				var tipo = $(".typeInv:radio[name='opcionivn']:checked").val();
				var cedula = $(this).val();
				
				
				if(tipo == 'i' && $(this).val() != ''){				
					swal({   
						title: "Esta seguro?",   
						text: "Estas seguro, de seleccionar este beneficiario?",   
						type: "warning",   
						showCancelButton: true,   
						confirmButtonColor: "#DD6B55",   
						confirmButtonText: "Si",   
						closeOnConfirm: true 
					},function(res){   
						if(res){
							getItemHitosById(cedula);
							
							$(".cedula_consignar").val(cedula);
							$(".cedula_consignar").attr('readonly','readonly');							
							$(".chosen-select").trigger("chosen:updated");
							
							$("#jqxgrid_invacpm").jqxGrid({ editable: true });
						}else{
							$(this).val('');
							$('#beneficiario,#banco,#tipo_cuenta,#num_cuenta,#observaciones').val('');
						}						
					});
				}
					
				$(".chosen-select").trigger("chosen:updated");				
					
			});
			
			/*Modulo de la grilla de inv de acpm por numero de identificacion*/
			var getItemHitosById = function(numidentificacion){
			  
				var seturl = 'ajax_data_invacpm.php?beneficiario='+numidentificacion; 
				
				var source_items = {
					datatype: "json",
					datafields: [
						 { name: 'id', type: 'number'},
						 { name: 'id_prestaciones', type: 'string'},					 
						 { name: 'id_regional', type: 'string'},
						 { name: 'beneficiarios', type: 'string'},
						 { name: 'descripcion', type: 'string'},
						 { name: 'cant_galones', type: 'number'},
						 { name: 'costo_unitario', type: 'number'},
						 { name: 'id_ps_state', type: 'string'},
						 { name: 'id_hito', type: 'number'},	  	
						 { name: 'id_anticipo', type: 'number'},	
						 { name: 'fecha_registro', type: 'date'},
						 { name: 'cant_salida_gal', type: 'number'}	
					],
					updaterow: function (rowid, rowdata, commit) {
						// synchronize with the server - send update command
						// call commit with parameter true if the synchronization with the server is successful 
						// and with parameter false if the synchronization failder.
						commit(true);
					},
					cache: true,
					url: seturl,
					sortcolumn: 'id',
					sortdirection: 'desc',
					filter: function()
					{
						// update the grid and send a request to the server.
						$("#jqxgrid_invacpm").jqxGrid('updatebounddata', 'filter');
					},
					sort: function()
					{
						// update the grid and send a request to the server.
						$("#jqxgrid_invacpm").jqxGrid('updatebounddata', 'sort');
					},
					root: 'Rows',
					beforeprocessing: function(data)
					{		
						if (data != null){
							source_items.totalrecords = data[0].TotalRows;					
						}
					}};		
		
					var dataadapter_items = new $.jqx.dataAdapter(source_items, {
						loadError: function(xhr, status, error){
							alert(error);
						}
					});	
					 // update data source.			
					$("#jqxgrid_invacpm").jqxGrid({ source: dataadapter_items });						
			};
			
			
								
			/*var source = {
                 datatype: "json",
                 datafields: [
					 { name: 'id', type: 'number'},
					 { name: 'id_prestaciones', type: 'string'},					 
					 { name: 'id_regional', type: 'string'},
					 { name: 'beneficiarios', type: 'string'},
					 { name: 'descripcion', type: 'string'},
					 { name: 'cant_galones', type: 'number'},
					 { name: 'costo_unitario', type: 'number'},
					 { name: 'id_ps_state', type: 'string'},
                     { name: 'id_hito', type: 'number'},	  	
					 { name: 'id_anticipo', type: 'number'},	
					 { name: 'fecha_registro', type: 'date'},
					 { name: 'cant_salida_gal', type: 'number'}						 
                ],
				updaterow: function (rowid, rowdata, commit) {
                    commit(true);
                },
				cache: false,
			    url: 'ajax_data_invacpm.php',
				root: 'Rows',
				sortcolumn: 'id',
                sortdirection: 'desc',
				filter: function(){
					// update the grid and send a request to the server.
					$("#jqxgrid_invacpm").jqxGrid('updatebounddata', 'filter');
				},
				sort: function(){
					// update the grid and send a request to the server.
					$("#jqxgrid_invacpm").jqxGrid('updatebounddata', 'sort');
				},
				root: 'Rows',
				beforeprocessing: function(data){		
					if (data != null){
						source.totalrecords = data[0].TotalRows;					
					}
				}
			};		

			var dataadapter = new $.jqx.dataAdapter(source, {
				loadError: function(xhr, status, error){
					alert(error);
				}
			});

            var dataadapter = new $.jqx.dataAdapter(source);*/
			
			$("#jqxgrid_invacpm").jqxGrid({
                width: '100%',
				height: 260,
				editable: false,
                showfilterrow: false,
                pageable: true,
                filterable: false,
                theme: theme,
				sortable: true,
                rowsheight: 25,
                columnsresize: true,
				virtualmode: true,
				rendergridrows: function(obj){
					 return obj.data;      
				},                
                columns: [ 				
                  { text: 'ID', datafield: 'id', filtertype: 'textbox', filtercondition: 'equal', width: 40,  columntype: 'textbox', editable: false },
				  
				  { text: 'C&oacute;digo', datafield: 'id_prestaciones', filtertype: 'textbox', filtercondition: 'equal', width: 60,  columntype: 'textbox', editable: false },
				  
				  { text: 'Regi&oacute;n', datafield: 'id_regional', filtertype: 'textbox', filtercondition: 'equal', width: 70,  columntype: 'textbox', editable: false },
				  
				  { text: 'Beneficiario', datafield: 'beneficiarios', filtertype: 'textbox', filtercondition: 'equal', width: 60,  columntype: 'textbox', editable: false },

                  /*{ text: 'Descripci&oacute;n', datafield: 'descripcion', columntype: 'textbox', filtertype: 'textbox', width: 100, editable: false },*/

				  { text: 'Cant. Galones', datafield: 'cant_galones', filtertype: 'textbox', width: 60, cellsalign: 'right', editable: false },
				  
				  { text: 'Costo Unitario', datafield: 'costo_unitario', filtertype: 'textbox', cellsformat: 'c2',cellsalign: 'right', editable: false },

				  { text: 'Departamento', datafield: 'id_ps_state', filtertype: 'none', width:80, cellsalign: 'right', cellsformat: 'c2', editable: false },

                  { text: 'ID Hito', datafield: 'id_hito', filtertype: 'textbox', width: 60, cellsalign: 'right',editable: false },
				  { text: 'ID Anticipo', datafield: 'id_anticipo', filtertype: 'textbox', width: 60, cellsalign: 'right', editable: false },
				  { text: 'Fecha Registro', datafield: 'fecha_registro', filtertype: 'date', width: 80, cellsformat: 'yyyy-MM-dd HH:mm:ss', editable: false },
				  
				  { text: 'Cant. Gal Salida', datafield: 'cant_salida_gal', filtertype: 'textbox', width: 100, cellsalign: 'right'}				   
                ]
            });	
			
			// validacion de ingreso de ACPM
			$("#jqxgrid_invacpm").on('cellendedit', function(event) {
				var args = event.args;
				var totalGal = 0, valor_total = 0;	
				var rows = $('#jqxgrid_invacpm').jqxGrid('getrows');
				var cant_galones = $("#jqxgrid_invacpm").jqxGrid('getcellvalue',args.rowindex,'cant_galones');
				var costo_unitario = $("#jqxgrid_invacpm").jqxGrid('getcellvalue',args.rowindex,'costo_unitario');
						
				if(args.value <= cant_galones){				
					$.each(rows,function(index,value){
						if(index != args.rowindex){
							totalGal += value.cant_salida_gal;
							valor_total += (value.cant_salida_gal * value.costo_unitario);
						}
					});
					
					totalGal += parseInt(args.value);
					valor_total += parseInt(args.value * costo_unitario);
					
					$('#galones2').val(totalGal);
					$('#acpm2').val(valor_total);
				}else{
					$("#jqxgrid_invacpm").jqxGrid('setcellvalue',args.rowindex, 'cant_salida_gal', 0);
					alert('La cantidad de galones de salida supera a la cantidad');
				}
	  		});	

});

</script>      



<script language="javascript" type="text/javascript">

$(document).ready(function(){

		$(".chosen-select").chosen({width:"220px"}); 
		$('input').setMask();	
		$(".btn_table").jqxButton({ theme: theme });
		
		$('#modificar').click(function(){
			$("#frm_per").submit(); 
		});

		$("#frm_per").validate({
			rules:{
				cedula_consignar:{
					required: true,
				}
			},
			messages: {
				cedula_consignar: "Falta cedula"
			},
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente modificar estos parametros?')
				if (respuesta)
					form.submit();
			}
		});


		$("#frm_item").validate({
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
				var respuesta = confirm('\xBFDesea realmente agregar este item?')
				if (respuesta)
					form.submit();
			}
		});


		$('#prioridad').blur(function(){
			var variable = $(this).val().toUpperCase();
			$(this).val(variable);
		});

		
		$('#prioridad').change(function(){
			
			if($(this).val() == 'GIRADO'){
				$('.fechaaprobado').css('display','block');
				$('#fechaapr').addClass('required');
			}else {
				$('.fechaaprobado').css('display','none');
				$('#fechaapr').removeClass('required');
				$('#fechaapr').val('');
			}
		});
		

		$('.cedula_consignar').change(function(){

			var nombre, banco, tipocuenta, numcuenta;

			$( ".cedula_consignar option:selected" ).each(function() {

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
		
		$('.nombre_responsable').change(function(){
			var cedula;
			$( ".nombre_responsable option:selected" ).each(function() {
			  cedula = $( this ).attr('cedula');
			});
			$('.cedula_responsable').val(cedula);
		});

		$('.orden_trabajo').change(function(){ 

			var orden;
			$('.hitos').empty();
			var proyecto = $( this ).val();	
			
			console.log(proyecto)		

			$.getJSON('ajax_list_hitos_orden.php', {id_proyecto:proyecto}, function (data) { 

					if(data != null){

						var options = $('.hitos');

						$('.hitos').empty();

						$('.hitos').append('<option value="">Seleccione..</option>');				


						$.each(data, function (i, v) { 
						
							/*if(v.valido == 0)
								options.append($("<option style='background-color:red;'></option>").val(v.id).text(v.orden+' ('+v.estado+')'));
							else*/
							if(v.estado != 'LIQUIDADO')
								options.append($("<option></option>").val(v.id).text(v.orden));
							else
								options.append($("<option disabled></option>").val(v.id).text(v.orden));
						});

						$(".hitos").trigger("chosen:updated");

					}else{ 

						alert('No se encontraron hitos para esta orden de trabajo');
						$('.hitos').empty();
						$('.hitos').append('<option value="">Seleccione..</option>');
						$(".hitos").trigger("chosen:updated");					
					}
			});
		});

		

		var regional_actual;

		$('.var_ordenes').change(function(){ 

			$('#orden_trabajo').empty();

			$("#orden_trabajo").trigger("chosen:updated");

			$('.hitos').empty();
			$(".hitos").trigger("chosen:updated");

			var regional = $('#regional').val();
			var centrocosto = $('.centros_costos').val(); 

			if(regional != '0' && regional_actual != regional ){

				$.getJSON('ajax_list_responsable.php', { id_regional:regional }, function (data) {

						var options = $('.nombre_responsable');

						$('.nombre_responsable').empty();

						$('.nombre_responsable').append('<option value="">Seleccione..</option>');				

						$.each(data, function (i, v) { 
							options.append($("<option></option>").val(v.nombre).text(v.nombre).attr('cedula',v.cedula));
						});

						$(".nombre_responsable").trigger("chosen:updated");
						regional_actual = regional;
						$('.cedula_responsable').val('');
				});
			}

			
			if(regional != '0' && centrocosto != '0'){
			/* Get Ordenes de trabajo   */	 

				$.getJSON('ajax_list_ordenes_trabajo.php', {id_regional:regional, id_centroscostos:centrocosto}, function (data) {

						var options = $('.orden_trabajo');

						$('.orden_trabajo').empty();

						$('.orden_trabajo').append('<option value="">Seleccione..</option>');				

						$.each(data, function (i, v) { 

							options.append($("<option></option>").val(v.id).text(v.orden));

						});

						$(".orden_trabajo").trigger("chosen:updated");

				});

			}else{
				$('#mensaje').show();
			}
		});
		
		$('#regional').change(function(){ 
			
			var idRegional = $(this).val();
			if(idRegional != 0){
				
				//console.log(idRegional)
				/* Get centro de costos */	 
				$.getJSON('ajax_list_centrocostos.php', {id_regional:idRegional}, function (data) {

						var options = $('.centros_costos');
						$('.centros_costos').empty();
						$('.centros_costos').append('<option value="0">Seleccione..</option>');				
						
						$.each(data, function (i, v) { 
							options.append($("<option></option>").val(v.id).text(v.sigla+' - '+v.nombre));
						});

						$('.centros_costos').trigger("chosen:updated");
				});
			}else{
				$('.centros_costos').empty();
				$('.centros_costos').append('<option value="0">Seleccione..</option>');
				$('.centros_costos').trigger("chosen:updated");
				/*$('#nombre_responsable_chosen').empty();
				$('#nombre_responsable_chosen').append('<option value="0">Seleccione..</option>');
				//$("#nombre_responsable_chosen").trigger("chosen:updated");*/
			}
		});
	});

	function replaceAll( text, busca, reemplaza ){

	  while (text.toString().indexOf(busca) != -1)
		  text = text.toString().replace(busca,reemplaza);
	  return text;
	}
 
	$('.anticipo').blur(function(){
		var total = 0;
		$('.anticipo').each(function( index ) {
			var val = replaceAll($( this ).val(),".","");
			total += parseFloat(val);
		});
		$('#total_anticipo').val(total+',00').setMask(); 
	});
	
	$('.centros_costos').change(function(){
		$('#centro_costo_item').val($(this).val());
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

	

	/*function fn_agregar(){

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

					$("#jqxgrid").jqxGrid('updatebounddata', 'cells');

				}

			}

		});

	};*/

function fn_agregar_item(){ 

	var tipoServicio = $('#tipoingreso').val();
	
	if(tipoServicio == 'invacpm')
		updateItemsACPM();
		
	else{
		var str = $("#frm_item").serialize();
		var value1, value2, value3, value11, value22;
	
		$.ajax({
			  type: 'POST',
			  dataType: 'json',
			  url: 'ajax_agregar_item.php', 
			  data: str,
			  success: function(data){	
		
				  if (data.estado == true){ 
				  
					 $("#total_anticipo, #test_total").val(data.total_anticipo);
					 $("#jqxgrid2").jqxGrid('updatebounddata');
		
					 value1 = 0;
					 value11 = replaceAll($("#valor_hito").val(),".","");
					 value1 += parseFloat(value11);
		
					 if($("#v_cotizado").val().length == 0)
						 value2 = 0;
					 else{
						 value2 = 0;
						 value22 = replaceAll($("#v_cotizado").val(),".","");
						 value2 += parseFloat(value22);
						 value2 = parseFloat($("#v_cotizado").val().replace('.','').replace(',','.'));
					 }
		
					 value3 = value1+value2;
					 $("#v_cotizado").val(value3.toString());
		
				  }else{
					  $('.blockPage').css('z-index','993');
					  //sweetAlert("Oops...", data.message, "error");
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
					  //alert(data.message);
				  }
			  }
	   });
	}// fin del tipo servicio
}

function updateItemsACPM(){
	
	var rows = $('#jqxgrid_invacpm').jqxGrid('getrows');	
	var arrayData = new Array();
	
	$.each(rows,function(index,value){
		if(value.cant_salida_gal != 0)
			arrayData.push({	'id':value.id,
								'cant_galones':value.cant_galones,
								'cant_salida_gal':value.cant_salida_gal,
								'costo_unitario':value.costo_unitario
							});
	});	
	
	$.ajax({ 
		  type: 'POST',
		  dataType: 'json',
		  url: 'ajax_update_inventario_item.php',
		  data: { 	datos:arrayData, 
		  			hitos: $('.hitos').val(), 
					idanticipo: <?=$id_anticipo?>,
					centro_costo_item:$('#centro_costo_item').val() 
		  }, 
		  success: function(data){
			   if (data.estado == true){ 
			   		$("#total_anticipo, #test_total").val(data.total_anticipo);
				  	$("#jqxgrid2").jqxGrid('updatebounddata');
				  	$("#jqxgrid_invacpm").jqxGrid('updatebounddata', 'cells'); 
			   }else{
			   		  $('.blockPage').css('z-index','993');
					  //sweetAlert("Oops...", data.message, "error");
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
			   }
		  }											
	});		

}

</script>