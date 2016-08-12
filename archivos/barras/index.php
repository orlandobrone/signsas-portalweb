<form action="" method="post">
 Ingrese el Codigo para crear el código de barras:
 <input name="numero" type="text" style="background-color:#CCF"/>
 <input type="submit" value="Enviar" />
 </form>
<?php
 if(isset($_POST["numero"]) && is_numeric($_POST["numero"]))
 {
 //Mostramos la imagen
 echo "<img src='codigoBarras_img.php?numero=".$_POST["numero"]."'>";
 }
 ?>