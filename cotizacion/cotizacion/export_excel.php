<?php

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Cotizaciones_export_".date('d-m-Y').".xls");
	header("Content-Transfer-Encoding: binary ");

	include "../../conexion.php";
	include "../extras/php/basico.php"; 

	setlocale(LC_MONETARY, 'en_US');

	$query = "SELECT * 
			  FROM cotizacion
			  WHERE 1 ORDER BY id DESC";   

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

?>

	<table rules="all" border="1">

    	<tr bgcolor="#CCCCCC">

        	<td align="center"><strong>ID</strong></td>
            <td align="center"><strong>Nombre</strong></td>
            <td align="center"><strong>Descripcion</strong></td>
            
            <td align="center"><strong>Transporte</strong></td>
            <td align="center"><strong>Alquiler Vehiculos</strong></td>
            <td align="center"><strong>Imprevistos</strong></td>
            <td align="center"><strong>ICA</strong></td>
            <td align="center"><strong>Coste Financiero</strong></td>
            <td align="center"><strong>Acarreos</strong></td>
            <td align="center"><strong>Arrendamientos</strong></td>
            <td align="center"><strong>Reparaciones</strong></td>
            <td align="center"><strong>Profesionales</strong></td>
            <td align="center"><strong>Seguros</strong></td>
            <td align="center"><strong>Comunicaciones Celular</strong></td>
            <td align="center"><strong>Aseo/Vigilancia</strong></td>
            <td align="center"><strong>Asistencia Tecnica</strong></td>
            <td align="center"><strong>Envio Correos</strong></td>
            <td align="center"><strong>Otros Servicios</strong></td>
            <td align="center"><strong>Combustible</strong></td>
            <td align="center"><strong>Lavado Vehiculo</strong></td>
            <td align="center"><strong>Gastos Viaje</strong></td>
            <td align="center"><strong>Tiquete Areos</strong></td>
            <td align="center"><strong>Aseo Cafeteria</strong></td>
            <td align="center"><strong>Papeleria</strong></td>
            <td align="center"><strong>Internet</strong></td>
            <td align="center"><strong>Taxis/Buses</strong></td>
            <td align="center"><strong>Parqueaderos</strong></td>
            <td align="center"><strong>Caja Menor</strong></td>
            <td align="center"><strong>Peajes</strong></td>
            <td align="center"><strong>Polizas</strong></td>
            
            <td align="center"><strong>Transporte 2</strong></td>
            <td align="center"><strong>Alquiler Vehiculos 2</strong></td>
            <td align="center"><strong>Imprevistos 2</strong></td>
            <td align="center"><strong>ICA 2</strong></td>
            <td align="center"><strong>Coste Financiero 2</strong></td>
            <td align="center"><strong>Acarreos 2</strong></td>
            <td align="center"><strong>Arrendamientos 2</strong></td>
            <td align="center"><strong>Reparaciones 2</strong></td>
            <td align="center"><strong>Profesionales 2</strong></td>
            <td align="center"><strong>Seguros 2</strong></td>
            <td align="center"><strong>Comunicaciones Celular 2</strong></td>
            <td align="center"><strong>Aseo/Vigilancia 2</strong></td>
            <td align="center"><strong>Asistencia Tecnica 2</strong></td>
            <td align="center"><strong>Envio Correos 2</strong></td>
            <td align="center"><strong>Otros Servicios 2</strong></td>
            <td align="center"><strong>Combustible 2</strong></td>
            <td align="center"><strong>Lavado Vehiculo 2</strong></td>
            <td align="center"><strong>Gastos Viaje 2</strong></td>
            <td align="center"><strong>Tiquete Areos 2</strong></td>
            <td align="center"><strong>Aseo Cafeteria 2</strong></td>
            <td align="center"><strong>Papeleria 2</strong></td>
            <td align="center"><strong>Internet 2</strong></td>
            <td align="center"><strong>Taxis/Buses 2</strong></td>
            <td align="center"><strong>Parqueaderos 2</strong></td>
            <td align="center"><strong>Caja Menor 2</strong></td>
            <td align="center"><strong>Peajes 2</strong></td>
            <td align="center"><strong>Polizas 2</strong></td>
            
            
            <td align="center"><strong>Ganancia Adicional</strong></td>
            <td align="center"><strong>Materiales</strong></td>
            <td align="center"><strong>MOD</strong></td>
            <td align="center"><strong>MOI</strong></td>
            <td align="center"><strong>TOES</strong></td>
            
            
            <td align="center"><strong>Materiales 2</strong></td>
            <td align="center"><strong>MOD 2</strong></td>
            <td align="center"><strong>MOI 2</strong></td>
            <td align="center"><strong>TOES 2</strong></td>
            
            
            <td align="center"><strong>Fecha</strong></td>
            <td align="center"><strong>Estado</strong></td>            
        </tr>

<?php	

    $letters = array('.','$',',');
	$fruit   = array('');	
		
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)):

?>

        <tr>
        
          <td bgcolor="#CCCCCC"><?=$row['id']?></td>
          <td><?=$row['nombre']?></td>
          <td><?=$row['descripcion']?></td>
          
          <td><?=$row['transportes']?></td>
          <td><?=$row['alquileres_vehiculos']?></td>          
          <td><?=$row['imprevistos']?></td>
          <td><?=$row['ica']?></td>
          <td><?=$row['coste_financiero']?></td>
          <td><?=$row['acarreos']?></td>
          <td><?=$row['arrendamientos']?></td>
          <td><?=$row['reparaciones']?></td>
          <td><?=$row['profesionales']?></td>
          <td><?=$row['seguros']?></td>
          <td><?=$row['comunicaciones_celular']?></td>
          <td><?=$row['aseo_vigilancia']?></td>
          <td><?=$row['asistencia_tecnica']?></td>
          <td><?=$row['envios_correos']?></td>
          <td><?=$row['otros_servicios']?></td>
          <td><?=$row['combustible']?></td>
          <td><?=$row['lavado_vehiculo']?></td>
          <td><?=$row['gastos_viaje']?></td>
          <td><?=$row['tiquetes_aereos']?></td>
          <td><?=$row['aseo_cafeteria']?></td>
          <td><?=$row['papeleria']?></td>
          <td><?=$row['internet']?></td>
          <td><?=$row['taxis_buses']?></td>
          <td><?=$row['parqueaderos']?></td>
          <td><?=$row['caja_menor']?></td>
          <td><?=$row['peajes']?></td>
          <td><?=$row['polizas']?></td>
          
          
          <td><?=$row['transportes2']?></td>
          <td><?=$row['alquileres_vehiculos2']?></td>          
          <td><?=$row['imprevistos2']?></td>
          <td><?=$row['ica2']?></td>
          <td><?=$row['coste_financiero2']?></td>
          <td><?=$row['acarreos2']?></td>
          <td><?=$row['arrendamientos2']?></td>
          <td><?=$row['reparaciones2']?></td>
          <td><?=$row['profesionales2']?></td>
          <td><?=$row['seguros2']?></td>
          <td><?=$row['comunicaciones_celular2']?></td>
          <td><?=$row['aseo_vigilancia2']?></td>
          <td><?=$row['asistencia_tecnica2']?></td>
          <td><?=$row['envios_correos2']?></td>
          <td><?=$row['otros_servicios2']?></td>
          <td><?=$row['combustible2']?></td>
          <td><?=$row['lavado_vehiculo2']?></td>
          <td><?=$row['gastos_viaje2']?></td>
          <td><?=$row['tiquetes_aereos2']?></td>
          <td><?=$row['aseo_cafeteria2']?></td>
          <td><?=$row['papeleria2']?></td>
          <td><?=$row['internet2']?></td>
          <td><?=$row['taxis_buses2']?></td>
          <td><?=$row['parqueaderos2']?></td>
          <td><?=$row['caja_menor2']?></td>
          <td><?=$row['peajes2']?></td>
          <td><?=$row['polizas2']?></td>
          
          
          <td><?=$row['ganancia_adicional']?></td>
          <td><?=$row['materiales']?></td>
          <td><?=$row['MOD']?></td>
          <td><?=$row['MOI']?></td>
          <td><?=$row['TOES']?></td>
          
          <td><?=$row['materiales2']?></td>
          <td><?=$row['MOD2']?></td>
          <td><?=$row['MOI2']?></td>
          <td><?=$row['TOES2']?></td>
          
          <td><?=$row['fecha']?></td>
          <td><?=$row['estado']?></td>
         
        </tr>

<?
	endwhile;
?>
	</table>

    

