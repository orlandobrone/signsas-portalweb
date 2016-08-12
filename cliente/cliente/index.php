<?php  include "../../restrinccion.php";  ?>

<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>Documento sin t?tulo</title>

        <script language="javascript" type="text/javascript" src="../extras/js/jquery-1.3.2.min.js"></script>

        <script language="javascript" type="text/javascript" src="../extras/js/jquery.blockUI.js"></script>

        <script language="javascript" type="text/javascript" src="../extras/js/jquery.validate.1.5.2.js"></script>

        <script language="javascript" type="text/javascript" src="../extras/js/mask.js"></script>

        <link href="../extras/css/estilo.css" rel="stylesheet" type="text/css" />

        <link href="../extras/php/PHPPaging.lib.css" rel="stylesheet" type="text/css" />

        <script language="javascript" type="text/javascript" src="index.js"></script>

    </head>

    <body>-->

    <?php require_once "../../config.php"; 

	define('URL_SECCION', URL_CLIENTE);

	define('SECCION', CLIENTE);	?>

	<?php require_once "../../tpl_top.php"; ?>

    	<div id="cuerpo">

            <h1>CLIENTES</h1>

            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">

                <table class="formulario">

                    <tbody>

                        <tr>

                            <td>Nombre</td>

                            <td><input name="criterio_usu_per" type="text" id="criterio_usu_per" /></td>

                            <td>Ordenar </td>

                            <td>

                            	<select name="criterio_ordenar_por" id="criterio_ordenar_por">

                                    <option value="id">Id</option>

                                    <option value="natural_juridico">Tipo Persona</option>

                                	<option value="nombre">Nombre</option>

                                    <option value="descripcion">Descripci&oacute;n</option>

                                    <option value="persona_contacto">Persona Contacto</option>

                                    <option value="telefono">Tel&eacute;fono Contacto</option>

                                    <option value="celular">Celular Contacto</option>

                                    <option value="email">E-mail Contacto</option>

                                    <option value="fecha">Fecha de Registro</option>

                                </select>

                            </td>

                            <td> En</td>

                            <td>

                            	<select name="criterio_orden" id="criterio_orden">

                                	<option value="desc">Descendente</option>

                                    <option value="asc">Ascendente</option>

                                </select>

                            </td>

                            <td>Registros</td>

                            <td>

                            	<select name="criterio_mostrar" id="criterio_mostrar">

                                	<option value="1">1</option>

                                	<option value="2">2</option>

                                	<option value="5">5</option>

                                	<option value="10">10</option>

                                	<option value="20" selected="selected">20</option>

                                	<option value="40">40</option>

                                </select>

                            </td>

                            <td><input type="submit" value="Buscar" /></td>

                        </tr>

                    </tbody>

                </table>

            </form>

             <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

                 <input value="Agregar Cliente" type="button" onclick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />

                 <input type="button" value="Exportar a Excel" onclick="ExportarExcel()" class="btn_table" />                 

            </div>

            <script>

				function ExportarExcel(){

					var data='<table>'+$("#grilla").html().replace(/<a\/?[^>]+>/gi, '')+'</table>';

						$('body').prepend("<form method='post' action='/exporttoexcel.php' style='display:none' id='ReportTableData'><input type='text' name='tableData' value='"+data+"' ></form>");

						 $('#ReportTableData').submit().remove();

						 return false;

				}

			</script>

            <div id="div_listar"></div>

            <div id="div_oculto" style="display: none;"></div>

            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

        <?php require_once "../../tpl_bottom.php"; ?>



<!--    </body>

</html>-->