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
	
	$resultado = mysql_query("SELECT * FROM items_anticipo WHERE id_anticipo =".$_GET['ide_per']) or die(mysql_error());
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
	
	$total_anticipo = $total_acpm + $total_toes + $total_anticipo + $giro;		
	$total_anticipo = '$'.number_format($total_anticipo).',00';

$mensaje = '<img src=http://proyecto.signsas.com/images/logo_sign.png  style="float:left;"/>

<h2 style="float:left; margin-left:20px;line-height: 43px;">FORMATO DE SOLICITUD DE ANTICIPO</h2> 
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
            
			
			$sqlPry = "SELECT * FROM centros_costos WHERE id=".$rs_per['id_centroscostos']; 
			$qrPry = mysql_query($sqlPry);
			$rsPry = mysql_fetch_array($qrPry);
			
			$centro_costo = $rsPry['sigla'].'/'.$rsPry['nombre'];
			
			$sqlPry = "SELECT * FROM orden_trabajo WHERE id_proyecto = ".$rs_per['id_ordentrabajo']; 
            $qrPry = mysql_query($sqlPry);
            $rsPry = mysql_fetch_array($qrPry);
            $orden_trabajo = $rsPry['orden_trabajo'];
			
			$sqlPry = "SELECT * FROM beneficiarios WHERE identificacion='".$rs_per['cedula_consignar']."'"; 
			$qrPry = mysql_query($sqlPry);
			$row_bene = mysql_fetch_array($qrPry);
			
 $mensaje .= '<tr>             
                <td style="font-weight:bold;">Centro Costo:</td>
                <td>'.$centro_costo.'</td>              
           
            	<td style="font-weight:bold;">Ordenes de Trabajos:</td>
                <td>'.$orden_trabajo.'</td>
                
            </tr>  
    </table>  
    
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
	</table>
    
    <h3>Informaci&oacute;n del Anticipo</h3>
   
    <table style="width:100%">
            <tr>
              <td style="font-weight:bold;">Valor del Giro (Aplica para Efecty, etc):</td>
              <td>'.$rs_per['giro'].'</td> 
              <td style="font-weight:bold;">Total Anticipo:</td>
              <td>'.$total_anticipo.'</td>           
        	</tr>       
   </table>';
   
   $sql = "SELECT *, i.id AS ID FROM items_anticipo AS i
								LEFT JOIN hitos AS h ON  h.id = i.id_hitos
								WHERE i.id_anticipo = ".$_GET['ide_per'];
   $resultado = mysql_query($sql) or die(mysql_error());
   
   
$mensaje .=  ' <h4>Lista Item</h4>   
			   <table style="width:100%;table-layout: fixed;word-wrap: break-word;">
						   <tr>
							 <td style="font-weight:bold;">Item:</td>
							 <td style="font-weight:bold;">Hitos:</td>
							 <td style="font-weight:bold;">Valor ACPM para el suministro:</td> 
							 <td style="font-weight:bold;">Valor Transporte - Trasiego o Mular:</td>
							 <td style="font-weight:bold;">Valor Viaticos - TOES :</td>
						   </tr>';
		   
		   
		   			 $total = mysql_num_rows($resultado);
					 if($total > 0):
						   while($row = mysql_fetch_assoc($resultado)):
           
						   $mensaje .= '<tr>
										  <td>'.$row['id'].'</td>
										  <td>'.utf8_encode($row['nombre']).'</td> 
										  <td>$'.$row['acpm'].'</td>
										  <td>$'.$row['valor_transporte'].'</td>    
										  <td>$'.$row['toes'].'</td>        
									   </tr> ';
          
           		 	endwhile; endif;
             
    $mensaje .= '</table>';
	
	require_once(dirname(__FILE__).'/html2pdf.class.php');
	try
    {
		
        $html2pdf = new HTML2PDF('P', 'A4', 'es');
        //$html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->WriteHTML($mensaje);
        $html2pdf->Output('Anticipo_ID_'.(int)$_GET['ide_per'].'.pdf');
		
		echo json_encode(array('estado'=>true, 'file'=>'Anticipo_ID_'.(int)$_GET['ide_per'].'.pdf'));
		exit;
		
    }
    catch(HTML2PDF_exception $e) {
		echo json_encode(array('estado'=>false, 'message'=>$e));
        exit;
    }
	
?>

