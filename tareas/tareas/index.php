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
	define('URL_SECCION', URL_TAREAS);
	define('SECCION', TAREAS); ?>
<?php require_once "../../tpl_top.php"; ?>
    	<div id="cuerpo">
            <h1>TAREAS</h1>
            <p>&nbsp;</p>
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
                <table class="formulario">
                    <tbody>
                        <tr>
                            <td>Nombre</td>
                            <td><input name="criterio_usu_per" type="text" id="criterio_usu_per" /></td>
                            <td>Ordenar </td>
                            <td>
                            	<select name="criterio_ordenar_por" id="criterio_ordenar_por">
                                    <option value="tareas.id">Id</option>
                                    <option value="hitos.nombre">Hito</option>
                                	<option value="tareas.nombre">Nombre</option>
                                    <option value="usuario.nombres">Usuario</option>
                                    <option value="tareas.fecha_inicio">Fecha Inicio</option>
                                    <option value="tareas.fecha_final">Fecha Final</option>
                                    <option value="tareas.descripcion">Descripci&oacute;n</option>
                                    <option value="tareas.fecha">Fecha Registro</option>
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
             <div class="excel-contener" style="margin-bottom: 53px;">
            	<a href="javascript:" onclick="ExportarExcel()">
                	<img src="https://cdn1.iconfinder.com/data/icons/fatcow/16/page_white_excel.png" style="float: left;" />
                	<div style="float: left;margin-left: 7px;">Exportar a Excel</div>
                </a>
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
            <p align="right">Desarrollado por: <strong>Ingecall SAS</strong><br /><a href="http://www.ingecall.com" target="_blank">www.ingecall.com</a></p>
        </div>
        <?php require_once "../../tpl_bottom.php"; ?>

<!--    </body>
</html>-->