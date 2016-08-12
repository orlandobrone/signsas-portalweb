<?php

	//header('Content-type: text/html; charset=iso-8859-1');

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
		echo "No existen legalizacion con ese ID";
		exit;
	}	

	$rs_per = mysql_fetch_assoc($per);

	$letters = array('.','$',',');
	$fruit   = array('');

	$valor_legalizado = 0;
	$reintegro = 0;
	$valor_pagar = 0; 


	$resultado = mysql_query("SELECT pagado FROM items WHERE estado = 0 AND id_legalizacion =".$_GET['ide_per']) or die(mysql_error());


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


	if($valor_legalizado != 0 ):			
		$reintegro = $valor_fondo - $valor_legalizado;
	endif;
	
	
	if($valor_legalizado > $valor_fondo):	
		$valor_pagar = $valor_legalizado - $valor_fondo;
		$reintegro = 0;
	endif;
	
	
	//echo $valor_legalizado.'-'.$valor_fondo.'='.$valor_pagar;
	
	$obj = new TaskCurrent;	
	//Obtengo el valor total de reintegro de un anticipo de prioridad reintegro
	$reintegro_anticipo = $obj->getReintegroByLegalizacion((int)$_GET['ide_per']);
	$reintegro_anticipo = substr($reintegro_anticipo,0, -3);
	$reintegro_anticipo = str_replace($letters, $fruit, $reintegro_anticipo);	

	$reintegro = $reintegro - $reintegro_anticipo;
	
	//echo $reintegro.'-'.$reintegro_anticipo;
	
	//echo 'Valor pagar->'.$valor_legalizado.'-'.$valor_fondo.' | '.$rs_per['valor_fa'];

	setlocale(LC_MONETARY, 'en_US');

	$sql2 = sprintf("SELECT total_anticipo FROM anticipo WHERE  publicado NOT IN('draft') AND estado != 4 AND id_legalizacion=%d",
		(int)$_GET['ide_per']
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
	//echo $valor_fondo.'+'.$total_anticipos_vinculados;
	//$valor_fondo = money_format('%(#1n',$valor_fondo + $total_anticipos_vinculados - $reintegro_anticipo);
	$valor_fondo = money_format('%(#1n',$valor_fondo);

	
	$resultado_anticipo = mysql_query("SELECT * FROM anticipo WHERE   publicado NOT IN('draft') AND estado != 4 AND id_legalizacion =".$_GET['ide_per']) or die(mysql_error());
	$total_anticipo = mysql_num_rows($resultado_anticipo);
	$row_anticipo = mysql_fetch_assoc($resultado_anticipo);

	 

	if($total_anticipo > 0):
		
		$tipo_anticipo = ($row_anticipo['prioridad'] == 'REINTEGRO')? 'R':'';
		
		$otro_anticipo = ' - '.$tipo_anticipo.$row_anticipo['id'];

		$total_anticipo2 = substr($row_anticipo['total_anticipo'],0, -3);
		$total_anticipo2 = str_replace($letters, $fruit, $total_anticipo2);

		$valor_pagar = $valor_pagar - $total_anticipo2 + $reintegro_anticipo;

		/*$items_anticipo = mysql_query("SELECT * FROM items_anticipo WHERE id_anticipo =".$row_anticipo['id']) or die(mysql_error());

		$total_items_anticipo = mysql_num_rows($items_anticipo);	
		while($row_anticipo = mysql_fetch_assoc($items_anticipo)):
			$valor = substr($row_anticipo['total_anticipo'],0, -3);
			$valor = str_replace($letters, $fruit, $valor);
			$total_anticipos_vinculados += $valor;
		endwhile;*/

	else:
		$otro_anticipo = '';
	endif;

	//echo $valor_pagar.'-'.$total_anticipo2.'-'.$reintegro_anticipo;


	$valor_pagar2 = $valor_pagar;

	$valor_pagar = money_format('%(#1n',$valor_pagar);
	$valor_reintegro = money_format('%(#1n',$reintegro);
	$valor_legalizado =  money_format('%(#1n',$valor_legalizado);
	
	//si tiene OS
	$os = 0;
	$sql_os = " SELECT orden_servicio_id 
				FROM anticipo WHERE estado != 4 AND id =".$rs_per['id_anticipo'];
	$resultado_os = mysql_query($sql_os) or die(mysql_error());
	$row_os = mysql_fetch_assoc($resultado_os);
	
	$os = $row_os['orden_servicio_id'];
	

$mensaje = '

<img src="http://operacionsign.com/logo_sign.png"  style="float:left;"/>

<h2 style="float:left; margin-left:20px;line-height: 43px;">&nbsp;FORMATO DE LEGALIZACI&Oacute;N DE CAJA MENOR</h2> 

<div style="clear:both"></div>

<br />



<table>

        <tbody>

		<tr>

            	<td>N&deg; LEGALIZACION:</td>

                <td>'.$_GET['ide_per'].'</td>

         </tr>

		

		 <tr>

			  <td>RESPONSABLE:</td>

			  <td>'.utf8_encode($rs_per['responsable']).'</td>

			  <td>No. ANTICIPO:</td>

			  <td>'.$rs_per['id_anticipo'].''.$otro_anticipo.'</td>

		  </tr>';

		   if($os != 0): 
			
					$sql = sprintf("select * from `orden_servicio` where id=%d",
						(int)$os
					);
					$per = mysql_query($sql);
					$rs_os = mysql_fetch_assoc($per);
			
			$mensaje .= '
            <tr>
            	<td colspan="2"><h3>Contratista:</h3></td>
            </tr>   
            <tr>
            	<td style="width:120px;">CEDULA:</td>
                <td>
              		'.$rs_os['cedula_contratista'].'       
                </td>                  
                <td>NOMBRE:</td>
                <td>'.utf8_encode($rs_os['nombre_contratista']).'</td>       
            </tr>          
            <tr>
            	<td>TELEFONO:</td>
                <td>'.$rs_os['telefono_contratista'].'               
                </td>
                <td>DIRECCI&Oacute;N:</td>
                <td>'.$rs_os['direccion_contratista'].'</td> 
            </tr>
            <tr>
            	<td>CONTACTO:</td>
                <td>
                 	'.utf8_encode($rs_os['contacto_contratista']).'          
                </td>
                <td>CORREO:</td>
                <td>
              		'.$rs_os['correo_contratista'].'       
                </td> 
            </tr>
            <tr>
            	<td>BANCO:</td>
                <td>
                 	'.$rs_os['banco_contratista'].'
                </td>
                <td>TIPO CUENTA:</td>
                <td>
              		'.$rs_os['tipocuenta_contratista'].'  			
                </td> 
            </tr> 
            <tr>    
                <td>N&deg; DE CUENTA:</td>
                <td>
              		'.$rs_os['numcuenta_contratista'].'    
                </td>         
            	<td>SALDO ACUMULADO:</td>
                <td>
              		'.$rs_os['observaciones_contratista'].'     
                </td>      
             </tr> 
             <tr>    
                <td>REGIMEN:</td>
                <td>
              		'.$rs_os['regimen_contratista'].'   
                </td>         

            	<td>POLIZA:</td>
                <td>
	               '.$rs_os['poliza_contratista'].'
                </td>      
            </tr>'; 
			
			
            else: 
					$sql3 = sprintf("SELECT banco, tipo_cuenta, num_cuenta, cedula_consignar, beneficiario
									 FROM anticipo WHERE id=%d",
							(int)$rs_per['id_anticipo']
					);
					$per3 = mysql_query($sql3);
					$rs_ant = mysql_fetch_assoc($per3);
					
		   $mensaje .= '
           <tr>
            	<td style="width:120px;">CEDULA:</td>
                <td>
              		'.$rs_ant['cedula_consignar'].'       
                </td>                  
                <td>NOMBRE:</td>
                <td>
              		'.utf8_encode($rs_ant['beneficiario']).'     
                </td>       
            </tr>          
          
            <tr>
            	<td>BANCO:</td>
                <td>
                 	'.$rs_ant['banco'].'
                </td>
                <td>N&deg; DE CUENTA:</td>
                <td>
              		'.$rs_ant['num_cuenta'].'  			
                </td> 
            </tr> 
            <tr>
            	<td>TIPO CUENTA:</td>
                <td>
                 	'.$rs_ant['tipo_cuenta'].'
                </td>
            </tr>';
           endif;


		  

		  $mensaje .='

		  <tr>
			  <td>VALOR FONDO / ANTICIPO:</td>

			  <td>'.$valor_fondo.'</td>

		  </tr>';

		  

		  $resultado = mysql_query("	SELECT o.orden_trabajo AS ordentrabajo,  o.id_proyecto AS idproyecto

										FROM anticipo AS a

										LEFT JOIN orden_trabajo AS o ON a.id_ordentrabajo = o.id_proyecto

										WHERE a.estado != 4 AND a.id =".$rs_per['id_anticipo']) or die(mysql_error());

										

			$row = mysql_fetch_assoc($resultado);

			$id_proyecto = $row['idproyecto'];

		  

		  $mensaje .='

		   <tr>

            	<td>PROYECTO - OT:</td>

                <td>'.$row['ordentrabajo'].'</td>

				

                <td>Valor Legalizado</td>

  				<td>'.$valor_legalizado.'</td>            

		  </tr>

		  

		  <tr>

		  	   <td colspan="2">&nbsp;</td>

               <td>Valor a Pagar</td>

               <td>'.$valor_pagar.'</td>

          </tr>

		  

		  <tr>

                <td>Fecha</td>

                <td>'.$rs_per['fecha'].'</td>

                <td>Legalizaci&oacute;n (L) o Reintego(R)</td>

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

	

	/*

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

	*/

    

   

   $sql = "SELECT * FROM items WHERE estado = 0 AND id_legalizacion =".(int)$_GET['ide_per']." ORDER BY id DESC";

   $resultado = mysql_query($sql) or die(mysql_error());
   

   $mensaje .=  ' <h4>Lista Item</h4>   

			   	  <table rules="all" border="1" style="width:100%;table-layout: fixed;word-wrap: break-word;font-size:12px;">

						   <tr>

							 <td style="font-weight:bold;">Item:</td>

							 <td style="font-weight:bold;">HITO - SITIO</td> 

							 <td style="font-weight:bold;">Concepto:</td>

							 <td style="font-weight:bold;">Cantidad de Recibidos:</td>

							 <td style="font-weight:bold;">Pagado:</td>

						   </tr>';

		   

		   

		   			 $total = mysql_num_rows($resultado);

					 if($total > 0):

					 

						   while($row = mysql_fetch_assoc($resultado)):

						   

						    /*$sql2 = "SELECT nombre_material FROM inventario WHERE id = ".$row['id_material'];

							$pai2 = mysql_query($sql2); 

							$rs_pai2 = mysql_fetch_assoc($pai2);*/

							

							

							$sql4 = "SELECT o.orden_trabajo AS ot, h.nombre AS nombre_hito FROM  orden_trabajo AS o

									 INNER JOIN hitos AS h ON h.id = ".$row['id_hito']."

									 WHERE o.id_proyecto = ".$row['id_proyecto'];

							$pai4 = mysql_query($sql4); 

							$rs_pai4 = mysql_fetch_assoc($pai4);	
							
							
							$sql7 = "SELECT concepto FROM `conceptos_legalizacion` WHERE id = ".$row['concepto'];

							$pai7 = mysql_query($sql7); 
						
							$rs_pai7 = mysql_fetch_assoc($pai7);

												

						   $mensaje .= '<tr>

										  <td>'.$row['id'].'</td>

										  <td><div style="width:250px;">'.$rs_pai4['nombre_hito'].'</div></td> 

										  <td><div style="width:130px;">'.$rs_pai7['concepto'].'</div></td> 

										  <td>'.$row['cantidad_recibida'].'</td>  

										  <td>'.$row['pagado'].'</td>  

									   </tr> ';

          

           		 	endwhile; endif; 

             

    $mensaje .= '</table>'; 

	/*echo $mensaje;
	exit;*/

	require_once('/home/operacionsign/public_html/anticipos/anticipo/html2pdf.class.php');

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