<?php 
	include "festivos.php";
	
	$dias_festivos = new Festivos('2014');
	 
	$fecini = '2014-01-01';
	$fecfin = '2014-07-31';
	
	$fecini1 = date($fecini);
	$fecfin1 = date($fecfin);
		$numdias = 0;
		while($fecini1 <= $fecfin1){
			if($dias_festivos->esHabilSabado($fecini1))
				$numdias++;
			$fecini1 = date("Y-m-d",strtotime($fecini1)+86400);
		}
		
	echo $numdias;

?>