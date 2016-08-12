<?php

	header("Pragma: public");

	header("Expires: 0"); 

	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	header("Content-Type: application/force-download");

	header("Content-Type: application/octet-stream");

	header("Content-Type: application/download");

	header("Content-Disposition: attachment;filename=Costos_export_".date('d-m-Y').".xls");

	header("Content-Transfer-Encoding: binary ");

	

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	$query = "SELECT *

			  FROM proyecto_costos

			  WHERE 1 ORDER BY id DESC";

			  

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	

?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>

            <td align="center"><strong>Proyecto</strong></td>

            <td align="center"><strong>Proveedor</strong></td>

            <td align="center"><strong>T&eacute;nico</strong></td>

            <td align="center"><strong>Concepto</strong></td>

            <td align="center"><strong>Descripci&oacute;n</strong></td>

            <td align="center"><strong>Fecha de Ingreso</strong></td>

            <td align="center"><strong>Valor</strong></td>

            <td align="center"><strong>Fecha de Registro</strong></td>   

            

            

            <!--<td align="center"><strong>Beneficiario</strong></td>

            <td align="center"><strong>Banco</strong></td>

            <td align="center"><strong>Valor Giro</strong></td>

            <td align="center"><strong>Hito</strong></td>

            <td align="center"><strong>Valor ACPM</strong></td>

            <td align="center"><strong>Valor Transp</strong></td>

            <td align="center"><strong>TOES</strong></td>-->

        </tr>

	

<?php	

    $letters = array('.','$',',');

	$fruit   = array('');	

	

	while ($row_item = mysql_fetch_array($result, MYSQL_ASSOC)):

	

		$resultado = mysql_query("SELECT nombre FROM proyectos WHERE id =".$row_item['id_proyecto']) or die(mysql_error());

		$rows = mysql_fetch_assoc($resultado);

		

		$proyecto = $rows['nombre'];

		

		$resultado = mysql_query("SELECT nombre FROM proveedor WHERE id =".$row_item['id_proveedor']) or die(mysql_error());

		$rows = mysql_fetch_assoc($resultado);

		

		$proveedor = $rows['nombre'];

		

		

		$resultado = mysql_query("SELECT nombre FROM tecnico WHERE id =".$row_item['id_tecnico']) or die(mysql_error());

		$rows = mysql_fetch_assoc($resultado);

		

		$tecnico = $rows['nombre'];

		

		

		$arrConcepto = array('','Transportes', 'Alquileres Vehiculos', 'Imprevistos', 'ICA', 'Coste Financiero', 

										   'Acarreos', 'Arrendamientos', 'Reparaciones', 'Profesionales', 'Seguros',

										   'Comunicaciones Celular', 'Aseo Vigilancia', 'Asistencia Tecnica', 'Envios Correos', 

										   'Otros Servicios', 'Combustible', 'Lavado Vehiculo', 'Gastos Viaje', 'Tiquetes Aereos',

										   'Aseo Cafeteria', 'Papeleria', 'Internet', 'Taxis Buses', 'Parqueaderos', 'Caja Menor',

										   'Peajes', 'Polizas', 'Materiales', 'MOD', 'MOI', 'TOES', 'Gas'); 

		

		

		

		/*setlocale(LC_MONETARY, 'en_US');

	

		$valor_pagar = money_format('%(#1n',$valor_pagar);

		$valor_reintegro = money_format('%(#1n',$reintegro);

		$valor_legalizado =  money_format('%(#1n',$valor_legalizado);*/ //FGR Provisional

		

	

?>

                <tr>

                    <td bgcolor="#CCCCCC"><?=$row_item['id']?></td>

                    <td><?=$proyecto?></td>

                    <td><?=$proveedor?></td>

                    <td><?=$tecnico?></td>

                    <td><?=$arrConcepto[$row_item['concepto']]?></td>

                    <td><?=$row_item['descripcion']?></td>
                    
                    <td><?=$row_item['fecha_ingreso']?></td>

                    <td>$<?=$row_item['valor']?></td>

                    <td><?=$row_item['fecha']?></td>

              </tr>

<?                 

	endwhile;

?>

	</table>
