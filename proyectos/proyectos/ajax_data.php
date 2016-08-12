<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";
	
	#Include the connect.php file

	#Connect to the database

	//connection String	

	// get data and store in a json array

	if(!in_array(111,$_SESSION['permisos']))
		$estadosql = '1';
	else
		$estadosql = 'estado IN("F","E","P","ELIMINADO")';


	$pagenum = $_GET['pagenum'];

	$pagesize = $_GET['pagesize'];

	$start = $pagenum * $pagesize;

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM proyectos WHERE ".$estadosql." LIMIT $start, $pagesize";

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

	$rows = mysql_query($sql);

	$rows = mysql_fetch_assoc($rows);

	$total_rows = $rows['found_rows'];

	$filterquery = "";

	

	// filter data.

	if (isset($_GET['filterscount']))

	{

		$filterscount = $_GET['filterscount'];

		

		if ($filterscount > 0)

		{

			$where = " WHERE (";

			$tmpdatafield = "";

			$tmpfilteroperator = "";

			for ($i=0; $i < $filterscount; $i++)

		    {

				// get the filter's value.

				$filtervalue = $_GET["filtervalue" . $i];

				// get the filter's condition.

				$filtercondition = $_GET["filtercondition" . $i];

				// get the filter's column.

				$filterdatafield = $_GET["filterdatafield" . $i];

				// get the filter's operator.

				$filteroperator = $_GET["filteroperator" . $i];

				

				if($filterdatafield == 'estado'){

					$estado = array('En Ejecución'=>'E', 'Facturado'=>'F', 'Pendiente de Facturación'=>'P');

					$filtervalue = $estado[$filtervalue];

				}

				

				$idsProyectos = '';

				

				if($filterdatafield == 'id_cliente'){

					

					$query_p = "SELECT p.id AS idproyecto FROM proyectos p, cliente c WHERE c.nombre LIKE '%".$filtervalue."%' AND p.id_cliente = c.id";

					$results_p = mysql_query($query_p);

					

					while($rowp = mysql_fetch_assoc($results_p)):

						$idsProyectos .= ' OR id='.$rowp['idproyecto'];

					endwhile;

					

					//$filtervalue = $estado[$filtervalue];

				}

				

				if ($tmpdatafield == "")

				{

					$tmpdatafield = $filterdatafield;			

				}

				else if ($tmpdatafield <> $filterdatafield)

				{

					$where .= ")AND(";

				}

				else if ($tmpdatafield == $filterdatafield)

				{

					if ($tmpfilteroperator == 0)

					{

						$where .= " AND ";

					}

					else $where .= " OR ";	

				}

				

				// build the "WHERE" clause depending on the filter's condition, value and datafield.

				switch($filtercondition)

				{

					case "NOT_EMPTY":

					case "NOT_NULL":

						$where .= " " . $filterdatafield . " NOT LIKE '" . "" ."'";

						break;

					case "EMPTY":

					case "NULL":

						$where .= " " . $filterdatafield . " LIKE '" . "" ."'";

						break;

					case "CONTAINS_CASE_SENSITIVE":

						$where .= " BINARY  " . $filterdatafield . " LIKE '%" . $filtervalue ."%'";

						break;

					case "CONTAINS":

						$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."%'";

						break;

					case "DOES_NOT_CONTAIN_CASE_SENSITIVE":

						$where .= " BINARY " . $filterdatafield . " NOT LIKE '%" . $filtervalue ."%'";

						break;

					case "DOES_NOT_CONTAIN":

						$where .= " " . $filterdatafield . " NOT LIKE '%" . $filtervalue ."%'";

						break;

					case "EQUAL_CASE_SENSITIVE":

						$where .= " BINARY " . $filterdatafield . " = '" . $filtervalue ."'";

						break;

					case "EQUAL":

						$where .= " " . $filterdatafield . " = '" . $filtervalue ."'";

						break;

					case "NOT_EQUAL_CASE_SENSITIVE":

						$where .= " BINARY " . $filterdatafield . " <> '" . $filtervalue ."'";

						break;

					case "NOT_EQUAL":

						$where .= " " . $filterdatafield . " <> '" . $filtervalue ."'";

						break;

					case "GREATER_THAN":

						$where .= " " . $filterdatafield . " > '" . $filtervalue ."'";

						break;

					case "LESS_THAN":

						$where .= " " . $filterdatafield . " < '" . $filtervalue ."'";

						break;

					case "GREATER_THAN_OR_EQUAL":

						$where .= " " . $filterdatafield . " >= '" . $filtervalue ."'";

						break;

					case "LESS_THAN_OR_EQUAL":

						$where .= " " . $filterdatafield . " <= '" . $filtervalue ."'";

						break;

					case "STARTS_WITH_CASE_SENSITIVE":

						$where .= " BINARY " . $filterdatafield . " LIKE '" . $filtervalue ."%'";

						break;

					case "STARTS_WITH":

						$where .= " " . $filterdatafield . " LIKE '" . $filtervalue ."%'";

						break;

					case "ENDS_WITH_CASE_SENSITIVE":

						$where .= " BINARY " . $filterdatafield . " LIKE '%" . $filtervalue ."'";

						break;

					case "ENDS_WITH":

						$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."'";

						break;

				}

								

				if ($i == $filterscount - 1)

				{

					$where .= ") AND ".$estadosql." ".$idsProyectos;

				}

				

				$tmpfilteroperator = $filteroperator;

				$tmpdatafield = $filterdatafield;			

			}

			// build the query.

			$query = "SELECT * FROM proyectos ".$where;

			$filterquery = $query;

			$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

			$rows = mysql_query($sql);

			$rows = mysql_fetch_assoc($rows);

			$new_total_rows = $rows['found_rows'];		

			$query = "SELECT * FROM proyectos ".$where." ".$idProyectos."  LIMIT $start, $pagesize";		

			$total_rows = $new_total_rows;	

		}

	}

	

	if (isset($_GET['sortdatafield']))

	{

	

		$sortfield = $_GET['sortdatafield'];

		$sortorder = $_GET['sortorder'];

		

		if ($sortorder != '')

		{

			if ($_GET['filterscount'] == 0)

			{

				if ($sortorder == "desc")

				{

					$query = "SELECT * FROM proyectos WHERE ".$estadosql." ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";

				}

				else if ($sortorder == "asc")

				{

					$query = "SELECT * FROM proyectos WHERE ".$estadosql." ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";

				}

			}

			else

			{

				if ($sortorder == "desc")

				{

					$filterquery .= " ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";

				}

				else if ($sortorder == "asc")	

				{

					$filterquery .= " ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";

				}

				$query = $filterquery;

			}		

		}

	}

	

	

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	$orders = null;

	// get data and store in a json array

	$estado = array('E'=>'En ejecuci&oacute;n', 'F'=>'Facturado', 'P'=>'Pendiente de Facturaci&oacute;n','ELIMINADO'=>'ELIMINADO');
	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {


		$ots = '';

		
		$sqlr = "SELECT nombre, (SELECT nombre FROM actividad WHERE id = ".$row['actividad_id'].") AS actividad
				 FROM linea_negocio where id = ".$row['linea_negocio_id'];
        $pair = mysql_query($sqlr); 
		$rs_pairA = mysql_fetch_assoc($pair);

		$sql2 = "select nombre from cliente where id = ".$row['id_cliente'];
        $pai2 = mysql_query($sql2); 
		$rs_pai2 = mysql_fetch_assoc($pai2);		


		$sql4 = "SELECT count(*) AS total FROM `orden_trabajo` WHERE id_proyecto = ".$row['id'];
        $pai4 = mysql_query($sql4); 
		$rs_pai4 = mysql_fetch_assoc($pai4);
		

		if($rs_pai4['total'] == 0){

			$ots = '&nbsp;<a href="javascript: fn_crear_ots('.$row['id'].');" title="Crear OTs"><img src="https://cdn2.iconfinder.com/data/icons/facebook-svg-icons-1/64/friend_finder-16.png" /></a>';

		}

		if(in_array(111,$_SESSION['permisos']))
			$eliminar = '<a title="Eliminar" href="javascript: fn_eliminar('.$row['id'].');"><img src="../extras/ico/delete.png" /></a>';
		else
			$eliminar = '';
			
			
		
		$sqlr = "SELECT COUNT(*) AS total_facturados, 
				(SELECT COUNT(*) FROM hitos WHERE estado NOT IN('ELIMINADO') AND id_proyecto = ".$row['id'].") AS total_hitos,
				(SELECT COUNT(*) FROM hitos WHERE estado IN('LIQUIDADO') AND id_proyecto = ".$row['id'].") AS total_hitos_liquidatos 
				FROM hitos WHERE estado IN('FACTURADO') AND id_proyecto = ".$row['id'];
		$pair = mysql_query($sqlr); 	
		$rs_pair = mysql_fetch_assoc($pair);
			
		//T. Facturado = '.$rs_pair['total_facturados'].' = Total hitos = '.$rs_pair['total_hitos'].'	
		$alerta = '';
		if($rs_pair['total_facturados'] == $rs_pair['total_hitos'] && $rs_pair['total_facturados'] > 0):
			$alerta = ' <a title="Hitos Facturados" href="javascript: fn_viewhitos('.$row['id'].');"><img src="https://cdn4.iconfinder.com/data/icons/6x16-free-application-icons/16/Error.png" /></a>';
		elseif($rs_pair['total_hitos_liquidatos'] > 0):
			$alerta = ' <a title="Hitos Liquidados" href="javascript: fn_viewhitos('.$row['id'].');"><img src="https://cdn4.iconfinder.com/data/icons/6x16-free-application-icons/16/Warning.png" /></a>';
		else:
			$alerta = ' <a title="Hitos" href="javascript: fn_viewhitos('.$row['id'].');"><img src="https://cdn0.iconfinder.com/data/icons/octicons/1024/alert-16.png" /></a>';
		endif;
		

		$customers[] = array(

			'id' => $row['id'],

			'nombre' => $row['nombre'],

			'descripcion' =>  utf8_encode($row['descripcion']),
			
			'regional' =>  $row['lugar_ejecucion'],

			'id_cliente' => $rs_pai2['nombre'],

			'linea_negocio_id' => $rs_pairA['nombre'],
			
			'actividad_id' => $rs_pairA['actividad'],

			'estado' => $estado[$row['estado']],

			'fecha_inicio' => $row['fecha_inicio'],

			'fecha_final' => $row['fecha_final'],

			'acciones' => '<a title="Editar'.$rs_pai4['total'].'" href="javascript: fn_mostrar_frm_modificar('.$row['id'].');"><img src="../extras/ico/page_edit.png" /></a>&nbsp;'.$eliminar.''.$ots.''.$alerta

		  );

	}

    $data[] = array(

       'TotalRows' => $total_rows,

	   'Rows' => $customers

	);

	echo json_encode($data);

?>