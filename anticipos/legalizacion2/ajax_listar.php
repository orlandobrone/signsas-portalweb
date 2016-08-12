<? header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
	include "../extras/php/basico.php";
	include "../extras/php/PHPPaging.lib.php";

	header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
	header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
	header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE


	$paging = new PHPPaging;
	$sql = "SELECT * FROM legalizacion AS s ";
	
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
            <th>Responsable</th>
            <th>Fecha</th>
            <th>N&deg;. de Caja</th>
            <th>Valor Fondo/Anticipo</th>
            <th>Valor Legalizado</th>
            <th>Valor a Pagar</th>
            <th>Legalizacion(L) o Reintego(R)</th>  
            <th>Estado</th>  
            <!--<th width="16px"><a href="javascript: fn_mostrar_frm_agregar();"><img src="../extras/ico/add.png"></a></th>-->
        </tr>
    </thead>
    <tbody>
    <?
        while ($rs_per = $paging->fetchResultado()){
    ?>
        <tr id="tr_<?=$rs_per['id']?>">
        	<td><?=$rs_per['id']?></td>
            <td><?=$rs_per['responsable']?></td>
            <td><?=$rs_per['fecha']?></td>
            <td><?=$rs_per['num_caja']?></td>            
            <td><?=$rs_per['valor_fa']?></td>
            <td><?=$rs_per['valor_legalizado']?></td>
            <td><?=$rs_per['valor_pagar']?></td>  
            <td><?=$rs_per['lega_rein']?></td> 
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
            <td><a href="javascript: fn_mostrar_frm_add_items(<?=$rs_per['id']?>);"><img src="https://cdn1.iconfinder.com/data/icons/fugue/icon_shadowless/application-sidebar-list.png"></a></td>
            <td><a href="javascript: fn_mostrar_frm_modificar(<?=$rs_per['id']?>);"><img src="../extras/ico/page_edit.png" /></a></td>
            <?php if($rs_per['fecha_edit'] != '0000-00-00 00:00:00'): ?>
            <td><img title="Fecha Editado:<?=$rs_per['fecha_edit']?>" src="https://cdn1.iconfinder.com/data/icons/16x16-free-toolbar-icons/16/58.png" /></td>
       		<?php endif; ?>
            <!--<td><a href="javascript: fn_eliminar(<?=$rs_per['id']?>);"><img src="../extras/ico/delete.png" /></a></td>-->
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