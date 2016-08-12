<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";

	#Include the connect.php file

	#Connect to the database

	//connection String	

	// get data and store in a json array



	$pagenum = $_GET['pagenum'];

	$pagesize = $_GET['pagesize'];

	$start = $pagenum * $pagesize;

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM materiales WHERE aprobado != 5 AND id_despacho = ".$_GET['id'];

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

					$where .= ") AND aprobado != 5 AND id_despacho = ".$_GET['id']."";

				}

				

				$tmpfilteroperator = $filteroperator;

				$tmpdatafield = $filterdatafield;			

			}

			// build the query.

			$query = "SELECT * FROM materiales ".$where;

			$filterquery = $query;

			$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

			$rows = mysql_query($sql);

			$rows = mysql_fetch_assoc($rows);

			$new_total_rows = $rows['found_rows'];		

			$query = "SELECT * FROM materiales ".$where;		

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

					$query = "SELECT * FROM materiales WHERE aprobado != 5 AND id_despacho = ".$_GET['id']." ORDER BY" . " " . $sortfield . " DESC ";

				}

				else if ($sortorder == "asc")

				{

					$query = "SELECT * FROM materiales WHERE aprobado != 5 AND id_despacho = ".$_GET['id']." ORDER BY" . " " . $sortfield . " ASC ";

				}

			}

			else

			{

				if ($sortorder == "desc")

				{

					$filterquery .= " ORDER BY" . " " . $sortfield . " DESC ";

				}

				else if ($sortorder == "asc")	

				{

					$filterquery .= " ORDER BY" . " " . $sortfield . " ASC ";

				}

				$query = $filterquery;

			}		

		}

	}

	

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	$orders = null;

	// get data and store in a json array

	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$estado = '';
		$editado = '';
		$aprobar = '';
		$eliminar = '';
		$btn_aprobar = '';
		$i = 0;

		$sql2 = "SELECT nombre_material, cantidad, codigo, costo_unidad FROM inventario WHERE id = ".$row['id_material'];
        $pai2 = mysql_query($sql2); 
		$rs_pai2 = mysql_fetch_assoc($pai2);
		
		$sql3 = "SELECT * FROM TEMP_MERCANCIAS WHERE id_item = ".$row['id'];
        $pai3 = mysql_query($sql3); 
		$rs_pai3 = mysql_fetch_assoc($pai3);


		switch($row['aprobado']):
				case '':
				case 0:
				case 3:
					$aprobar = "No Aprobado";
					$btn_aprobar = '<a href="javascript: fn_aprobar_item('.$row['id'].','.$i.','.$_GET['id'].');"><img src="https://cdn2.iconfinder.com/data/icons/color-svg-vector-icons-part-2/512/ok_check_yes_tick_accept_success-16.png" /></a>&nbsp<a href="javascript: fn_eliminar_item('.$row['id'].');"><img src="../extras/ico/delete.png" /></a>';
				break;
				case 1:
					$aprobar = "Aprobado";
					$btn_aprobar = '&nbsp';
				break;				
		endswitch;
		
		if($rs_pai3['iva2'] != '')
			$iva = $rs_pai3['iva2'];
		else
			$iva  = 0.16;
			
		
		if($rs_pai3['orden_compra2'] != '' || $rs_pai3['orden_compra2'] != 0)
			$oc = $rs_pai3['orden_compra2'];
		else
			$oc = 'N/A';


		$cantidade =($rs_pai3['cantidade'] != '')?$rs_pai3['cantidade']:0; // total de cantidad entregada
		$valor_adjudicado =($rs_pai3['valor_adjudicado'] != '')?$rs_pai3['valor_adjudicado']:0;
		$total = $cantidade * $valor_adjudicado; 

		$customers[] = array(
		
			'id' => $row['id'],
			'codigo' => $rs_pai2['codigo'], 
			'name_material' => $rs_pai2['codigo'].'-'.utf8_encode($rs_pai2['nombre_material']),
			'presupuesto' => $row['presupuesto'],
			'cantidad_solicitada' => utf8_encode($row['cantidad']),
			'cantidad_inventario' => (int)$rs_pai2['cantidad'],
			'costo_uninventario' => $rs_pai2['costo_unidad'],
			
			'estado' => $aprobar,
			
			'cantidadc' => ($rs_pai3['cantidadc'] != '')?$rs_pai3['cantidadc']:0, // Cantidad Comprada
			'costo_unidadcompra'=>($rs_pai3['costo_unidadcompra'] != '')?$rs_pai3['costo_unidadcompra']:0, //Costo de unidad comprada 
			
			'cantidadentinv'=>($rs_pai3['cantidadentinv'] != '')?$rs_pai3['cantidadentinv']:0,
			'cantidadentcomp'=>($rs_pai3['cantidadentcomp'] != '')?$rs_pai3['cantidadentcomp']:0,
			'cantidade' => $cantidade, // total de cantidad entregada
			
			'costoinv'=>($rs_pai3['costoinv'] != '')?$rs_pai3['costoinv']:0,
			'costocomp'=>($rs_pai3['costocomp'] != '')?$rs_pai3['costocomp']:0,
			
			'valor_adjudicado'=>$valor_adjudicado,
			'total' => $total,
			
			'costo' => $row['costo'],
			
			'acciones' => $btn_aprobar,
			'iva2' => $iva,
			'orden_compra2' => $oc, 
			
			
			'num_factura' => '-',
			'orden_compra'=> '-',
			'proovedor'=>'-',
			'fecha_factura'=> '0000-00-00',	
			'fecha_vencimiento'=> '0000-00-00'			
			
			/*'ct_materiales' => (int)$rs_pai3['ct_materiales'],
			'ct_compra' => (int)$rs_pai3['ct_compra'],*/
			
		 );
		 
		 $i++;
	}

    $data[] = array(
       'TotalRows' => $total_rows,
	   'Rows' => $customers
	);

	echo json_encode($data);

?>