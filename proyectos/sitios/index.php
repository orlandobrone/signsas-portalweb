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

    <?php  require_once "../../config.php";   

	define('URL_SECCION', URL_PROYECTOS);

	define('SECCION', SITIOS); ?>

	<?php require_once "../../tpl_top.php"; ?>

    

    <script type="text/javascript">

        $(document).ready(function () {

            var source =

            {

                 datatype: "json",

                 datafields: [

					 { name: 'id', type: 'number'},

					 { name: 'regional', type: 'string'},

					 { name: 'departamento', type: 'string'},

					 { name: 'ciudad', type: 'string'},

					 { name: 'nombre_rb', type: 'string'},

					 { name: 'direccion', type: 'string'},

					 { name: 'tipo_rb', type: 'string'},

					 { name: 'acciones', type: 'string'}						 

                ],

				cache: false,

			    url: 'ajax_data.php',

				root: 'Rows',

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

				}

				);



            var dataadapter = new $.jqx.dataAdapter(source);



            $("#jqxgrid").jqxGrid({

                width: '100%',

                source: dataadapter,

                showfilterrow: true,

                pageable: true,

                filterable: true,

                theme: theme,

				sortable: true,

                rowsheight: 40, 

                columnsresize: true,

				virtualmode: true,

				rendergridrows: function(obj)

				{

					 return obj.data;      

				},                

                columns: [

                  { text: 'ID', datafield: 'id', filtertype: 'textbox', filtercondition: 'equal', width: 50,  columntype: 'textbox' },

                  { text: 'Acción', datafield: 'acciones', filtertype: 'none', width:50, pinned: true, cellsalign: 'center' },

				  { text: 'Regional', datafield: 'regional',filtertype: 'checkedlist', filteritems: ['CENTRO', 'NORTE','NOROCCIDENTE', 'NORORIENTE', 'SUR', 'SURORIENTE', 'SUROCCIDENTE'], filtercondition: 'equal', width:130 },

				  { text: 'Departamento', datafield: 'departamento', filtertype: 'textbox', filtercondition: 'starts_with', width: 140 },

                  { text: 'Ciudad', datafield: 'ciudad',  filtertype: 'textbox', filtercondition: 'starts_with',  width: 100 },

				  { text: 'Nombre RB', datafield: 'nombre_rb', filtertype: 'textbox', filtercondition: 'starts_with' },

				  { text: 'Dirección', datafield: 'direccion', filtertype: 'textbox', filtercondition: 'starts_with'},

                  { text: 'Tipo RB', datafield: 'tipo_rb', filtertype: 'textbox', filtercondition: 'starts_with', width: 100 }						 			  

                ]

            });

            $('#clearfilteringbutton').click(function () {

                $("#jqxgrid").jqxGrid('clearfilters');

            });

			$("#excelExport").click(function () {

                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Sitios');           

            });

        });

    </script>

    

    	<div id="cuerpo">

            <h1>SITIOS</h1>

            

            <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

                 <input value="Agregar Sitio" type="button" onClick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />

                 <input type="button" value="Exportar a Excel" id='excelExport' class="btn_table"/>

                 <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table"/>

            </div>

            

            <div id="jqxgrid"></div>

            

            <div id="div_oculto" style="display: none;"></div>

            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

    <?php require_once "../../tpl_bottom.php"; ?>



<!--    </body>

</html>-->