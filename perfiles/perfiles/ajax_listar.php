<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";

	include "../extras/php/basico.php";

	include "../extras/php/PHPPaging.lib.php";



	header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada

	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos

	header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE

	header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE





	$paging = new PHPPaging;

	$sql = "select * from perfiles WHERE estado = 0";

	if (isset($_GET['criterio_usu_per']))

		$sql .= "  AND nombre like '%".fn_filtro(substr($_GET['criterio_usu_per'], 0, 16))."%'";

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

			<th>Estado</th>
            
            <th>Fecha de registro</th>

            <th></th>
			<? if(in_array(133,$_SESSION['permisos'])): ?>
            <th width="16px"><a href="javascript: fn_mostrar_frm_agregar();"><img src="../extras/ico/add.png"></a></th>
            <? endif; ?>

        </tr>

    </thead>

    <tbody>

    <?

        while ($rs_per = $paging->fetchResultado()){
			
			$estado = 'Activo';
			if($rs_per['estado'] == 1)
				$estado = 'Inactivo';

    ?>

        <tr id="tr_<?=$rs_per['id']?>">

        	<td><?=$rs_per['id']?></td>

            <td><?=$rs_per['nombre']?></td>

            <td><?=$rs_per['descripcion']?></td>

            <td><?=$estado?></td>
            
            <td><?=$rs_per['fecha']?></td>
					
            <td>
            	<? if(in_array(131,$_SESSION['permisos'])): ?>
            	<a href="javascript: fn_mostrar_frm_modificar(<?=$rs_per['id']?>);"><img src="../extras/ico/page_edit.png" /></a>
                <? endif; ?>
            </td>

            <td><a href="javascript: fn_eliminar(<?=$rs_per['id']?>);"><img src="../extras/ico/delete.png" /></a></td>

        </tr>

    <? } ?>

    </tbody>

    <tfoot>

        <tr>

            <td colspan="9">

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