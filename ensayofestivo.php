<?php
require('festivos.php');
$dias_festivos = new festivos('2014');
//echo $dias_festivos->esHabil('2014-05-1')?'Es Hábil':'No es Hábil';
echo $dias_festivos->proxHabil('2014-06-28');
?>