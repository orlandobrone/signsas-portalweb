<?php

	header('Content-type: text/html; charset=iso-8859-1');

	if(empty($_GET['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}

	include "../extras/php/basico.php";
	include "../../conexion.php";	

	$sql = sprintf("select * from anticipo where id=%d",

		(int)$_GET['ide_per']

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
	
	$total_iva = 0;
	$total_ica = 0;
	$total_rte = 0;
	
	$obj = new TaskCurrent;	

	$resultado = mysql_query("SELECT id,total_hito 
							  FROM items_anticipo 
							  WHERE estado = 1 AND id_anticipo =".$_GET['ide_per']) or die(mysql_error());

	$total = mysql_num_rows($resultado);


	while ($rows = mysql_fetch_assoc($resultado)):

		$total_anticipo += $rows['total_hito'];
		
		$valueImp = $obj->getImpuestoByAnticipoItem($rows['id']);
		
		$total_iva += (is_array($valueImp['acpm']))?$valueImp['acpm']['iva']:0;
		$total_ica += (is_array($valueImp['acpm']))?$valueImp['acpm']['valor_ica']:0;
		$total_rte += (is_array($valueImp['acpm']))?$valueImp['acpm']['valor_rte']:0;
		
		$total_iva += (is_array($valueImp['transporte']))?$valueImp['transporte']['iva']:0;
		$total_ica += (is_array($valueImp['transporte']))?$valueImp['transporte']['valor_ica']:0;
		$total_rte += (is_array($valueImp['transporte']))?$valueImp['transporte']['valor_rte']:0;
		
		$total_iva += (is_array($valueImp['toes']))?$valueImp['toes']['iva']:0;
		$total_ica += (is_array($valueImp['toes']))?$valueImp['toes']['valor_ica']:0;
		$total_rte += (is_array($valueImp['toes']))?$valueImp['toes']['valor_rte']:0;
		
		$total_iva += (is_array($valueImp['viaticos']))?$valueImp['viaticos']['iva']:0;
		$total_ica += (is_array($valueImp['viaticos']))?$valueImp['viaticos']['valor_ica']:0;
		$total_rte += (is_array($valueImp['viaticos']))?$valueImp['viaticos']['valor_rte']:0;
		
		$total_iva += (is_array($valueImp['mular']))?$valueImp['mular']['iva']:0;
		$total_ica += (is_array($valueImp['mular']))?$valueImp['mular']['valor_ica']:0;
		$total_rte += (is_array($valueImp['mular']))?$valueImp['mular']['valor_rte']:0;

	endwhile;


	$giro = 0;
	if($rs_per['giro'] != 0){
		$giro = explode(',00',$rs_per['giro']);
		$giro = str_replace($letters, $fruit, $giro[0] );
	}
	
	$total_anticipo = '$'.number_format($total_anticipo).',00';
	
$mensaje = '<img src="http://operacionsign.com/logo_sign.png"  style="float:left;"/>

	<h2 style="float:left; margin-left:20px;line-height: 43px;">&nbsp;FORMATO DE SOLICITUD DE ANTICIPO</h2> 
	
	<div style="clear:both"></div>
	
	<br />

	<table>
        	 <tr>
			 	<td width="20%" style="font-weight:bold;">ID:</td>
                <td width="20%" style="font-weight:bold;">'.(int)$_GET['ide_per'].'</td>
                <td width="20%" style="font-weight:bold;">Fecha:</td>
                <td width="30%" style="font-weight:bold;">'.$rs_per['fecha'].'</td>
                <td width="20%" style="font-weight:bold;">Prioridad:</td>
                <td width="30%">'.$rs_per['prioridad'].'</td>
            </tr> 
      </table>       

      <h3>Responsable del Anticipo</h3>

	
      <table>      

            <tr>

            	 <td style="font-weight:bold;">Regional:</td>

                 <td>';

                	$sqlPry = "SELECT * FROM regional WHERE id =".$rs_per['id_regional']; 

                    $qrPry = mysql_query($sqlPry);

					$rsPry = mysql_fetch_array($qrPry);

$mensaje .= $rsPry['region'].'</td>               

            </tr>

            <tr>           

                <td style="font-weight:bold;">Nombre:</td>

                <td>'.$rs_per['nombre_responsable'].'</td>

                <td style="font-weight:bold;">Cedula:</td>

                <td>'.$rs_per['cedula_responsable'].'</td>            

            </tr>';

            

			

			$sqlPry = "SELECT * FROM linea_negocio WHERE id=".$rs_per['id_centroscostos']; 

			$qrPry = mysql_query($sqlPry);

			$rsPry = mysql_fetch_array($qrPry);

			

			$centro_costo = $rsPry['codigo'].'-'.$rsPry['nombre'];

			

			$sqlPry = "SELECT * FROM orden_trabajo WHERE id_proyecto = ".$rs_per['id_ordentrabajo']; 

            $qrPry = mysql_query($sqlPry);

            $rsPry = mysql_fetch_array($qrPry);

            $orden_trabajo = $rsPry['orden_trabajo'];
			

 $mensaje .= '<tr>             

                <td style="font-weight:bold;">Centro Costo:</td>

                <td>'.$centro_costo.'</td>              

           

            	<td style="font-weight:bold;">Ordenes de Trabajos:</td>

                <td>'.$orden_trabajo.'</td>

                

            </tr>  

    </table>  ';

    
	if($rs_per['orden_servicio_id'] == 0):
	
		$sqlPry = "SELECT * FROM beneficiarios WHERE identificacion='".$rs_per['cedula_consignar']."'"; 
		$qrPry = mysql_query($sqlPry);
		$row_bene = mysql_fetch_array($qrPry);
	
	$mensaje .= '
    <table style="width:100%;">

            <tr>

            	<td colspan="4"><h3>Consignar a:</h3></td>

            </tr>   

            <tr>

            	<td style="font-weight:bold;">CEDULA:</td>

                <td>'.$row_bene['identificacion'].'</td>                 

                <td style="font-weight:bold;">BENEFICIARIO:</td>

                <td>'.$row_bene['beneficiario'].'</td>       

            </tr>          

            <tr>

            	<td style="font-weight:bold;">BANCO:</td>

                <td>'.$row_bene['entidad'].'</td>

                

                <td style="font-weight:bold;">TIPO CUENTA:</td>

                <td>'.$row_bene['tipo_cuenta'].'</td> 

            </tr> 

            <tr>    

                <td style="font-weight:bold;">N&deg; DE CUENTA:</td>

                <td>'.$row_bene['num_cuenta'].'</td>         

           

            	<td style="font-weight:bold;">OBSERVACIONES:</td>

                <td>'.$rs_per['observaciones'].'</td>      

            </tr>   

	</table>';
	else:
	
		$sqlPry = "SELECT * FROM `orden_servicio` WHERE id = ".$rs_per['orden_servicio_id']; 
		$qrPry = mysql_query($sqlPry);
		$row_bene = mysql_fetch_array($qrPry);
	
	
	$mensaje .= '
	<table style="width:100%;">
			  	<tr>
            		<td colspan="4"><h3>Consignar a:</h3></td>
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
                   
                </tr>
                <tr>
                    <td>CONTRATO:</td>
                    <td>'.$row_bene['num_contrato_contratista'].'</td> 
					<td>SALDO ACUMULADO:</td>
                    <td>$'.$row_bene['observaciones_contratista'].'</td> 
                </tr> 
		 </table> '; 
	endif;
	
	
	$mensaje .=' <h3>Informaci&oacute;n del Anticipo</h3>';
	

    $mensaje .=  '<table style="width:100%">

						<tr>
			
						  <td style="font-weight:bold;">Valor del Giro (Aplica para Efecty, etc):</td>
			
						  <td>'.$rs_per['giro'].'</td> 
			
						  <td style="font-weight:bold;">Total Anticipo:</td>
			
						  <td>'.$total_anticipo.'</td>  
						  
						  <td style="font-weight:bold;">Total Galones:</td>
			
						  <td>'.$totalGalones.'</td>           
			
						</tr> 
						
						<tr>
							<td style="font-weight:bold;">IVA:</td>
							<td>$'.number_format($total_iva).'</td>
							<td style="font-weight:bold;">ICA:</td>
							<td>$'.number_format($total_ica).'</td>
							<td style="font-weight:bold;">Retefuente:</td>
							<td>$'.number_format($total_rte).'</td>
						</tr>      
			
			   </table>';

$mensaje .=  ' <h4>Lista Item</h4>   

			   <table style="width:100%;table-layout: fixed;word-wrap: break-word;" border="1">

						   <tr>

							 <td style="font-weight:bold;">ID Hito</td>

							 <td style="font-weight:bold;">Hitos</td>
							 
							 <td style="font-weight:bold;">V. <br>ACPM</td> 
							 
							 <td style="font-weight:bold;">Gal. <br>ACPM</td> 
							 
							 <td style="font-weight:bold;">Retenci&oacute;n<br/>ACPM</td> 

							 <td style="font-weight:bold;">Total ACPM</td> 

							 <td style="font-weight:bold;">V. Transporte</td>

							 <td style="font-weight:bold;">TOES</td>
							 
							 <td style="font-weight:bold;">Viaticos</td>
							 
							 <td style="font-weight:bold;">Trans. Mular</td>

						   </tr>';

		   			 	$sql = " SELECT *, i.id AS ID 
								 FROM items_anticipo AS i
								 LEFT JOIN hitos AS h ON  h.id = i.id_hitos
								 WHERE i.estado = 1 AND i.id_anticipo = ".$_GET['ide_per'];
					
					   	$resultado = mysql_query($sql) or die(mysql_error());
					   	$total = mysql_num_rows($resultado);
		   			 

					 if($total > 0):

						   while($row = mysql_fetch_assoc($resultado)):

							   $mensaje .= '<tr>
											  <td>'.$row['id'].'</td>
											  <td style="width:100px; word-wrap:break-word;">'.utf8_encode($row['nombre']).'</td>
											  <td style="width:80px; word-wrap:break-word;">$'.$row['valor_galon'].'</td>
											  <td style="width:50px; word-wrap:break-word;">'.$row['cant_galones'].'</td> 
											  <td>'.$row['retencion'].'</td> 
											  
											  <td style="width:50px; word-wrap:break-word;">$'.$row['acpm'].'</td>
											  <td>$'.$row['valor_transporte'].'</td>    
											  <td>$'.$row['toes'].'</td>
											  <td>$'.$row['viaticos'].'</td>
											  <td>$'.$row['mular'].'</td>        
										   </tr> ';
           		 			endwhile; 
					endif;

    $mensaje .= '</table>';
	
	/*echo $mensaje;
	exit;*/
	
	//style="width:100px; word-wrap:break-word;"
	require_once(dirname(__FILE__).'/html2pdf.class.php');
	try
    {

        $html2pdf = new HTML2PDF('P', 'A4', 'es');
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->WriteHTML($mensaje);
        $html2pdf->Output('Anticipo_ID_'.(int)$_GET['ide_per'].'.pdf');
		exit;
    }

    catch(HTML2PDF_exception $e) {
		echo $e;
        exit;
    }

?>



