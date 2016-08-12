<?php

	header('Content-type: text/html; charset=iso-8859-1');

	if(empty($_GET['ide_per'])){

		echo "Por favor no altere el fuente";

		exit;

	}



	include "../extras/php/basico.php";

	include "../../conexion.php";	

	

	$sql = sprintf("select * from solicitud_despacho where id=%d",

		(int)$_GET['ide_per']

	);

	$per = mysql_query($sql);

	$num_rs_per = mysql_num_rows($per);

	if ($num_rs_per==0){

		echo "No existen solicitud con ese ID";

		exit;

	}  

	

	$rs_per = mysql_fetch_assoc($per);

	



$mensaje = '

<img src="http://operacionsign.com/logo_sign.png"  style="float:left;"/>

<h2 style="float:left; margin-left:20px;line-height: 43px;">&nbsp;FORMATO DE SOLICITUD SALIDA MERCANCIA</h2> 

<div style="clear:both"></div>

<br />

	<h1>Formato Solicitud de Despacho</h1>

<table>

        <tbody>
		  <tr>
		  		<td style="font-weight:bold;">ID Solicitud:</td>
                <td>'.$_GET['ide_per'].'</td>
		  	
		  </tr>

          <tr>

                <td style="font-weight:bold;">Fecha Solicitud:</td>
                <td>'.$rs_per['fecha_solicitud'].'</td>

          </tr>

          <tr>

                <td style="font-weight:bold;">Fecha Entrega:</td>

                <td>'.$rs_per['fecha_entrega'].'</td>

              

                <td style="font-weight:bold;">Prioridad:</td>

                <td>'.$rs_per['prioridad'].'</td>

            </tr> 

            

            <tr>

            	<td colspan="2"><h3>Responsable de la Solicitud</h3></td>

            </tr>';

			

			$sqlPry = "SELECT * FROM regional WHERE id =".$rs_per['id_regional']; 

			$qrPry = mysql_query($sqlPry);

			$rsPry = mysql_fetch_array($qrPry);

            

           $mensaje .= '<tr>

            	<td style="font-weight:bold;">Regional:</td>

                <td>'.$rsPry['region'].'</td>                 

            </tr>

            <tr>        

                <td style="font-weight:bold;">Nombre:</td>

                <td>'.$rs_per['nombre_responsable'].'</td>

                

                <td style="font-weight:bold;">Cedula:</td>

                <td>'.$rs_per['cedula_responsable'].'</td> 

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

		   </tr>';

		   

		   $sqlPry = "SELECT * FROM centros_costos WHERE id =".$rs_per['id_centrocostos'];

           $qrPry = mysql_query($sqlPry);

           $rsPry = mysql_fetch_array($qrPry);

		          

           $mensaje .= '

		   <tr> 

                <td style="font-weight:bold;">Centro Costo:</td>

                <td>'.$rsPry['sigla'].' / '.$rsPry['nombre'].'</td>            

            	<td style="font-weight:bold;">Orden Trabajo:</td>

                <td>';

				

			$sqlPry = "SELECT * FROM orden_trabajo WHERE id_proyecto =".$rs_per['id_proyecto'];

			$qrPry = mysql_query($sqlPry);

			$rsPry = mysql_fetch_array($qrPry);

			

			

           $mensaje .= $rsPry['orden_trabajo'].'

                </td>

           </tr> 
		   <tr>

               <td style="font-weight:bold;">Hitos:</td>

               <td>';                    

			$sqlPry = "SELECT * FROM hitos WHERE id =".$rs_per['id_hito'];

			$qrPry = mysql_query($sqlPry);

			$rsPry = mysql_fetch_array($qrPry);

			

			$mensaje .= $rsPry['nombre'].'      

               </td> 

           </tr>

           <tr>

               <td style="font-weight:bold;">ID Hito:</td>

               <td>                  

			   '.$rs_per['id_hito'].'  

               </td> 

           </tr>

           

        </tbody>

    </table>  

	<br />

    <table>

            <tr>

              <td style="font-weight:bold;">Direcci&oacute;n de entrega</td>

              <td>'.$rs_per['direccion_entrega'].'</td>

              <td style="font-weight:bold;">Nombre de quien recibe</td>

              <td>'.$rs_per['nombre_recibe'].'</td>

            </tr>

            <tr>

              <td style="font-weight:bold;">Tel&eacute;fono / Celular</td>

              <td>'.$rs_per['celular'].'</td>

              <td style="font-weight:bold;">Descripci&oacute;n:</td>

              <td>'.$rs_per['descripcion'].'</td>

            </tr>   

   </table>';

   

   $sql = "SELECT * FROM materiales WHERE aprobado = 1 AND id_despacho =".(int)$_GET['ide_per'];

   $resultado = mysql_query($sql) or die(mysql_error());


   $mensaje .=  ' <h4>Lista Item</h4>   

			   	   <table style="width:98%;table-layout: fixed;" border="1">

						   <tr>

							 <th style="font-weight:bold; width:45px;" align="center">C&oacute;digo</th>	 
							 <th style="width: 100px;" align="center">Material</th>
							 
							 <th style="width: 63px;">Cant. Solicitada</th>
							 <th style="width: 63px;">Cant. Inventario</th>
							 <th style="width: 63px;">Costo Unitario Inventario</th>
							 <th style="width: 30px;" align="center">IVA</th>
							 <th style="width: 30px;" align="center">OC</th>
							 
							 <th style="width: 65px;">Cant. Comprada</th>
							 <th style="width: 65px;">Costo Unidad Comprada</th>
							 
							 <th style="width: 65px;">Cant. Ent. Inventario</th>
							 <th style="width: 65px;">Cant. Entregada</th>							 
							 <th style="width: 50px;" align="center">Cant. Total</th>
							 
							 <th style="width: 60px;" align="center">Costo Inv</th>
							 <th style="width: 60px;" align="center">Costo Compra</th>
							 <th style="width: 80px;" align="center">Valor Adjudicación</th>
							 <th style="width: 80px;" align="center">Total</th>
							</tr>';

							/* <th style="font-weight:bold;">Cantidad</th> 							 
							 <th style="font-weight:bold;text-align:center; width:80px;">Presupuesto</th>
							 <th style="font-weight:bold;">Observaci&oacute;n</th>							 
							 
							 <th style="font-weight:bold;">Existencia</th> 
							 <th style="font-weight:bold;">C.Comprada</th>
							 <th style="font-weight:bold;">C.U</th>
							 <th style="font-weight:bold;">IVA</th>
							 <th style="font-weight:bold;">O.C</th>
							 <th style="font-weight:bold;">C.Entregada</th>
							 
							 <th style="font-weight:bold;">CT Materiales</th>							 
							 <th style="font-weight:bold;">CT Compra</th>

						   </tr>';*/

		   			 $total = mysql_num_rows($resultado);

					 if($total > 0):
					 
					 	   $totalizador = 0;

						   while($row = mysql_fetch_assoc($resultado)):

						    $sql2 = "SELECT nombre_material, cantidad, codigo, costo_unidad FROM inventario
									 WHERE id = ".$row['id_material'];
							$pai2 = mysql_query($sql2); 
							$rs_pai2 = mysql_fetch_assoc($pai2);
							
							$sql3 = "SELECT * FROM TEMP_MERCANCIAS WHERE id_item = ".$row['id'];
							$pai3 = mysql_query($sql3); 
							$rs_pai3 = mysql_fetch_assoc($pai3);
							
							if($rs_pai3['iva2'] != '')
								$iva = $rs_pai3['iva2'];
							else
								$iva  = 0.16;
								
							if($rs_pai3['orden_compra2'] != '' || $rs_pai3['orden_compra2'] != 0)
								$oc = $rs_pai3['orden_compra2'];
							else
								$oc = 'N/A';
												

						    /*switch($row['aprobado']):
									case 0:
									case 3:
										$aprobar = "No Aprobado";
									break;
									case 1:
										$aprobar = "Aprobado";
									break;				
						   	endswitch;*/
							
							$cantidadComprada = ($rs_pai3['cantidadc'] != '')?$rs_pai3['cantidadc']:0;
							$costo_unidadcompra = ($rs_pai3['costo_unidadcompra'] != '')?$rs_pai3['costo_unidadcompra']:0;
							
							$cantidadentinv =($rs_pai3['cantidadentinv'] != '')?$rs_pai3['cantidadentinv']:0;
							$cantidadentcomp =($rs_pai3['cantidadentcomp'] != '')?$rs_pai3['cantidadentcomp']:0;
							$cantidade =($rs_pai3['cantidade'] != '')?$rs_pai3['cantidade']:0; // total de cantidad entregada
						   	
							$costoinv = ($rs_pai3['costoinv'] != '')?$rs_pai3['costoinv']:0;
							$costocomp = ($rs_pai3['costocomp'] != '')?$rs_pai3['costocomp']:0;
							$valor_adjudicado =($rs_pai3['valor_adjudicado'] != '')?$rs_pai3['valor_adjudicado']:0;
							
							$total = $cantidade * $valor_adjudicado; 
							$totalizador+=$total;
											
							$mensaje .= '<tr>

										  <td valign="top">'.$rs_pai2['codigo'].'</td>
										  <td valign="top"><div style="width:100px;">'.utf8_encode($rs_pai2['nombre_material']).'</div></td> 
										  <td align="center" valign="top">'.(int)$row['cantidad'].'</td>  
										  <td align="center" valign="top">'.(int)$rs_pai2['cantidad'].'</td>  
										  <td align="center" valign="top">$'.$rs_pai2['costo_unidad'].'</td> 
										  
										  <td align="center" valign="top">'.$iva.'</td> 
										  <td align="center" valign="top">'.$oc.'</td>
										  
										  <td align="center" valign="top">'.$cantidadComprada.'</td>  
										  <td align="center" valign="top">$'.$costo_unidadcompra.'</td>
										    
										  <td align="center" valign="top">'.$cantidadentinv.'</td>    
										  <td align="center" valign="top">'.$cantidadentcomp.'</td> 
										  <td align="center" valign="top">'.$cantidade.'</td> 
										  
										  <td align="center" valign="top">$'.$costoinv.'</td>    
										  <td align="center" valign="top">$'.$costocomp.'</td> 
										  <td align="center" valign="top">$'.$valor_adjudicado.'</td>
										  
										  <td align="center" valign="top">$'.$total.'.00</td>
										</tr>';
										  
										  /*<td align="center" valign="top">'.utf8_encode($row['cantidad']).'</td>
										  <td align="right" valign="top">$'.$row['presupuesto'].'</td>    
										  <td valign="top"><div style="width:100px;">'.utf8_encode($row['observacion']).'</div></td>  										 
										  
										  <td align="center" valign="top">'.(int)$rs_pai2['cantidad'].'</td>  
										  <td align="center" valign="top">'.$rs_pai3['cantidadc'].'</td>  
										  <td align="center" valign="top">'.$rs_pai3['costo2'].'</td>  
										  <td align="center" valign="top">'.$rs_pai3['iva2'].'</td>  
										  <td align="center" valign="top">'.$rs_pai3['orden_compra2'].'</td>  
										  <td align="center" valign="top">'.$rs_pai3['cantidade'].'</td> 
										  <td align="center" valign="top">'.$rs_pai3['ct_materiales'].'</td> 
										  <td align="center" valign="top">'.$rs_pai3['ct_compra'].'</td>  
									
									   </tr> ';*/
          
           		 	endwhile; endif;
					
					$mensaje .= '<tr>
									<td align="center" valign="top" colspan="14">&nbsp;</td> 
									<td align="center" valign="top">Total</td>  
									<td align="center" valign="top">$'.$totalizador.'.00</td>
								 </tr>';

             

    $mensaje .= '</table>';
	
	
	$mensaje .= '<table style="margin-top:50px;">
					<tr>
						<td>----------------------------------------------</td>
						<td>----------------------------------------------</td>
					</tr>
					<tr>
						<td>Quien entrega</td>
						<td>Quien Recibe</td>
					</tr>
				 </table>';


	/*echo $mensaje;
 
	exit;*/

	require_once('/home/operacionsign/public_html/anticipos/anticipo/html2pdf.class.php');

	try

    {

		

        $html2pdf = new HTML2PDF('L', 'A4', 'es');

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



