<?  header('Content-type: text/html; charset=iso-8859-1');

	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit; 
	} 

	include "../extras/php/basico.php";
	include "../../conexion.php";


	$sql = sprintf("select * from legalizacion where id=%d",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);

	if ($num_rs_per==0){
		echo "No existen legalizacion con ese ID";
		exit;
	}	
	$rs_per = mysql_fetch_assoc($per);

	$letters = array('.','$',',');
	$fruit   = array('');

	$valor_legalizado = 0;
	$reintegro = 0;
	$valor_pagar = 0; 

	$resultado = mysql_query("SELECT pagado FROM items WHERE estado = 0 AND id_legalizacion =".$_POST['ide_per']) or die(mysql_error());

	while ($rows = mysql_fetch_assoc($resultado)):

		if($rows['pagado'] != ''):
			/*$valor = explode(',00',$rows['pagado']);
			$valor2 = str_replace($letters, $fruit, $valor[0] );
			$valor_legalizado += $valor2;*/
			$valor_legalizado += (int)$rows['pagado']; //FGR

		endif;
	endwhile;

	$valor = substr($rs_per['valor_fa'],0, -3);
	$valor_fondo = str_replace($letters, $fruit, $valor);	
	$valor_fondo_tmp = $valor_fondo;

	if($valor_legalizado != 0 ):			
		$reintegro = $valor_fondo - $valor_legalizado;
	endif;

	if($valor_legalizado > $valor_fondo):			
		$valor_pagar = $valor_legalizado - $valor_fondo;
		$reintegro = 0;
	endif;
	
	$obj = new TaskCurrent;	
	//Obtengo el valor total de reintegro de un anticipo de prioridad reintegro
	$reintegro_anticipo = $obj->getReintegroByLegalizacion((int)$_POST['ide_per']);
	$reintegro_anticipo = substr($reintegro_anticipo,0, -3);
	$reintegro_anticipo = str_replace($letters, $fruit, $reintegro_anticipo);	

	$reintegro = $reintegro - $reintegro_anticipo;
	
	//echo $reintegro.'-'.$reintegro_anticipo;
	//echo 'Valor pagar->'.$valor_legalizado.'-'.$valor_fondo.' | '.$rs_per['valor_fa'];

	setlocale(LC_MONETARY, 'en_US');

	$sql2 = sprintf("SELECT total_anticipo FROM anticipo WHERE publicado NOT IN('draft','ELIMINADO') AND estado != 4 AND id_legalizacion=%d",
		(int)$_POST['ide_per']
	);
	$per2 = mysql_query($sql2);
	$num_rs_per2 = mysql_num_rows($per2);
	
	if ($num_rs_per2 > 0){
		while($rs_per2 = mysql_fetch_assoc($per2)){
			$valor = substr($rs_per2['total_anticipo'],0, -3);
			$valor = str_replace($letters, $fruit, $valor);
			$total_anticipos_vinculados += $valor;
		}
	}else{
		$total_anticipo  = 0;
	}
	
	$valor_fondo.'+'.$total_anticipos_vinculados.'-'.$reintegro_anticipo;
	$valor_fondo = money_format('%(#1n',$valor_fondo + $total_anticipos_vinculados - $reintegro_anticipo);

	
	$resultado_anticipo = mysql_query("SELECT * FROM anticipo WHERE publicado NOT IN('draft','ELIMINADO') AND estado != 4 AND id_legalizacion =".$_POST['ide_per']) or die(mysql_error());
	$total_anticipo = mysql_num_rows($resultado_anticipo);
	$row_anticipo = mysql_fetch_assoc($resultado_anticipo);
	
	if($total_anticipo > 0):
		
		switch($row_anticipo['prioridad']):
			case 'REINTEGRO':
				$tipo_anticipo = 'R';
			break;
			case 'VINCULADO':
				$tipo_anticipo = 'V';
			break;
		endswitch;
		
		$otro_anticipo = ' - '.$tipo_anticipo.$row_anticipo['id'];

		$total_anticipo2 = substr($row_anticipo['total_anticipo'],0, -3);
		$total_anticipo2 = str_replace($letters, $fruit, $total_anticipo2);

		$valor_pagar = $valor_pagar - $total_anticipo2 + $reintegro_anticipo;

	else:
		$otro_anticipo = '';
	endif;

	$valor_pagar2 = $valor_pagar;

	$valor_pagar = money_format('%(#1n',$valor_pagar);
	$valor_reintegro = money_format('%(#1n',$reintegro);
	$valor_legalizado =  money_format('%(#1n',$valor_legalizado);
	
	
	//si tiene OS
	$os = 0;
	$sql_os = " SELECT orden_servicio_id 
				FROM anticipo WHERE publicado NOT IN('draft','ELIMINADO') AND estado != 4 AND id =".$rs_per['id_anticipo'];
	$resultado_os = mysql_query($sql_os) or die(mysql_error());
	$row_os = mysql_fetch_assoc($resultado_os);
	
	$os = $row_os['orden_servicio_id'];
?>

<style>
#row0jqxgrid2 .jqx-grid-cell:nth-child(1){
	width: 27px !important;
}
</style>



<!--Hoja de estilos del calendario -->

<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">

<!-- librería principal del calendario -->

<script type="text/javascript" src="../../calendario/calendar.js"></script>

<!-- librería para cargar el lenguaje deseado -->

<script type="text/javascript" src="../../calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>



<link rel="stylesheet" href="/js/chosen/chosen.css">

<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 



<div id="content_form">

	<h1>FORMATO DE LEGALIZACION DE ANTICIPOS</h1>

    <form action="javascript: fn_agregar();" method="post" id="frm_per">

       <input type="hidden" value="<?=$_POST['ide_per']?>" name="id_legalizacion"/>
       
       <h1 style="text-align: center; color:#CC3300;font-size: 20px;">RESPONSABLE: <?=$rs_per['responsable']?></h1> 

       <table class="formulario">

        <tbody>

        	<tr>
            	<td colspan="2">
                	 <h3 style="margin-bottom:0;">N&deg; LEGALIZACI&Oacute;N: <?=$rs_per['id']?></h3>
                </td>
            </tr>
			<? if($os != 0): 
			
					$sql = sprintf("select * from `orden_servicio` where id=%d",
						(int)$os
					);
					$per = mysql_query($sql);
					$rs_os = mysql_fetch_assoc($per);
			?>
            <tr>
            	<td colspan="2"><h3>Contratista:</h3></td>
            </tr>   
            <tr>
            	<td style="width:120px;">CEDULA:</td>
                <td>
              		<input type="text" value="<?=$rs_os['cedula_contratista']?>" readonly/>       
                </td>                  
                <td>NOMBRE:</td>
                <td>
              		<input type="text" value="<?=$rs_os['nombre_contratista']?>" readonly/>       
                </td>       
            </tr>          
            <tr>
            	<td>TELEFONO:</td>
                <td>
                 	<input type="text" value="<?=$rs_os['telefono_contratista']?>" readonly/>               
                </td>
                <td>DIRECCI&Oacute;N:</td>
                <td>
              		<input type="text" value="<?=$rs_os['direccion_contratista']?>" readonly/>       
                </td> 
            </tr>
            <tr>
            	<td>CONTACTO:</td>
                <td>
                 	<input type="text" value="<?=$rs_os['contacto_contratista']?>" readonly/>               
                </td>
                <td>CORREO:</td>
                <td>
              		<input type="text" value="<?=$rs_os['correo_contratista']?>" readonly/>       
                </td> 
            </tr>
            <tr>
            	<td>BANCO:</td>
                <td>
                 	<input type="text" value="<?=$rs_os['banco_contratista']?>" readonly/>
                </td>
                <td>TIPO CUENTA:</td>
                <td>
              		<input type="text" value="<?=$rs_os['tipocuenta_contratista']?>" readonly/>       			</td> 
            </tr> 
            <tr>    
                <td>N&deg; DE CUENTA:</td>
                <td>
              		<input type="text" value="<?=$rs_os['numcuenta_contratista']?>" readonly/>    
                </td>         
            	<td>SALDO ACUMULADO:</td>
                <td>
              		<input type="text" value="<?=$rs_os['observaciones_contratista']?>" readonly/>       
                </td>      
             </tr> 
             <tr>    
                <td>REGIMEN:</td>
                <td>
              		<input type="text" value="<?=$rs_os['regimen_contratista']?>" readonly/>    
                </td>         

            	<td>POLIZA:</td>
                <td>
	                <input type="radio"  <?=($rs_os['poliza_contratista'] == "Si")?"checked=\"checked\"":'';?> readonly/> Si.
                    <input type="radio" <?=($rs_os['poliza_contratista'] == "No")?"checked=\"checked\"":'';?> readonly/> No.
                </td>      
            </tr> 
            <? else: 
					$sql3 = sprintf("SELECT banco, tipo_cuenta, num_cuenta, cedula_consignar, beneficiario
									 FROM anticipo WHERE id=%d",
							(int)$rs_per['id_anticipo']
					);
					$per3 = mysql_query($sql3);
					$rs_ant = mysql_fetch_assoc($per3);
			?> 
           <tr>
            	<td style="width:120px;">CEDULA:</td>
                <td>
              		<input type="text" value="<?=$rs_ant['cedula_consignar']?>" readonly/>       
                </td>                  
                <td>NOMBRE:</td>
                <td>
              		<input type="text" value="<?=$rs_ant['beneficiario']?>" readonly/>       
                </td>       
            </tr>          
          
            <tr>
            	<td>BANCO:</td>
                <td>
                 	<input type="text" value="<?=$rs_ant['banco']?>" readonly/>
                </td>
                <td>N&deg; DE CUENTA:</td>
                <td>
              		<input type="text" value="<?=$rs_ant['num_cuenta']?>" readonly/>       			</td> 
            </tr> 
            <tr>
            	<td>TIPO CUENTA:</td>
                <td>
                 	<input type="text" value="<?=$rs_ant['tipo_cuenta']?>" readonly/>
                </td>
            </tr>
           <? endif; ?>
           
           <tr>
           		<td colspan="2"><h3>Informaci&oacute;n del Anticipo</h3></td>
           <tr>
                <td>No. DE ANTICIPO:</td>
                <td><?=$rs_per['id_anticipo']?><?=$otro_anticipo?></td>
                <td>VALOR FONDO / ANTICIPO:</td>
                <td><input name="valor_fa" type="text" id="valor_fa" size="40" class="required money" value="<?=$valor_fondo?>" readonly/> 
                	  <? 
					  	//echo $rs_per['estado'].'-'.$valor_legalizado.'-'.$valor_pagar.'-'. $valor_reintegro.'<br>';
					  	if($rs_per['estado'] == 'NO REVISADO' && $valor_legalizado == ' $0.00' && $valor_pagar == ' $0.00' && $valor_reintegro == ' $0.00'): ?>
                      		<br/>
							<a href="javascript:" id="addReintegroTotal">Crear Anticipo Reintegro Total</a>
					  <? endif; ?>
                </td>
            </tr>

            <tr>
            	<td>PROYECTO - OT:</td>
                <td>
                <?
					$resultado = mysql_query("	SELECT o.orden_trabajo AS ordentrabajo,  o.id_proyecto AS idproyecto

												FROM anticipo AS a

												LEFT JOIN orden_trabajo AS o ON a.id_ordentrabajo = o.id_proyecto

												WHERE a.id =".$rs_per['id_anticipo']) or die(mysql_error());

					$row = mysql_fetch_assoc($resultado);

					$id_proyecto = $row['idproyecto'];

					echo $row['ordentrabajo'];

				?>

                <input name="id_proyecto" type="hidden" value="<?=$id_proyecto?>" />

                </td>

                

                <td>Valor Legalizado</td>

                <td><input name="valor_legalizado" type="text" id="valor_legalizado" size="40" class="required"  value="<?=$valor_legalizado?>" disabled="disabled" /></td>

            </tr>

            

            <tr>

               <td colspan="2">&nbsp;</td>

               <td>Valor a Pagar</td>

               <td>

               	<input name="valor_pagar" type="text" id="valor_pagar" size="40" class="required money" value="<?=$valor_pagar?>" disabled="disabled" />
				<? if($os == 0): ?>
					<? if($valor_pagar2 > 0):?>
                            <br />
                            <a href="javascript:" id="add_anticipo">Vincular un Nuevo Anticipo</a>
                    <? endif; ?>
                <? else: ?>
                	<? if($valor_pagar2 > 0):?>
                		<br />
                		<a href="javascript:" class="btnAlert">Vincular un Nuevo Anticipo</a>
                    <? endif; ?>	
 				<? endif; ?>
               </td>

            </tr>

            <tr>

                <td>Fecha</td>

                <td><input type="text"  readonly="readonly" value="<?=$rs_per['fecha']?>" disabled="disabled"/></td>

                <td>Legalizaci&oacute;n (L) o Reintego(R) valor <?=$reintegro?></td>

                <td><input name="lega_rein" type="text" id="lega_rein" size="40" class="required money" value="<?=$valor_reintegro?>" disabled="disabled" />
                	<? if($reintegro != 0):?>
						<? if($os == 0):?>
                            <br />
                            <a href="javascript:" id="addReintegro">Crear Anticipo Reintegro</a>
                        <? else: ?>
                            <br />
                            <a href="javascript:" class="btnAlert">Crear Anticipo Reintegro</a>                    <? 	   endif; 
						endif;
					?>
                </td>

             </tr>
             
             
             <? if(in_array(204,$_SESSION['permisos'])): ?>
             <tr>
             	<td>Cambio de estado:</td>
                <td>
                	<select name="cambio_estado" id="cambio_estado" class="chosen-select required">
                        <option value="NO REVISADO" <?=($rs_per['estado']=='NO REVISADO')?'selected':''?>>NO REVISADO</option>
                        <option value="APROBADO" <?=($rs_per['estado']=='APROBADO')?'selected':''?>>APROBADO</option>
                        <option value="ELIMINADO" <?=($rs_per['estado']=='ELIMINADO')?'selected':''?>>ELIMINADO</option>
                     </select>    
                </td>
             </tr>
             <? endif; ?>

       	</tbody> 

       </table>   


      <table class="formulario">

        <tbody>   

       
            <tr>

            	<td>HITO - SITIO</td>

                <td>Concepto</td>

                <td>Cantidad de Recibidos</td>

                <td>Pagado</td>

            </tr>

            

            <tr>

                <td>       
                
                <?php

					    $sql = "SELECT *, h.nombre AS nombre_hito, h.id AS idHito
								FROM items_anticipo AS ia 
								LEFT JOIN hitos AS h ON h.id = ia.id_hitos 						  
								WHERE ia.estado = 1 AND ia.id_anticipo = ".$rs_per['id_anticipo'];  
				?>            

                 <select name="id_hito" id="hitos" class="chosen-select required">

                 	<option>Seleccione...</option>

                 	<?php

						$resultado = mysql_query($sql) or die(mysql_error());
						$total_hitos_anti = mysql_num_rows($resultado);

						while($row = mysql_fetch_assoc($resultado)):

					?>

                    		<option value="<?=$row['idHito']?>"><?=$row['idHito'].'-'.$row['nombre_hito'].'-'.$row['fecha_inicio'].'- $'.$row['total_hito']?></option>

					<? endwhile;?>

                 </select>            

               </td> 

            

            	<!--<td><input name="fecha" type="text" id="fecha" readonly="readonly" size="16"/>

                  <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "fecha",      // id del campo de tesxto

						ifFormat       :    "%Y-%m-%d",   // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador"   // el id del botón que lanzará el calendario

					});

				</script></td>-->

                

               <!-- <td><input name="beneficiario" type="text" id="beneficiario" size="20" class="required"/></td>

                <td><input name="nitccident" type="text" id="nitccident" size="20" class="required" alt="integer"/></td>

                

                <td>

                 <? $sqlPry = "SELECT * FROM centros_costos WHERE id = 1 OR id = 2 OR id = 3 OR id = 5 OR id = 6 OR id = 4 ORDER BY sigla ASC"; 

                    $qrPry = mysql_query($sqlPry);

                 ?>

                    <select name="centro_costos" id="centro_costos" class="chosen-select required">

                        <option>Seleccione...</option>

                        <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>

                        <option value="<?=$rsPry['sigla']?> / <?=$rsPry['nombre']?>"><?=$rsPry['sigla']?> / <?=$rsPry['nombre']?></option>

                        <? } ?>

                    </select>    

                </td>-->

                

                <td>
                
                 <? $sqlPry = "SELECT * FROM conceptos_legalizacion ORDER BY id ASC"; 

                    $qrPry = mysql_query($sqlPry);

                 ?>

                    <select name="concepto" id="concepto" class="chosen-select required">

                        <option value="">Seleccione...</option>

                        <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>

                        <option value="<?=$rsPry['id']?>"><?=$rsPry['concepto']?></option>

                        <? } ?>

                    </select>

                </td>

                <td><input name="cantidad" type="text" id="cantidad" size="20" class="required" align="integer"/></td>

                <td><input name="pagado" type="text" id="pagado" size="20" class="required money"/></td>

            </tr>

            

        </tbody>

        </table>

        <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;height: 25px;">



                  <?php 
				 	if($rs_per['estado']!='APROBADO' && in_array(202,$_SESSION['permisos'])):
						if($total_hitos_anti > 0):
				  ?>
                	<input name="agregar" type="submit" id="agregar" value="Agregar" class="btn_table"/>
                    
                 <?php endif; ?>

						<? if(in_array(203,$_SESSION['permisos'])): ?>
                            <input type="button" id="aprobar" value="Aprobar" class="btn_table"/> 
                        <? endif; ?>

                 <?php elseif($rs_per['estado']=='APROBADO'):

						echo "<div style='float:left; margin-right:20px;'>Esta Legalizaci&oacute;n ya fue revisado y aprobado.</div>";	

					  endif; 
				  ?>

                	<input name="btn_print" type="button" id="btn_print" value="Imprimir" style="float:left;" class="btn_table"/>  


                    <input name="cancelar" type="button" 

                      <?php if($rs_per['estado'] == 'NO REVISADO' ):?> 

                    	id="cancelar" 

                      <?php endif; ?>

                    	value="Terminar" onclick="fn_cerrar();" style="float:left;" class="btn_table"/>
                      <? if(in_array(204,$_SESSION['permisos'])): ?>
                		<input type="button" id="btnCambioestado" value="Cambiar Estado" style="float:left;" class="btn_table"/>  
                      <? endif; ?>

        </div>	

    </form>



    <div style="margin-bottom:20px; clear:both;">

         <div id="jqxgrid2"></div>

    </div>



</div>



<script type="text/javascript">

$(document).ready(function () {

            var source =

            {

                 datatype: "json",

                 datafields: [

					 { name: 'id', type: 'string'},
					 
					 { name: 'id_hito', type: 'string'},

					 { name: 'concepto', type: 'string'},

					 { name: 'pagado', type: 'string'},

					 { name: 'cantidad_recibida', type: 'string'},

					 { name: 'hito', type: 'string'},

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

				sortcolumn: 'id',

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

				}

				);



            var dataadapter = new $.jqx.dataAdapter(source);



            $("#jqxgrid2").jqxGrid({

                width: '100%',

				height: 260,

                source: dataadapter,

				editable: true,

                showfilterrow: false,

                pageable: true,

                filterable: false,

                theme: theme,

				sortable: true,

                rowsheight: 25,

                columnsresize: true,

				virtualmode: true,

				rendergridrows: function(obj)

				{

					 return obj.data;      

				},                

                columns: [

				  <?php if($rs_per['estado']=='NO REVISADO' || $_SESSION['perfil'] == 5):?>

				  { text: '-', datafield: 'acciones', cellsalign: 'center',editable: false,width: 50  },

				  <? endif; ?>
					
				  { text: 'ID', datafield: 'id', filtertype: 'textbox', filtercondition: 'starts_with', columntype: 'textbox', editable: false, width: 50 },	
					
                  { text: 'ID Hito', datafield: 'id_hito', filtertype: 'textbox', filtercondition: 'starts_with', columntype: 'textbox', editable: false, width: 50 },

				  { text: 'HITO - SITIO', datafield: 'hito', filtertype: 'textbox', filtercondition: 'starts_with'},

                  { text: 'Concepto', datafield: 'concepto', filtertype: 'textbox', filtercondition: 'starts_with'},

				  { text: 'Cantidad de Recibidos', datafield: 'cantidad_recibida', filtertype: 'textbox', filtercondition: 'starts_with', width: 190 },

				  { text: 'Pagado', datafield: 'pagado', filtertype: 'none', width: 100 }
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

			

			$('#add_anticipo').click(function(){
				
				loaderSpinner();

				$("#div_oculto").load("ajax_form_agrega_anticipo.php?ide_per=<?=$rs_per['id_anticipo']?>&id_legalizacion=<?=$_POST['ide_per']?>", function(){

					$.blockUI({

						message: $('#div_oculto'),
						css:{
							width: '660px',
							top: '2%',
							left: '24%',
							'max-height': '580px',
							'overflow-y': 'scroll'						
						}

					}); 
					
					stoploaderSpinner();

				});
			});
			
		$('#addReintegroTotal').click(function(){
			
			loaderSpinner();

			$("#div_oculto").load("ajax_form_agrega_anticipo_reintegro.php?ide_per=<?=$rs_per['id_anticipo']?>&id_legalizacion=<?=$_POST['ide_per']?>&valor_fa=<?=$valor_fondo_tmp?>", function(){

				$.blockUI({
					message: $('#div_oculto'),
					css:{
						width: '660px',
						top: '2%',
						left: '24%',
						'max-height': '580px',
						'overflow-y': 'scroll'						
					}

				}); 
				
				stoploaderSpinner();

			});
		});
		
		$('#addReintegro').click(function(){
			
			loaderSpinner();

			$("#div_oculto").load("ajax_form_agrega_anticipo_reintegro.php?ide_per=<?=$rs_per['id_anticipo']?>&id_legalizacion=<?=$_POST['ide_per']?>", function(){

				$.blockUI({
					message: $('#div_oculto'),
					css:{
						width: '660px',
						top: '2%',
						left: '24%',
						'max-height': '580px',
						'overflow-y': 'scroll'						
					}

				}); 
				
				stoploaderSpinner();

			});
		});


		$(".money").maskMoney({ prefix:'$', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

		$(".chosen-select").chosen({width:"250px"});

		$(".btn_table").jqxButton({ theme: theme });	

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

					var respuesta = confirm('\xBFRealmente desea agregar este item?')

					if (respuesta)

						form.submit();		

			}

		});

		$('#aprobar').click(function(){

			var idLegalizacion = <?=(int)$_POST['ide_per']?>;
			var respuesta = confirm('\xBFDesea realmente cambiar el estado a aprobado?')

				if (respuesta){		
					$.ajax({
						  type: 'POST',
						  dataType: 'json',
						  url: 'ajax_aprobar_legalizado.php',
						  data: {id:idLegalizacion},
						  success: function(data){	

							  if (data.estado == false){ 

								 alert(data.mensaje);

							  }else{

							  	fn_cerrar();	

								$("#jqxgrid").jqxGrid('updatebounddata', 'cells');					

							  }

						  }

					 });					

				}
		});		


		$('#btn_print').click(function(){
			window.open("/anticipos/legalizacion/export_pdf.php?ide_per=<?=$rs_per['id']?>");
		});	


		$('#cancelar').click(function(){
			  $.ajax({
				  type: 'POST',
				  dataType: 'json',
				  url: 'ajax_modificar_legalizacion.php',
				  data: $('#frm_per').serialize()			 
			  }); 
	  	});
		
		$('#btnCambioestado').click(function(){
			  $.ajax({
				  type: 'POST',
				  dataType: 'json',
				  url: 'ajax_cambiarestado_legalizacion.php',
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
		
		$('.btnAlert').click(function(){
			swal({
			  title: "Ups",
			  text: "No se puede crear un anticipo (vinculado o reintegro).\n El anticipo de la legalizaci\xf3n tiene una OS vinculada.\n Por favor pida una autorizaci\xf3n a gerencia", 
			  type: "warning",
			  showCancelButton: false,
			  //confirmButtonClass: "btn-danger",
			  //confirmButtonText: "Yes, delete it!",
			  closeOnConfirm: false
			});
		});

});

	

function fn_agregar(){ 

  var str = $("#frm_per").serialize();
  
  $.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'ajax_agregar_item.php',
		data: str,
		success: function(data){	
	
			if (data.estado == true){ 
	
			   $("#valor_legalizado").val(data.valor_legalizado);
	
			   $("#valor_pagar").val(data.valor_pagar);
	
			   $("#lega_rein").val(data.valor_reintegro);
	
			   $("#jqxgrid2").jqxGrid('updatebounddata', 'cells');
	
			   /*setTimeout(function(){  
	
				   $("#jqxgrid2").jqxGrid('updatebounddata', 'cells');
	
			   },1000);*/
	
			  // $("#flex1").flexReload();
	
			   //$('#frm_per').reset();
	
			}
	
		}	  
	
	});

};





function fn_borrar(id_event){    

			id = id_event;

			

			$.ajax({

				type: 'POST',

				dataType: 'json',

				url: 'ajax_delete_item.php',

				data: {IdDelete: id, id_legalizacion:<?=$_POST['ide_per']?>},

				success: function(data){	

					if (data.estado == true){

					   $("#valor_legalizado").val(data.valor_legalizado);

					   $("#valor_pagar").val(data.valor_pagar);

					   $("#lega_rein").val(data.valor_reintegro);

					   $("#jqxgrid2").jqxGrid('updatebounddata', 'cells');

					}

				}

			})

}


jQuery.fn.reset = function () {

$(this).each (function() { this.reset(); });

}



</script>



 