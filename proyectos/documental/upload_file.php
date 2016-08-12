<?php
include "../../conexion.php";
include "../extras/php/basico.php";

require('uploader/extras/Uploader.php');
//require(dirname(__FILE__) . '/../../Uploader.php');

$upload_dir = 'uploads/'.$_GET['iddocumental'].'/';

if (!file_exists($upload_dir)) {
	if(!mkdir($upload_dir, 0777, true)) {
		die('Fallo al crear las carpetas...');
	}
}

$valid_extensions = array('jpg','png','jpeg','gif','xls','xlsx','pdf','doc','docx','ppt','pptx','dwg');
 
$Upload = new FileUpload('uploadfile');
$ext = $Upload->getExtension(); // Get the extension of the uploaded file
$name_a = $Upload->getFileName();
$name_a = explode('.',$name_a);
$Upload->newFileName = rawurldecode($name_a[0]).'.'.$ext;

$result = $Upload->handleUpload($upload_dir, $valid_extensions);

if (!$result) {
    echo json_encode(array('success' => false, 'msg' => $Upload->getErrorMsg()));   
} else {
	
	$sql = sprintf("INSERT INTO `documental_items` (nombre_archivo,documental_id,tipo_archivo) VALUES ('%s', %d, '%s');",
		fn_filtro(utf8_encode($Upload->getFileName())),
		fn_filtro((int)$_GET['iddocumental']),
		fn_filtro($Upload->getExtension())
	);
	mysql_query($sql);
    echo json_encode(array('success' => true, 'iddoc'=>(int)$_GET['iddocumental'],'file' => $Upload->getFileName())); 
}

?>