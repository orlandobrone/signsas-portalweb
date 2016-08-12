<?  header('Content-type: text/html; charset=iso-8859-1');

	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}

	include "../extras/php/basico.php";

	include "../../conexion.php";



	$sql = sprintf("select * from anticipo where id=%d",

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

	

	$acpm = 0;

	$valor_transporte = 0;

	$toes = 0;

	$total_acpm = 0;

	$total_transpornte = 0;

	$total_toes = 0;

	$total_anticipo = 0;

	

	$resultado = mysql_query("SELECT * FROM items_anticipo WHERE estado = 1 AND id_anticipo =".$_POST['ide_per']) or die(mysql_error());

	$total = mysql_num_rows($resultado);

	while ($rows = mysql_fetch_assoc($resultado)):

	

		if($rows['acpm'] != 0):

			$acpm = explode(',00',$rows['acpm']);

			$acpm = str_replace($letters, $fruit, $acpm[0] );

			$total_acpm += $acpm;
			
			$test .= $acpm.'+';

		endif;

		

		if($rows['valor_transporte'] != 0):

			$valor_transporte = explode(',00',$rows['valor_transporte']);

			$valor_transporte = str_replace($letters, $fruit, $valor_transporte[0] );

			$total_acpm += $valor_transporte;
			
			$test .= $valor_transporte.'+';

		endif;

		
		//echo $test.'<br/>';
		

		if($rows['toes'] != 0):

			$toes = explode(',00',$rows['toes']);

			$toes = str_replace($letters, $fruit, $toes[0] );

			$total_anticipo += $toes;

		endif;

	endwhile;

	$giro = 0;

	if($rs_per['giro'] != 0){
		$giro = explode(',00',$rs_per['giro']);
		$giro = str_replace($letters, $fruit, $giro[0] );
	}

	/*echo $total_acpm.'+'.$total_toes.'+'.$total_anticipo.'+'.$giro;	
	echo '<br>';*/

	$total_anticipo = $total_acpm + $total_toes + $total_anticipo + $giro;		
	$total_anticipo = $total_anticipo.',00';
	
	
	$sql5 = " SELECT SUM(total_hito) AS total
			  FROM  `items_anticipo` 
			  WHERE  estado = 1 AND id_anticipo = ".(int)$_POST['ide_per'];
	$pai5 = mysql_query($sql5);	
	$rs_pai5 = mysql_fetch_assoc($pai5);
	$total_anticipo = number_format($rs_pai5['total'] + $giro);
	

	$obj = new TaskCurrent();
	
	$valor_concepto = $obj->getValorConceptoFinanciero(14);	 
	
	if($total_anticipo == 0 && $rs_per['prioridad'] == 'VINCULADO')
		$total_anticipo = $rs_per['total_anticipo'];   

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



<div id="content_form">

    <img src="/images/logo_sign.png"  style="float:left;"/>

    <h1 style="float:left; margin-left:20px;line-height: 43px;">FORMATO DE SOLICITUD DE ANTICIPO</h1> 

    <div style="clear:both"></div>

<div>



<form action="javascript: fn_modificar();" method="post" id="frm_per">

	<input type="hidden" name="action" value="edit" readonly/>
    <input type="hidden" name="os_vincular" value="<?=$rs_per['orden_servicio_id']?>" readonly/>

	<table style="display:block;">

        <tbody>

        	 <tr>

                <td>ID:</td>

                <td><input type="text" id="id" name="id" value="<?=$rs_per['id']?>" readonly /></td>

                <td width="20%">Fecha:</td>

                <td width="30%"><input name="fecha" type="text" id="fecha" readonly value="<?=$rs_per['fecha']?>"/>

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
                 	<input type="text" name="prioridad" id="prioridad" value="<?=$rs_per['prioridad']?>" readonly/>                
                </td>

            </tr> 
            
            <? if($rs_per['prioridad'] == 'GIRADO'): ?>
            <tr>
            	<td><div class="fechaaprobado">Fecha Aprobado:</div></td>
                <td><div class="fechaaprobado"><input name="fechaapr" type="text" id="fechaapr" value="<?=$rs_per['fecha_aprobado']?>" readonly/>
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
            
            <? else: ?>
            	<input type="hidden" name="fechaapr" value="<?=$rs_per['fecha_aprobado']?>">
            <? endif; ?>

         </tbody>

      </table>   

      

      <h3>Responsable del Anticipo</h3>

      <table style="display:block">      

            <tr>
            	 <td>Regional:</td>
                 <td>

                 <? $sqlPry = "SELECT * FROM regional ORDER BY region ASC"; 

                    $qrPry = mysql_query($sqlPry);

                 ?>
			     <input type="hidden" name="regional" value="<?=$rs_per['id_regional']?>">
                 <select class="chosen-select required var_ordenes" disabled>

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

                 <!--<input type="text" name="nombre_responsable" id="nombre_responsable" size="40" value="<?=$rs_per['nombre_responsable']?>" class="required"/>-->      

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
						$sqlPry = "SELECT * FROM centros_costos ORDER BY sigla ASC"; 
                       	$qrPry = mysql_query($sqlPry);
                    ?>
					<input type="hidden" name="centros_costos" value="<?=$rs_per['id_centroscostos']?>">
                    <select class="chosen-select required var_ordenes" disabled>

                        <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>

                        <option value="<?=$rsPry['id']?>" <?php echo ($rsPry['id']==$rs_per['id_centroscostos'])? 'selected="selected"': '';?>><?=$rsPry['sigla']?> / <?=$rsPry['nombre']?></option>

                        <? } ?>

                    </select>            

                </td>              

            	<td>Ordenes de Trabajos:</td>

                <td>
					<input type="hidden" name="orden_trabajo" value="<?=$rs_per['id_ordentrabajo']?>">
                    
                    <select class="chosen-select required" disabled>
                    	 <? 
						 	$resultado = mysql_query("SELECT * FROM orden_trabajo WHERE id_regional = ".$rs_per['id_regional']." AND id_centroscostos = ".$rs_per['id_centroscostos']) or die(mysql_error());
							 while ($rsPry = mysql_fetch_array($resultado)) { 
						?>

                        		<option value="<?=$rsPry['id_proyecto']?>" <?=($rsPry['id_proyecto']==$rs_per['id_ordentrabajo'])? 'selected="selected"' : '';?>><?=$rsPry['orden_trabajo']?></option>

                         <? } ?>

                    </select>     

                </td>
            </tr>  
   		</tbody>  
    </table>  

	
    <? if($rs_per['orden_servicio_id'] == 0):  ?>  

    <table style="width:100%;">

        <tbody>            

            <tr>
            	<td colspan="4"><h3>Consignar a (Interno):</h3></td>
            </tr>   

            <tr>
            	<td style="width:120px;">CEDULA:</td>
                <td>
                   

                    <input type="text" name="cedula_consignar" id="cedula_consignar" value="<?=$rs_per['cedula_consignar']?>" size="30" readonly>

                </td>                  

                <td>BENEFICIARIO:</td>

                <td>

              		<input type="text" name="beneficiario" id="beneficiario" size="30" class="required" value="<?=$rs_per['beneficiario']?>" readonly/>       

                </td>       

            </tr>          

            <tr>

            	<td>BANCO:</td>

                <td>

                 	<input type="text" name="banco" id="banco" size="30"  class="required" value="<?=$rs_per['banco']?>" readonly/>               

                </td>

                

                <td>TIPO CUENTA:</td>

                <td>

              		<input type="text" name="tipo_cuenta" id="tipo_cuenta" size="30" class="required" value="<?=$rs_per['tipo_cuenta']?>" readonly/>       

                </td> 

            </tr> 

            <tr>    

                <td>N&deg; DE CUENTA:</td>

                <td>

              		<input type="text" name="num_cuenta" id="num_cuenta" size="30"  alt="integer" class="required" value="<?=$rs_per['num_cuenta']?>" readonly/>    

                </td>         

           

            	<td>OBSERVACIONES:</td>

                <td>

              		<input type="text" name="observaciones" id="observaciones" size="30" value="<?=$rs_per['observaciones']?>" readonly/>       

                </td>      

            </tr> 
            
            <tr>
            	<td>TIPO BANCO</td>
                <td>
                	<input type="text" name="opcionbanco" value="<?=$rs_per['tipo_banco']?>" readonly/>
                </td>
            </tr>      

        </tbody>

    </table>   
    
    <? else: 
	
		$sqlPry = "SELECT * FROM `orden_servicio` WHERE id = ".$rs_per['orden_servicio_id']; 
		$qrPry = mysql_query($sqlPry);
		$row_bene = mysql_fetch_array($qrPry);
	
	
		echo $mensaje = '
		<table style="width:100%;">
			  	<tr>
            		<td colspan="4"><h3>Consignar a (Contratista):</h3></td>
            	</tr>   
				<tr>
					<td>Orden de Servicio #:</td>
					<td>'.$rs_per['orden_servicio_id'].'</td> 
				</tr>
				<tr>
                    <td>NOMBRE CONTRATISTA:</td>
                    <td>'.$row_bene['nombre_contratista'].'</td>  
                    <td>CEDULA:</td>
                    <td>'.$row_bene['cedula_contratista'].'</td> 
                    <td>TEL&Eacute;FONO:</td>
                    <td>'.$row_bene['telefono_contratista'].'</td>  
                </tr>
                <tr>
                    <td>DIRECCI&Oacute;N:</td>
                    <td>'.$row_bene['direccion_contratista'].'</td> 
                    <td>CONTACTO:</td>
                    <td>'.$row_bene['contacto_contratista'].'</td> 
                    <td>REGIMEN:</td>
                    <td>'.$row_bene['regimen_contratista'].'</td>  
                </tr>
                <tr>
                    <td>CORREO:</td>
                    <td>'.$row_bene['correo_contratista'].'</td> 
                    <td>POLIZA:</td>
                    <td>'.$row_bene['poliza_contratista'].'</td> 
                    <td>BANCO:</td>
                    <td>'.$row_bene['banco_contratista'].'</td>  
                </tr>
                <tr>
                    <td>TIPO CUENTA:</td>
                    <td>'.$row_bene['tipocuenta_contratista'].'</td> 
                    <td>NO. CUENTA:</td>
                    <td>'.$row_bene['numcuenta_contratista'].'</td> 
                    <td>SALDO ACUMULADO:</td>
                    <td>$'.$row_bene['observaciones_contratista'].'</td> 
                </tr>
                <tr>
                    <td>CONTRATO:</td>
                    <td>'.$row_bene['num_contrato_contratista'].'</td> 
                </tr> 
		 </table> '; 
	
	 endif; 
	?>
    <h3>Informaci&oacute;n Cotizaci&oacute;n</h3>

        <table>

            <tbody>          	

                <tr>

                  <td>Valor cotizado:</td>

                  <td>

                     <input type="text" name="v_cotizado" id="v_cotizado"  value="<?=$rs_per['v_cotizado']?>"  readonly="readonly"/> 

                  </td>            

                </tr>       

            </tbody>   

       </table>  

       <br />
       
       <? if(in_array(185,$_SESSION['permisos'])): ?>
       
       <h3>Cambio de estado</h3>

        <table>
            <tbody> 
                <tr>
                  <td>Estado:</td>
                  <td>
                      <select name="estado_anticipo" id="estado_anticipo" class="chosen-select">

                        <option value="">Seleccionar..</option>                   
                        <option value="0" <?=($rs_per['estado'] == 0)?'selected="selected"':''?>>No Revisado</option>
                        <option value="1" <?=($rs_per['estado'] == 1)?'selected="selected"':''?>>Aprobado</option>
                    </select>     
                  </td> 
                </tr> 
            </tbody> 
       </table> 
       
       <? endif; ?> 
       
       
       <h3>Informaci&oacute;n del Anticipo</h3>

       <table style="width:100%">
    
            <tbody>          	
    
                <tr>
    
                  <td>Valor del Giro (Aplica para Efecty, etc):</td>
    
                  <td>
    
                     <input type="text" name="giro" id="giro" value="<?=$rs_per['giro']?>" alt="decimal"/> 
    
                  </td> 
    
                   <td>Total Anticipo:</td>
    
                  <td>
    
                      <input type="text" name="total_anticipo" id="total_anticipo" readonly style="background:#CCC" value="<?=$total_anticipo?>"/>               
    
                  </td>           
    
                </tr>       
    
            </tbody>   
    
       </table>

</form>

  

<form action="javascript: fn_agregar_item();" method="post" id="frm_item">

  <input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
  <input type="hidden" id="centro_costo_item" name="centro_costo_item" value="<?=$rs_per['id_centroscostos']?>"/>
  
  <input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
  <input type="hidden" id="tipoingreso" name="tipoingreso" value="transferencia"/>
  <input type="hidden" id="id_os" name="id_os" value="<?=$rs_per['orden_servicio_id']?>"/> 
  
  <input type="hidden" name="giro" id="giro" value="<?=$rs_per['giro']?>"/> 
  <input type="hidden" name="total_anticipo" id="total_anticipo" value="<?=$total_anticipo?>"/>       

   
   <? if($rs_per['estado'] != 1 || $_SESSION['perfil'] == 5): ?>

   <div class="agregar_item_content" style="display:block;">

   <h4>Agregar Item</h4>  

   <table style="width:100%;table-layout: fixed;word-wrap: break-word;">

        <tbody>       

          	<tr>
                <td>Hitos:</td>
                <td colspan="2">
        
                    <select name="hitos" id="hitos" class="chosen-select required">
        
                      <option>Seleccione...</option>
        
                      <?php
        
                          $total = 0;
        
                          $resultado = mysql_query("SELECT * FROM hitos WHERE estado IN ('PENDIENTE','EN EJECUCION','ADMIN','COTIZADO','EJECUTADO','INFORME ENVIADO') AND id_proyecto = ".$rs_per['id_ordentrabajo']) or die(mysql_error());
                          $total = mysql_num_rows($resultado);
        
                          if($total > 0):
                              while($row = mysql_fetch_assoc($resultado)):
                      ?>
        
                      <option value="<?=$row['id']?>"><?=utf8_encode($row['nombre']).'-'.$row['fecha_inicio']?></option>
        
                      <?php			
                              endwhile;
                          endif;
                      ?>
                    </select> 
                </td> 
           </tr>         
           
           <tr class="transferencia acpm">                
                  <td width="120">Valor ACPM para el suministro:</td> 
                  <td>
                  	<input type="text" name="acpm" id="acpm" value="0" alt="decimal" class="openimpuesto" window="acpm" readonly/>
                  </td>
		   </tr>
           <tr class="transferencia">       
                  <td>Valor Viaticos:</td>
                  <td class="viaticos">
                      <input type="text" name="viaticos" id="viaticos" value="0" alt="decimal" class="required reset openimpuesto" window="viaticos" readonly/> 
                  </td> 
                  <td>Valor Transporte:</td>
                  <td class="transporte">
                      <input type="text" name="valor_transporte" value="0" id="valor_transporte" alt="decimal" class="required reset openimpuesto" window="transporte" readonly/>
                  </td>  
           </tr> 
           <tr class="transferencia">       
                  <td>TOES:</td>
                  <td class="toes"> 
                      <input type="text" name="toes" id="toes" value="0" alt="decimal" class="required reset openimpuesto" window="toes" readonly/>
                  </td> 
                  <td>Trasiego o Mular:</td>
                  <td class="mular">
                      <input type="text" name="mular" value="0" id="mular" alt="decimal" class="required reset openimpuesto" window="mular" readonly/> 
                  </td>   
           </tr>  
           
           <tr>
                <td colspan="2">
                    <input name="agregar" type="submit" id="agregar" value="Agregar Item" class="btn_table transferencia"/>
                </td>
           </tr>

    	  </tbody>	

    	</table>

    </div>
    
    <? endif; ?>

	</form>

    <div id="grid_html"></div>

	<div id="jqxgrid2" style="margin-top:20px; margin-bottom:20px;"></div>

</div>



    <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
		  <? if(in_array(182,$_SESSION['permisos']) && $rs_per['estado']==0): ?>
                <input name="update" type="button" id="update" value="Actualizar" class="btn_table" />
          <? elseif($_SESSION['perfil']==5): ?>
                <input name="update" type="button" id="update" value="Actualizar ADMIN" class="btn_table" /> 
          <? endif; ?>                      
    
           <input name="btn_print" type="button" id="btn_print" value="Imprimir" class="btn_table" /> 
    
           <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();"  class="btn_table" />                  
    
    </div>

</div>



<script type="text/javascript">

$(document).ready(function () {
	
	//calcula el valor de galon por precio
	$('.valor_total_galon').live('change',function(){
   
	   var galones = $('#galones').val();
	   var valor_galon = $('#valor_galon').val();
	   var total_neto = 0;
	   var retencion = 0;
	   var concepto = <?=($valor_concepto!='')?$valor_concepto:0?>
	   
	   var res = valor_galon.split(",00");
	   valor_galon = parseInt(res[0].replace('.',''));
	   
	   total_neto = galones * valor_galon;
	   retencion = total_neto * concepto;
	   
	   total = total_neto;
	   
	   $('#valor_neto_total').val(parseInt(total));		   
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
			 { name: 'viaticos', type: 'number'},
			 { name: 'mular', type: 'number'},
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
		url: 'ajax_list_items.php?id=<?=$_POST['ide_per']?>',
		root: 'Rows',
		sortcolumn: 'i.id',
		sortdirection: 'desc',
		filter: function(){
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

		}

		);



	var dataadapter = new $.jqx.dataAdapter(source);

	$("#jqxgrid2").jqxGrid({
		width: '98%',
		height: 260,
		source: dataadapter,
		//editable: <?=($rs_per['estado']==1)? 'false':'true'?>,
		showfilterrow: false,
		pageable: true,
		filterable: false,
		theme: theme,
		sortable: true,
		rowsheight: 25,
		columnsresize: true,
		virtualmode: true,
		
		showstatusbar: true,
		statusbarheight: 50,
		showaggregates: true,
		
		rendergridrows: function(obj){
			 return obj.data;      
		},                
		columns: [ 
		<? if($rs_per['estado']!=1 || $_SESSION['perfil'] == 5 ): ?>
		  { text: '-', datafield: 'acciones', filtertype: 'none', width:40, cellsalign: 'center', editable: false },
		<? endif; ?>                 

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
		  
		  { text: 'Viaticos', datafield: 'viaticos', filtertype: 'none', width: 130, cellsalign: 'right',cellsformat: 'c2'  },
		  
		  { text: 'Tras. Mular', datafield: 'mular', filtertype: 'none', width: 130, cellsalign: 'right',cellsformat: 'c2'  },

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

$(document).ready(function(){

	   	//calcula el valor de galon por precio
		$('.valor_total_galon').live('change',function(){
	   
		   var galones = $('#galones').val();
		   var valor_galon = $('#valor_galon').val();
		   var total_neto = 0;
		   var retencion = 0;
		   var concepto = <?=($valor_concepto!='')?$valor_concepto:0?>
		   
		   var res = valor_galon.split(",00");
		   valor_galon = parseInt(res[0].replace('.',''));
		   
		   total_neto = galones * valor_galon;
		   retencion = total_neto * concepto;
		   
		   total = total_neto;		   
		   $('#valor_neto_total').val(parseInt(total));		   
		});

		$(".chosen-select").chosen({width:"220px"}); 
		$('input').setMask();
		$(".btn_table").jqxButton({ theme: theme });

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

	});

	

	

	function replaceAll( text, busca, reemplaza ){
	  //console.log(text);
	  if(text != 'undefined'){

		  while (text.toString().indexOf(busca) != -1)
			  text = text.toString().replace(busca,reemplaza);
		  return text;
	  }

	}



	

	$('.anticipo').blur(function(){

		var total = 0;

		$('.anticipo').each(function( index ) {

			var val = replaceAll($( this ).val(),".","");

			total += parseFloat(val);
			
			console.log(val);

		});
		
		$('#total_anticipo').val(total+',00').setMask(); 
	});

	

	function fn_modificar(){
		
		loaderSpinner();
		
		var str = $("#frm_per").serialize();

		$.ajax({
			url: 'ajax_modificar.php',
			data: str,
			type: 'post',
			success: function(data){
				if(data != "") {
					stoploaderSpinner();
					alert(data);
				}else{
					stoploaderSpinner();
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
}
</script>