<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";

	#Include the connect.php file

	#Connect to the database

	//connection String	

	// get data and store in a json array


	
	$query = "SELECT * FROM regional ORDER BY `region` DESC ";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	// get data and store in a json array
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$customers[] = array(   'id' => $row['id'],
								'region' => $row['region']
							);

	}
	
	/*$customers[] = array( 'id' => 0,
						  'region' => 'TODOS'
						 );*/

    $data[] = array(
       'TotalRows' => $total_rows,
	   'Rows' => $customers
	);

	echo json_encode($data);

?>