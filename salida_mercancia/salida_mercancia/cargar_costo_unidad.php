<?php require_once "../../conexion.php";
$idMaterial = $_POST['idMaterial'];
$qrInventario = mysql_query("SELECT * FROM inventario WHERE id = '" . $idMaterial . "'");
$rowsInventario = mysql_fetch_array($qrInventario);
$material = explode("$", $rowsInventario['costo_unidad']);
$costo = trim($material[1]);
$costo = explode(".", $costo);
$costo = str_replace(",", "", $costo[0]) . '.' . $costo[1];
//$costo = str_replace(",", "", $costo);
$arr = array("costo"=>$costo, "cantidad"=>$rowsInventario['cantidad']);
echo json_encode($arr);
?>