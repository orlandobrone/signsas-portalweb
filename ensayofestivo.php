<?php
require('festivos.php');
$dias_festivos = new festivos('2014');
//echo $dias_festivos->esHabil('2014-05-1')?'Es H�bil':'No es H�bil';
echo $dias_festivos->proxHabil('2014-06-28');
?>