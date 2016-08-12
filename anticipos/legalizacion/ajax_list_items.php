<?php

include "../../conexion.php";

/*

$total = 0;

$resultado = mysql_query("	SELECT * FROM items WHERE id_legalizacion =".$_GET['id']) or die(mysql_error());

$total = mysql_num_rows($resultado);





$query = isset($_POST['query']) ? $_POST['query'] : false;

$page = isset($_POST['page']) ? $_POST['page'] : 1;

$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;

$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'name';

$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';



$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : false;



header("Content-type: application/json");



$jsonData = array('page'=>$page,'total'=>$total,'rows'=>array());





if($total > 0):



	while ($row = mysql_fetch_assoc($resultado)):

	//Only cell's with named keys and matching columns are order independent.

	

		$entry = array('id'=>$row['id'],

				'cell'=>array(

					'item'=>$row['id'],

					'fecha'=>$row['fecha'],

					'beneficiario'=>$row['beneficiario'],

					'nitccident'=>$row['nitccident'],

					'centro_costos'=>$row['centro_costos'],

					'concepto'=>$row['concepto'],

					'pagado'=>$row['pagado']				

				),

		);

		

		

		$jsonData['rows'][] = $entry;

	

	endwhile;

endif;



echo json_encode($jsonData);*/



	$pagenum = $_GET['pagenum'];

	$pagesize = $_GET['pagesize'];

	$start = $pagenum * $pagesize;

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM items WHERE estado = 0 AND id_legalizacion =".$_GET['id']." LIMIT $start, $pagesize";

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

			$where = " AND (";

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

					$where .= ") AND estado = 0 AND id_legalizacion =".$_GET['id']." ";

				}

				

				$tmpfilteroperator = $filteroperator;

				$tmpdatafield = $filterdatafield;			

			}

			// build the query.

			$query = "SELECT * FROM items ".$where;

			$filterquery = $query;

			$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

			$rows = mysql_query($sql);

			$rows = mysql_fetch_assoc($rows);

			$new_total_rows = $rows['found_rows'];		

			$query = "SELECT * FROM items ".$where." LIMIT $start, $pagesize";		

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

					$query = "SELECT * FROM items  WHERE estado = 0 AND id_legalizacion =".$_GET['id']." ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";

				}

				else if ($sortorder == "asc")

				{

					$query = "SELECT * FROM items  WHERE estado = 0 AND id_legalizacion =".$_GET['id']." ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";

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

	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		

		  $sql4 = "SELECT o.orden_trabajo AS ot, h.nombre AS nombre_hito FROM  orden_trabajo AS o

				   INNER JOIN hitos AS h ON h.id = ".$row['id_hito']."

				   WHERE o.id_proyecto = ".$row['id_proyecto'];

		  $pai4 = mysql_query($sql4); 

		  $rs_pai4 = mysql_fetch_assoc($pai4);	
		  
		  $sql5 = "SELECT * FROM conceptos_legalizacion

				   WHERE id = ".$row['concepto'];

		  $pai5 = mysql_query($sql5); 

		  $rs_pai5 = mysql_fetch_assoc($pai5);

		  

		  //echo $rs_pai4['nombre_hito'];

		

		

		  $customers[] = array(

			'id'=>$row['id'],
			
			'id_hito'=>$row['id_hito'],

			//'fecha'=>$row['fecha'],

			//'beneficiario'=>$row['beneficiario'],

			//'nitccident'=>$row['nitccident'],

			//'centro_costos'=>$row['centro_costos'],

			'concepto'=>$rs_pai5['concepto'],

			'pagado'=>$row['pagado'],

			'hito'=>utf8_encode($rs_pai4['nombre_hito']),

			'cantidad_recibida'=>$row['cantidad_recibida'],		

			'acciones' => '<a href="javascript:" onclick="fn_borrar('.$row['id'].');"><img src="https://cdn1.iconfinder.com/data/icons/diagona/icon/16/101.png"/></a>'

		  );

	}

    $data[] = array(

       'TotalRows' => $total_rows,

	   'Rows' => $customers

	);

	echo json_encode($data);