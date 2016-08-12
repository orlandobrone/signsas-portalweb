<?

	include "../../conexion.php";

	$sqlPry = 'SELECT id, orden_trabajo 
				FROM  `orden_trabajo` 
				WHERE `id_centroscostos` = 6';

	$qrPry = mysql_query($sqlPry);

    while ($row = mysql_fetch_array($qrPry)):

   				$optionT .= '<option value="'.$row['id'].'">'.utf8_encode($row['orden_trabajo']).'</option>';

    endwhile;

	echo $optionT;                   

?>