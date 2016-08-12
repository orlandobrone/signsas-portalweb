<?  header('Content-type: text/html; charset=iso-8859-1');
 
	include "../../conexion.php";
	
	$sql = sprintf("INSERT INTO `orden_servicio` ( `id` , `fecha_create` , `estado` ) VALUES (NULL , NOW( ) , 'draft')");

	if(!mysql_query($sql)){
		echo "Error al insertar la nueva orden servicio:\n$sql"; 
	}

	$id_ordenservicio = mysql_insert_id();
	 
	$obj = new TaskCurrent();
	$IVA = $obj->getValorConceptoFinanciero(20);
	$obj->setLogEvento('Orden Servicio',$id_ordenservicio,'Borrador');

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
.pasoTwo input[type=text]{
	text-align:right;
}
</style>


<h1>Formato de Solicitud de Orden Servicio <span style="color:#FF0000; display:none;">En matenimiento</span></h1> 

<div style="width:95%; margin-right:10px;">

<p>Por favor diligencie el siguiente formulario</p>

<form action="javascript:" method="post" id="frm_per">
        <table class="pasoOne">    
            <tbody>    
                 <tr>    
                     <td>ID Orden:</td>    
                     <td>    
                        <input type="text" id="id" name="id" value="<?=$id_ordenservicio?>" readonly />
                     </td>    
                 </tr>    
                 <tr>
                    <td width="20%">Fecha Inicio Actividad:</td>
                    <td width="30%"><input name="fecha_inicio" type="text" id="fecha_inicio" readonly />
                      <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />
    
                    	<script type="text/javascript">
    
							Calendar.setup({
								inputField     :    "fecha_inicio",      // id del campo de texto
								ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
								button         :    "lanzador"   // el id del botón que lanzará el calendario
							});
						</script>
    
                    </td>
               
                    <td>Fecha de Terminaci&oacute;n Actividad:</td>
                    <td><input name="fecha_terminado" type="text" id="fecha_terminado" readonly/>
                        <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2" />
        
                        <script type="text/javascript">
                            Calendar.setup({
                                inputField     :    "fecha_terminado",      // id del campo de texto
                                ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                                button         :    "lanzador2"   // el id del botón que lanzará el calendario
                            });
                        </script>
                    </td>
                </tr>
    
    
                <tr>
                    <td colspan="2"><h3>Responsable del Orden Servicio</h3></td>
                </tr>
    
                <tr>
    
                    <td>Regional:</td>
    
                    <td>
    
                     <? 
                        $sqlPry = "SELECT id_regional FROM usuario WHERE id = ".$_SESSION['id']; 					
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
       
        <h3 class="pasoOne">Contratista:</h3>
    
        <table class="pasoOne">    
             <tr>
                <td style="width:220px;">Cedula/NIT:</td>
                <td>
                    <!--<input type="text" name="cedula_consignar" id="cedula_consignar" size="30" alt="integer" class="required" />-->      

                    <? 	$sqlPry = "SELECT * FROM beneficiarios WHERE tipo_persona = 'contratista' ORDER BY identificacion ASC"; 
                    	$qrPry = mysql_query($sqlPry);
						
						
                    ?>

                    <select id="cedula_consignar" name="cedula_consignar"  class="cedula_consignar chosen-select required">

                        <option value="0">Seleccionar..</option>

                        <? while ($rsPry = mysql_fetch_array($qrPry)) { 
								$acumulado = 0;
								$acumulado = $obj->getTotalAcumuladoOSByIdent($rsPry['identificacion']);
						?>

                            <option value="<?=$rsPry['identificacion']?>" 
                                data-nombre="<?=$rsPry['nombre']?>"
                                data-entidad="<?=$rsPry['entidad']?>"
                                data-numcuenta="<?=$rsPry['num_cuenta']?>"
                                data-tipocuenta="<?=$rsPry['tipo_cuenta']?>"
                                data-contacto="<?=$rsPry['contacto']?>"
                                data-telefono="<?=$rsPry['telefono']?>"
                                data-regimen="<?=$rsPry['regimen']?>"
                                data-correo="<?=$rsPry['correo']?>"
                                data-direccion="<?=$rsPry['direccion']?>"
                                data-num_contrato="<?=$rsPry['num_contrato']?>"
                                data-saldo_acomulado="<?=$acumulado?>"
                                <?=($rsPry['estado']==1 || $rsPry['clinton']==1 || $rsPry['sgss']==1 || $rsPry['tipo_trabajo']==1)?'disabled':''?>><?=$rsPry['identificacion']?></option>

                        <? } ?>
                    </select>    
                </td>  

                <td>Nombre:</td>
                <td>
                    <input type="text" name="nombre" id="nombre" size="30" readonly/>       
                </td> 
                
                <td>T&eacute;lefono:</td>
                <td>
                    <input type="text" name="telefono" id="telefono" size="30" readonly/>       
                </td>       
            </tr>
            
            <tr>
                <td>Direcci&oacute;n:</td>
                <td>
                    <input type="text" name="direccion" id="direccion" size="30" readonly/>                </td>

                <td>Contacto:</td>
                <td>
                    <input type="text" name="contacto" id="contacto" size="30" readonly/>       
                </td> 
                
                <td>Correo:</td>
                <td>
                    <input type="text" name="correo" id="correo" size="30" readonly/>       
                </td> 
            </tr>

            <tr>
                <td>Banco:</td>
                <td>
                    <input type="text" name="banco" id="banco" size="30"  readonly/>                
                </td>

                <td>Tipo Cuenta:</td>
                <td>
                	<input type="text" name="tipo_cuenta" id="tipo_cuenta" size="30"  readonly/>      
                </td> 
                <td>No. Cuenta:</td>
                <td>
                    <input type="text" name="num_cuenta" id="num_cuenta" size="30" readonly/>       
                </td>                 
            </tr>

            <tr>   
                <td>No. Contrato:</td>
                <td>
                    <input type="text" name="num_contrato" id="num_contrato" size="30" readonly/>       			</td>  
                
                <td>R&eacute;gimen:</td>
                <td>
                    <input type="text" name="regimen" id="regimen" size="30"  readonly/>          			
                </td>  
                
                <td>Saldo Acumulado:</td>
                <td>
                    <input type="text" name="observaciones" id="observaciones" size="30" readonly/>
                </td>  

            </tr>   
            <tr>          	
                <td>P&oacute;liza:</td>
                <td colspan="3">
                    <input type="radio" name="opcionpoliza" value="Si" class="required" readonly/> Si.
                    <input type="radio" name="opcionpoliza" value="No" class="required" readonly/> No.
                </td>
            </tr>    
    
          </table> 
          
          
          <div class="pasoTwo" style="display:none;"> 
          	  <h3>Impuestos</h3> 
              <table>
              	  <tr>
                  	  <td>Bruto Total:</td>
                      <td>
                      	<input type="text" id="valor_neto_total" name="valor_neto_total" value="0" onkeyup="calcularImpuesto()" readonly>
                      </td>
                  </tr>
                  <tr>           	 
                      <td>Tipo Impuesto:</td>
                      <td colspan="3">
                          <input type="checkbox" class="checktipo iva" name="tipoimp[]" value="iva"/> IVA.
                          <input type="checkbox" class="checktipo ica" name="tipoimp[]" value="ica"/> ICA.
                          <input type="checkbox" class="checktipo rtefuente" name="tipoimp[]" value="rtefuente"/> RteFuente.
                      </td>
                  </tr>  
                  <tr class="content_iva" style="display:none;">
                      <td>IVA:</td>
                      <td><input class="impuestos" type="text" name="iva" value="0" onkeyup="calcularImpuesto()" readonly> X 100
                      </td>
                  </tr>
                  <tr class="content_ica" style="display:none;">
                      <td>ICA:</td>
                      <td><input type="text" class="impuestos"  name="ica" onkeyup="calcularImpuesto()" value="0"> X 1000
                      </td>
                  </tr>
                  <tr class="content_rtefuente" style="display:none;">
                      <td>RteFuente:</td>
                      <td><input type="text"  class="impuestos" name="rtefuente" onkeyup="calcularImpuesto()" value="0" alt="porcentaje"> X 100
                      </td>
                  </tr>                  
                  <tr>
                      <td>Total:</td>
                      <td><input type="text" name="totalconimpuesto" value="0" onkeyup="calcularImpuesto()" readonly>
                      </td>
                  </tr>
              </table>  
              
              <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
              		<input name="atras" type="button" id="atras" value="Atras" class="btn_table" />
                    <input name="calcular" type="button" id="calcular" value="Calcular" class="btn_table" />
                    
                    <input name="modificar" type="button" id="modificar" value="Guardar" class="btn_table" />
                    <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar(<?=$id_ordenservicio?>);"  class="btn_table"/>                   
                
              </div>
                                 
           </div> 
	</form>
    
	<!--formulario de ingreso de items-->
    <form action="javascript: fn_agregar_item();" method="post" id="frm_item" name="frm_item" class="pasoOne">
    
      <input type="hidden" id="centro_costo_item" name="centro_costo_item" value="0"/>
      <input type="hidden" id="id_os" name="id_os" value="<?=$id_ordenservicio?>"/>
      <input type="checkbox" id="validarhito" name="validarhito" style="display:none;" checked/>
    
      <h3>Agregar Item</h3>   
    
      <table style="width:100%;">
    
            <tbody>       
    
               <tr>
                    <td>   
                        Hitos:                  
                        <select name="hitos" id="hitos" class="hitos chosen-select required"></select>            
                    </td>                   
               </tr>
             
               <tr>       
                     <td>
                          p_O/Tiket:
                          <input type="text" name="po_ticket" id="po_ticket"  class="required"/>
                     </td>
                     <td>    
                          Descripci&oacute;n:
                          <input type="text" name="descripcion" id="descripcion" class="required" />
                     </td>
                     
                     <td>    
                          Forma Pago:
                          <select name="forma_pago" id="forma_pago" class="required">
                          	<option class="CONTADO">Contado</option>
                            <option class="CR&Eacute;DITO">Cr&eacute;dito</option>	
                          </select>
                     </td>
               </tr>
               
               <tr> 
                      <td>
                          Cantidad: <input type="text" name="cantidad" id="cantidad" value="0" alt="integer" class="reset required" style="width:110px" onkeyup="calcular()"/>
                      </td>
                      <td>    
                         Valor unitario: <input type="text" name="valor_unitario" id="valor_unitario" value="0" alt="integer" class="required" style="width:110px" onkeyup="calcular()"/>
                       </td>
                      <td>    
                          Total
                          <input type="text" name="total" id="total" value="0" alt="decimal" class="required reset" style="width:120px" readonly/>               
                      </td>
               </tr>           
    
               <tr>
                    <td colspan="2">
                        <input name="agregar" type="submit" id="agregar" value="Agregar Item" class="btn_table transferencia"/>
                        
                    </td>
               </tr>
    
              </tbody>	
    
            </table>
    
        </form>
    
        <div id="jqxgrid2" style="margin-top:20px; margin-bottom:20px;" class="pasoOne"></div>
    
        <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;" class="pasoOne">
        
            <input type="button" id="nextone" value="Siguiente" class="btn_table" />
        
            <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar(<?=$id_anticipo?>);"  class="btn_table"/>                   
        
        </div>
    
</div><!--fin del content-->

<style>
	.invacpm{ display:none; }
</style>

<script type="text/javascript">
var calcularImpuesto = null;

$(document).ready(function () {
	
	$('input[alt=porcentaje]').inputmask({'mask':"9{0,2}.9{0,2}", greedy: false});
	$('input[name=ica]').inputmask({'mask':"9{0,2}.9{0,3}", greedy: false});
	
	var source = {
		 datatype: "json",
		 datafields: [
			 { name: 'i.id', type: 'number'},
			 { name: 'id_hitos', type: 'string'},
			 
			 { name: 'po_ticket', type: 'string'},
			 { name: 'descripcion', type: 'string'},
			 { name: 'cantidad', type: 'number'},
			 
			 { name: 'valor_unitario', type: 'number'},
			 { name: 'total', type: 'number'},
			 { name: 'forma_pago', type: 'string'},
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
		url: 'ajax_list_items.php?id=<?=$id_ordenservicio?>',
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
		  
		  { text: 'p_O/Tiket', datafield: 'po_ticket', filtertype: 'none', width: 120, cellsalign: 'right'},
	
		  { text: 'Descripcion', datafield: 'descripcion', filtertype: 'none', width: 80, cellsalign: 'right'},
		  
		  { text: 'Cantidad', datafield: 'cantidad', filtertype: 'none', width: 100, cellsalign: 'right',cellsformat: 'c2'},	 
		  
		  { text: 'Valor Unitario', datafield: 'valor_unitario', filtertype: 'none', width:130, cellsalign: 'right', cellsformat: 'c2' },
	
		  { text: 'Total', datafield: 'total', filtertype: 'none', width: 130, cellsalign: 'right',cellsformat: 'c2' },
	
		  { text: 'Forma Pago', datafield: 'forma_pago', filtertype: 'none', width: 130, cellsalign: 'right' } 				 
		]
	
	});			
	
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
				}else{
					$(this).val('');
					$('#beneficiario,#banco,#tipo_cuenta,#num_cuenta,#observaciones').val('');
				}						
			});
		}			
		$(".chosen-select").trigger("chosen:updated");
	});

	$(".chosen-select").chosen({width:"220px"}); 
	$('input').setMask();	
	$(".btn_table").jqxButton({ theme: theme });	
	
	$('#nextone').click(function(){
		/*$('.pasoOne').hide();
		$('.pasoTwo').show();*/
		$('#frm_per').submit();		
	});
	
	$('.pasoTwo input').change(function(){
		calcularImpuesto();
	});
	
	var iva = parseFloat(<?=$IVA?>);	
	$('.pasoTwo input:checkbox').change(function(){
		
		var valorNeto = parseInt($('#valor_neto_total').val());
		
		if($(".iva").is(':checked')){  			
			var totaliva = valorNeto * iva;
			$('.content_iva').show();			
			$('input[name=iva]').val(totaliva);
		}else{
			$('.content_iva').hide();  
			$('input[name=iva]').val(0);
		}			
		
		if($('.ica').is(':checked')){  
			$('.content_ica').show(); 
		}else{
			$('.content_ica').hide();
			$('input[name=ica]').val(0);
		}
		
		if($('.rtefuente').is(':checked')){  
			$('.content_rtefuente').show(); 
		}else{
			$('.content_rtefuente').hide();
			$('input[name=rtefuente]').val(0);
		}
		
		calcularImpuesto();		
	});
	
	calcularImpuesto = function(){
		
		var valorNeto = parseInt($('#valor_neto_total').val());
		var valorIca = 0;
		var valorRte = 0;
		var TotalIva = 0;
		
		if($('.ica').is(':checked')){  
			var ica = $('input[name=ica]').val();
			valorIca = parseInt(valorNeto * (ica/1000));
			console.log('ICA:'+valorIca);
		}
		
		if($('.rtefuente').is(':checked')){  
			var rtefuente = $('input[name=rtefuente]').val();
			valorRte = parseInt(valorNeto * (rtefuente/100));
			console.log('rteFuente:'+valorRte);
		}
		
		if($(".iva").is(':checked')){   
			TotalIva = valorNeto * iva;
			$('input[name=iva]').val(TotalIva);	 		
		}
		
		var totalNeto = ((valorNeto + TotalIva) - valorIca) - valorRte;
		if(valorNeto == '')
			totalNeto = 0;
			
		valorTmp = totalNeto;
		$('input[name=totalconimpuesto]').val(totalNeto);	
		
		return true;			
	}
	
	$('#calcular').click(function(){		
		calcularImpuesto();
	});
	
	$('#modificar').click(function(){
		fn_modificar();
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
			var respuesta = confirm('\xBFDesea realmente enviar estos parametros?')
			if (respuesta){
				$('.pasoOne').hide();
				$('.pasoTwo').show();
			}
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
	
	
	$('#atras').click(function(){
		$('.pasoTwo .impuestos').val(0);
		$('.content_iva, .content_ica, .content_rtefuente').hide();
		$('.pasoTwo input[type=checkbox]').prop('checked', false);
		
		calcularImpuesto();
		
		$('.pasoTwo').hide();
		$('.pasoOne').show();		
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
	
		var nombre, banco, tipocuenta, numcuenta, contacto, telefono, regimen, correo,num_contrato,direccion;
	
		$( ".cedula_consignar option:selected" ).each(function() {
			  
			$('#nombre').val($(this).data('nombre'));
			$('#banco').val($(this).data('entidad'));
			$('#tipo_cuenta').val($(this).data('tipocuenta'));
			$('#num_cuenta').val($(this).data('numcuenta'));
			
			$('#contacto').val($(this).data('contacto'));
			$('#telefono').val($(this).data('telefono'));
			$('#regimen').val($(this).data('regimen'));
			$('#correo').val($(this).data('correo'));
			$('#direccion').val($(this).data('direccion'));
			$('#num_contrato').val($(this).data('num_contrato'));
			$('#observaciones').val($(this).data('saldo_acomulado'));	
			 
		});
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
							options.append($("<option></option>").val(v.id).text(v.orden).attr('data-ot_cliente',v.ot_cliente).attr('data-descripcion',v.descripcion));
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
		$('.hitos').trigger("chosen:updated");
	
		var regional = $('#regional').val();
		var centrocosto = $('.centros_costos').val(); 
		
		//asigna la variable de centro de costo para items
		$('#centro_costo_item').val(centrocosto);
	
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
					
					if(data != null){
						var options = $('.orden_trabajo');
						$('.orden_trabajo').empty();
						$('.orden_trabajo').append('<option value="">Seleccione..</option>');				
						$.each(data, function (i, v) { 
							options.append($("<option></option>").val(v.id).text(v.orden));
						});
						$(".orden_trabajo").trigger("chosen:updated");
					}else{
						alert('No tiene ordenes');
					}
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
	
	$('#hitos').change(function(){
		
		var doom = $('#hitos option:selected');
		var otcliente = $(doom).data('ot_cliente');
		var descripcion = $(doom).data('descripcion');
		
		$('#po_ticket').val(otcliente);
		$('#descripcion').val(descripcion);
		
		$('#po_ticket').attr('readonly','readonly');
	});
	
});

function replaceAll( text, busca, reemplaza ){
	  while (text.toString().indexOf(busca) != -1)
		  text = text.toString().replace(busca,reemplaza);
	  return text;
}	

function fn_modificar(){
	
	loaderSpinner();
	
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
			
			stoploaderSpinner();
		},
		error: function(err) {
			alert(err);
		}
	
	});
};
	
function fn_agregar_item(){ 

	var str = $("#frm_item").serialize();
	//var value1, value2, value3, value11, value22;
	
	$.ajax({
		  type: 'POST',
		  dataType: 'json',
		  url: 'ajax_agregar_item.php', 
		  data: str,
		  success: function(data){	
	
		    if(data.estado == true){ 
				$("#valor_neto_total").val(data.total_neto);
			   	$("#jqxgrid2").jqxGrid('updatebounddata');
			   	$('#validarhito').prop("checked", true);
			}else{
				//$('.blockPage').css('z-index','993');
				swal({   
					title: "Oops",   
					text: data.message,   
					type: "error",   
					showCancelButton: true,   
					confirmButtonColor: "#DD6B55",  
					confirmButtonText: "Si, deseo agregarlo!",   
					cancelButtonText: "No, cancelar plx!",   
					closeOnConfirm: true,   
					closeOnCancel: true
				}, function(isConfirm){   
					if (isConfirm) {     
						$('#validarhito').prop("checked", false); 
						fn_agregar_item();	
					}
				});
		  	}
		  }
	});
	
}
<!-- funcion calcula el valor total orden de servicio//-->
function calcular()
{
  cantidad=document.frm_item.cantidad.value;
  valor_unitario=document.frm_item.valor_unitario.value;
  var res = valor_unitario.split(",00");
			   valor_unitario = parseInt(res[0].replace('.',''));
  total_final=parseInt(cantidad)*parseInt(valor_unitario);
  document.frm_item.total.value=total_final;
  	
}
</script>