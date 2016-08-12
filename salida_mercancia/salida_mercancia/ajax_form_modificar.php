<?  header('Content-type: text/html; charset=iso-8859-1');

	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}

	include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("select * from solicitud_despacho where id=%d",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);

	if ($num_rs_per==0){
		echo "No existen solicitudes de despacho con ese ID";
		exit;
	}

	$rs_per = mysql_fetch_assoc($per);
	$id_despacho = $rs_per['id'];
	
	$sql = "SELECT * FROM materiales WHERE id_despacho =".(int)$_POST['ide_per'];
  	$resultado = mysql_query($sql) or die(mysql_error());
	$noaprobado = true;

	while($row2 = mysql_fetch_assoc($resultado)):
		if($row2['aprobado']>=1):
			$noaprobado = false;
		endif;				  
	endwhile;
?>

<h1>Formato Solicitud de Despacho No.:<?=$id_despacho?></h1>

<table>

        <tbody>

       	  <tr>

                <td style="font-weight:bold;">Fecha Solicitud:</td>

                <td><?=$rs_per['fecha_solicitud']?></td>

          </tr>

          <tr>

                <td style="font-weight:bold;">Fecha Entrega:</td>

                <td><?=$rs_per['fecha_entrega']?></td>

              

                <td style="font-weight:bold;">Prioridad:</td>

                <td><?=$rs_per['prioridad']?></td>

            </tr> 

            

            <tr>

            	<td colspan="2"><h3>Responsable de la Solicitud</h3></td>

            </tr>

            

            <tr>

            	<td style="font-weight:bold;">Regional:</td>

                <td>

                 <? 

				 	$sqlPry = "SELECT * FROM regional WHERE id =".$rs_per['id_regional']; 

                    $qrPry = mysql_query($sqlPry);

					$rsPry = mysql_fetch_array($qrPry);

                 	echo $rsPry['region'];

				 ?>

                </td> 

                <td colspan="2">

                	<div id="mensaje" class="alert" style="display:none;">Debe selecionar Regional y Centro Costos.</div>   

                </td>  

            </tr>

            <tr>        

                <td style="font-weight:bold;">Nombre:</td>

                <td><?=$rs_per['nombre_responsable']?></td>

                

                <td style="font-weight:bold;">Cedula:</td>

                <td><?=$rs_per['cedula_responsable']?></td> 

           </tr>         

           <tr> 

                <td style="font-weight:bold;">Centro Costo:</td>

                <td>

                    <? 

						$sqlPry = "SELECT * FROM linea_negocio WHERE id =".$rs_per['id_centrocostos'];

                    	$qrPry = mysql_query($sqlPry);

                        $rsPry = mysql_fetch_array($qrPry);

					?>

                    <?=$rsPry['codigo']?> - <?=$rsPry['nombre']?>

                </td>            

         

            	<td style="font-weight:bold;">Orden Trabajo:</td>

                <td>

                    <? 

						$sqlPry = "SELECT * FROM orden_trabajo WHERE id_proyecto =".$rs_per['id_proyecto'];

                    	$qrPry = mysql_query($sqlPry);

                        $rsPry = mysql_fetch_array($qrPry);

					?>

                    <?=$rsPry['orden_trabajo'];?>

                </td>

           </tr> 

           <tr>

               <td style="font-weight:bold;">Hitos:</td>

               <td>                     

                	<? 

						$sqlPry = "SELECT * FROM hitos WHERE id =".$rs_per['id_hito'];

                    	$qrPry = mysql_query($sqlPry);

                        $rsPry = mysql_fetch_array($qrPry);

					?>

                    <?=$rsPry['nombre'];?>        

               </td> 

           </tr>

           

        </tbody>

    </table>  

	<br />

    <table>

            <tr>

              <td style="font-weight:bold;">Direcci&oacute;n de entrega</td>

              <td><?=$rs_per['direccion_entrega']?></td>

              <td style="font-weight:bold;">Nombre de quien recibe</td>

              <td><?=$rs_per['nombre_recibe']?></td>

            </tr>

            <tr>

              <td style="font-weight:bold;">Tel&eacute;fono / Celular</td>

              <td><?=$rs_per['celular']?></td>

              <td style="font-weight:bold;">Descripci&oacute;n:</td>

              <td><?=$rs_per['descripcion']?></td>

            </tr> 
            
            <? if(in_array(164, $_SESSION['permisos'])): ?>
            <tr>
            	<td style="font-weight:bold;">Cambio estado:</td>
                <td>
                	<form id="frm_per">
                    <input type="hidden" name="id" value="<?=$_POST['ide_per']?>">
                	<select name="cambio_estado" id="cambio_estado">
                    	<option value="Pendiente" <?=($rs_per['estado']=='Pendiente')?'selected':''?>>Pendiente</option>
                        <option value="ELIMINADO" <?=($rs_per['estado']=='ELIMINADO')?'selected':''?>>Eliminado</option>
                    </select>
                    </form>		                
                </td>
            </tr>
            <? endif; ?>

    </table>   

</div>

<div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

    <input name="cancelar" type="button" id="cancelar" value="Cerrar" onclick="fn_cerrar('');" class="btn_table"/>			  	
    <? if(in_array(162,$_SESSION['permisos'])): ?>
    <input type="button" id="viewFormMaterial" value="Agregar un Material" class="btn_table"/>    
	<? endif; ?>         
    
    <? if(in_array(164, $_SESSION['permisos'])): ?>   
    <input type="button" id="btnCambioestado" value="Cambio Estado" class="btn_table"/> 
    <? endif; ?>  
</div>

<span>Los campos con el signo * guarda los cambios en la base de datos</span>
<div id="jqxgrid2" style="margin-top:20px; margin-bottom:20px;"></div>



<link rel="stylesheet" href="/js/chosen/chosen.css">

<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 



<script type="text/javascript">

$(document).ready(function () {
	
		window.localStorage.removeItem("idParent");

		$(".chosen-select").chosen({width:"200px"}); 

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

		/*--------------------------------------------------------------------------------------*/

        var source =
		{
                 datatype: "json",
                 datafields: [
					 { name: 'id', type: 'number'},
					 { name: 'codigo', type: 'string'},
					 { name: 'name_material', type: 'string'},
					 { name: 'presupuesto', type: 'number'},
					 { name: 'cantidad_solicitada', type: 'number'},
					 { name: 'cantidad_inventario', type: 'number'},
					 { name: 'costo_uninventario', type: 'number'},
					 { name: 'estado', type: 'string'},
					 
					 { name: 'cantidadc', type: 'number'},
					 { name: 'costo_unidadcompra', type: 'number'},
					 
					 { name: 'cantidadentinv', type: 'number'},
					 { name: 'cantidadentcomp', type: 'number'},
					 { name: 'cantidade', type: 'number'},
					 
					 { name: 'costoinv', type: 'number'},
					 { name: 'costocomp', type: 'number'},
					 
					 { name: 'costo', type: 'number'},	
						
					 { name: 'observacion', type: 'string'},			
					 { name: 'acciones', type: 'string'},
					 { name: 'iva2', type: 'string'},
					 { name: 'orden_compra2', type: 'string'},
					 
					 { name: 'valor_adjudicado', type: 'number'},
					 { name: 'total', type: 'number'},
					 
					 { name: 'num_factura', type: 'number'},
					 { name: 'orden_compra', type: 'number'},
					 { name: 'proovedor', type: 'string'},
					 { name: 'fecha_factura', type: 'date'},	
					 { name: 'fecha_vencimiento', type: 'date'}					 
                ],
				updaterow: function (rowid, rowdata, commit) {
                    // synchronize with the server - send update command
                    // call commit with parameter true if the synchronization with the server is successful 
                    // and with parameter false if the synchronization failder.
                    commit(true);
                },
				cache: true,
			    url: 'ajax_list_materiales.php?id=<?=(int)$_POST['ide_per']?>',
				root: 'Rows',
				sortcolumn: 'id',
                sortdirection: 'desc',
				filter: function()
				{
					// update the grid and send a request to the server.
					$("#jqxgrid2").jqxGrid('updatebounddata', 'filter');
				},
				sort: function()
				{// update the grid and send a request to the server.
					$("#jqxgrid2").jqxGrid('updatebounddata', 'sort');
				},
				root: 'Rows',
				beforeprocessing: function(data)
				{		
					if (data != null){
						source.totalrecords = data[0].TotalRows;					
					}
				}
		};		

		var dataadapter2 = new $.jqx.dataAdapter(source, {
				loadError: function(xhr, status, error)
				{
					alert(error);
				}
		});
		
		var tooltiprenderer = function (element) {
                $(element).jqxTooltip({position: 'mouse', content: $(element).text() });
            }

      	//var dataadapter = new $.jqx.dataAdapter(source);

        $("#jqxgrid2").jqxGrid({
				width: '100%',
				autoheight: true,
                source: dataadapter2,
                showfilterrow: true,
				editable: true,
                pageable: false,
                filterable: true,
                theme: theme,
				sortable: false,
                columnsresize: true,
				virtualmode: true,
				autorowheight: true,
				showstatusbar: true,
                statusbarheight: 50,
				showaggregates: true,
                //autoheight: true,
				enabletooltips: false,
                selectionmode: 'multiplecellsadvanced',
				rendergridrows: function(obj)
				{
					 return obj.data;      
				},                
                columns: [
				  <?php 
				  	if($noaprobado): 
				  		$text = '<a href="javascript:" class="aprobarALL" onclick="fn_aprobar_allitems('.$id_despacho.');" style="z-index:1000;"><img src="https://cdn2.iconfinder.com/data/icons/color-svg-vector-icons-part-2/512/ok_check_yes_tick_accept_success-16.png" /></a>';
					else:
						$text = '-';
				  	endif; 
				  ?>
				  { text: '<?=$text?>', 
				  	datafield: 'acciones', filtertype: 'none', width:60, cellsalign: 'center', editable: false, sortable:false },
                  { text: 'Item', datafield: 'id', filtertype: 'textbox', hidden: true , filtercondition: 'equal',  columntype: 'textbox', editable: false },
				  { text: 'C&oacute;digo', datafield: 'codigo', filtertype: 'textbox', filtercondition: 'equal',  columntype: 'textbox', editable: false, width:70 },
				  
				   { text: 'Nombre Material', datafield: 'name_material', filtertype: 'textbox', filtercondition: 'equal',  columntype: 'textbox', editable: false, width:100 },
				   { text: 'Presupuesto', datafield: 'presupuesto', filtertype: 'textbox', filtercondition: 'equal',  columntype: 'none', editable: false, width:80, cellsformat: 'c2'},
				  
				  { text: 'Cant. Solicitada', datafield: 'cantidad_solicitada', filtertype: 'none', cellsalign: 'center',editable: false, width:70,rendered: tooltiprenderer  },
				  { text: 'Cant. Inventario', datafield: 'cantidad_inventario', filtertype: 'none', cellsalign: 'center', editable: false, width:70,rendered: tooltiprenderer  },
				  { text: 'Cost. Unitario Inventario', datafield: 'costo_uninventario', columntype: 'numberinput', filtertype: 'none', cellsalign: 'right',editable: false, cellsformat: 'c2', width:100, rendered: tooltiprenderer },
				  
				  { text: 'Estado', datafield: 'estado', filtertype: 'none', cellsalign: 'center', editable: false, width:70 },
				  { text: 'IVA', datafield: 'iva2', filtertype: 'none', cellsalign: 'right', editable: true, columntype: 'numberinput', width:40,
                      createeditor: function (row, cellvalue, editor) {
                          editor.jqxNumberInput({ decimalDigits: 2, digits: 3 });
                      }
				  },
				  
				  { text: 'OC', datafield: 'orden_compra2', filtertype: 'none', cellsalign: 'right', editable: true, sortable:false, width:50 },		
				   
				  //campos de unidades compradas
				  { text: 'Cant. Comprada', datafield: 'cantidadc', align: 'right', cellsalign: 'right', sortable:false,columntype: 'numberinput', width:90, filtertype: 'none',rendered: tooltiprenderer ,editable: true,
					  validation: function (cell, value) {
						  if (value < 0) {
							  return { result: false, message: "La cantidad Comprada no puede ser negativa" };
						  }
						  return true;
					  },
					  createeditor: function (row, cellvalue, editor) {
                          editor.jqxNumberInput({ decimalDigits: 0});  
                      }
				  },
				  { text: 'Costo Unidad Comprada', datafield: 'costo_unidadcompra', align: 'right', cellsalign: 'right', cellsformat: 'c2', columntype: 'numberinput', editable: true, sortable:false, filtertype: 'none', width:100,
                      validation: function (cell, value) {
                          if (value < 0) {
                              return { result: false, message: "Precio no debe ser negativo" };
                          }
                          return true;
                      },
                      createeditor: function (row, cellvalue, editor) {
                          editor.jqxNumberInput({ decimalDigits: 0 });
                      },rendered: tooltiprenderer 
                  },
				  
				  // campos de entrega de material
				  { text: '* Cant. Ent. Inventario', datafield: 'cantidadentinv', width: 100, align: 'right', cellsalign: 'right', columntype: 'numberinput', filtertype: 'none',
                      validation: function (cell, value) {
                          if (value <= -1 ) {
                              return { result: false, message: "Cantidad entregada no debe ser menor a 0" };
                          }
                          return true;
                      },
                      createeditor: function (row, cellvalue, editor) {
                          editor.jqxNumberInput({ decimalDigits: 0 });
                      },rendered: tooltiprenderer 
                  },
				  { text: '* Cant. Ent. Comprada', datafield: 'cantidadentcomp', width: 90, align: 'right', cellsalign: 'right', columntype: 'numberinput', filtertype: 'none',
                      validation: function (cell, value) {
                          if (value <= -1 ) {
                              return { result: false, message: "Cantidad entregada no debe ser menor a 0" };
                          }
                          return true;
                      },
                      createeditor: function (row, cellvalue, editor) {
                          editor.jqxNumberInput({ decimalDigits: 0 });
                      },rendered: tooltiprenderer 
                  },
				  
				  { text: 'Cant. Total', datafield: 'cantidade', width: 80, align: 'center', cellsalign: 'right', columntype: 'numberinput', filtertype: 'none', editable: false,rendered: tooltiprenderer },
				  
				  
				  { text: 'Costo Inventario', datafield: 'costoinv', align: 'right', cellsalign: 'right', columntype: 'numberinput', filtertype: 'none', editable: false, cellsformat: 'c2',rendered: tooltiprenderer, width: 90 },
				  { text: 'Costo Compra', datafield: 'costocomp', align: 'right', cellsalign: 'right', columntype: 'numberinput', filtertype: 'none', editable: false, cellsformat: 'c2',rendered: tooltiprenderer, width: 90 },
                  /*{ text: 'Material', datafield: 'name_material',  filtertype: 'textbox', filtercondition: 'starts_with', editable: false },*/
				  
				 
				  /*{ text: 'Observaci&oacute;n', datafield: 'observacion', filtertype: 'none',cellsalign: 'right',editable: false, width:80},*/
                 
				  
				  { text: 'Valor Adjudicado', datafield: 'valor_adjudicado', filtertype: 'none', cellsalign: 'right', editable: false, width:90, cellsformat: 'c2'},
				  { text: 'Total', datafield: 'total', align: 'center', cellsalign: 'right', columntype: 'numberinput', filtertype: 'none', editable: false, cellsformat: 'c2', rendered: tooltiprenderer, width: 90, aggregates: ['sum'], aggregatesrenderer: function (aggregates) {
					  	  //console.log(aggregates)	;				  	
                          var renderstring = "";
                          $.each(aggregates, function (key, value) {
                              var name = key == 'sum' ? 'Total' : 'Max';
                              renderstring += '<div style="position: relative; margin: 4px; overflow: hidden;">' + name + ':<br/> ' + value +'</div>';
                          });
                          return renderstring;
                      } 
				   },
				   
				   { text: 'No. Factura', datafield: 'num_factura', filtertype: 'none', cellsalign: 'right', editable: false, width:90},
				   { text: 'No. Orden de Compra', datafield: 'orden_compra', filtertype: 'none', cellsalign: 'right', editable: false, width:90},
				   { text: 'Prooverdor', datafield: 'proovedor', filtertype: 'none', cellsalign: 'right', editable: false, width:90},
				   { text: 'Fecha Factura', datafield: 'fecha_factura', filtertype: 'none', cellsalign: 'right', editable: false, width:90},
				   { text: 'Fecha Vencimiento', datafield: 'fecha_vencimiento', filtertype: 'none', cellsalign: 'right', editable: false, width:90},
				   
				   ]
				   
            });			

            $("#jqxgrid2").on('cellendedit', function (event) {
				
					var args = event.args;
					var id = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'id');
					var save = false;
					var operacion = false;
					var costoInventario, totalMaterial, costoComprado = 0;
					var totalEntregado = 0;
					
					var cantinv = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'cantidad_inventario');//Cantidad Inventario
					var costuninv = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'costo_uninventario');//Costo unitario Inventario
					var canticomp = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'cantidadc');//Cantidad Comprada
					var costuncomp = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'costo_unidadcompra');//Costo unitario comprado
 						
					if(args.datafield == 'cantidadentinv'){//cantidad entregada inventario
						
						if(args.value <= cantinv){
							
							costoInventario = args.value * costuninv;
							$("#jqxgrid2").jqxGrid('setcellvalue',args.rowindex, 'costoinv', costoInventario);
							operacion = true;
							save = true;
						}else{							
							setTimeout(function(){
								$("#jqxgrid2").jqxGrid('setcellvalue',args.rowindex, args.datafield, args.oldvalue);
							},200);
							alert('No ahi existencia para su solicitud');
						}							
					}else if(args.datafield == 'cantidadentcomp'){//cantidad entregada comprada
						
						if(args.value <= canticomp){
							
							costoComprado = args.value * costuncomp;
							$("#jqxgrid2").jqxGrid('setcellvalue',args.rowindex, 'costocomp', costoComprado);
							operacion = true;
							save = true;
						}else{							
							setTimeout(function(){
								$("#jqxgrid2").jqxGrid('setcellvalue',args.rowindex, args.datafield, args.oldvalue);
							},200);
							alert('No ahi existencia para su solicitud');
						}		
					}else if(args.datafield == 'costo2'){//costo unidad						
						operacion = true; 
					}else{
						operacion = false;
					}
					
					
					if(operacion){		
						setTimeout(function(){
							
							var Total = 0;							
							var cantentInv = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'cantidadentinv');	
							var cantentComp = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'cantidadentcomp');	
						
							totalEntregado = cantentInv + cantentComp;						
							$("#jqxgrid2").jqxGrid('setcellvalue',args.rowindex, 'cantidade', totalEntregado);
							
							var costoInventario = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'costoinv');	
							var costoComprado   = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'costocomp');
							var totalCantEnt    = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'cantidade');
							
							sumaTotal = (costoInventario + costoComprado) / totalCantEnt;
							Total = sumaTotal * totalCantEnt;							
						
							$("#jqxgrid2").jqxGrid('setcellvalue',args.rowindex, 'valor_adjudicado', sumaTotal);
							$("#jqxgrid2").jqxGrid('setcellvalue',args.rowindex, 'total', Total);
						
						
							if(save){
								
								var iva = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'iva2');
								var OC = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'orden_compra2');
								
								var cantEntInv = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'cantidadentinv');
								var cantEntComp = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'cantidadentcomp');
								 
								$.ajax({ 
									type: 'POST',
									dataType: 'json',
									url: 'ajax_add_mercancia_item.php',
									data: {
											 id_item: id,
											 id_despacho: <?=$id_despacho?>,									
											 cantidadc: canticomp,
											 costo_unidadcompra: costuncomp,
											 iva2: iva,
											 orden_compra2: OC,
											 cantidade: totalCantEnt,
											 costoinv: costoInventario, 
											 costocomp: costoComprado,
											 costo_unitario: costuninv,
											 cantidadentinv: cantEntInv,
											 cantidadentcomp: cantEntComp,
											 valor_adjudicado: sumaTotal
									}
								});				
							}
						},500);
					}				
		    });		
			
			
			$('#viewFormMaterial').live('click',function(){ 
				$('#form_material #id_despacho').val(<?=(int)$_POST['ide_per']?>)
				$('#addmaterialWindow').jqxWindow('open'); 
			});
		
			$('#btn_agregar_material').live('click',function(){
				console.log('entro a add material');
			});
			
			$('#btnCambioestado').click(function(){
				  $.ajax({
					  type: 'POST',
					  dataType: 'json',
					  url: 'ajax_cambio_estado.php',
					  data: $('#frm_per').serialize(),
					  success: function(data){
						  if (data.estado == true){ 
							fn_cerrar();	
						  }else{
							alert('Hubo error:'+data.msj);
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



jQuery.fn.reset = function () {

	  $(this).each (function() { this.reset(); });

}



</script>      





