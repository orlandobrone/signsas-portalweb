<?  header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";


	/*$sqlfgr = "SELECT opcion AS region FROM opciones_perfiles WHERE id_perfil = ".$_SESSION['perfil']." AND opcion > 100 ORDER BY id ASC";

    $paifgr = mysql_query($sqlfgr);

	

	$filtroRegion = '';

	$filtroRegion2 = '';

	$cont=0;

	while($usuariofgr = mysql_fetch_assoc($paifgr)){

		if($cont==0){

			$filtroRegion .= ' (';

		}

		$filtroRegion .= ' id_regional='.substr($usuariofgr['region'], 2).' or';

		$cont++;

	}

	if($cont>0){

		$filtroRegion = substr($filtroRegion, 0, -2).') and';

		$filtroRegion2 = ' and'.$filtroRegion;

		$filtroRegion2 = substr($filtroRegion2, 0, -3);

	}*/

	
	$filtroRegion = '';


	$pagenum = $_GET['pagenum'];

	$pagesize = $_GET['pagesize'];

	$start = $pagenum * $pagesize;

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM solicitud_despacho WHERE ".$filtroRegion." estado != 'draft' LIMIT $start, $pagesize";

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

				

				switch($_GET["filterdatafield" . $i]):

				

					case "id_proyecto":

					

						$ots_where;

						$sqlfgr2 = "SELECT id FROM proyectos WHERE ".$filtroRegion." nombre LIKE '%".strtoupper($_GET["filtervalue" . $i])."%'";

						$paifgr2 = mysql_query($sqlfgr2);		

						$total_rows2 = mysql_num_rows($paifgr2);

						if($total_rows2 == 0){

							$data[] = array(

								'TotalRows' => $total_rows2,

								'Rows' => NULL,

								'msj' => $sqlfgr2

							);

							echo json_encode($data);

							exit;

						}

						$filtervalue = '';

						$i2=0;

						

						while($otfgr = mysql_fetch_assoc($paifgr2)):

							if($i2==0):

								$ots_where .= ' AND id_proyecto = '.$otfgr['id'];

								$i2++;

							else:

								$ots_where .= ' OR id_proyecto = '.$otfgr['id'];

							endif;

						endwhile;

						

					 break;

					

				endswitch;

				

				

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

					$where .= ") ".$ots_where." AND estado != 'draft'";

				}

				

				$tmpfilteroperator = $filteroperator;

				$tmpdatafield = $filterdatafield;			

			}

			// build the query.

			$query = "SELECT * FROM solicitud_despacho ".$where." ".$filtroRegion2;

			$filterquery = $query;

			$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

			$rows = mysql_query($sql);

			$rows = mysql_fetch_assoc($rows);

			$new_total_rows = $rows['found_rows'];		

			$query = "SELECT * FROM solicitud_despacho ".$where." ".$filtroRegion2." LIMIT $start, $pagesize";		

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

					$query = "SELECT * FROM solicitud_despacho WHERE ".$filtroRegion." estado != 'draft' ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";

				}

				else if ($sortorder == "asc")

				{

					$query = "SELECT * FROM solicitud_despacho WHERE ".$filtroRegion." estado != 'draft' ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";

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

	

	

	//echo $query;	

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	$orders = null;

	// get data and store in a json array

	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		

		$sqlfgr2 = "SELECT nombre, id_regional FROM proyectos WHERE  id = ".$row['id_proyecto'];

		$paifgr2 = mysql_query($sqlfgr2);

		$otfgr=mysql_fetch_assoc($paifgr2);

		

		$customers[] = array(

			  'sql' => $sql,

			  'id' => $row['id'],

			  'nombre_responsable' => utf8_encode($row['nombre_responsable']),

			  'id_proyecto' => $otfgr['nombre'],
			  
			  'id_hito' => $row['id_hito'],

			  'direccion_entrega' => $row['direccion_entrega'],

			  'nombre_recibe' =>  utf8_encode($row['nombre_recibe']),

			  'celular' => $row['celular'],

			  'fecha_solicitud' => $row['fecha_solicitud'],

			  'fecha_entrega' => $row['fecha_entrega'],

			  'fecha' => $row['fecha'],

			  'acciones' => '<a href="javascript: fn_mostrar_frm_modificar('.$row['id'].');"><img src="https://cdn1.iconfinder.com/data/icons/humano2/16x16/actions/old-edit-find.png" /></a>'

		 );

		

	}

    $data[] = array(

       'TotalRows' => $total_rows,

	   'Rows' => $customers

	);

	echo json_encode($data);

?>