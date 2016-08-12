<! include "conexion.php"; !>
<?php  
 	function myfunction($a, $b = true)  {
          if($a && !$b) {
               echo "Hello, World! \n";
          }
    }

    $s = array(0 => "my",
                     1 => "call ",
                     2 => '$function',
                     3 => ' ',
                     4 => " function",
                     5 => '$a',
                     6 => '$b',
                     7 => 'a',
                     8 => 'b',
                     9 => ' ');

    $a = true;
    $b = false;

    /* Grupo A */
    $name = $s[4].$s[3].$s[0].$s[4].$s[9].$s[9];

    /* Grupo B */
    $name(${$s[7]} , ${$s[8]});
	
	
	
	 exit;



include "conexion.php";



$hostname = '{mail.signsas.com/notls}INBOX';

$username = 'anticipos@signsas.com';

$password = 'UeUTEPyHT#U4';



$inbox = imap_open($hostname,$username,$password) or die('Ha fallado la conexión: ' . imap_last_error());

$emails = imap_search($inbox,'ALL');





if($emails) {

  

  $salida = '';

  

  foreach($emails as $email_number) {   

  

          $overview = imap_fetch_overview($inbox,$email_number,0);

		  

		  //print_r($overview);

		   

		  $cadena = $overview[0]->subject;

		  $buscar = 'Re: Nuevo Anticipo #';

		  

		  $resultado = strpos($cadena, $buscar);

		  if($resultado !== FALSE && $overview[0]->deleted != 1):

		  	  	$anticipo = explode('#', $cadena);

			  

			  	$update = " UPDATE  `signsas_project`.`anticipo`

							SET  `estado` =  '1' WHERE  `anticipo`.`id` =".$anticipo[1];

				

				if(mysql_query($update)){							  

				

					$sql=mysql_query(" 	SELECT  a.id_usuario AS idusuario, u.email AS emailuser

										FROM anticipo AS a

										LEFT JOIN usuario AS u ON a.id_usuario = u.id

										WHERE  a.`id` =".(int)$anticipo[1],$con) or

					die("Problemas en la base de datos:".mysql_error());

					$row=mysql_fetch_array($sql);

					

					echo $salida= '<p>Tema: '.$overview[0]->subject.' Email:'.$row['emailuser'].'<br/>';	

					

					$para = $row['emailuser']; 

					// subject

					$titulo = 'Revisado Anticipo #'.$anticipo[1];

					$mensaje = 'Ya fue Aprobado el Anticipo #'.$anticipo[1]; 

					

					$cabeceras  = 'MIME-Version: 1.0' . "\r\n";

					$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

					$cabeceras .= 'From: anticipos@signsas.com'. "\r\n";

					

					mail($para, $titulo, $mensaje, $cabeceras);

				}

				  

				

				imap_delete($inbox, $email_number);		

			  

		  endif;

  }

 



} 



imap_close($inbox);





?>

