<?php

require "class/Uploader.php";
include "../conexion.php";
include "../funciones.php";
include "extras/php/basico.php";

$obj = new TaskCurrent;
$upload_dir = 'uploads/';



require_once 'php/ext/PHPExcel-1.7.7/Classes/PHPExcel/IOFactory.php';
//cargamos el archivo que deseamos leer
$objPHPExcel = PHPExcel_IOFactory::load($upload_dir.'');
//obtenemos los datos de la hoja activa (la primera) 
$objHoja = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

/*foreach ($objHoja as $row):
	
	$valor = str_replace(',', '.', str_replace('.', '',str_replace(' ','',$row['B'])));
	$idState = $obj->getIdCiudad($row['A']);
	
	if($idState != 0):
		$sql = sprintf("INSERT INTO valor_acpm VALUES ('', %d, '%s', NOW());",
			fn_filtro($idState),
			fn_filtro($valor)
		);		

		if(!mysql_query($sql)):
			echo "Error al insertar al nuevo cliente:\n$sql";
		endif;
	endif;
	
endforeach;*/


exit;

$valid_extensions = array('xls');
 
$Upload = new FileUpload('uploadfile');
$result = $Upload->handleUpload($upload_dir, $valid_extensions);


if (!$result) {	
    echo json_encode(array('success' => false, 'msg' => $Upload->getErrorMsg()));   
} else {
	
	require_once 'php/ext/PHPExcel-1.7.7/Classes/PHPExcel/IOFactory.php';
	//cargamos el archivo que deseamos leer
	$objPHPExcel = PHPExcel_IOFactory::load($upload_dir.$Upload->getFileName());
	//obtenemos los datos de la hoja activa (la primera) 
	$objHoja = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	
	/*foreach ($objHoja as $row):
		
		$valor = str_replace(',', '.', str_replace('.', '',str_replace(' ','',$row['B'])));
		$idState = $obj->getIdCiudad($row['A']);
		
		if($idState != 0):
			$sql = sprintf("INSERT INTO valor_acpm VALUES ('', %d, '%s', NOW());",
				fn_filtro($idState),
				fn_filtro($valor)
			);		
	
			if(!mysql_query($sql)):
				echo "Error al insertar al nuevo cliente:\n$sql";
			endif;
		endif;
		
	endforeach;*/
	 
    echo json_encode(array('success' => true, 'file' => $Upload->getFileName())); 
}

?>