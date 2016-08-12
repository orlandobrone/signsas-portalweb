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

	define('URL_SECCION', URL_COTIZACION);

	define('SECCION', COTIZACION); ?>

	<?php require_once "../../tpl_top.php"; ?>
    
     <style>
	.jqx-widget-content jqx-widget-content-bootstrap{
		z-index:1 !important;
	}
	</style>

    <script type="text/javascript">

    $(document).ready(function () {
	
            var source = {
                 datatype: "json",
                 datafields: [
					 { name: 'id', type: 'id'},
					 { name: 'nombre', type: 'string'},
					 { name: 'descripcion', type: 'string'},
					 { name: 'ventaTotal', type: 'number'},
					 { name: 'costoTotal', type: 'number'},
					 { name: 'ganancia_adicional', type: 'string'},
					 { name: 'acciones', type: 'string'}
                ],
				cache: false,
			    url: 'ajax_data.php',
				sortcolumn: 'id',
                sortdirection: 'desc',
				filter: function()

				{

					// update the grid and send a request to the server.

					$("#jqxgrid").jqxGrid('updatebounddata', 'filter');

				},

				sort: function()

				{

					// update the grid and send a request to the server.

					$("#jqxgrid").jqxGrid('updatebounddata', 'sort');

				},

				root: 'Rows',

				beforeprocessing: function(data)

				{		

					if (data != null)

					{

						source.totalrecords = data[0].TotalRows;					

					}

				}

				};		

				var dataadapter = new $.jqx.dataAdapter(source, {

					loadError: function(xhr, status, error)

					{

						alert(error);

					}

			});			

            // var dataadapter = new $.jqx.dataAdapter(source);

            $("#jqxgrid").jqxGrid({
                width: '100%',
                source: dataadapter,
                showfilterrow: true,
                pageable: true,
                filterable: true,
                theme: theme,
				autorowheight: true,
                autoheight: true,
				sortable: true,
                autoheight: true,
                columnsresize: true,
				virtualmode: true,
				rendergridrows: function(obj){
					 return obj.data;      
				},			
                columns: [
                  { text: '-', datafield: 'acciones', filtertype: 'none',pinned: true, width:80},
				  { text: 'ID', datafield: 'id', filtertype: 'textbox', filtercondition: 'equal', width: 80,  columntype: 'textbox', editable: false },
				  { text: 'Nombre Cotización', datafield: 'nombre', filtertype: 'textbox', filtercondition: 'starts_with'},
				  { text: 'Descripción', datafield: 'descripcion', filtertype: 'textbox', filtercondition: 'starts_with',width: 80},
				 
				  { text: 'Venta Total', datafield: 'ventaTotal', filtertype: 'none', filtercondition: 'starts_with', cellsformat: 'c2'},
				  { text: 'Costo Total', datafield: 'costoTotal', filtertype: 'none', filtercondition: 'starts_with', cellsformat: 'c2'},
				  { text: 'Factor Utilidad', datafield: 'ganancia_adicional', filtertype: 'none', filtercondition: 'starts_with'}
                ]
            });

            $(".btn_table").jqxButton({ theme: theme });

            $('#clearfilteringbutton').click(function () {

                $("#jqxgrid").jqxGrid('clearfilters');

            });

			$("#excelExport").click(function () {

                $('#jqxgrid').jqxGrid('hidecolumn', 'acciones'); 

				setTimeout(function(){    
                	$("#jqxgrid").jqxGrid('exportdata', 'xls', 'Cotizaciones_<?=date('m-d-Y')?>');   

				},1000);

				setTimeout(function(){
					$('#jqxgrid').jqxGrid('showcolumn', 'acciones');
				},2000);      

            });
			
			$('#excelExport2').click(function(){
				window.open('export_excel.php');
			});
    });
    </script>

    	<div id="cuerpo">

            <h1>COTIZACIONES <span style="color:#C00; display:block;">En Mantenimiento</span></h1>

            <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
             
             	 <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />

                 <input value="Agregar Cotización" type="button" onclick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />

                 <input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" />
                 
                 <input type="button" value="Exportar Todo" id='excelExport2' class="btn_table" />                 

            </div>

            <div id="jqxgrid"></div>
            
            <div id="div_listar"></div>

            <div id="div_oculto" style="display: none;"></div>

            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

    <?php require_once "../../tpl_bottom.php"; ?>



<!--    </body>

</html>-->