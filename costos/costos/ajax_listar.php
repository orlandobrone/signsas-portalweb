<? header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
	include "../extras/php/basico.php";
	include "../extras/php/PHPPaging.lib.php";

	header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
	header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
	header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE


	$paging = new PHPPaging;
	$sql = "select proyecto_costos.* from proyecto_costos, proyectos where proyecto_costos.id_proyecto=proyectos.id";
	if (isset($_GET['criterio_usu_per']))
		$sql .= " and proyectos.nombre like '%".fn_filtro(substr($_GET['criterio_usu_per'], 0, 16))."%'";
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
?>
<table id="grilla" class="lista" width="690px">
  <thead>
        <tr>
            <th>Id</th>
            <th>Proyecto</th>
            <th>Proveedor</th>
            <th>Técnico</th>            
            <th>Concepto</th>
            <th>Descripci&oacute;n</th>
            <th>Fecha de ingreso</th>
            <th>Valor</th>
            <th>Fecha de registro</th>
            <th></th>
            <th width="16px"><a href="javascript: fn_mostrar_frm_agregar();"><img src="../extras/ico/add.png"></a></th>
        </tr>
    </thead>
    <tbody>
    <?
        while ($rs_per = $paging->fetchResultado()){
			$qrPry = mysql_query("SELECT proyectos.nombre AS name_proyecto, proveedor.nombre AS name_proveedor, tecnico.nombre AS name_tecnico  
								  FROM proyectos AS proyectos
								  LEFT JOIN proveedor AS proveedor ON proveedor.id = ".$rs_per['id_proveedor']."
								  LEFT JOIN tecnico AS tecnico ON tecnico.id = ".$rs_per['id_tecnico']."
								  WHERE proyectos.id = '" . $rs_per['id_proyecto'] . "'");								  
			
			$rsPry = mysql_fetch_array($qrPry);
		
    ?>
    <?php $arrConcepto = array('', 'Transportes', 'Alquileres Vehiculos', 'Imprevistos', 'ICA', 'Coste Financiero', 
										   'Acarreos', 'Arrendamientos', 'Reparaciones', 'Profesionales', 'Seguros',
										   'Comunicaciones Celular', 'Aseo Vigilancia', 'Asistencia Tecnica', 'Envios Correos', 
										   'Otros Servicios', 'Combustible', 'Lavado Vehiculo', 'Gastos Viaje', 'Tiquetes Aereos',
										   'Aseo Cafeteria', 'Papeleria', 'Internet', 'Taxis Buses', 'Parqueaderos', 'Caja Menor',
										   'Peajes', 'Polizas', 'Materiales', 'MOD', 'MOI', 'TOES', 'Gas'); ?>
        <tr id="tr_<?=$rs_per['id']?>">
        	<td><?=$rs_per['id']?></td>
            <td><?=($rsPry['name_proyecto'])?></td>
            <td><?=($rsPry['name_proveedor'])?></td>
            <td><?=($rsPry['name_tecnico'])?></td>
            <td><?=$arrConcepto[$rs_per['concepto']]?></td>
            <td><?=($rs_per['descripcion'])?></td>
            <td><?=$rs_per['fecha_ingreso']?></td>
            <td><?=number_format($rs_per['valor'], 2, '.', ',')?></td>
            <td><?=$rs_per['fecha']?></td>
            <td><a href="javascript: fn_mostrar_frm_modificar(<?=$rs_per['id']?>);"><img src="../extras/ico/page_edit.png" /></a></td>
            <td><a href="javascript: fn_eliminar(<?=$rs_per['id']?>);"><img src="../extras/ico/delete.png" /></a></td>
        </tr>
    <? } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="10">
				<? /*
					-- Aqui MOSTRAMOS MAS DETALLADAMENTE EL PAGINADO
					Página: <?=$paging->numEstaPagina()?>, de <?=$paging->numTotalPaginas()?><br />
					Mostrando: <?=$paging->numRegistrosMostrados()?> registros, del <?=$paging->numPrimerRegistro()?> al <?=$paging->numUltimoRegistro()?><br />
					De un total de: <?=$paging->numTotalRegistros()?><br />
                */ ?>
                <?=$paging->fetchNavegacion()?>
            </td>
        </tr>
    </tfoot>
</table>