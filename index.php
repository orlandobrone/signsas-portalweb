<?php require_once "config.php";?>

<?php require_once "tpl_top.php";?>  




<?php //echo phpinfo(); ?>



<?php 

	if(isset($_GET['err'])):

		switch($_GET['err']):
	
			case 2:
	
				echo "Se ha terminado la Sessión";
	
			break;
	
		endswitch;

	endif;

?>



<div style="width:1050px;">

<form id="form1" name="form1" method="post" action="login.php">

  <table width="50" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td>&nbsp;</td>

    </tr>

    <tr>

      <td><img src="images/logo.png" width="207" height="132" /></td>

    </tr>

    <tr>

      <td>&nbsp;</td>

    </tr>

  </table>

  <table width="259" border="0" cellpadding="0" cellspacing="0" align="center" style="border:solid 1px #F00;">

    <tr>

      <td height="27" colspan="2" align="center" style="font-family:Arial, Helvetica, sans-serif; size:11px; color:#666"><strong>Autenticaci&oacute;n de Usuarios</strong></td>

    </tr>

    <tr>

      <td height="26" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">&nbsp;&nbsp;Usuario:</td>

      <td><input type="text" name="usuario" id="usuario" /></td>

    </tr>

    <tr>

      <td height="28" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">&nbsp;&nbsp;Contrase&ntilde;a:</td>

      <td><input type="password" name="password" id="password" /></td>

    </tr>

    <tr>

      <td height="29">&nbsp;</td>

      <td><input type="submit" name="button" id="button" value="Ingresar" /></td>

    </tr>

  </table>
  
 <!-- <h2 style="text-align:center;">Ups, el sistema se encuentra en mantenimiento, disculpe por las molestias.</h2>-->

  <p>&nbsp;</p>

</form>

</div>

<?php require_once "tpl_bottom.php";?>