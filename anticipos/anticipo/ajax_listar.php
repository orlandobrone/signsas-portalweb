<? header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
	include "../extras/php/basico.php";
	include "../extras/php/PHPPaging.lib.php";

	header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
	header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
	header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE
	
	/*$sqlfgr = "select id_regional AS regional, codigo_perfil AS perfil from usuario where id = ".$_SESSION['perfil'];
    $paifgr = mysql_query($sqlfgr);
    $usuariofgr=mysql_fetch_assoc($paifgr);
	$filtroRegion = '';
	if($usuariofgr['perfil'] != '5')
		$filtroRegion = 's.id_regional='.$usuariofgr['regional'].' and';*/

	$paging = new PHPPaging;
	$sql = "SELECT *, s.id AS ID, c.nombre AS centro_costo FROM anticipo AS s 
			LEFT JOIN centros_costos AS c ON  s.id_centroscostos = c.id ";
	if (isset($_GET['criterio_asignacions']))
		$sql .= " where nombre like '%".fn_filtro(substr($_GET['criterio_asignacion'], 0, 16))."%'";
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

<script> 
  $(function() {
    $( document ).tooltip({
      track: true
    });
  });
</script>
<table id="grilla" class="lista" width="690px">
  <thead>
        <tr>
            <th>ID</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Prioridad</th>
            <th>Nombre Responsable</th>
            <th>Cedula Responsable</th>
            <th>Centro Costo</th>
            <th>Valor Cotizado</th>
            <th>Total Anticipo</th>  
            <th>Beneficiario</th>            
           
            <th width="16px"><a href="javascript: fn_mostrar_frm_agregar();"><img src="../extras/ico/add.png"></a></th>
        </tr>
    </thead>
    <tbody>
    <?
        while ($rs_per = $paging->fetchResultado()){
    ?>
        <tr id="tr_<?=$rs_per['ID']?>">
        	<td><?=$rs_per['ID']?></td>
            <td><?php
			switch($rs_per['estado']):
				case 0:
					echo "No Revisado";
				break;
				case 1:
					echo "Aprobado";
				break;
				case 2:
					echo "Rechazado";
				break;
			endswitch;
			?></td>
            <td><?=$rs_per['fecha']?></td>
            <td><?=$rs_per['prioridad']?></td>            
            <td><?=$rs_per['nombre_responsable']?></td>
            <td><?=$rs_per['cedula_responsable']?></td>
            <td><?=$rs_per['centro_costo']?></td>  
            <td><?=$rs_per['v_cotizado']?></td>
            <td><?=$rs_per['total_anticipo']?></td>  
            <td><?=$rs_per['beneficiario']?></td>           
            <td><a href="javascript: fn_mostrar_frm_modificar(<?=$rs_per['ID']?>);"><img src="../extras/ico/page_edit.png" /></a></td>
            <td><a href="javascript: fn_eliminar(<?=$rs_per['ID']?>);"><img src="../extras/ico/delete.png" /></a></td>
            <?php if($rs_per['fecha_edit'] != '0000-00-00 00:00:00'): ?>
            <td><img title="Fecha Editado:<?=$rs_per['fecha_edit']?>" src="https://cdn1.iconfinder.com/data/icons/16x16-free-toolbar-icons/16/58.png" /></td>
       		<?php endif; ?>
        </tr>
    <? } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7">
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