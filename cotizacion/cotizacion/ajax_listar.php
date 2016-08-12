<? header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
	include "../extras/php/basico.php";
	include "../extras/php/PHPPaging.lib.php";

	header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
	header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
	header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE


	$paging = new PHPPaging;
	$sql = "select * from cotizacion";
	if (isset($_GET['criterio_usu_per']))
		$sql .= " where nombre like '%".fn_filtro(substr($_GET['criterio_usu_per'], 0, 16))."%'";
	if (isset($_GET['criterio_ordenar_por']))
		$sql .= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
	else
		$sql .= " order by id desc";
	$paging->agregarConsulta($sql); 
	$paging->div('div_listar');
	$paging->modo('desarrollo'); 
	if (isset($_GET['criterio_mostrar']))
		$paging->porPagina(fn_filtro((int)$_GET['criterio_mostrar']));
	$paging->verPost(true);
	$paging->mantenerVar("criterio_usu_per", "criterio_ordenar_por", "criterio_orden", "criterio_mostrar");
	$paging->ejecutar();
	
	
function costoReal($proyecto){		
	
	if ($proyecto != '*' && $proyecto != ''):
	
		$sql = "SELECT *
				FROM cotizacion 
				WHERE id = {$proyecto} ";
				
		$qrCostos = mysql_query($sql); 
		$rowsCostos = mysql_fetch_array($qrCostos);
		
		$vowels = array(",");	
		
	   /* $nombreProyecto = $rowsCostos['nombre'];
	    $costoReal = (int)$rowsCostos['SumaTotal'];
		$descriptionProyect = $rowsCostos['description'];*/
		
	    $costoPresu =       + (int)str_replace($vowels, "", $rowsCostos['transportes'])
							+ (int)str_replace($vowels, "", $rowsCostos['alquileres_vehiculos'])
							+ (int)str_replace($vowels, "", $rowsCostos['imprevistos'])
							+ (int)str_replace($vowels, "", $rowsCostos['ica'] )
							+ (int)str_replace($vowels, "", $rowsCostos['coste_financiero']) 
							+ (int)str_replace($vowels, "", $rowsCostos['acarreos'] )							
							+ (int)str_replace($vowels, "", $rowsCostos['arrendamientos'] )
							+ (int)str_replace($vowels, "", $rowsCostos['reparaciones'])
							+ (int)str_replace($vowels, "", $rowsCostos['profesionales'])
							+ (int)str_replace($vowels, "", $rowsCostos['seguros'])
							+ (int)str_replace($vowels, "", $rowsCostos['comunicaciones_celular'])
							+ (int)str_replace($vowels, "", $rowsCostos['aseo_vigilancia'])
							+ (int)str_replace($vowels, "", $rowsCostos['asistencia_tecnica'])
							+ (int)str_replace($vowels, "", $rowsCostos['envios_correos'])
							+ (int)str_replace($vowels, "", $rowsCostos['otros_servicios'])
							+ (int)str_replace($vowels, "", $rowsCostos['combustible'])
							+ (int)str_replace($vowels, "", $rowsCostos['lavado_vehiculo'])
							+ (int)str_replace($vowels, "", $rowsCostos['gastos_viaje'])
							+ (int)str_replace($vowels, "", $rowsCostos['tiquetes_aereos'])
							+ (int)str_replace($vowels, "", $rowsCostos['aseo_cafeteria'])
							+ (int)str_replace($vowels, "", $rowsCostos['papeleria'])
							+ (int)str_replace($vowels, "", $rowsCostos['internet'])
							+ (int)str_replace($vowels, "", $rowsCostos['taxis_buses'])
							+ (int)str_replace($vowels, "", $rowsCostos['parqueaderos'])
							+ (int)str_replace($vowels, "", $rowsCostos['caja_menor'])
							+ (int)str_replace($vowels, "", $rowsCostos['peajes'])
							+ (int)str_replace($vowels, "", $rowsCostos['polizas'])
							+ (int)str_replace($vowels, "", $rowsCostos['materiales'])	
							+ (int)str_replace($vowels, "", $rowsCostos['MOD'])	
			 				+ (int)str_replace($vowels, "", $rowsCostos['MOI'])	
							+ (int)str_replace($vowels, "", $rowsCostos['TOES']);
							
	  $ventaTotal   =       + (int)str_replace($vowels, "", $rowsCostos['transportes2'])
							+ (int)str_replace($vowels, "", $rowsCostos['alquileres_vehiculos2'])
							+ (int)str_replace($vowels, "", $rowsCostos['imprevistos2'])
							+ (int)str_replace($vowels, "", $rowsCostos['ica2'] )
							+ (int)str_replace($vowels, "", $rowsCostos['coste_financiero2']) 
							+ (int)str_replace($vowels, "", $rowsCostos['acarreos2'] )							
							+ (int)str_replace($vowels, "", $rowsCostos['arrendamientos2'] )
							+ (int)str_replace($vowels, "", $rowsCostos['reparaciones2'])
							+ (int)str_replace($vowels, "", $rowsCostos['profesionales2'])
							+ (int)str_replace($vowels, "", $rowsCostos['seguros2'])
							+ (int)str_replace($vowels, "", $rowsCostos['comunicaciones_celular2'])
							+ (int)str_replace($vowels, "", $rowsCostos['aseo_vigilancia2'])
							+ (int)str_replace($vowels, "", $rowsCostos['asistencia_tecnica2'])
							+ (int)str_replace($vowels, "", $rowsCostos['envios_correos2'])
							+ (int)str_replace($vowels, "", $rowsCostos['otros_servicios2'])
							+ (int)str_replace($vowels, "", $rowsCostos['combustible2'])
							+ (int)str_replace($vowels, "", $rowsCostos['lavado_vehiculo2'])
							+ (int)str_replace($vowels, "", $rowsCostos['gastos_viaje2'])
							+ (int)str_replace($vowels, "", $rowsCostos['tiquetes_aereos2'])
							+ (int)str_replace($vowels, "", $rowsCostos['aseo_cafeteria2'])
							+ (int)str_replace($vowels, "", $rowsCostos['papeleria2'])
							+ (int)str_replace($vowels, "", $rowsCostos['internet2'])
							+ (int)str_replace($vowels, "", $rowsCostos['taxis_buses2'])
							+ (int)str_replace($vowels, "", $rowsCostos['parqueaderos2'])
							+ (int)str_replace($vowels, "", $rowsCostos['caja_menor2'])
							+ (int)str_replace($vowels, "", $rowsCostos['peajes2'])
							+ (int)str_replace($vowels, "", $rowsCostos['polizas2'])
							+ (int)str_replace($vowels, "", $rowsCostos['materiales2'])	
							+ (int)str_replace($vowels, "", $rowsCostos['MOD2'])	
			 				+ (int)str_replace($vowels, "", $rowsCostos['MOI2'])	
							+ (int)str_replace($vowels, "", $rowsCostos['TOES2']);
		
	endif;
	
	
	return $arrayData = array('costoTotal' =>$costoPresu, 'ventaTotal'=>$ventaTotal);
}


?>
<table id="grilla" class="lista" width="690px">
  <thead>
        <tr>
            <th>Id</th>
            <th>Nombre Cotizaci&oacute;n</th>
            <th>Descripci&oacute;n</th>
            <th>Precio de venta Total</th>
            <th>Costo Total</th>
            <th>Factor Utilidad</th>
            <th></th>
            <th width="16px"><a href="javascript: fn_mostrar_frm_agregar();"><img src="../extras/ico/add.png"></a></th>
        </tr>
    </thead>
    <tbody>
    <?
        while ($rs_per = $paging->fetchResultado()){
		
		$data = costoReal($rs_per['id']);
		$ventaTotal = $data['ventaTotal'];
		$costoTotal = $data['costoTotal'];
			
    ?>
        <tr id="tr_<?=$rs_per['id']?>">
        	<td><?=$rs_per['id']?></td>
            <td><?=($rs_per['nombre'])?></td>
            <td><?=($rs_per['descripcion'])?></td>
            <td><?php echo '$'.number_format($ventaTotal)?></td>
            <td><?php echo '$'.number_format($costoTotal)?></td>
            <td><?php echo '$'.$rs_per['ganancia_adicional']?></td>
            <td><a href="javascript: fn_mostrar_frm_modificar(<?=$rs_per['id']?>);"><img src="../extras/ico/page_edit.png" /></a></td>
            <td><a href="javascript: fn_eliminar(<?=$rs_per['id']?>);"><img src="../extras/ico/delete.png" /></a></td>
        </tr>
    <? } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5">
				<? /*
					-- Aqui MOSTRAMOS MAS DETALLADAMENTE EL PAGINADO
					P&aacute;gina: <?=$paging->numEstaPagina()?>, de <?=$paging->numTotalPaginas()?><br />
					Mostrando: <?=$paging->numRegistrosMostrados()?> registros, del <?=$paging->numPrimerRegistro()?> al <?=$paging->numUltimoRegistro()?><br />
					De un total de: <?=$paging->numTotalRegistros()?><br />
                */ ?>
                <?=$paging->fetchNavegacion()?>
            </td>
        </tr>
    </tfoot>
</table>