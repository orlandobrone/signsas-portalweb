<?php


		$para  = 'ingsistemas.ordonez@gmail.com';

        // subject
        $titulo = 'Andriod';

        // message
		
		$mensaje = 'llego';
       
		
	
	
        // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


        // Cabeceras adicionales
       	$cabeceras .= 'To: Gilberto López <bertolopez13@hotmail.com>' . "\r\n";
        $cabeceras .= 'From: National Marketing Online <noreply@nationalmarketingonline.com>' . "\r\n";

        // Mail it
		mail($para, $titulo, $mensaje, $cabeceras);			


$target_path  = "./";
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
 echo "The file ".  basename( $_FILES['uploadedfile']['name']).
 " has been uploaded";
} else{
 echo "There was an error uploading the file, please try again!";
}
?>