<?  header('Content-type: text/html; charset=iso-8859-1');

	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}

	include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("select * from `orden_servicio` where id=%d",
		(int)$_POST['ide_per']
	);

	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);

	if ($num_rs_per==0){
		echo "No existen anticipo con ese ID";
		exit;
	}

	$rs_per = mysql_fetch_assoc($per);

	$letters = array('.');
	$fruit   = array('');	
	
	$obj = new TaskCurrent();
	$IVA = $obj->getValorConceptoFinanciero(20);	
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
.pasoTwo input[type=text]{
	text-align:right;
}
</style>


<div id="content_form">

    <img src="/images/logo_sign.png"  style="float:left;"/>

    <h1 style="float:left; margin-left:20px;line-height: 43px;">FORMATO DE SOLICITUD DE ORDEN DE SERVICIO</h1> 

    <div style="clear:both"></div>

<div>



<form action="javascript: fn_modificar();" method="post" id="frm_per">
	  <input type="hidden" name="action" value="edit" readonly />
      <table>
        <tbody>
          <tr>
            <td>ID Orden:</td>
            <td><input type="text" id="id" name="id" value="<?=$rs_per['id']?>" readonly /></td>
          </tr>
          <tr>
            <td width="20%">Fecha Inicio Actividad:</td>
            <td width="30%"><input name="fecha_inicio" type="text" id="fecha_inicio" readonly value="<?=$rs_per['fecha_inicio']?>"/>
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
            <td><input name="fecha_terminado" type="text" id="fecha_terminado" readonly value="<?=$rs_per['fecha_terminado']?>"/>
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
        </tbody>
      </table>
	  

      <h3>Responsable del Orden de Servicio</h3>


      <table style="display:block">   
      		
            <tr>
            	<td>Cambiar Estado</td>
                <td colspan="3">
                	  <select name="forze_estado" id="forze_estado" class="chosen-select required">
                      	<option value="0" <?=($rs_per['aprobado']==0)?'selected':''?>>NO REVISADO</option>
                        <option value="1" <?=($rs_per['aprobado']==1)?'selected':''?>>APROBADO</option>
                        <option value="2" <?=($rs_per['aprobado']==2)?'selected':''?>>ANULADO</option>
                      </select>
                </td>            
            </tr>   


            <tr>

            	<td>Regional:</td>

               	<td>
					 <? 
                        $sqlPry = "SELECT * FROM regional WHERE id = ".$rs_per['id_regional']; 
                        $qrPry = mysql_query($sqlPry);
                     ?>
    
                     <select name="regional" id="regional" class="chosen-select required var_ordenes">
    
                         <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>
    
                            <option value="<?=$rsPry['id']?>" <?php echo ($rsPry['id']==$rs_per['id_regional'])? 'selected="selected"': '';?>><?=$rsPry['region']?></option> 
    
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

                 	<select name="nombre_responsable" id="nombre_responsable" class="chosen-select required">

                    	<option value="<?=$rs_per['nombre_responsable']?>"><?=$rs_per['nombre_responsable']?></option>

                    </select>          

                </td>


                <td>Cedula:</td>

                <td>

                 <input type="text" name="cedula_responsable" id="cedula_responsable" size="40" value="<?=$rs_per['cedula_responsable']?>" alt="integer" class="required"/>                

                </td>            

            </tr>

            <tr>             

                <td>Centro Costo:</td>

                <td>

                    <? 
						$sqlPry = "SELECT * FROM linea_negocio WHERE id = ".$rs_per['id_centroscostos']; 
                    	$qrPry = mysql_query($sqlPry);
                    ?>

                    <select name="centros_costos" id="centros_costos" class="chosen-select required var_ordenes" readonly>

                        <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>

                        <option value="<?=$rsPry['id']?>" <?php echo ($rsPry['id']==$rs_per['id_centroscostos'])? 'selected="selected"': '';?>><?=$rsPry['codigo']?> / <?=$rsPry['nombre']?></option>

                        <? } ?>

                    </select>            

                </td>              

            	<td>Ordenes de Trabajos:</td>

                <td>

                    <select name="orden_trabajo" id="orden_trabajo" class="chosen-select" readonly>

                    	 <? 
						 	$resultado = mysql_query("SELECT * FROM orden_trabajo WHERE id_regional = ".$rs_per['id_regional']." AND id_centroscostos = ".$rs_per['id_centroscostos']." AND id_proyecto = ".$rs_per['id_ordentrabajo']) or die(mysql_error());
							
							while ($rsPry = mysql_fetch_array($resultado)) { 
						 ?>

                        		<option value="<?=$rsPry['id_proyecto']?>" <?=($rsPry['id_proyecto']==$rs_per['id_ordentrabajo'])? 'selected="selected"' : '';?>><?=$rsPry['orden_trabajo']?></option>

                         <? } ?>

                    </select>     

                </td>
            </tr> 
        </tbody>
    </table>  

    <table style="width:100%;">

        <tbody>            
            <tr>
            	<td colspan="4"><h3>Contratista:</h3></td>
            </tr>   

            <tr>
            
            	<td style="width:120px;">CEDULA:</td>
                <td>
              		<input type="text" name="cedula_consignar" id="cedula_consignar" size="30"  value="<?=$rs_per['cedula_contratista']?>" readonly/>       
                </td>                  

                <td>NOMBRE:</td>

                <td>
              		<input type="text" name="nombre" id="nombre" size="30"  value="<?=$rs_per['nombre_contratista']?>" readonly/>       

                </td>       

            </tr>          

            <tr>

            	<td>TELEFONO:</td>

                <td>

                 	<input type="text" name="telefono" id="telefono" size="30"  value="<?=$rs_per['telefono_contratista']?>" readonly/>               

                </td>

                

                <td>DIRECCI&Oacute;N:</td>

                <td>

              		<input type="text" name="direccion" id="direccion" size="30" value="<?=$rs_per['direccion_contratista']?>" readonly/>       

                </td> 

            </tr>
            <tr>

            	<td>CONTACTO:</td>

                <td>

                 	<input type="text" name="contacto" id="contacto" size="30" value="<?=$rs_per['contacto_contratista']?>" readonly/>               

                </td>

                

                <td>CORREO:</td>

                <td>

              		<input type="text" name="correo" id="correo" size="30" value="<?=$rs_per['correo_contratista']?>" readonly/>       

                </td> 

            </tr>

            <tr>

            	<td>BANCO:</td>

                <td>

                 	<input type="text" name="banco" id="banco" size="30"  value="<?=$rs_per['banco_contratista']?>" readonly/>               

                </td>

                

                <td>TIPO CUENTA:</td>

                <td>

              		<input type="text" name="tipo_cuenta" id="tipo_cuenta" size="30" value="<?=$rs_per['tipocuenta_contratista']?>" readonly/>       

                </td> 

            </tr> 

            <tr>    

                <td>N&deg; DE CUENTA:</td>

                <td>

              		<input type="text" name="num_cuenta" id="num_cuenta" size="30"  alt="integer"  value="<?=$rs_per['numcuenta_contratista']?>" readonly/>    

                </td>         

           

            	<td>SALDO ACUMULADO:</td>

                <td>

              		<input type="text" name="observaciones" id="observaciones" size="30" value="<?=$rs_per['observaciones_contratista']?>" readonly/>       

                </td>      

            </tr>  
             <tr>    

                <td>REGIMEN:</td>

                <td>

              		<input type="text" name="regimen" id="regimen" size="30" value="<?=$rs_per['regimen_contratista']?>" readonly/>    

                </td>         

            	<td>POLIZA:</td>

                <td><input type="hidden" value="<?=$rs_per['poliza_contratista']?>" name="opcionpoliza"><?=$rs_per['poliza_contratista']?></td>      

            </tr> 

        </tbody>

    </table>  
    
    <?
    	$imp = unserialize($rs_per['impuesto_os']); 
		/*echo '<pre>';
		print_r($imp);
		echo '</pre>';*/
		function arrayIsTrue($value,$array){
			if(is_array($array)):
				if(in_array($value,$array)):
					return true;
				else:
					return false;
				endif;
			else:
				return false;
			endif;
		}	
		
		$sql = "SELECT SUM(total) AS total
				FROM items_ordenservicio 
				WHERE estado IN (0,2) AND id_ordenservicio = ".(int)$_POST['ide_per'];
		$resultado = mysql_query($sql) or die(mysql_error());
		$rowItemOS = mysql_fetch_array($resultado);
		
		if(empty($rowItemOS['total']))
			$rowItemOS['total'] = 0;
		
		
	?> 

  	<div class="pasoTwo"> 
        <h3>Impuestos</h3> 
        <table>
            <tr>
                <td>Bruto Total:</td>
                <td>
                  <input type="text" id="valor_neto_total" name="valor_neto_total" onkeyup="calcularImpuesto()" value="<?=(int)$rowItemOS['total']?>" readonly>
                </td>
            </tr>
            <tr>           	 
                <td>Tipo Impuesto:</td>
                <td colspan="3">
                    <input type="checkbox" class="checktipo iva" name="tipoimp[]" value="iva" <?=(arrayIsTrue('iva',$imp[0]['tipoimp']))?'checked':'';?>/> IVA.
                    <input type="checkbox" class="checktipo ica" name="tipoimp[]" value="ica" <?=(arrayIsTrue('ica',$imp[0]['tipoimp']))?'checked':'';?>/> ICA.
                    <input type="checkbox" class="checktipo rtefuente" name="tipoimp[]" value="rtefuente" <?=(arrayIsTrue('rtefuente',$imp[0]['tipoimp']))?'checked':'';?>/> RteFuente.
                </td>
            </tr>  
            <tr class="content_iva" <?=(!arrayIsTrue('iva',$imp[0]['tipoimp']))?'style="display:none;"':'';?>>
                <td>IVA:</td>
                <td><input class="impuestos" type="text" name="iva" value="<?=$imp[0]['iva']?>"  onkeyup="calcularImpuesto()" readonly> X 100</td>
            </tr>
            <tr class="content_ica" <?=(!arrayIsTrue('ica',$imp[0]['tipoimp']))?'style="display:none;"':'';?>>
                <td>ICA:</td>
                <td><input type="text" class="impuestos"  name="ica" onkeyup="calcularImpuesto()" value="<?=$imp[0]['ica']?>"> X 1000</td>
            </tr>
            <tr class="content_rtefuente" <?=(!arrayIsTrue('rtefuente',$imp[0]['tipoimp']))?'style="display:none;"':'';?>>
                <td>RteFuente:</td>
                <td><input type="text"  class="impuestos" name="rtefuente" onkeyup="calcularImpuesto()" value="<?=$imp[0]['rtefuente']?>" alt="porcentaje"/> X 100</td>
            </tr>                  
            <tr>
                <td>Total:</td>
                <td><input type="text" name="totalconimpuesto" value="<?=$imp[0]['totalconimpuesto']?>" onkeyup="calcularImpuesto()" readonly/></td>
            </tr>
        </table>  
        
      <!--  <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
              <input name="calcular" type="button" id="calcular" value="Calcular" class="btn_table" />
        </div>-->
                           
     </div> 
</form>

	<form action="javascript: fn_agregar_item();" method="post" id="frm_item" name="frm_item">

        <input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
        <input type="hidden" id="centro_costo_item" name="centro_costo_item" value="<?=$rs_per['id_centroscostos']?>"/>
        <input type="hidden" id="id_os" name="id_os" value="<?=$rs_per['id']?>" />
        <input type="checkbox" id="validarhito" name="validarhito" style="display:none;" checked/>

        <h3>Agregar Item</h3>   
    
        <table style="width:100%;">
    
            <tbody>       
    
               <tr>
                    <td>   
                        Hitos:                  
                        <select name="hitos" id="hitos" class="chosen-select required">
    
                            <option>Seleccione...</option>
    
                          <?php
    
                            $total = 0;
    
                            $resultado = mysql_query("SELECT * FROM hitos  						  
                                                      WHERE estado IN ('PENDIENTE','EN EJECUCION','ADMIN','COTIZADO','EJECUTADO','INFORME ENVIADO') AND id_proyecto = ".$rs_per['id_ordentrabajo']) or die(mysql_error());
    
                            
     
                            $total = mysql_num_rows($resultado);
    
                            if($total > 0):
    
                                while($row = mysql_fetch_assoc($resultado)):
    
                                    ?>
    
                                        <option data-ot_cliente="<?=$row['ot_cliente']?>"
                                        		data-descripcion="<?=$row['descripcion']?>"
                                        		value="<?=$row['id']?>"><?=$row['id'].'-'.$row['nombre'].'-'.$row['fecha_inicio']?></option>
    
                                    <?php			
    
                                endwhile;
    
                            endif;
    
                          ?>
    
                          </select>            
    
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
                       Valor unitario: <input type="text" name="valor_unitario" id="valor_unitario" value="0" class="required" style="width:110px" onkeyup="calcular()" alt="integer"/>
                     </td>
                    <td>    
                        Total:
                      <input type="text" name="total" id="total" value="0" alt="decimal" class="required reset" style="width:120px" readonly/> 
                    </td>
               </tr>           
    
               <tr>
                    <td colspan="2">
                    <?
                    	if($rs_per['aprobado'] == 0):
							if(in_array(402, $_SESSION['permisos'])):
								
					?>
					
                    	<input name="agregar" type="submit" id="agregar" value="Agregar Item" class="btn_table transferencia"/>
                    <?									
							endif;
						else:
							if(in_array(402, $_SESSION['permisos'])):
								if($obj->getValidateExcepcionOS((int)$_POST['ide_per'])):
					?>
                    	<input name="agregar" type="submit" id="agregar" value="Agregar Item Excepci&oacute;n" class="btn_table transferencia"/> 
                    <?			endif;
							endif;
						endif;
					?>
                    </td>
               </tr>
    
              </tbody>	
    
    	</table>

	</form>


    <div id="grid_html"></div>

	<div id="jqxgrid2" style="margin-top:20px; margin-bottom:20px;"></div>


    <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
    
        	
     <? if($rs_per['estado']!=1):  
	 		if(in_array(402, $_SESSION['permisos'])):
	 ?>   
       			<input name="update" type="button" id="update" value="Actualizar" class="btn_table" /> 
     <? 	endif;  
	 	else:
	 ?>
     	
     <?
			if(in_array(402, $_SESSION['permisos'])):
				if(!$obj->getValidateExcepcionOS($rs_per['id_ordentrabajo'])):
	 ?>
				<input type="hidden" name="excepcion" value="true">
                <input name="update" type="button" id="update" value="Actualizar Excepci&oacute;n" class="btn_table" />
	 <?
				endif;
			endif;
	 	endif; 
	 ?>                 

       <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();"  class="btn_table" />                  

	</div>

	<!--<input type="button" value="test" class="test">-->

</div>



<script type="text/javascript">

$(document).ready(function () {
	
	$(".chosen-select").chosen({width:"220px"}); 
	$('input').setMask();
	$(".btn_table").jqxButton({ theme: theme });
	
	$('input[alt=porcentaje]').inputmask({'mask':"9{0,2}.9{0,2}", greedy: false});
	$('input[name=ica]').inputmask({'mask':"9{0,2}.9{0,3}", greedy: false});
	
	var source = {
	 datatype: "json",
	 datafields: [
		 { name: 'i.id', type: 'number'},
		 { name: 'id_hitos', type: 'string'},
		 { name: 'idHitos', type: 'number'},
		 
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
	url: 'ajax_list_items.php?id=<?=(int)$_POST['ide_per']?>',
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
		   
		   { text: 'Id Hito', datafield: 'idHitos', filtertype: 'textbox', filtercondition: 'equal', width: 60,  columntype: 'textbox', editable: false },
	
		  { text: 'Nombre Hito', datafield: 'id_hitos',  filtertype: 'textbox', filtercondition: 'starts_with',  width: 150, editable: false },
		  
		  { text: 'p_O/Tiket', datafield: 'po_ticket', filtertype: 'none', width: 120, cellsalign: 'right'},
		  		
		  { text: 'Descripcion', datafield: 'descripcion', filtertype: 'none', width: 80, cellsalign: 'right'},
		  
		  { text: 'Cantidad', datafield: 'cantidad', filtertype: 'none', width: 100, cellsalign: 'right'},	 
		  
		  { text: 'Valor Unitario', datafield: 'valor_unitario', filtertype: 'none', width:130, cellsalign: 'right', cellsformat: 'c2' },
	
		  { text: 'Total', datafield: 'total', filtertype: 'none', width: 130, cellsalign: 'right',cellsformat: 'c2' },
	
		  { text: 'Forma Pago', datafield: 'forma_pago', filtertype: 'none', width: 130, cellsalign: 'right' } 				 
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

	$('#update').click(function(){ $("#frm_per").submit(); })	


	$("#frm_per").validate({

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

	})

	
	$('#aprobar').click(function(){

		var idAnticipo = <?=$rs_per['id']?>;

		var respuesta = confirm('\xBFDesea realmente cambiar el estado a aprobado?')

			if (respuesta){		

				$.post('ajax_aprobar_anticipo.php',{id:idAnticipo},function(data){

					fn_cerrar();	

					$("#jqxgrid").jqxGrid('updatebounddata', 'cells');

				});

			}

	});

	  

	$('#btn_print').click(function(){

		$(".btn_actions, .agregar_item_content, #jqxgrid2").hide(); 			

		var gridContent = $("#jqxgrid2").jqxGrid('exportdata', 'html');

		$('#grid_html').html(gridContent);

		$("#content_form").printArea();

		fn_cerrar(); 

	});	

	

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

	

	var regional_actual;

	$('.var_ordenes').change(function(){ 

		$('#orden_trabajo').empty();
		$("#orden_trabajo").trigger("chosen:updated");
		$('#hitos').empty();
		$("#hitos").trigger("chosen:updated");


		var regional = $('#regional').val();
		var centrocosto = $('#centros_costos').val(); 

		if(regional != '0' && regional_actual != regional ){

			$.getJSON('ajax_list_responsable.php', {id_regional:regional}, function (data) {

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

			$.getJSON('ajax_list_ordenes_trabajo.php', {id_regional:regional, id_centroscostos:centrocosto}, function (data) {

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

	
	$('#orden_trabajo').change(function(){ 

		var orden;

		$('#hitos').empty();

		var proyecto = $( "#orden_trabajo" ).val();			

		

		$.getJSON('ajax_list_hitos_orden.php', {id_proyecto:proyecto}, function (data) { 

				if(data != null){

					var options = $('#hitos');

					$('#hitos').empty();

					$('#hitos').append('<option value="">Seleccione..</option>');				

					$.each(data, function (i, v) { 

						options.append($("<option></option>").val(v.id).text(v.orden));

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
	
	
	$('.anticipo').blur(function(){
	  var total = 0;
	
	  $('.anticipo').each(function( index ) {
		  var val = replaceAll($( this ).val(),".","");
		  total += parseFloat(val);
	  });
	
	  $('#total_anticipo').val(total+',00').setMask(); 
	
	});
	
	$('#hitos').change(function(){
	
		var doom = $('#hitos option:selected');
		var otcliente = $(doom).data('ot_cliente');
		var descripcion = $(doom).data('descripcion');
		
		$('#po_ticket').val(otcliente);
		$('#descripcion').val(descripcion);
		
		$('#po_ticket').attr('readonly','readonly');
	});
	
	
	///inicio de impuestos
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
	/////fin de impuestos
	
	$('.test').click(function(){
		  $('.blockPage').css('z-index','993');
		  //sweetAlert("Oops...", data.message, "error");
		  swal({   
			  title: "Oops",   
			  text: 'test',   
			  type: "error",   
			  showCancelButton: false,   
			  confirmButtonColor: "#DD6B55",   
			  confirmButtonText: "Ok, entendido!",   
			  closeOnConfirm: true 
		  }, function(){   
			  $('.blockPage').css('z-index','1016');
		  });   
   	 });

});


function replaceAll( text, busca, reemplaza ){
  //console.log(text);
  if(text != 'undefined'){

	  while (text.toString().indexOf(busca) != -1)
		  text = text.toString().replace(busca,reemplaza);
	  return text;
  }

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



function fn_agregar_item(){ 

	  var str = $("#frm_item").serialize();	
	  //var value1, value2, value3, value11, value22;

	  $.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'ajax_agregar_item.php', 
		data: str,
		success: function(data){	

			if(data.estado){ 

			   $("#valor_neto_total").val(data.total_neto);
			   $("#jqxgrid2").jqxGrid('updatebounddata');
			   $('#validarhito').prop("checked", true);

			}else{
				//$('.blockPage').css('z-index','993');
				//sweetAlert("Oops...", data.message, "error");
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
				//alert(data.message);
			}
		}

   });
  
}
   <!-- funcion calcula el valor total orden de servicio Milena//-->
function calcular()
{
  cantidad=document.frm_item.cantidad.value;
  valor_unitario=document.frm_item.valor_unitario.value;
  total_final=parseInt(cantidad)*parseInt(valor_unitario);
  document.frm_item.total.value=total_final;	
}

</script> 