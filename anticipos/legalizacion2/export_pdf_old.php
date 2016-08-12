<?php
	header('Content-type: text/html; charset=iso-8859-1');
	if(empty($_GET['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}

	include "../extras/php/basico.php";
	include "../../conexion.php";	
	
	$sql = sprintf("select * from legalizacion where id=%d",
		(int)$_GET['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen solicitud con ese ID";
		exit;
	}  
	
	$rs_per = mysql_fetch_assoc($per);
	
	
	
	$letters = array('.','$',',');
	$fruit   = array('');
	$valor_legalizado = 0;
	$reintegro = 0;
	$valor_pagar = 0; 
	
	$resultado = mysql_query("SELECT pagado FROM items WHERE id_legalizacion =".(int)$_GET['ide_per']) or die(mysql_error());
	
	while ($rows = mysql_fetch_assoc($resultado)):
	
		if($rows['pagado'] != ''):
			$valor = explode(',00',$rows['pagado']);
			$valor2 = str_replace($letters, $fruit, $valor[0] );
			$valor_legalizado += $valor2;
		endif;
	endwhile;
	
	$valor = substr($rs_per['valor_fa'],0, -3);
	$valor_fondo = str_replace($letters, $fruit, $valor);		
	
	if($valor_legalizado != 0 ):			
		$reintegro = $valor_fondo - $valor_legalizado;
	endif;
	
	if($valor_legalizado > $valor_fondo):			
		$valor_pagar = $valor_legalizado - $valor_fondo;
		$reintegro = 0;
	endif;
	setlocale(LC_MONETARY, 'en_US');
	
	$valor_pagar = money_format('%(#1n',$valor_pagar);
	$valor_reintegro = money_format('%(#1n',$reintegro);
	$valor_legalizado =  money_format('%(#1n',$valor_legalizado);
	
	

$mensaje = '
<img src=http://proyecto.signsas.com/images/logo_sign.png  style="float:left;"/>
<h2 style="float:left; margin-left:20px;line-height: 43px;">&nbsp;FORMATO DE LEGALIZACI&Oacute;N DE CAJA MENOR</h2> 
<div style="clear:both"></div>
<br />
<table>
        <tbody>
       	  <tr>
		  		<td style="font-weight:bold;">Responsable:</td>
                <td>'.$rs_per['responsable'].'</td>
                <td style="font-weight:bold;">Fecha:</td>
                <td>'.$rs_per['fecha'].'</td>
          </tr>
          <tr>
                <td style="font-weight:bold;">No Anticipo:</td>
                <td>'.$rs_per['id_anticipo'].'</td>
				<td style="font-weight:bold;">Valor fondo / anticipo:</td>
                <td>$'.$rs_per['valor_fa'].'</td>
            </tr> 
			<tr>
				<td style="font-weight:bold;">Valor Legalizado:</td>
                <td>'.$valor_legalizado.'</td>
            	<td style="font-weight:bold;">Valor a Pagar:</td>
                <td>'.$valor_pagar.'</td>                 
            </tr>
            <tr>        
                <td style="font-weight:bold;">Legalizaci&oacute;n (L) o Reintegro(R):</td>
                <td>'.$valor_reintegro.'</td>
           </tr>
		   <tr>
		   	<td></td>
		   </tr>
		   <tr>
		   	<td></td>
		   </tr>
		   <tr>
		   	<td></td>
		   </tr>
		   <tr>
		   	<td></td>
		   </tr>
        </tbody>
    </table>  
	<br />';
    
   
   $sql = "SELECT * FROM items WHERE id_legalizacion =".(int)$_GET['ide_per'];
   $resultado = mysql_query($sql) or die(mysql_error());
   
	
   
   
   $mensaje .=  ' <h4>Lista Item</h4>   
			   	  <table rules="all" border="1" style="width:100%;table-layout: fixed;word-wrap: break-word;font-size:12px;">
						   <tr>
							 <td style="font-weight:bold;">Item:</td>
							 <td style="font-weight:bold;">Fecha:</td>
							 <td style="font-weight:bold;">Beneficiario</td> 
							 <td style="font-weight:bold;">NIT/CC/IDENT:</td>
							 <td style="font-weight:bold;">Centro Costos:</td>
							 <td style="font-weight:bold;">Concepto:</td>
							 <td style="font-weight:bold;">Pagado:</td>
						   </tr>';
		   
		   
		   			 $total = mysql_num_rows($resultado);
					 if($total > 0):
					 
						   while($row = mysql_fetch_assoc($resultado)):
						   
						    /*$sql2 = "SELECT nombre_material FROM inventario WHERE id = ".$row['id_material'];
							$pai2 = mysql_query($sql2); 
							$rs_pai2 = mysql_fetch_assoc($pai2);*/
						   
												
						   $mensaje .= '<tr>
										  <td>'.$row['id'].'</td>
										  <td>'.$row['fecha'].'</td> 
										  <td><div style="width:160px;">'.utf8_encode($row['beneficiario']).'</div></td>
										  <td>'.$row['nitccident'].'</td>    
										  <td>'.$row['centro_costos'].'</td> 
										  <td><div style="width:130px;">'.$row['concepto'].'</div></td> 
										  <td>'.$row['pagado'].'</td>  
									   </tr> ';
          
           		 	endwhile; endif;
             
    $mensaje .= '</table>'; 
	
	//echo $mensaje;
	require_once('/home/signsas/public_html/proyecto/anticipos/anticipo/html2pdf.class.php');
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

