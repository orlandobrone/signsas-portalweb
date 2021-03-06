<? header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
	include "../extras/php/basico.php";
	include "../extras/php/PHPPaging.lib.php";

	header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
	header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
	header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE


	$paging = new PHPPaging;
	$sql = "select * from proyectos";
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
?>
<table id="grilla" class="lista" width="690px">
  <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Descripci&oacute;n</th>
            <th>Cliente</th>
            <th>Lugar de Ejecuci&oacute;n</th>
            <th>Estado</th>
            <th>Fecha inicio</th>
            <th>Fecha final</th>
            <th>Fecha final real</th>
            <th>Cotizaci&oacute;n</th>
            <th></th>
            <th width="16px"><a href="javascript: fn_mostrar_frm_agregar();"><img src="../extras/ico/add.png"></a></th>
        </tr>
    </thead>
    <tbody>
    <?
        while ($rs_per = $paging->fetchResultado()){
    ?>
        <tr id="tr_<?=$rs_per['id']?>">
        	<td><?=$rs_per['id']?></td>
            <td><?=($rs_per['nombre'])?></td>
            <td><?=($rs_per['descripcion'])?></td>
            <?php $sql2 = "select nombre from cliente where id = ".$rs_per['id_cliente'];
                  $pai2 = mysql_query($sql2); 
				  $rs_pai2 = mysql_fetch_assoc($pai2)?>
            <td><?=($rs_pai2['nombre'])?></td>
            <td><?=($rs_per['lugar_ejecucion'])?></td>
            <?php $estado = array('E'=>'En ejecuci&oacute;n', 'F'=>'Facturado', 'P'=>'Pendiente de Facturaci&oacute;n');?>
            <td><?=$estado[$rs_per['estado']]?></td>
            <td><?=$rs_per['fecha_inicio']?></td>
            <td><?=$rs_per['fecha_final']?></td>
            <td><?=$rs_per['fecha_final_real']?></td>
            <?php $sql3 = "select nombre from cotizacion where id = ".$rs_per['id_cotizacion'];
                  $pai3 = mysql_query($sql3); 
				  $rs_pai3 = mysql_fetch_assoc($pai3)?>
            <td><?=($rs_pai3['nombre'])?></td>
            <td>
            <?php if($rs_per['fecha_final_real'] == NULL):?>
            	<a href="javascript: fn_mostrar_frm_modificar(<?=$rs_per['id']?>);"><img src="../extras/ico/page_edit.png" /></a>
            <?php endif;?>
            </td>
            <td><a href="javascript: fn_eliminar(<?=$rs_per['id']?>);"><img src="../extras/ico/delete.png" /></a></td>
        </tr>
    <? } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="11">
				<? /*
					-- Aqui MOSTRAMOS MAS DETALLADAMENTE EL PAGINADO
					P�gina: <?=$paging->numEstaPagina()?>, de <?=$paging->numTotalPaginas()?><br />
					Mostrando: <?=$paging->numRegistrosMostrados()?> registros, del <?=$paging->numPrimerRegistro()?> al <?=$paging->numUltimoRegistro()?><br />
					De un total de: <?=$paging->numTotalRegistros()?><br />
                */ ?>
                <?=$paging->fetchNavegacion()?>
            </td>
        </tr>
    </tfoot>
</table>