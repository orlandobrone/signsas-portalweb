<?php 
  session_start();
  unset($_SESSION["id"]); 
  unset($_SESSION["nombres"]);
  unset($_SESSION["perfil"]);
  unset($_SESSION["ultimoAcceso"]);
  
  session_destroy();
  header("Location: index.php");
  exit;
?>