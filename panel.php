<?php require_once "conexion.php"; ?>
<?php require_once "config.php";?>
<?php require_once "tpl_top.php";?>
<div id="cuerpo">
<table width="50" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>BIENVENIDO(A) <?php echo utf8_encode($_SESSION['nombres']);?></td>
  </tr>
</table>
</div>
<?php require_once "tpl_bottom.php";?>