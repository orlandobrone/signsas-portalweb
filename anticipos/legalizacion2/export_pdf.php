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

	

	$resultado = mysql_query("SELECT pagado FROM items WHERE estado = 0 AND id_legalizacion =".(int)$_GET['ide_per']) or die(mysql_error());

	

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

	$resultado_anticipo = mysql_query("SELECT * FROM anticipo WHERE  id_legalizacion =".(int)$_GET['ide_per']) or die(mysql_error());

	$total_anticipo = mysql_num_rows($resultado_anticipo);

	$row_anticipo = mysql_fetch_assoc($resultado_anticipo);

	

	if($total_anticipo > 0):

		$otro_anticipo = ' - '.$row_anticipo['id'];

		

		$total_anticipo2 = substr($row_anticipo['total_anticipo'],0, -3);

		$total_anticipo2 = str_replace($letters, $fruit, $total_anticipo2);

		

		$valor_pagar = $valor_pagar - $total_anticipo2;

		

	else:

		$otro_anticipo = '';

	endif;

	

	$valor_pagar2 = $valor_pagar;

	

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

            	<td colspan="2">&nbsp;</td>

            	<td>N&deg; LEGALIZACION:</td>

                <td>'.$_GET['ide_per'].'</td>

         </tr>

		

		 <tr>

			  <td>Coordinador:</td>

			  <td>'.utf8_encode($rs_per['coordinador']).'</td>

			  <td>No. DE ANTICIPO:</td>

			  <td>'.$rs_per['id_anticipo'].''.$otro_anticipo.'</td>

		  </tr>';

		  

		  $resultado = mysql_query("SELECT * FROM tecnico WHERE id = ".$rs_per['id_tecnico']) or die(mysql_error());

		  $row = mysql_fetch_assoc($resultado);

		  

		  

		  $mensaje .='

		  <tr>

			  <td>TECNICO O AUXILIAR:</td>

			  <td>'.utf8_encode($row['nombre']).'</td>

			  

			  <td>VALOR FONDO / ANTICIPO:</td>

			  <td>$'.$rs_per['valor_fa'].'</td>

		  </tr>';

		  

		  $resultado = mysql_query("	SELECT o.orden_trabajo AS ordentrabajo,  o.id_proyecto AS idproyecto

										FROM anticipo AS a

										LEFT JOIN orden_trabajo AS o ON a.id_ordentrabajo = o.id_proyecto

										WHERE a.id =".$rs_per['id_anticipo']) or die(mysql_error());

										

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

	//echo $mensaje;

	require_once($_SERVER['DOCUMENT_ROOT'].'/anticipos/anticipo/html2pdf.class.php');

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