<? header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
	include "../extras/php/basico.php";
	include "../extras/php/PHPPaging.lib.php";

	header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
	header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
	header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE


	$paging = new PHPPaging;
	$sql = "select ingreso_mercancia.* from ingreso_mercancia, inventario, proveedor where ingreso_mercancia.id_material=inventario.id and ingreso_mercancia.id_proveedor=proveedor.id";
	if (isset($_GET['criterio_usu_per']))
		$sql .= " and ingreso_mercancia.nfactura like '%".fn_filtro(substr($_GET['criterio_usu_per'], 0, 16))."%'";
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
            <th>Material</th>
            <th>Cantidad</th>
            <th>Costo</th>
            <th>No. Factura</th>
            <th>Proveedor</th>
            <th>Fecha de registro</th>
            <th></th>
            <th width="16px"><a href="javascript: fn_mostrar_frm_agregar();"><img src="../../ingreso_mercancia/extras/ico/add.png"></a></th>
        </tr>
    </thead>
    <tbody>
    <?
        while ($rs_per = $paging->fetchResultado()){
			$sqlMat = "SELECT nombre_material FROM inventario WHERE id = '" . $rs_per['id_material'] . "'";
			$rsMat = mysql_query($sqlMat);
			$fetchMat = mysql_fetch_assoc($rsMat); 

			$sqlProv = "SELECT nombre FROM proveedor WHERE id = '" . $rs_per['id_proveedor'] . "'";
			$rsProv = mysql_query($sqlProv);
			$fetchProv = mysql_fetch_array($rsProv); 
    ?>
        <tr id="tr_<?=$rs_per['id']?>">
        	<td><?=$rs_per['id']?></td>
            <td><?=($fetchMat['nombre_material'])?></td>
            <td><?=$rs_per['cantidad']?></td>
            <td><?=number_format($rs_per['costo'], 2, '.', ',')?></td>
            <td><?=$rs_per['nfactura']?></td>
            <td><?=($fetchProv['nombre'])?></td>
            <td><?=$rs_per['fecha']?></td>
            <td><a href="javascript: fn_mostrar_frm_modificar(<?=$rs_per['id']?>);"><img src="../../ingreso_mercancia/extras/ico/page_edit.png" /></a></td>
            <td><a href="javascript: fn_eliminar(<?=$rs_per['id']?>);"><img src="../../ingreso_mercancia/extras/ico/delete.png" /></a></td>
        </tr>
    <? } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="8">
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