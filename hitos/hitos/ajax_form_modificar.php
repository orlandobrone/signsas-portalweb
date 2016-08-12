<?  header('Content-type: text/html; charset=iso-8859-1');
	
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}
	include "../extras/php/basico.php";
	include "../../conexion.php";
	
	$obj = new TaskCurrent;	
	
	setlocale(LC_MONETARY, 'en_US');
	
	$sql = sprintf("select * from hitos where id=%d",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen hitos con ese ID";
		exit;
	}
	$rs_per = mysql_fetch_assoc($per);
	
	$sql_estados = sprintf("SELECT DISTINCT estado FROM hitos");
	$result = mysql_query($sql_estados);
	
	if($rs_per['editable']=='0'){
		echo '<p>Este hito no se puede editar</p>';	
		echo '<input name="cancelar" style="margin-bottom:25px;" type="button" id="cancelar" value="Cerrar" onclick="fn_cerrar();" class="btn_table"/>';
	}
	
	else {
		
			$sololectura_po = 'readonly="readonly"';
			$sololectura_po2 = 'readonly="readonly"';
			$sololectura_po3 = 'readonly="readonly"';
			$sololectura_po4 = 'readonly="readonly"';
			
			if(($_SESSION['perfil'] == 5 || $_SESSION['perfil'] == 19) && ($rs_per['estado'] == 'PENDIENTE' || $rs_per['estado'] == 'N/A')):
				$sololectura_po = '';
				$sololectura_po2 = '';
				$sololectura_po3 = '';
				$sololectura_po4 = '';
			else:
				if($rs_per['po'] == 'PENDIENTE' || $rs_per['po'] == 'N/A'):
					$sololectura_po = '';
				endif;	
				if($rs_per['po2'] == 'PENDIENTE' || $rs_per['po2'] == 'N/A'):
					$sololectura_po2 = '';
				endif;
				if($rs_per['po3'] == 'PENDIENTE' || $rs_per['po3'] == 'N/A'):
					$sololectura_po3 = '';
				endif;	
				if($rs_per['po4'] == 'PENDIENTE' || $rs_per['po4'] == 'N/A'):
					$sololectura_po4 = '';
				endif;		
				
			endif;
			
			if($_SESSION['perfil'] != 19):
				if($rs_per['po'] == 'PENDIENTE'):
					$sololectura_po = '';
				endif;	
				if($rs_per['po2'] == 'PENDIENTE'):
					$sololectura_po2 = '';
				endif;
				if($rs_per['po3'] == 'PENDIENTE'):
					$sololectura_po3 = '';
				endif;
				if($rs_per['po4'] == 'PENDIENTE'):
					$sololectura_po4 = '';
				endif;						
			endif;
			//elseif($_SESSION['perfil'] == 19 && $rs_per['estado'] == 'FACTURADO')
			
			function addDay($date){
				$fecha = $date;
				$nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
				return $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
			}
			
			if($_SESSION['perfil'] == 19 || $_SESSION['perfil'] == 5):
					$sololectura_po = '';
					$sololectura_po2 = '';
					$sololectura_po3 = '';
					$sololectura_po4 = '';
			endif;
			
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
	form#frm_per input{ width:150px; }
</style>
<h1>Modificando Hito</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
    <input type="hidden" name="fecha_create" value="<?=$rs_per['fecha']?>" />
    
    <table class="formulario">
        <tbody>
        	<?php 
						
			if($_SESSION['perfil'] == 5):
				$sololectura_po = '';
				$sololectura_po2 = '';
				$sololectura_valor = '';
			else:
				$sololectura_valor = 'readonly="readonly"';
			endif;	
			
			//if (in_array(27, $_SESSION['permisos'])) echo 'tiene permision 27'; 
			
			?>
        	
        	<tr>
                <td>Proyecto </td>
                <td>
                
                	<?php if( $_SESSION['perfil'] == 5 ){  ?>
                	<select name="proyec" ide="proyec" class="required">
                    	<option value=""></option>
						<?
                            $sql = "select * from proyectos order by nombre asc";
                            $pai = mysql_query($sql);
                            while($rs_pai = mysql_fetch_assoc($pai)){
                        ?>
                            <option value="<?=$rs_pai['id']?>" <? if($rs_pai['id']==$rs_per['id_proyecto']) echo "selected='selected'";?>><?=$rs_pai['nombre']?></option>
                        <? } ?>
					</select>
                    <?php }else{
						$sql = "select nombre from proyectos where id=".$rs_per['id_proyecto'];
                        $pai = mysql_query($sql);
                        $rs_pai = mysql_fetch_assoc($pai);?>
                        <input name="proyec_fgr" type="text" id="proyec_fgr" size="40" value="<?=$rs_pai['nombre']?>" readonly />
                        <input name="proyec" id="proyec" type="hidden" value="<?=$rs_per['id_proyecto']?>"  />
						
					<?php }?>
                </td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td><input name="nombre" type="text" id="nombre" size="40" class="requisssred" value="<?=$rs_per['nombre']?>" <?=$sololectura?>/></td>
            </tr>
            <tr>
            	  <td>Departamento:</td>
                  <td colspan="3">
						  <? $sqlPry = "SELECT * FROM ps_state"; 
                          $qrPry = mysql_query($sqlPry);
                          ?>
                          <select name="departamento" id="departamento" class="chosen-select <?=($_SESSION['perfil']==19 || $_SESSION['perfil']==5)?'':'required'?>">
                              <option value="">--Seleccione--</option>
							  <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>
                              <option value="<?=$rsPry['id']?>" <?php echo ($rsPry['id']==$rs_per['id_ps_state'])? 'selected="selected"': '';?>><?=$rsPry['name']?></option>
                              <? } ?>
                          </select>
                  </td>            
             </tr>
             	
            
            <tr>
            	  <td>Sitios:</td>
                  <td colspan="3">
                  	  <?php if($conteofgr['cuenta']){  ?>
						  <? $sqlPry = "SELECT * FROM sitios"; 
                          $qrPry = mysql_query($sqlPry);
                          ?>
                          <select name="sitios" id="sitios" class="chosen-select required" <?=$sololectura?>>
                              <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>
                              <option value="<?=$rsPry['id']?>" <?php echo ($rsPry['id']==$rs_per['id_sitios'])? 'selected="selected"': '';?>><?=$rsPry['nombre_rb']?></option>
                              <? } ?>
                          </select>   
                      <?php } 
						else {
							$sql = "select nombre_rb from sitios where id=".$rs_per['id_sitios'];
							$pai = mysql_query($sql);
							$rs_pai = mysql_fetch_assoc($pai);?>
							<input name="sitios_fgr" type="text" id="sitios_fgr" size="40" value="<?=$rs_pai['nombre_rb']?>" readonly />
                            <input name="sitios" id="sitios" type="hidden" value="<?=$rs_per['id_sitios']?>"  />
							
						<?php }?>         
                  </td>            
             </tr>
             
             <tr>
            	 <td>Estado Actual:</td>
                 <td colspan="3"><?=$rs_per['estado'];?></td>
             </tr>
            
             <tr>
            	  <td>Creaci&oacute;n:</td>
                  <td colspan="3"><?=$rs_per['fecha_real'];?></td>
             </tr>         
            
            <tr>
                <td>Fecha de Inicio</td>
                <td><input name="fecini" type="text" id="fecini" size="40" class="required" value="<?=$rs_per['fecha_inicio']?>" readonly />
                <?php if( $_SESSION['perfil'] == 5 || $_SESSION['perfil'] == 19 ){  ?>
                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" <?=$displaynone?>/>
				<script type="text/javascript">
					Calendar.setup({
						inputField     :    "fecini",      // id del campo de texto
						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
						button         :    "lanzador"   // el id del botón que lanzará el calendario
					});
				</script>
                <? } ?>
                
                </td>
            </tr>
            <?php
				$style = 'display:none';
				$arrayEstado = array('AUTORIZADO','LIQUIDADO','FACTURADO','EN FACTURACION');	
				if(in_array($rs_per['estado'],$arrayEstado)):
					$style = '';
				endif;
				
			?>
            <tr class="liquidacionfinal" style=" <?=$style?>">
            	 <td>Liquidaci&oacute;n Final</td>
                 <td>
                 	<input name="liquidacion_final" type="text" id="liquidacion_final" size="40" value="<?=$rs_per['liquidacion_final']?>" class="money">
                 </td>
            </tr>
            
            <? 
			$fecha_final = explode("-", $rs_per['fecha_final']);
			$fecha_final = $fecha_final[2] . "/" . $fecha_final[1] . "/" . $fecha_final[0];
			?>
            <tr>
                <td>Fecha de Finalizaci&oacute;n</td>
                <td><input name="fecfin" type="text" id="fecfin" size="40" class="required" value="<?=$rs_per['fecha_final']?>" readonly />
                
                <?php if( $_SESSION['perfil'] == 5 || $_SESSION['perfil'] == 19 ){  ?>
                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2" <?=$displaynone?>/>
				<script type="text/javascript">
					Calendar.setup({
						inputField     :    "fecfin",      // id del campo de texto
						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
						button         :    "lanzador2"   // el id del botón que lanzará el calendario
					});
				</script>
                
                <? } ?>
                
                </td>
            </tr>
            
            
            <tr>
                <td>Descripci&oacute;n</td>
                <td><input name="descri" type="text" id="descri" size="40" class="required" value="<?=$rs_per['descripcion']?>" <?=$sololectura?> /></td>
            </tr>
            
            <tr>
                <td>PO / TT</td>
                <td><input name="ot_cliente" type="text" id="ot_cliente" size="40" class="" 
                	value="<?=$rs_per['ot_cliente']?>" <?=$sololectura?> 
					<?=($rs_per['ot_cliente'] != 'PENDIENTE' && $_SESSION['perfil'] != 5)?' readonly="readonly"':''?>/></td> 
            </tr>
            
            <?php if( $_SESSION['perfil'] == 5 || $_SESSION['perfil'] == 19 ){  ?>
            <tr>
                <td>Cantidad de Galones</td>
                <td><input name="cant_galones_h" class="required" type="text" id="cant_galones_h" size="40" 					value="<?=$rs_per['cant_galones_h']?>">
                </td>                
            </tr>
            <?php }else{ ?>            
            	<input name="cant_galones_h" type="hidden" value="<?=$rs_per['cant_galones_h']?>">
            <?php } ?>
            
            <tr>
                <td>Valor Cotizado Hito</td>
                <td><input name="valor_cotizado_hito" class="money required" type="text" id="valor_cotizado_hito" size="40" value="<?=$rs_per['valor_cotizado_hito']?>" <?=$sololectura_valor?>/>
                </td>
                <td>Adici&oacute;n Cotizado</td>
                <td><?=money_format('%(#10n',$obj->getAdicionCotizado($rs_per['id_ps_state'],$rs_per['id']));?></td>
            </tr>
            
            
            <tr>
                <td>D&iacute;as para Facturar</td>
                <td><input name="dias_para_facturar" type="text" id="dias_para_facturar" size="40" value="<?=$rs_per['dias_para_facturar']?>" <?=$sololectura?>/></td>
            </tr>
            
           
            <? 
			if (in_array(303, $_SESSION['permisos'])): ?>     
            <tr>
                <td>PO</td>
                <td><input name="po" type="text" id="po" size="40"  value="<?=$rs_per['po']?>" <?=$sololectura_po?>/></td>
                <td>PO2</td>
                <td><input name="po2" type="text" id="po2" size="40"  value="<?=$rs_per['po2']?>" <?=$sololectura_po2?>/></td>
            </tr>            
            <?php else: ?>  
            	<input name="po" type="hidden"  value="<?=$rs_per['po']?>"/>	
               	<input name="po2" type="hidden"  value="<?=$rs_per['po2']?>"/>
            <?php endif; ?>         
            
            
            
            <? if (in_array(25, $_SESSION['permisos'])): ?>     
            <tr>
                <td>GR</td>
                <td><input name="gr" type="text" id="gr" size="40" value="<?=$rs_per['gr']?>" /></td>
                <td>GR2</td>
                <td><input name="gr2" type="text" id="gr2" size="40" value="<?=$rs_per['gr2']?>" /></td>
            </tr>
            
            <tr>
                <td>#Factura</td>
                <td><input name="factura" type="text" id="factura" size="40" value="<?=$rs_per['factura']?>" /></td>
                <td>#Factura2</td>
                <td><input name="factura2" type="text" id="factura2" size="40" value="<?=$rs_per['factura2']?>" /></td>
            </tr>
            <?php else: ?>            
            	<input name="gr" type="hidden"  value="<?=$rs_per['gr']?>" />
                <input name="g2" type="hidden"  value="<?=$rs_per['g2']?>" />
                 
                <input name="factura" type="hidden"  value="<?=$rs_per['factura']?>" />
                <input name="factura2" type="hidden" value="<?=$rs_per['factura2']?>" />
                
            <?php endif; ?>   
            
            <? if (in_array(302, $_SESSION['permisos'])): ?>              
            <tr>
                <td>Valor Facturado</td>
                <td><input name="valorfactura" class="money" type="text" id="valorfacturado" size="40" value="<?=$rs_per['valor_facturado']?>"/></td>
                <td>Valor Facturado 2</td>
                <td><input name="valorfactura2" class="money" type="text" id="valorfacturado2" size="40" value="<?=$rs_per['valor_facturado2']?>"/></td>
            </tr>
            
            <tr>
            	<td>F. Facturado 1</td>
                <td>
                	<input name="fecha_facturado_1" id="fecha_facturado_1" value="<?=$rs_per['fecha_facturado1'];?>" /> 
                    <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador061" />
					<script type="text/javascript">
                          Calendar.setup({
                              inputField     :    "fecha_facturado_1",      // id del campo de texto
                              ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                              button         :    "lanzador061"   // el id del botón que lanzará el calendario
                          });
                    </script>
                </td>
            	<td>F. Facturado 2</td>
                <td>
                	<input name="fecha_facturado_2" id="fecha_facturado_2" value="<?=$rs_per['fecha_facturado2'];?>" /> 
                    <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador06" />
					<script type="text/javascript">
                          Calendar.setup({
                              inputField     :    "fecha_facturado_2",      // id del campo de texto
                              ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                              button         :    "lanzador06"   // el id del botón que lanzará el calendario
                          });
                    </script>
                </td>
            </tr>            
            <?php else: ?>            
            	<input name="valorfactura" type="hidden"  value="<?=$rs_per['valor_facturado']?>"/>
                <input name="valorfactura2" type="hidden"  value="<?=$rs_per['valor_facturado2']?>"/>
            	
                <input name="fecha_facturado_1" type="hidden"  value="<?=$rs_per['fecha_facturado1'];?>"/>
                <input name="fecha_facturado_2" type="hidden"  value="<?=$rs_per['fecha_facturado2'];?>"/> 
            <?php endif; ?>   
            
            <?php if($_SESSION['perfil'] == 19 || $_SESSION['perfil'] == 5): ?>
            
            <tr>
                <td>PO3</td>
                <td><input name="po3" type="text" id="po3" size="40"  value="<?=$rs_per['po3']?>" <?=$sololectura_po3?>/></td>
                <td>PO4</td>
                <td><input name="po4" type="text" id="po4" size="40"  value="<?=$rs_per['po4']?>" <?=$sololectura_po4?>/></td>
            </tr>            
            
            <tr>
                <td>GR3</td>
                <td><input name="gr3" type="text" id="gr3" size="40" value="<?=$rs_per['gr3']?>" /></td>
                <td>GR4</td>
                <td><input name="gr4" type="text" id="gr4" size="40" value="<?=$rs_per['gr4']?>" /></td>
            </tr>
            
            <tr>
                <td>#Factura3</td>
                <td><input name="factura3" type="text" id="factura3" size="40" value="<?=$rs_per['factura3']?>" /></td>
                <td>#Factura4</td>
                <td><input name="factura4" type="text" id="factura4" size="40" value="<?=$rs_per['factura4']?>" /></td>
            </tr>
            
            <tr>
            	<td>F. Facturado 3</td>
                <td>
                	<input name="fecha_facturado_3" class="datepicker" id="fecha_facturado_3" value="<?=$rs_per['fecha_facturado3'];?>" /> 
                </td>
                <td>F. Facturado 4</td>
                <td>
                	<input name="fecha_facturado_4" class="datepicker" id="fecha_facturado_4" value="<?=$rs_per['fecha_facturado4'];?>" /> 
                </td>
            </tr> 
            
            <tr>
                <td>Valor Facturado 3</td>
                <td><input name="valorfacturado3" class="money" type="text" id="valorfacturado3" size="40" value="<?=$rs_per['valorfacturado3'];?>"/></td>
                <td>Valor Facturado 4</td>
                <td><input name="valorfacturado4" class="money" type="text" id="valorfacturado4" size="40" value="<?=$rs_per['valorfacturado4'];?>"/></td>
            </tr>      
            
            <?php else: ?>            
                <input name="po3" type="hidden"  value="<?=$rs_per['po3']?>"/>
                <input name="po4" type="hidden"  value="<?=$rs_per['po4']?>"/>
                <input name="gr3" type="hidden"  value="<?=$rs_per['gr3']?>" />
                <input name="gr4" type="hidden"  value="<?=$rs_per['gr4']?>" />
                
            	<input name="factura3" type="hidden" value="<?=$rs_per['factura3']?>" />
                <input name="factura4" type="hidden" value="<?=$rs_per['factura4']?>" />			
                <input name="fecha_facturado_3" type="hidden"  value="<?=$rs_per['fecha_facturado3'];?>" /> 
                <input name="fecha_facturado_4" type="hidden"  value="<?=$rs_per['fecha_facturado4'];?>" />  
            
                <input name="valorfacturado3" type="hidden"  value="<?=$rs_per['valorfacturado3'];?>"/>
                <input name="valorfacturado4" type="hidden"  value="<?=$rs_per['valorfacturado4'];?>"/>
                
            <?php endif; ?>   
            
            
            <? if(in_array(310,$_SESSION['permisos'])): ?>
            <tr>
            	<td>Autorizado</td>
            	<td> 
                	<select name="autorizar" class="chosen-select">
               			<option value="0" <?=($rs_per['autorizado']==0)?'selected':''?>>No Revisado</option>
                	 	<option value="1" <?=($rs_per['autorizado']==1)?'selected':''?>>Si</option>
                     	<option value="2" <?=($rs_per['autorizado']==2)?'selected':''?>>No</option>
                    </select>
                </td> 
            </tr>
            <? else: ?>
            	<input type="hidden" name="autorizar" value="<?=$rs_per['autorizado']?>"/>
			<? endif; ?>
         
            <tr>
                 <? 
				 $estadoHIto = array('CANCELADO','CANCELAR','DUPLICADO','ELIMINADO');
				 if(!in_array($rs_per['estado'],$estadoHIto)):
				 
				 	if (in_array(301, $_SESSION['permisos'])): 
				 ?>     
                 <td>Cambiar Estado:</td>
                 <td>
                 	<?
						$sqlfgr = "SELECT DISTINCT (estado) FROM  `hitos` WHERE 1 ORDER BY `estado` DESC";
						$paifgr = mysql_query($sqlfgr);
						$obj = new TaskCurrent;
						
						$omitir = 0;
													
						if($obj->getHitoByAnticipoGirado($rs_per['id']))							
							$omitir = 1;
						
						$array_options = array();
						if($omitir):	
							while($conteofgr = mysql_fetch_assoc($paifgr)):
								if(trim($conteofgr['estado']) != 'ELIMINADO' || trim($conteofgr['estado']) != 'CANCELADO' || trim($conteofgr['estado']) != 'DUPLICADO'):
									array_push($array_options,$conteofgr['estado']);
								endif;
							endwhile;
						else:
							while($conteofgr = mysql_fetch_assoc($paifgr)):
								if(!in_array(trim($conteofgr['estado']),$array_options)):
									array_push($array_options,trim($conteofgr['estado']));
								endif;
							endwhile;
						endif;
					?>
                 	<select name="estadofgr" id="estadofgr" class="chosen-select">
                      	<option value=""></option>
                        <? foreach($array_options as $row): ?>
                        		<option value="<?=$row?>" <?=(trim($rs_per['estado'])==$row)?'selected':''?>><?=$row?></option>
                        <? endforeach; ?>                      
                     </select>  
                 </td>
                 <? endif;  
				 elseif(in_array($rs_per['estado'],$estadoHIto)): 
				 ?>
                 	<td>Estado Actual:</td>
                 	<td>
						<?=$rs_per['estado'];?>
                        <input type="hidden" name="estadofgr" value="<?=$rs_per['estado']?>"/>
                    </td>                    	
				 <? endif;?> 
                 
                 <? if ($_SESSION['perfil'] == 35): ?>     
                 <td>Cambiar Estado Coordinador:</td>
                 <td>
                 	<?php
						$obj = new TaskCurrent;
						$omitir = 0;
													
						if($obj->getHitoByAnticipoGirado($rs_per['id']))							
							$omitir = 1;
							
						if($obj->getRelacionByidhito($rs_per['id']))
							$omitir = 1;
					?>
                    
                 	<select name="estadofgr" id="estadofgr" class="chosen-select">
                      	<option value=""></option>
                        <?php 
							if($omitir == 0):
								if($rs_per['estado'] == 'EN EJECUCION' || $rs_per['estado'] == 'EJECUTADO' || $rs_per['estado'] == 'PENDIENTE'): ?>
                        <option value="CANCELAR">CANCELAR</option>
                        
                        <option value="EN EJECUCION">EN EJECUCION</option>
                        <option value="EJECUTADO">EJECUTADO</option>
                        <option value="INFORME ENVIADO">INFORME ENVIADO</option>
                        
                        <?php 
								endif;
							endif; 
						?>
                      </select>  
                 </td>
                 <? endif; ?> 
            </tr>
            
            <tr>
            	  <td>Creaci&oacute;n:</td>
                  <td colspan="3"><?=$rs_per['fecha_real'];?></td>
            </tr> 
            
            <? if (in_array(21, $_SESSION['permisos'])): ?>      
            
            <tr>
            	<td>F.I. Ejecuci&oacute;n</td>
                <td>  
                	  <input name="fecha_inicio_ejecucion" id="fecha_inicio_ejecucion"  value="<?=(!empty($rs_per['fecha_inicio_ejecucion']))?$rs_per['fecha_inicio_ejecucion']:'0000-00-00';?>" <?=($rs_per['fecha_inicio_ejecucion'] == '0000-00-00' || $rs_per['fecha_inicio_ejecucion'] == '' || $_SESSION['perfil'] == 5)? 'class="datepicker"' : 'readonly'?> /> 
                	
                </td>
          
            	<td>F. Ejecutado</td>
                <td>
                	<input name="fecha_ejecutado" id="fecha_ejecutado" value="<?=$rs_per['fecha_ejecutado'];?>" <?=($rs_per['fecha_ejecutado'] == '0000-00-00' || $_SESSION['perfil'] == 5)?'class="datepicker"' : 'readonly'?>/> 
                    <!--<img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador6" />
					 <script type="text/javascript">
                          Calendar.setup({
                              inputField     :    "fecha_ejecutado",      // id del campo de texto
                              ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                              button         :    "lanzador6"   // el id del botón que lanzará el calendario
                          });
                    </script>-->
                </td>
            </tr>
            <tr>
            	<td>F. Inf. Enviado</td>
                <td>
                	<input name="fecha_informe" id="fecha_informe" value="<?=$rs_per['fecha_informe'];?>" <?=($rs_per['fecha_informe'] == '0000-00-00' || $_SESSION['perfil'] == 5)?'class="datepicker"' : 'readonly'?>/> 
                     <!--<img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador7" />
					<script type="text/javascript">
                          Calendar.setup({
                              inputField     :    "fecha_informe",      // id del campo de texto
                              ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                              button         :    "lanzador7"   // el id del botón que lanzará el calendario
                          });
                    </script>-->
                </td>
         
            	<td>F. Liquidado</td>
                <td>
                	<input name="fecha_liquidacion" id="fecha_liquidacion"  value="<?=$rs_per['fecha_liquidacion'];?>" <?=($rs_per['fecha_liquidacion'] == '0000-00-00' || $_SESSION['perfil'] == 5)?'class="datepicker"' : 'readonly'?>/>
                    <!--<img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador8" />
					<script type="text/javascript">
                          Calendar.setup({
                              inputField     :    "fecha_liquidacion",      // id del campo de texto
                              ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                              button         :    "lanzador8"   // el id del botón que lanzará el calendario
                          });
                    </script> -->
                </td>
            </tr>
            <?php if($_SESSION['perfil'] == 19 || $_SESSION['perfil'] == 5): ?>
            <tr>
            	<td>F. en Facturaci&oacute;n</td>
                <td>
                	<input name="fecha_facturacion" id="fecha_facturacion" value="<?=$rs_per['fecha_facturacion'];?>" <?=($rs_per['fecha_facturacion'] == '0000-00-00' || $_SESSION['perfil'] == 5)?'class="datepicker"' : 'readonly'?>/> 
                    <!--<img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador9" />
					<script type="text/javascript">
                          Calendar.setup({
                              inputField     :    "fecha_facturacion",      // id del campo de texto
                              ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                              button         :    "lanzador9"   // el id del botón que lanzará el calendario
                          });
                    </script>--> 
                </td>
          		
            	<td>F. Facturado</td>
                <td>
                <?php
					$fecha_facturado = $rs_per['fecha_facturado'];
                	/*if(!empty($rs_per['fecha_facturado1']) && $rs_per['fecha_facturado1'] != '0000-00-00')
                        $fecha_facturado = $rs_per['fecha_facturado1'];
                    if(!empty($rs_per['fecha_facturado2']) && $rs_per['fecha_facturado2'] != '0000-00-00')
                        $fecha_facturado = $rs_per['fecha_facturado2'];
                    if(!empty($rs_per['fecha_facturado3']) && $rs_per['fecha_facturado3'] != '0000-00-00')
                        $fecha_facturado = $rs_per['fecha_facturado3'];
                    if(!empty($rs_per['fecha_facturado4']) && $rs_per['fecha_facturado4'] != '0000-00-00')
                        $fecha_facturado = $rs_per['fecha_facturado4'];	*/				
				?>
                	<input name="fecha_facturado" id="fecha_facturado" value="<?=$fecha_facturado;?>" <?=($fecha_facturado == '0000-00-00' || $_SESSION['perfil'] == 5)?'class="datepicker"' : 'readonly'?>/> 
                     <!--<img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador10" />
					<script type="text/javascript">
                          Calendar.setup({
                              inputField     :    "fecha_facturado",      // id del campo de texto
                              ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
							 
                              button         :    "lanzador10"   // el id del botón que lanzará el calendario
                          });
                    </script>--> 
                </td>
            </tr>  
            <?php else: ?>            
                <input type="hidden" name="fecha_facturacion"  value="<?=$rs_per['fecha_facturacion'];?>"/> 
                <input type="hidden" name="fecha_facturado"  value="<?=$fecha_facturado;?>"/> 
                
            <?php endif; ?>         
           
         <?php else: ?>            
                 <input type="hidden" name="fecha_inicio_ejecucion"  value="<?=(!empty($rs_per['fecha_inicio_ejecucion']))?$rs_per['fecha_inicio_ejecucion']:'0000-00-00';?>"/> 
                 <input type="hidden" name="fecha_ejecutado"  value="<?=$rs_per['fecha_ejecutado'];?>"/>
                 <input type="hidden" name="fecha_informe"  value="<?=$rs_per['fecha_informe'];?>"/>
                 <input type="hidden" name="fecha_liquidacion"  value="<?=$rs_per['fecha_liquidacion'];?>"/> 
                 <input type="hidden" name="fecha_liquidacion"  value="<?=$rs_per['fecha_liquidacion'];?>"/>
                 
                 <input type="hidden" name="fecha_facturado"  value="<?=$fecha_facturado;?>"/>   
                
         <?php endif; ?>  
         
         	<tr>
                <td>Observaciones:</td>
                <td colspan="2"><textarea name="observaciones" cols="10" style="width:100%;"><?=$rs_per['observaciones'];?></textarea></td>
            </tr>    
         
          	<tr>
            	<td colspan="2">
                	<ul class="form-errors"></ul>
                </td>
			</tr>
            
        </tbody>
       
    </table>
    
    <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
    
    		<?php
				$canUpdate = true;
				//echo $_SESSION['perfil'].'|'.$rs_per['estado'] ;
				if((int)$_SESSION['perfil']!= 5 && (int)$_SESSION['perfil'] != 19):
					if(trim($rs_per['estado']) == 'LIQUIDADO' || trim($rs_per['estado']) == 'EN FACTURACION' || trim($rs_per['estado']) == 'FACTURADO'):
						$canUpdate = false;
					endif;
				endif;				
				//echo 'estado->'.$canUpdate;
				if($canUpdate):	
			?>
			<input name="modificar" type="submit" id="modificar" value="Modificar" class="btn_table"/>
            <? endif; ?>
            
            <?php
				if(trim($rs_per['estado']) == 'LIQUIDADO' || trim($rs_per['estado']) == 'EN FACTURACION' || trim($rs_per['estado']) == 'FACTURADO'):					
			?>
			<input name="modificar_liquidacion" type="button" id="modificar_liquidacion" value="Modificar Liquidaci&oacute;n" class="btn_table"/>
            <? 	endif; ?>
            
            <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" class="btn_table"/>
    </div>
</form>

<style>
.validClass{ background-color:none;  }
.errorClassInput{ background-color:#FFC1C1;  }
.form-errors li{ text-align:left; color:#FF7575; }
label[class=errorClassInput]{ display:none !important; }
</style>
<?php } ?>
<link rel="stylesheet" href="/js/chosen/chosen.css">
<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		
		$("#frm_per select").chosen({width:"250px"});
		$(".btn_table").jqxButton({ theme: theme });
		
		$('.datepicker').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'    
		});
		
		$('#fecha_liquidacion').change(function(){
			var value = $(this).val();
			
			if(value != '0000-00-00'){
				$('.liquidacionfinal input').val(0);
				$('.liquidacionfinal').show();
			}else{
				$('.liquidacionfinal input').val(0);
				$('.liquidacionfinal').hide();
			}
		});
		
		//Valida que le hito tenga el estado liquidado para pasar a facturado
		<? if((int)$_SESSION['id'] == 71): ?>
		$('#fecha_facturado').change(function(){
			var fechaliq = $('#fecha_liquidacion').val();
			if(fechaliq == '0000-00-00' || fechaliq == ''){				
				swal("Upss", 'Se debe validar con el coordinador para pasar el hito a Facturado.', "error");
				return false;
			}
		});
		<? endif; ?>
		
		<? if($rs_per['fecha_inicio'] != '0000-00-00'): 
			$find = array("-0");
			$replace = array("-");
		?> 
			//Fecha de inicio < a la fecha de ejecucion <?=str_replace($find,$replace,$rs_per['fecha_inicio']);?>
			
			var date = new Date("<?=str_replace($find,$replace,$rs_per['fecha_inicio']);?>");
			var currentMonth = date.getMonth();
			var currentDate = date.getDate();
			var currentYear = date.getFullYear();
			$("#fecha_inicio_ejecucion" ).datepicker( "option", "minDate", new Date(currentYear, currentMonth, currentDate));
		<? endif; ?>
		
		<? if($rs_per['fecha_facturado'] != '0000-00-00'): ?> //Liquidado < Facturado
			var date = new Date("<?=addDay($rs_per['fecha_facturado']);?>");
			var currentMonth = date.getMonth();
			var currentDate = date.getDate();
			var currentYear = date.getFullYear();
			$("#fecha_liquidacion" ).datepicker( "option", "maxDate", new Date(currentYear, currentMonth, currentDate));
		<? endif; ?>
		
		<? if($rs_per['fecha_facturacion'] != '0000-00-00'): ?> //facturacion < Facturado
			var date = new Date("<?=addDay($rs_per['fecha_facturacion']);?>");
			var currentMonth = date.getMonth();
			var currentDate = date.getDate();
			var currentYear = date.getFullYear();
			$("#fecha_facturado" ).datepicker( "option", "maxDate", new Date(currentYear, currentMonth, currentDate));
		<? endif; ?>
		
		<? if($rs_per['fecha_ejecutado'] != '0000-00-00'): ?> //ejecucion < ejecutado
			var date = new Date("<?=addDay($rs_per['fecha_ejecutado']);?>");
			var currentMonth = date.getMonth();
			var currentDate = date.getDate();
			var currentYear = date.getFullYear();
			$("#fecha_inicio_ejecucion" ).datepicker( "option", "maxDate", new Date(currentYear, currentMonth, currentDate));
		<? endif; ?>
		
		//$('input').setMask();
		<? if (in_array(302, $_SESSION['permisos'])): ?>   
		$(".money").maskMoney({ prefix:'$', allowNegative: true, thousands:'', decimal:',', affixesStay: false});
		<? endif; ?>
		
		$("#frm_per").validate({
			ignore: '*:not([name])', // <-- option so that hidden elements are validated
			rules:{
				 proyec: {					
				 	required: true,
				 },
				 nombre:{
					 required: true,
				 }
			},	
			messages: {
				proyec: { required: "Se requiere proyecto" }, 
				nombre: { required: "Se requiere el nombre del hito" },
				departamento: { required: "Se requiere el departamento" },
				sitios: { required: "Se requiere el sitios" },
				fecini: { required: "Se requiere la Fecha de inicio" },
				fecfin: { required: "Se requiere la Fecha Final" },
				descri: { required: "Se requiere la descripci&oacute;n" },
				valor_cotizado_hito: { required: "Se requiere el valor cotizado" }    
			},
			errorClass: "errorClassInput",
			onkeyup: false,
			errorContainer: ".form-errors",	
			errorLabelContainer: ".form-errors ul",	
		    showErrors: function (errorMap, errorList){
				$.each(errorMap, function(index,value){					
					$("div .form-errors").append('<li>'+value+'.</li>');
				});
				this.defaultShowErrors(); 
            }, 
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente modificar hito?')
				if (respuesta)
					form.submit();
			}
		});
		
		
		$('#modificar_liquidacion').click(function(){
			$.ajax({
				url: 'ajax_modificar_liquidacion.php',
				data: { id: <?=(int)$_POST['ide_per']?>, liquidacion_final: $('#liquidacion_final').val() },			
				type: 'post',
				dataType: 'json',
				success: function(data){
					console.log(data) 
					if(!data.estado){				
						swal("Error", data.msj, "error");
					}else{
						fn_cerrar();	
					}
				}
			});
		});
		
	});
	
	function fn_modificar(){
		var str = $("#frm_per").serialize();
		$.ajax({
			url: 'ajax_modificar.php',
			data: str,			
			type: 'post',
			dataType: 'json',
			success: function(data){
				console.log(data) 
				if(!data.estado){				
					swal("Error", data.msj, "error");
				}else{
					fn_cerrar();	
				}
			}
		});
	};
</script>