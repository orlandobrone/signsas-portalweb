<? header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
	include "../extras/php/basico.php";
	include "../extras/php/PHPPaging.lib.php";

	header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
	header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
	header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE


	$paging = new PHPPaging;
	$sql = "select *, solicitud_despacho.id AS id_despacho FROM solicitud_despacho, usuario where solicitud_despacho.id_usuario=usuario.id";
	if (isset($_GET['criterio_usu_per']))
		$sql .= " and solicitud_despacho.descripcion like '%".fn_filtro(substr($_GET['criterio_usu_per'], 0, 16))."%'";
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
            <th>Usuario</th>
            <th>Descripci&oacute;n</th>
            <th>Fecha de solicitud</th>
            <th>Fecha de despacho</th>
            <th>Fecha de entrega</th>
            <th>Direcci&oacute;n de entrega</th>
            <th>Nombre de quien recibe</th>
            <th>Tel&eacute;fono</th>
            <th>Celular</th>
            <th>Fecha de registro</th> 
            <th></th>
            <th width="16px"><a href="javascript: fn_mostrar_frm_agregar();"><img src="../extras/ico/add.png"></a></th>
        </tr>
    </thead>
    <tbody>
    <?
        while ($rs_per = $paging->fetchResultado()){
			$qrUsuario = mysql_query("SELECT nombres FROM usuario WHERE id = '" . $rs_per['id_usuario'] . "'");
			$rsUsuario = mysql_fetch_array($qrUsuario);
    ?>
        <tr id="tr_<?=$rs_per['id_despacho']?>">
        	<td><?=$rs_per['id_despacho']?></td>
            <td><?=($rsUsuario['nombres'])?></td>
            <td><?=($rs_per['descripcion'])?></td>
            <td><?=$rs_per['fecha_solicitud']?></td>
            <td><?=$rs_per['fecha_despacho']?></td>
            <td><?=$rs_per['fecha_entrega']?></td>
            <td><?=($rs_per['direccion_entrega'])?></td>
            <td><?=($rs_per['nombre_recibe'])?></td>
            <td><?=$rs_per['telefono']?></td>
            <td><?=$rs_per['celular']?></td>
            <td><?=$rs_per['fecha']?></td>
            <td><a href="javascript: fn_mostrar_frm_modificar(<?=$rs_per['id_despacho']?>);"><img src="../extras/ico/page_edit.png" /></a></td>
            <td><a href="javascript: fn_eliminar(<?=$rs_per['id_despacho']?>);"><img src="../extras/ico/delete.png" /></a></td>
             <td><a href="javascript: fn_addmateriales(<?=$rs_per['id_despacho']?>);"><img src="../extras/ico/add.png" /></a></td>
        </tr>
    <? } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="12">
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