<?php
class TaskCurrent{
    
	/*@ int $idHito
	* Obtiene la suma cargada al hito en compras */ 
    function getTotalCompraByhito($idHito){
		  $sql3 = "	SELECT SUM( tmp.valor_adjudicado * tmp.cantidade) AS total_compras
					FROM `solicitud_despacho` AS sd
					LEFT JOIN TEMP_MERCANCIAS AS tmp ON tmp.id_despacho = sd.id
					WHERE sd.id_hito = ".$idHito;
		  $pai3 = mysql_query($sql3); 
		  $rs_pai3 = mysql_fetch_assoc($pai3);
		  
		  if($rs_pai3['total_compras'] != null)		  
			  $totalCompra = $rs_pai3['total_compras'];
		  else
		  	  $totalCompra = 0;
		  
		  return $totalCompra;
	}
	
	/*@ int $idHito
	* Obtiene la suma cargada al anticipo 
	* solamente suma lo que esta en estado 1 el idhito en items anticipo
	*valida los anticipo con estado 0(no aprobado) y 1(aprobado)
	*/ 
	function getSumaTotalAnticipoByhito($idHito){
		$sql5 = "SELECT SUM( i.total_hito ) AS total
				 FROM  `items_anticipo` AS i
				 LEFT JOIN anticipo AS a ON a.id = i.id_anticipo 
				 WHERE i.id_hitos =".$idHito." AND i.estado = 1 AND a.estado = 1";
				 
		//se cambio a.estado a i.estado 21/11/2015
		
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		$numrows = mysql_num_rows($pai5);
		
		return ($numrows > 0)?$rs_pai5['total']:0;
	}
	
	
	
	//anticipos no aprobados
	function getSumaTotalAnticipoByhitoNoaprobado($idHito){
		$sql5 = "SELECT SUM( i.total_hito ) AS total
				 FROM  `items_anticipo` AS i
				 LEFT JOIN anticipo AS a ON a.id = i.id_anticipo 
				 WHERE i.id_hitos =".$idHito." AND i.estado = 1 AND a.estado = 0";
		
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		$numrows = mysql_num_rows($pai5);
		
		return ($numrows > 0)?$rs_pai5['total']:0;
	}
	
	
	//obtiene el valor del valor del item del anticipo con impuestos
	function getTotalNetoAnticipoByhito($idHito,$idanticipo){
		$sql5 = "SELECT SUM( i.total_hito ) AS total
				 FROM  `items_anticipo` AS i
				 LEFT JOIN anticipo AS a ON a.id = i.id_anticipo 
				 WHERE i.id_hitos =".$idHito." AND i.estado = 1 AND a.id = ".$idanticipo;
		
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		$numrows = mysql_num_rows($pai5);
		
		return ($numrows > 0)?$rs_pai5['total']:0;
	}
	
	
	/*@ int $idHito
	* Obtiene la suma total del vehiculo asignado a un hito*/ 
	function getCostoVehiculoByhito($idHito){
		$sql5 = "SELECT SUM( a.horas_trabajadas * v.valor_hora ) AS total
				 FROM `asignacion` AS a
				 LEFT JOIN vehiculos AS v ON v.id = a.id_vehiculo
				 WHERE a.id_vehiculo != 0 AND a.id_hito =".$idHito;
		
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		return $rs_pai5['total'];
	}
	
	/*@ int $idHito
	* Obtiene la suma total del vehiculo asignado a un hito*/ 
	function getCostoManobraByhito($idHito){
		$sql5 = "SELECT SUM( a.horas_trabajadas * v.valor_hora ) AS total
				 FROM `asignacion` AS a
				 LEFT JOIN tecnico AS v ON v.id = a.id_tecnico
				 WHERE a.id_tecnico != 0 AND a.id_hito =".$idHito;
		
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		return $rs_pai5['total'];
	}
	
	/*@ int $idHito
	* Obtiene la suma total del reintegro del hito*/ 
	function getTotalReintegroByhito($idHito){
		$totalReintegro = 0;
		
		$sql5 = "SELECT SUM(total_reintegro) AS total_reintegro FROM reintegros WHERE estado = 1 AND id_hito =".$idHito;
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		/*$sql6 = "SELECT SUM(total_reintegro) AS total_reintegro FROM reintegros WHERE estado = 1 AND id_hito =".$idHito;
		$pai6 = mysql_query($sql6);	
		$rs_pai6 = mysql_fetch_assoc($pai6);
		
		$totalReintegro = $rs_pai5['total_reintegro'] + $rs_pai6['total_reintegro'];
		return $totalReintegro;*/
		
		return $rs_pai5['total_reintegro'];
	}
	
	
	function getTotalHito($idHito,$centrocosto,$total_hito){	
	
		
		$totalCompras = $this->getTotalCompraByhito($idHito);
		$totalManobra = $this->getCostoManobraByhito($idHito);
		$totalVehiculos = $this->getCostoVehiculoByhito($idHito);
		$sumaTotalAnticipo = $this->getSumaTotalAnticipoByhito($idHito);
		
		//Reintegro en salida de mercancia
		$reintegro = $this->getTotalReintegroByhito($idHito);
		$reintegro = (!empty($reintegro))?$reintegro:0;
		
		/*if($centrocosto == 4)
			$concepto = 12; 
		else
			$concepto = 13;*/
			
		/*$sqlC = mysql_query("SELECT valor, (SELECT valor_cotizado_hito FROM hitos WHERE id = ".$idHito.") AS valorCotizado FROM prestaciones WHERE id =".$concepto) or die(mysql_error());
		$rowsC = mysql_fetch_assoc($sqlC);*/	
		
		$sqlC = mysql_query("SELECT valor_cotizado_hito, factor FROM hitos WHERE id = ".$idHito) or die(mysql_error());
		$rowsC = mysql_fetch_assoc($sqlC);
		

		
		$totalHitoCargado = ($totalCompras + $totalManobra + $totalVehiculos + $sumaTotalAnticipo + $total_hito) * $rowsC['factor']; 
		
		$valores = '(Costo Compra: $'.$totalCompras.' + Costo Mano Obra: $'.$totalManobra.' + Costo Vehiculos: $'.$totalVehiculos.' + Total Anticipos: $'.$sumaTotalAnticipo.' + Actual Carga: $'.$total_hito.')'.' X Concepto: $'.$rowsC['factor'].' = $'.$totalHitoCargado .' - '.$reintegro;
		
		if($totalHitoCargado > $rowsC['valor_cotizado_hito'])
			return array('estado'=>false,'valores'=>$valores);
		else
			return array('estado'=>true, 'valor'=>$totalHitoCargado.'>'.$rowsC['valor_cotizado_hito']); 
	}
	
	
	function total_anticipo($idAnticipo){
		
			$letters = array('.');
			$fruit   = array('');		
		
			$acpm = 0;
			$valor_transporte = 0;
			$toes = 0;
			$total_acpm = 0;
			$total_transpornte = 0;
			$total_toes = 0;
			$total_anticipo = 0;
		
			$resultado = mysql_query("SELECT * FROM items_anticipo WHERE estado = 1 AND id_anticipo =".$idAnticipo) or die(mysql_error());
		
			$total = mysql_num_rows($resultado);
		
			while ($rows = mysql_fetch_assoc($resultado)):
		
				if($rows['acpm'] != 0):
					$acpm = explode(',00',$rows['acpm']);
					$acpm = str_replace($letters, $fruit, $acpm[0] );
					$total_acpm += $acpm;
				endif;
		
				if($rows['valor_transporte'] != 0):
					$valor_transporte = explode(',00',$rows['valor_transporte']);
					$valor_transporte = str_replace($letters, $fruit, $valor_transporte[0] );
					$total_acpm += $valor_transporte;
				endif;
		
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
		
			return $total_acpm + $total_toes + $total_anticipo + $giro;	
	}
	
	//get totalizar de salida de mercancia
	function getTotalizarBydespacho($iDdespacho){
		
		$result = mysql_query("SELECT SUM((valor_adjudicado * cantidade)) AS totalizador FROM `TEMP_MERCANCIAS` WHERE `id_despacho` = ".$iDdespacho) or die(mysql_error());
		
		$total = mysql_num_rows($result);
		$rows = mysql_fetch_assoc($result);
		
		return $rows['totalizador'];
	}
	
	
	/**
	 * Determina si la hora de referencia queda dentro del rango horario dado
	 *
	 * - Todas las horas son cadenas en formato HH:MM (o HH:MM:SS)
	 * - El rango es cerrado y de tipo 9:00-14:00 o 23:00-6:00
	 * - Compara con la hora actual si no se indica lo contrario
	 */
	function dentro_de_horario($hms_inicio, $hms_fin, $hms_referencia=NULL){ // v2011-06-21
		if( is_null($hms_referencia) ){
			$hms_referencia = date('G:i:s');
		}
	
		list($h, $m, $s) = array_pad(preg_split('/[^\d]+/', $hms_inicio), 3, 0);
		$s_inicio = 3600*$h + 60*$m + $s;
	
		list($h, $m, $s) = array_pad(preg_split('/[^\d]+/', $hms_fin), 3, 0);
		$s_fin = 3600*$h + 60*$m + $s;
	
		list($h, $m, $s) = array_pad(preg_split('/[^\d]+/', $hms_referencia), 3, 0);
		$s_referencia = 3600*$h + 60*$m + $s;
	
		if($s_inicio<=$s_fin){
			return $s_referencia>=$s_inicio && $s_referencia<=$s_fin;
		}else{
			return $s_referencia>=$s_inicio || $s_referencia<=$s_fin;
		}
	}
	
	// Calcular horas trabajadas
	function calcular_horas($hora1,$hora2){ 
	
		$separar[1]=explode(':',$hora1); 
		$separar[2]=explode(':',$hora2); 
	
		$total_minutos[1] = ($separar[1][0]*60)+$separar[1][1]; 
		$total_minutos[2] = ($separar[2][0]*60)+$separar[2][1]; 
		$total_minutos = $total_minutos[1]-$total_minutos[2]; 
		$total_horas = $total_minutos/60;
		return $total_horas;
   } 
   
   //existe cedula tecnico
   function existCedulaByTecnico($cedula){
		
		$result = mysql_query(" SELECT COUNT(*) AS total FROM  `tecnico` WHERE  `cedula` = ".$cedula) or die(mysql_error());
		$rows = mysql_fetch_assoc($result);
		
		if($rows['total'] > 0)
			return true;
		else
			return false;
	}
	
	//exite una OT by hito	41,27,
	function existOTinHito($otcliente,$idhito){
		
		if($idhito != 0):
			$sql = "SELECT ot_cliente FROM `hitos` WHERE ot_cliente = '".$otcliente."' AND id =".$idhito;
			$result = mysql_query($sql) or die(mysql_error());
			$rows = mysql_fetch_assoc($result);	
			$total = mysql_num_rows($result);		
			
			if($total != 1):
				
				$sql2 = "SELECT COUNT(*) AS total FROM `hitos` WHERE ot_cliente != 'PENDIENTE' AND `ot_cliente` = '".$otcliente."'";
				$result = mysql_query($sql2) or die(mysql_error());
				$rows = mysql_fetch_assoc($result);
				
				if($rows['total'] > 0)
					return true;
				else
					return false;
			else:
				return false;
			endif;
		else:
		
			$sql2 = "SELECT COUNT(*) AS total FROM `hitos` WHERE `ot_cliente` = '".$otcliente."'";
			$result = mysql_query($sql2) or die(mysql_error());
			$rows = mysql_fetch_assoc($result);
				
			if($rows['total'] > 0)
				return true;
			else
				return false;
				
		endif;		
	} 
	
	function getValidateEstadoHito($idhito){
	
		$arrayestado = array('COTIZADO','PENDIENTE');
		$sql2 = "SELECT estado
				 FROM `hitos` WHERE id = ".$idhito;
		$result = mysql_query($sql2) or die(mysql_error());
		$rows = mysql_fetch_assoc($result);
		
		if(in_array($rows['estado'],$arrayestado))
			return true;
		else
			return false;
	}
	
	
	//excepciones para los clientes id 36 y 37 con relacion al proyecto
	function omitirOTByClienteProyecto($idproyecto){
		
		if($idproyecto != 0):
		
			$sql = "SELECT id_cliente FROM `proyectos` WHERE id = ".$idproyecto;
			$result = mysql_query($sql) or die(mysql_error());
			$rows = mysql_fetch_assoc($result);	
			
			if($rows['id_cliente'] == 36 || $rows['id_cliente'] == 27 || $rows['id_cliente'] == 41)
				return true;
			else
				return false;
		endif;
	} 
	
	//limpiara los valores enteros
	function clearInt($entero){
		if($entero != '' && $entero != 'N/A'):
			$entero_bak = $entero;
			
			$letters2 = array('.','$',' ');
			$fruit2   = array(',','');	
			$entero = str_replace($letters2, $fruit2, trim($entero));	
						
			$data = explode(',',$entero);			
			
			if(count($data) <= 2):
				$entero = $entero;
			else:
				$entero = '';
				for($i=0; $i < count($data)-1; $i++):
					$entero .= $data[$i];
				endfor;	
				$entero .= ','.array_pop($data);				
			endif;
			
		else:
			$entero = 0;
		endif;
		
		return $entero;
	}
	
	//exite una OT by hito	
	function getHitoByAnticipoGirado($idHito){
		
		$sql5 = "SELECT COUNT(*) AS total
				 FROM `items_anticipo` AS i
				 LEFT JOIN anticipo AS a ON a.id = i.id_anticipo
				 WHERE a.prioridad = 'GIRADO' AND i.id_hitos =".$idHito;
		
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		if($rs_pai5['total'] > 0)
			return true;
		else
			return false;
		
	}
	
	//exite un Carga al hito en asignacion, anticipos o material
	function getRelacionByidhito($idHito){
		
		$sql5 = "SELECT (SELECT COUNT(*) FROM asignacion WHERE id_hito = h.id ) AS total_asignacion,
					(SELECT COUNT(*) FROM items_anticipo WHERE id_hitos = h.id ) AS total_anticipo,
					(SELECT COUNT(*) FROM solicitud_despacho WHERE id_hito = h.id ) AS total_solicitudespacho
				 FROM `hitos` AS h
				 WHERE h.id = ".$idHito;
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		if($rs_pai5['total_asignacion'] != 0 || $rs_pai5['total_anticipo'] != 0 || $rs_pai5['total_solicitudespacho'] != 0)
			return true;
		else
			return false;
		
	}
	
	// obtiene el valor del concepto por el id
	function getValorConceptoFinanciero($idconcepto){
		$sql5 = "SELECT valor 
				 FROM `prestaciones` 
				 WHERE id =".$idconcepto;
		
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		return $rs_pai5['valor'];		
	}
		
	// guarda el evento de un modulo con su id y usuario
	function setLogEvento($modulo,$ref_id,$estado){
		
		session_start();
		$user = $_SESSION['id'];
		
		$sql5 = "INSERT INTO `log_eventos` (modulo,ref_id,estado,usuario_id,fecha_cambio,variables) VALUES ('".$modulo."',".$ref_id.",'".$estado."',".$user.",NOW(),'')"; 
		
		$pai5 = mysql_query($sql5);	
		return $sql5;
		
	}
	
	function setLogEventoHito($modulo,$ref_id,$estado,$dataArray){
		
		session_start();
		$user = $_SESSION['id'];
		
		if($estado == 'Modificado'):
		
				$sqlh = "SELECT * FROM `hitos` WHERE id =".$ref_id;
				$resulth = mysql_query($sqlh);	
				$rowh = mysql_fetch_assoc($resulth);
				
				$save_array = [];
				
				if($rowh['id_proyecto'] != $dataArray['proyec'])
					$save_array['id_proyecto'] = array('new'=>$dataArray['proyec'], 'old'=>$rowh['id_proyecto']);
					
				if($rowh['nombre'] != $dataArray['nombre'])
					$save_array['nombre'] = array('new'=>$dataArray['nombre'], 'old'=>$rowh['nombre']);
					
				if($rowh['fecha_inicio'] != $dataArray['fecini'])
					$save_array['fecha_inicio'] = array('new'=>$dataArray['proyec'], 'old'=>$rowh['id_proyecto']);
					
				if($rowh['fecha_final'] != $dataArray['fecfin'])
					$save_array['fecha_final'] = array('new'=>$dataArray['fecfin'], 'old'=>$rowh['fecha_final']);
				
				if($rowh['descripcion'] != $dataArray['descri'])
					$save_array['descripcion'] = array('new'=>$dataArray['descri'], 'old'=>$rowh['descripcion']);
					
				if($rowh['ot_cliente'] != $dataArray['ot_cliente'])
					$save_array['ot_cliente'] = array('new'=>$dataArray['ot_cliente'], 'old'=>$rowh['ot_cliente']);
					
				if($rowh['estado'] != $dataArray['estado'])
					$save_array['estado'] = array('new'=>$dataArray['estado'], 'old'=>$rowh['estado']);
					
				if($rowh['po'] != $dataArray['po'])
					$save_array['po'] = array('new'=>$dataArray['po'], 'old'=>$rowh['po']);
					
				if($rowh['gr'] != $dataArray['gr'])
					$save_array['gr'] = array('new'=>$dataArray['gr'], 'old'=>$rowh['gr']);
					
				if($rowh['factura'] != $dataArray['factura'])
					$save_array['factura'] = array('new'=>$dataArray['factura'], 'old'=>$rowh['factura']);
					
				if($rowh['po2'] != $dataArray['po2'])
					$save_array['po2'] = array('new'=>$dataArray['po2'], 'old'=>$rowh['po2']);
					
				if($rowh['gr2'] != $dataArray['gr2'])
					$save_array['gr2'] = array('new'=>$dataArray['gr2'], 'old'=>$rowh['gr2']); 
					
				if($rowh['factura2'] != $dataArray['factura2'])
					$save_array['factura2'] = array('new'=>$dataArray['factura2'], 'old'=>$rowh['factura2']);
					
				if($rowh['dias_hito'] != $dataArray['dias_hito'])
					$save_array['dias_hito'] = array('new'=>$dataArray['dias_hito'], 'old'=>$rowh['dias_hito']);
					
				if($rowh['valor_cotizado_hito'] != $dataArray['valor_cotizado_hito'])
					$save_array['valor_cotizado_hito'] = array('new'=>$dataArray['valor_cotizado_hito'], 'old'=>$rowh['valor_cotizado_hito']);
					
				if($rowh['dias_para_facturar'] != $dataArray['dias_para_facturar'])
					$save_array['dias_para_facturar'] = array('new'=>$dataArray['dias_para_facturar'], 'old'=>$rowh['dias_para_facturar']);
					
				if($rowh['valor_facturado'] != $dataArray['valorfactura'])
					$save_array['valor_facturado'] = array('new'=>$dataArray['valorfactura'], 'old'=>$rowh['valor_facturado']);
					
				if($rowh['valor_facturado2'] != $dataArray['valorfactura2'])
					$save_array['valor_facturado2'] = array('new'=>$dataArray['valorfactura2'], 'old'=>$rowh['valor_facturado2']);
					
				if($rowh['fecha_facturado1'] != $dataArray['fecha_facturado_1'])
					$save_array['fecha_facturado1'] = array('new'=>$dataArray['fecha_facturado_1'], 'old'=>$rowh['fecha_facturado1']);
					
				if($rowh['fecha_facturado2'] != $dataArray['fecha_facturado_2'])
					$save_array['fecha_facturado2'] = array('new'=>$dataArray['fecha_facturado2'], 'old'=>$rowh['dias_hito']);
					
				if($rowh['po3'] != $dataArray['po3'])
					$save_array['po3'] = array('new'=>$dataArray['po3'], 'old'=>$rowh['po3']);
					
				if($rowh['gr3'] != $dataArray['gr3'])
					$save_array['gr3'] = array('new'=>$dataArray['gr3'], 'old'=>$rowh['gr3']);
					
				if($rowh['factura3'] != $dataArray['factura3'])
					$save_array['factura3'] = array('new'=>$dataArray['factura3'], 'old'=>$rowh['factura3']);
					
				if($rowh['fecha_facturado3'] != $dataArray['fecha_facturado3'])
					$save_array['fecha_facturado3'] = array('new'=>$dataArray['fecha_facturado3'], 'old'=>$rowh['fecha_facturado3']);
					
				if($rowh['po4'] != $dataArray['po4'])
					$save_array['po4'] = array('new'=>$dataArray['po4'], 'old'=>$rowh['po4']);
					
				if($rowh['gr4'] != $dataArray['gr4'])
					$save_array['gr4'] = array('new'=>$dataArray['gr4'], 'old'=>$rowh['gr4']);
					
				if($rowh['factura4'] != $dataArray['factura4'])
					$save_array['factura4'] = array('new'=>$dataArray['factura4'], 'old'=>$rowh['factura4']);
					
				if($rowh['fecha_facturado4'] != $dataArray['fecha_facturado4'])
					$save_array['fecha_facturado4'] = array('new'=>$dataArray['fecha_facturado4'], 'old'=>$rowh['fecha_facturado4']);
					
				if($rowh['valorfacturado3'] != $dataArray['valorfacturado3'])
					$save_array['valorfacturado3'] = array('new'=>$dataArray['valorfacturado3'], 'old'=>$rowh['valorfacturado3']);
					
				if($rowh['valorfacturado4'] != $dataArray['valorfacturado4'])
					$save_array['valorfacturado4'] = array('new'=>$dataArray['valorfacturado4'], 'old'=>$rowh['valorfacturado4']);
					
				if($rowh['id_ps_state'] != $dataArray['departamento'])
					$save_array['departamento'] = array('new'=>$dataArray['departamento'], 'old'=>$rowh['id_ps_state']);
				
				if($rowh['cant_galones_h'] != $dataArray['cant_galones_h'])
					$save_array['cant_galones_h'] = array('new'=>$dataArray['cant_galones_h'], 'old'=>$rowh['cant_galones_h']);
					
					
				if($rowh['liquidacion_final'] != $dataArray['liquidacion_final'])
					$save_array['liquidacion_final'] = array('new'=>$dataArray['liquidacion_final'], 'old'=>$rowh['liquidacion_final']);
					
			$sql = serialize($save_array);
		
		endif;
		
		$sql5 = "INSERT INTO `log_eventos` (modulo,ref_id,estado,usuario_id,fecha_cambio,variables) VALUES ('".$modulo."',".$ref_id.",'".$estado."',".$user.",NOW(),'".$sql."')"; 
		
		$pai5 = mysql_query($sql5);	
		return $sql5;
		
	}
	
	// verifica si existe la cedula o nit
	function existeCedulaNit($num){
		$sql = "SELECT COUNT(*) AS total
				 FROM `beneficiarios` 
				 WHERE identificacion  =".$num;
		
		$result = mysql_query($sql);	
		$rs_pai = mysql_fetch_assoc($result);
		
		if($rs_pai['total'] > 0)
			return true;
		else
			return false; 
	}
	
	// Obtiene el valor de un reintegro anticipo 
	//@id_reintegro
	function getReintegroByLegalizacion($id_legalizacion){
		$sql = " SELECT total_anticipo 
				 FROM `anticipo` 
				 WHERE publicado NOT IN('draft','ELIMINADO') AND estado != 4 AND prioridad = 'REINTEGRO' AND id_legalizacion = ".$id_legalizacion;
		
		$result = mysql_query($sql);	
		$rs_pai = mysql_fetch_assoc($result);
		
		if(!empty($rs_pai['total_anticipo']))
			return $rs_pai['total_anticipo'];
		else
			return 0; 
	}
	
	
	//El hito sea superior a liquidado
	//@id_reintegro
	function isMayorLiquidadoByHito($idhito){
		$sql = " SELECT COUNT(*) AS total 
				 FROM `hitos` 
				 WHERE estado IN ('PENDIENTE','EN EJECUCIÓN','EJECUTADO') AND id = ".$idhito;
		
		$result = mysql_query($sql);	
		$rs_pai = mysql_fetch_assoc($result);
		
		if($rs_pai['total'] > 0)
			return false;
		else
			return true; 
	}
	
	//con el id del user verificar si puede eliminar o no
	function isActionDelModulo($refid,$modulo){
		
		session_start();
		$user = $_SESSION['id'];
		
		$sql = " SELECT COUNT(*) AS total 
				 FROM `temp_delete` 
				 WHERE modulo = '".$modulo."' AND ref_id = ".$refid." AND user_id = ".$user;
		
		$result = mysql_query($sql);	
		$rs_pai = mysql_fetch_assoc($result);
		
		if($rs_pai['total'] > 0)
			return true;
		else
			return false; 
	}
	
	function setTempDelModulo($refid,$modulo){
		
		session_start();
		$user = $_SESSION['id']; 
		
		$sql5 = "INSERT INTO `temp_delete` (modulo,ref_id,user_id) VALUES ('".$modulo."',".$refid.",".$user.")"; 
		if(!mysql_query($sql5))
			return true;
		else
			return false;
		
	}
	
	function setPitagoraHito($accion = 'N/A',$idhito = 0,$monto_hito = 0,$idanticipo = 0){
		
		session_start();
		$user = $_SESSION['id']; 
		
		$sql5 = "INSERT INTO `pitagora_hitos` (id_usuario,id_hito,id_anticipo,monto,accion,fecha_estado) VALUES (".$user.",".$idhito.",".$idanticipo.",".$monto_hito.",'".$accion."',NOW())"; 
		if(!mysql_query($sql5))
			return true;
		else
			return false;
	}
	
	function isPitagoraHito($idhito){
	
		$sql = "SELECT COUNT(*) AS total
				FROM `pitagora_hitos` 
				WHERE id_hito  =".$idhito;
			
		$result = mysql_query($sql);	
		$rs_pai = mysql_fetch_assoc($result);
		
		if($rs_pai['total'] > 0)
			return true;
		else
			return false; 
	}
	
	
	// obtiene el valor de adicion cotizado 
	function getAdicionCotizado($iddepartamento,$idhito){
		
		$sqlh = "SELECT AVG(valor_galon) AS valorgalon, SUM(cant_galones) AS cant_galones
				FROM `items_anticipo` 
				WHERE cant_galones > 0 AND id_hitos = ".$idhito;
		$resulth = mysql_query($sqlh);	
		$rs_paih = mysql_fetch_assoc($resulth);
		
		//echo '<pre>';
		if($rs_paih['cant_galones'] != 0):			
			
			$promedioGalon = explode('.',$rs_paih['valorgalon']); 
			$promedioGalon = (int)$promedioGalon[0];	
		
			$sql = "SELECT valor_acpm
					FROM `valor_acpm` 
					WHERE id_ps_state = ".$iddepartamento." ORDER BY fecha DESC LIMIT 1";
			$result = mysql_query($sql);	
			$rs_pai = mysql_fetch_assoc($result);
			
			$valorBase = (int)$rs_pai['valor_acpm'];
			
			if(!empty($valorBase)):// si no tiene agregado el valor de ACPM por region 
				//print_r($rs_paih);
				//echo $valorBase.'x'.$this->getValorConceptoFinanciero(18).'<br>';
				$valorFinanciero = $valorBase * $this->getValorConceptoFinanciero(18);
				//echo '<br>';
				$valorTotal1 = $valorBase + $valorFinanciero;
				/*echo '<br>';
				echo '<br>';
				
				echo (int)$rs_paih['valorgalon'].'-'.$valorTotal1;
				echo '<br>';*/
				$valor1 = (int)$rs_paih['valorgalon'] - $valorTotal1;  
				//echo '<br>';
				$valorFinanciero2 = abs($valor1) * $this->getValorConceptoFinanciero(16);
				//echo '<br>';
				 return $Total = $rs_paih['cant_galones'] * $valorFinanciero2;
			else:
				return 0;
			endif;
		else:
			return 0;
		endif;	
	}
	
	// ingresa un relacion entre items anticipo y inventario acpm
	function setOutInvACPM($id_items_anticipo,$id_inventario_acpm,$cant_salida_gal){
		
		session_start();
		$user = $_SESSION['id']; 
		
		$sql5 = "INSERT INTO `salida_inventario_acpm` (id_items_anticipo,id_inventario_acpm,estado,fecha,usuario,cant_salida_gal) VALUES (".$id_items_anticipo.",".$id_inventario_acpm.",0,NOW(),".$user.",".$cant_salida_gal.")"; 
		if(!mysql_query($sql5))
			return true;
		else
			return false;
	}
	
	
	//verificar si el item anticipo es de invetario ACPM
	function setItemInvACPM($refid){	
	
		$resultado = mysql_query("SELECT * FROM items_anticipo WHERE estado = 1 AND id_anticipo = ".$_POST['id_anticipo']) or die(mysql_error());
		$total = mysql_num_rows($resultado);	
		
		$sql = " SELECT sia.*, COUNT(*) AS total, ic.cant_galones, ic.salida_acpm,
				 (SELECT cant_galones FROM items_anticipo WHERE id = ".$refid.") AS cantGalones
				 FROM `salida_inventario_acpm` AS sia
				 LEFT JOIN inventario_acpm AS ic ON sia.id_inventario_acpm = ic.id
				 WHERE sia.estado = 0 AND sia.id_items_anticipo = ".$refid;
		
		$result = mysql_query($sql);	
		$rs_pai = mysql_fetch_assoc($result);
		
		if($rs_pai['total'] > 0):
			// 1. cargar de nuevo el inventario de ACPM
			$total_galones = $rs_pai['cant_galones'] + $rs_pai['cant_salida_gal'];
			$salida_galones = $rs_pai['salida_acpm'] - $rs_pai['cantGalones'];
			
			$sql3 = sprintf("UPDATE `inventario_acpm` SET salida_acpm = %d WHERE id = %d",
				fn_filtro(0),
				fn_filtro($rs_pai['id_inventario_acpm'])	
			);
			if(!mysql_query($sql3)):
				echo "Error al acutalizar el acpm:\n$sql";
				exit;
			else:
				/*$cantidadInv = $rs_pai['cant_salida_gal'] + $rs_pai['cantidad_inventario'];
			
				/*$sql = sprintf("UPDATE inventario SET cantidad=%d WHERE id = 1539",
					fn_filtro($cantidadInv)
				);
				mysql_query($sql);*/
				
				$sql = sprintf("UPDATE salida_inventario_acpm SET estado = 1 WHERE id_items_anticipo = %d",
					fn_filtro($refid)
				);
				mysql_query($sql);
			endif;
		endif;
	}
	
	//obtener el factor financiero por el proyecto
	function getFactorByProyecto($idproyecto){
		
		$sql = "SELECT id_centroscostos FROM proyectos WHERE id = ".$idproyecto;
		$result = mysql_query($sql);	
		$rs_pai = mysql_fetch_assoc($result);		
		
		if((int)$rs_pai['id_centroscostos'] == 4 || (int)$rs_pai['id_centroscostos'] == 9):	
			return $valor_concepto = $this->getValorConceptoFinanciero(12);
		else:
			return $valor_concepto = $this->getValorConceptoFinanciero(13);
		endif;
	}
	
	//obtener el factor financiero por el proyecto
	function getCentroCostoByProyecto($idproyecto){
		
		$sql = " SELECT id_centroscostos FROM proyectos WHERE id = ".$idproyecto;
		$result = mysql_query($sql);	
		$rs_pai = mysql_fetch_assoc($result);
		
		return $rs_pai['id_centroscostos']; 
	}
	
	//obtener el total de galones reintegrados por anticipo
	function getTotalGalReintByHito($idhito){
		
		$sql = " SELECT SUM(cant_galones + salida_acpm) AS total_galones FROM inventario_acpm WHERE id_hito = ".$idhito;
		$result = mysql_query($sql);	
		$rs_pai = mysql_fetch_assoc($result);
		
		if(empty($rs_pai['total_galones'])):	
			return 0;
		else:
			return (int)$rs_pai['total_galones'];
		endif;
		
	}
	
	
	//obtiene el id de la ciudad con el nombre del propio
	function getIdCiudad($name){
	
		$sql = " SELECT id FROM ps_state WHERE name LIKE '".$name."'";
		$result = mysql_query($sql);	
		$rs_pai = mysql_fetch_assoc($result);
		
		if(empty($rs_pai['id'])):	
			return false;
		else:
			return (int)$rs_pai['id'];
		endif;
	}
	
	//obtiene el promedio de precio de galon y la cantidad disponible
	function getPromedioTotalGal(){
	
		$query = "SELECT id,cant_galones,costo_unitario
			  	  FROM inventario_acpm			
			  	  WHERE estado = 0 ORDER BY id DESC";
		$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
		
		$totalGalA = 0;
		$totalGalR = 0;
		$ponderado = 0;
		$ponderado_neg = 0;
		$veces = 0;
		$promedioGal = 0;
		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):
		
			$totalGalA += $row['cant_galones'];	
			$ponderado += $row['cant_galones'] * $row['costo_unitario'];
			
			$promedioGal += (int)$row['costo_unitario']; 
			$veces++;
			
			$sql3 = "SELECT ia.*, sia.fecha AS fecha_salida
					 FROM salida_inventario_acpm AS sia
					 LEFT JOIN items_anticipo AS ia ON ia.id = sia.id_items_anticipo
					 WHERE sia.estado = 0 AND sia.id_inventario_acpm = ".$row['id'];
			$per3 = mysql_query($sql3);			
			
			while($rs_per3 = mysql_fetch_assoc($per3)):	
			
				$sql4 = "SELECT *
						 FROM anticipo
						 WHERE publicado != 'draft' AND id = ".$rs_per3['id_anticipo'];
				$per4 = mysql_query($sql4);
				$rs_per4 = mysql_fetch_assoc($per4);
				
				
				if( mysql_num_rows($per4) > 0 ):	
				
					$totalGalR += $rs_per3['cant_galones'];
					$promedioGal += (int)$rs_per3['valor_galon']; 
					$veces++;
					$ponderado_neg -= ($rs_per3['cant_galones'] * $rs_per3['valor_galon']);
				endif;
			endwhile;
			
		endwhile;		
		
		if($totalGalA > 0)
			return array('total_gal'=>$totalGalA-$totalGalR,'ponderado'=>($ponderado + $ponderado_neg)/($totalGalA-$totalGalR));
		else
			return array('total_gal'=>0,'ponderado'=>0);
		
	}
	
	
	function getPromedioTotalGalByID($id){
	
		$query = "SELECT id,cant_galones,costo_unitario
			  	  FROM inventario_acpm			
			  	  WHERE estado = 0 AND id = ".$id;
		$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
		
		$totalGalA = 0;
		$totalGalR = 0;
		$ponderado = 0;
		$veces = 1;
		$promedioGal = 0;
		
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		
		$totalGalA += $row['cant_galones'];	
		$ponderado += $row['cant_galones'] * $row['costo_unitario'];
		$promedioGal += $row['costo_unitario'];
		
		$sql3 = "SELECT ia.*, sia.fecha AS fecha_salida
				 FROM salida_inventario_acpm AS sia
				 LEFT JOIN items_anticipo AS ia ON ia.id = sia.id_items_anticipo
				 WHERE sia.estado = 0 AND sia.id_inventario_acpm = ".$row['id'];
		$per3 = mysql_query($sql3);			
		
		while($rs_per3 = mysql_fetch_assoc($per3)):	
		
			
			$sql4 = "SELECT *
					 FROM anticipo
					 WHERE publicado != 'draft' AND id = ".$rs_per3['id_anticipo'];
			$per4 = mysql_query($sql4);
			$rs_per4 = mysql_fetch_assoc($per4);
			
			if( mysql_num_rows($per4) > 0 ):			
				$totalGalR += $rs_per3['cant_galones'];
				$promedioGal += $rs_per3['valor_galon']; 
				$veces++;
			endif;
		endwhile;
			
		
		if($totalGalA > 0 && ($totalGalA-$totalGalR) > 0)
			return array('total_gal'=>$totalGalA-$totalGalR,'ponderado'=>$ponderado/($totalGalA-$totalGalR));
		else
			return array('total_gal'=>0,'ponderado'=>0);
		
	}
	
	
	/*Obtiene la sumatoria de valor factura 1,2,3 y 4*/
	function getValorFacturasByhito($idHito){
		
		$sql5 = "SELECT valor_facturado, valor_facturado2, valorfacturado3, valorfacturado4 
				 FROM  `hitos` WHERE id =".$idHito;
		
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		$suma = (float)$rs_pai5['valor_facturado'] + (float)$rs_pai5['valor_facturado2'] + (float)$rs_pai5['valorfacturado3'] + (float)$rs_pai5['valorfacturado4'];
		
		if($suma > 0)		
			return $suma;
		else
			return 0;
	}
	
	
	/*agrega el registro de cambio de estado*/
	function setCronHito($idHito,$estado_cambiar){
		
		$sql5 = "SELECT estado FROM `hitos` WHERE id =".$idHito;
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		
		$date = date('Y-m-d');
		
		$sql6 = "SELECT COUNT(*) AS total FROM `cron_hitos` 
				 WHERE `id_hito` = ".$idHito." 
				 AND `fecha` LIKE '%".$date."%'";
		$pai6 = mysql_query($sql6);	
		$rs_pai6 = mysql_fetch_assoc($pai6);
		
		if($rs_pai6['total'] == 0):
		
			session_start();
			$user = $_SESSION['id']; 
			
			$sql5 = "INSERT INTO `cron_hitos` (	estado,
												id_hito,
												id_usuario,
												fecha,
												estado_hito_last,
												estado_hito_new) 
					 VALUES (0,
							".$idHito.",
							".$user.",
							NOW(),
							'".$rs_pai5['estado']."',
							'".$estado_cambiar."')"; 
							
			if(!mysql_query($sql5))	
				return false;
			else
				return true;
		else:
			return false;
		endif;
	}
	
	
	//Obtiene la suma total de el hito by id hito
	function total_hito_imp($idHito){
		
			$resultado = mysql_query("SELECT SUM(total_hito) AS total FROM items_anticipo WHERE estado IN(1,2) AND id_hitos = ".$idHito) or die(mysql_error());
		
			$rows = mysql_fetch_assoc($resultado);
			return $rows['total'];	
	}
	
	/*
	* Valida si id hito esta en la orden de servicio
	* @idhito INT
	* @idOS INT
	*/
	function getValidateHitoByOrdenservicio($idHito,$idOS){ 
	
		$sql5 = "SELECT COUNT(*) AS total FROM `items_ordenservicio` WHERE estado IN(2) AND id_ordenservicio =".$idOS." AND id_hitos = ".$idHito;
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		if($rs_pai5['total'] == 0):
			return false; //no existe
		else:
			return true; //si existe
		endif;
	}
	
	function getEstadoOS($estado){
	
		$cadena = '';
	
		switch($estado):
			case 0:
				$cadena = 'NO REVISADO';
			break;
			case 1:
				$cadena = 'APROBADO';
			break;
			case 2:
				$cadena = 'ANULADO';
			break;
		endswitch;
		
		return $cadena;
	}
	
	function validarOSbyAnticipos($idos){
		
		$sql5 = "SELECT COUNT( * ) AS TOTAL
				 FROM `items_anticipo` AS ia
				 LEFT JOIN anticipo AS a ON a.id = ia.id_anticipo
				 WHERE (a.estado = 1 OR a.prioridad = 'GIRADO') AND ia.estado = 1 AND ia.orden_servicio_id =".$idos;
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		if($rs_pai5['TOTAL'] == 0):
			return true; //no tiene ningun anticipo aprobado
		else:
			return false; //si tiene ningun anticipo aprobado
		endif;
		
	}
	
	function isHitoaprobadoOS($idhito){ 
	
		$sql5 = "SELECT COUNT(*) AS TOTAL
				 FROM `items_ordenservicio` AS ios
				 LEFT JOIN orden_servicio AS os ON os.id = ios.id_ordenservicio
				 WHERE os.aprobado = 1 AND ios.id_hitos =".$idhito;
				 
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		if($rs_pai5['TOTAL'] == 0):
			return false; //no esta aprobado el hito en la OS
		else:
			return true; //si esta aprobado el hito en la OS
		endif;
	}
	
	function getValidateValorByOrdenservicio($idos,$idhito,$valor){
		
		$sql5 = "SELECT total
				 FROM `items_ordenservicio` 
				 WHERE estado IN(0,2) AND id_hitos = ".$idhito." AND id_ordenservicio = ".$idos;				 
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		
		//obtener las id de los anticipos con relacion a la OS
		$cadena_ids = '';
		$sql6 = "SELECT id
				 FROM anticipo 
				 WHERE estado != 4 AND orden_servicio_id = ".$idos;				 
		$pai6 = mysql_query($sql6);	
		$numfilas = mysql_num_rows($pai6);
		
		while($rowAnti = mysql_fetch_assoc($pai6)):
			$cadena_ids = $rowAnti['id'].',';	
		endwhile;
		
		if($numfilas>0):
			$cadena_ids = substr($cadena_ids,0,-1);
			$sql7 = "SELECT SUM(total_hito) AS totalHitoAnticipo
					 FROM items_anticipo 
					 WHERE estado IN(1,2) AND id_hitos = ".$idhito." AND id_anticipo IN(".$cadena_ids.")";	
			$pai7 = mysql_query($sql7);	
			$rowItemA = mysql_fetch_assoc($pai7);
		else:
			$rowItemA['totalHitoAnticipo'] = 0;	
		endif;
	
	
		$total_anticipo = $rowItemA['totalHitoAnticipo'] + $valor;
		
		//$total_anticipo.'>'.$rs_pai5['total'];
		
		if( $total_anticipo > $rs_pai5['total']):
			return array('estado'=>true,'valor_os'=>'$'.number_format($rs_pai5['total']),'valor_hito'=>'$'.number_format($rowItemA['totalHitoAnticipo']));
		else:
			return array('estado'=>false);
		endif;
	}
	
	//Obtiene los valores con impuestos para un solo item
	/* estructura del array
		array (
		  'valor_neto' => INT,
		  'tipoimp' => 
		  	array (
				0 => 'iva',
		  	),
		  'iva' => INT',
		  'ica' => INT,
		  'rtefuente' => INT,
		  'total' => 'INT',
		  'valor_ica' => INT,
		  'valor_rte' => INT
		)
	*/
	public function getImpuestoByAnticipoItem($id){
	
		$sql5 = "SELECT impuestos_acpm, impuestos_viaticos, impuestos_transporte, impuestos_toes, impuestos_mular
				 FROM items_anticipo
				 WHERE id = ".$id;				 
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		$acpm = unserialize($rs_pai5['impuestos_acpm']);
		$viaticos = unserialize($rs_pai5['impuestos_viaticos']);
		$transporte = unserialize($rs_pai5['impuestos_transporte']);
		$toes = unserialize($rs_pai5['impuestos_toes']);
		$mular = unserialize($rs_pai5['impuestos_mular']);
		
		
		if(is_array($acpm)):
			$acpm['valor_ica'] = $this->calcularICA($acpm['valor_neto'],$acpm['ica']);
			$acpm['valor_rte'] = $this->calcularRTEFUENTE($acpm['valor_neto'],$acpm['rtefuente']);
		endif;
				
		if(is_array($viaticos)):
			$viaticos['valor_ica'] = $this->calcularICA($viaticos['valor_neto'],$viaticos['ica']);
			$viaticos['valor_rte'] = $this->calcularRTEFUENTE($viaticos['valor_neto'],$viaticos['rtefuente']);
		endif;
		
		if(is_array($transporte)):
			$transporte['valor_ica'] = $this->calcularICA($transporte['valor_neto'],$transporte['ica']);
			$transporte['valor_rte'] = $this->calcularRTEFUENTE($transporte['valor_neto'],$transporte['rtefuente']);
		endif;
		
		if(is_array($toes)):
			$toes['valor_ica'] = $this->calcularICA($toes['valor_neto'],$toes['ica']);
			$toes['valor_rte'] = $this->calcularRTEFUENTE($toes['valor_neto'],$toes['rtefuente']);
		endif;
		
		if(is_array($mular)):
			$mular['valor_ica'] = $this->calcularICA($mular['valor_neto'],$mular['ica']);
			$mular['valor_rte'] = $this->calcularRTEFUENTE($mular['valor_neto'],$mular['rtefuente']);
		endif;
		
		
		$array_valores = array(
			'acpm' => $acpm,
			'viaticos' => $viaticos,
			'transporte' => $transporte,
			'toes' => $toes,
			'mular' => $mular
		);
		
		return $array_valores;
	}
	
	//Obtiene la suma total de items por anticipo con impuesto
	public function getSumaTotalItemsByAnticipo($idanticipo){
		$sql5 = "SELECT SUM( total_hito ) AS total
				 FROM `items_anticipo` AS i
				 WHERE id_anticipo =".$idanticipo." AND estado IN(1,2)";				 
		
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		$numrows = mysql_num_rows($pai5);
		
		return ($numrows > 0)?$rs_pai5['total']:0;
	}
	
	
	//obtiene el id del item anticipo
	// @id anticipo
	// @id hito
	public function getIDItemAnticipo($idanticipo, $idhito){
		$sql = "SELECT id FROM `items_anticipo` WHERE id_anticipo = ".$idanticipo." AND id_hitos =".$idhito. " LIMIT 1";
		$pai = mysql_query($sql);	
		$rs = mysql_fetch_assoc($pai);
		
		return $rs['id'];
	}
	
	//obtiene la suma total de las ordenes de servicio
	/*
		0 -> creado
		1 -> eliminado
		2 -> aprobado
	*/
	public function getTotalSumItemsOS($idOS){ 
	
		$sql5 = "SELECT SUM(total) AS total FROM `items_ordenservicio` WHERE estado IN(0,2) AND id_ordenservicio =".$idOS;
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		return $rs_pai5['total'];
	}
	
	/* valida si el hito ha sido cargado en otra OS */
	public function getValidateItemOSByHito($idhito,$idOS){ 
	
		$sql5 = "SELECT COUNT(*) AS total 
				 FROM `items_ordenservicio` 
				 WHERE estado IN(0,1) AND id_hitos = ".$idhito." AND id_ordenservicio != ".$idOS;
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		return ($rs_pai5['total'] > 0)?true:false;
	}
	
	
	/* obtiene las id os relacionadas con el hito */
	function getIdOSByHito($idhito,$idOS){
		$sql5 = "SELECT DISTINCT(id_ordenservicio)
				 FROM `items_ordenservicio` 
				 WHERE estado IN(0,2) AND id_hitos = ".$idhito." AND id_ordenservicio != ".$idOS;
		$pai5 = mysql_query($sql5);	
		
		$idos = '';
		while($rs_pai5 = mysql_fetch_assoc($pai5)):
			$idos .= $rs_pai5['id_ordenservicio'].',';
		endwhile;
		
		return $idos;
	}
	
	
	
	//Validacion de excepcion de OT
	/*
		JR - Regional ID 21 
		10 - Cliente ID 10
		01 - Línea Negocio ID 9
		00 – Actividad ID 9
	*/
	function getValidateExcepcionOS($idOT){ 
	
		$arrayExecp = array(
			'211099' //OT-JR-10-0100
		);
	
		$sql5 = "SELECT id_regional, id_cliente, linea_negocio_id, actividad_id
				 FROM `proyectos`
				 WHERE `id` = ".(int)$idOT;
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		$cadena = $rs_pai5['id_regional'].$rs_pai5['id_cliente'].$rs_pai5['linea_negocio_id'].$rs_pai5['actividad_id'];
		
		if(in_array($cadena,$arrayExecp))
			return true;
		else
			return false;
	}
	
	//Verificar si el hito esta abierto o no 
	//INT @idhito
	// 1->abierto
	// 0->cerrado
	function ValidateHitoIlimitado($idhito){	
	
		$sql5 = "SELECT ilimitado FROM hitos WHERE id = ".(int)$idhito;
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		if($rs_pai5['ilimitado'] == 1)
			return true;
		else
			return false;
	}
	
	//Obtiene el valor acumulado de un contratista 
	//STRING @identificacion 
	function getTotalAcumuladoOSByIdent($identificacion){	
	
		$sql5 = "SELECT impuesto_os
				 FROM orden_servicio WHERE estado IN('publish') AND aprobado != 2 AND cedula_contratista = '".$identificacion."'";
		$pai5 = mysql_query($sql5);	
		
		$total_acumulado = 0;
		while($rs_pai5 = mysql_fetch_assoc($pai5)):
			$imp = unserialize($rs_pai5['impuesto_os']);
			$total_acumulado += $imp[0]['valor_neto_total'];
		endwhile;
		
		return $total_acumulado;
	}
	
	//valida si un anticipo 
	//INT @idos 
	function getValidateAnticiposByOS($idos){	
	
		$sql5 = "SELECT COUNT(*) AS total
				 FROM anticipo 
				 WHERE publicado NOT IN('draft','ELIMINADO') AND estado != 4 AND orden_servicio_id = ".$idos;
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		if($rs_pai5['total'] > 0)
			return true;
		else
			return false;
	}
	
	
	//valida si un beneficiarios tiene os cargadas
	//STRING @cedula contratista
	function validateBeneficarioByOS($cedula){
		$sql5 = "SELECT COUNT(*) AS total
				 FROM orden_servicio 
				 WHERE estado NOT IN('draft','ELIMINADO') AND cedula_contratista = '".$cedula."'";
		$pai5 = mysql_query($sql5);	
		$rs_pai5 = mysql_fetch_assoc($pai5);
		
		if($rs_pai5['total'] > 0)
			return true;
		else
			return false;
	}
	
	//cambio de transferencia de hito
	public function updateTrasnferenciaHito($iditem,$idhito){

		$sql = sprintf("UPDATE `items_anticipo` SET `id_hitos` = %d WHERE id = %d",
			(int)$idhito,
			(int)$iditem
		);
		
		if(!mysql_query($sql))
			return false;
		else
			return true;
	}
	
	//Los items de legalizacion pasa a eliminados por el id del anticipo y el idhito
	public function deleteItemsLegalizacionByAnticipo($idAnticipo,$idhito){
		
		/* Eliminar los items de legalizacion
		/* Eliminado -> 1
		/* No eliminado -> 0 */
		$sql5 = "SELECT id AS id_legalizacion
				 FROM `legalizacion` 
				 WHERE id_anticipo = ".$idAnticipo;				 
		$pai5 = mysql_query($sql5);	
		$rs_lega = mysql_fetch_assoc($pai5);	
		
		$idLegalizacion = (int)$rs_lega['id_legalizacion'];
		
		$sql = sprintf("UPDATE `items` SET  `estado` = '1' WHERE id_legalizacion = %d AND id_hito = %d",
			$idLegalizacion,
			(int)$idhito
		);
	
		if(!mysql_query($sql))
			return false;
		else
			return true;
	}
	
	//Elimina los items del anticipo por su idhito
	public function deleteItemsAnticipoByHito($idanticipo,$idhito){
		
		//Eliminar el item en items anticipo
		$sql = sprintf("UPDATE `items_anticipo` SET `estado` = 0 WHERE id_anticipo = %d AND id_hitos = %d",
			(int)$idanticipo,
			(int)$idhito
		);
	
		if(!mysql_query($sql))
			return false;
		else
			return true;	
	}
	
	
	//obtiene emails usuario de una regional
	public function getEmailsUsuarioByRegional($idRegional){
		$sql5 = "SELECT email, id_regional
				 FROM `usuario` 
				 WHERE estado != 1 AND id_regional LIKE '%".$idRegional."%'";				 
		$pai5 = mysql_query($sql5);	
		
		$emails = [];
		while($row = mysql_fetch_assoc($pai5)):
			$regional = explode(',',$row['id_regional']);
			if(in_array($idRegional,$regional)):
				$emails .= $row['email'].',';
			endif;
		endwhile;
		
		$emails = substr($emails,0,-1);
		
		return $emails;	
	}
	
	
	
	//calculos de IMP
	function calcularICA($neto,$icavalue){
		if(!empty($icavalue)):
			$ica = ($neto * $icavalue)/1000;
			return round($ica);
		else:
			return 0;
		endif;
	}
	
	function calcularRTEFUENTE($neto,$rtevalue){
		if(!empty($rtevalue)):
			$rte = ($neto * $rtevalue)/100;
			return round($rte);
		else:
			return 0;
		endif;
	}
	


}

?>