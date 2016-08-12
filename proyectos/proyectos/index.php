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

	require_once "../../restrinccion.php"; 

	define('URL_SECCION', URL_PROYECTOS);

	define('SECCION', PROYECTOS); ?>

	<?php require_once "../../tpl_top.php"; ?>

    <script type="text/javascript">

        $(document).ready(function () {

            var source =

            {

                 datatype: "json",

                 datafields: [
{ name: 'id', type: 'integer'},
					 { name: 'nombre', type: 'string'},
					 { name: 'descripcion', type: 'string'},					 
					 { name: 'regional', type: 'string'},
					 { name: 'id_cliente', type: 'string'},
					 { name: 'linea_negocio_id', type: 'string'},
					 { name: 'actividad_id', type: 'string'},
					 { name: 'estado', type: 'string'},
					 { name: 'fecha_inicio', type: 'date'},
					 { name: 'fecha_final', type: 'date'},
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

				}

				);



            // var dataadapter = new $.jqx.dataAdapter(source);



            $("#jqxgrid").jqxGrid(

            {

                width: '100%',

                source: dataadapter,

                showfilterrow: true,

                pageable: true,

                filterable: true,

                theme: theme,

				rowsheight: 40,

				sortable: true,

                autoheight: true,

                columnsresize: true,

				virtualmode: true,

				rendergridrows: function(obj)

				{

					 return obj.data;      

				},              

                columns: [

                  { text: 'ID', datafield: 'id',  filtertype: 'textbox', filtercondition: 'equal',  width: 60,  columntype: 'textbox'  },

                  { text: 'Acciones', datafield: 'acciones', filtertype: 'none', width:70, pinned: true, cellsalign: 'center' },

				  { text: 'Nombre', datafield: 'nombre', filtertype: 'textbox', filtercondition: 'starts_with', width: 190 },

                  { text: 'Descripcion', datafield: 'descripcion', filtertype: 'textbox', filtercondition: 'starts_with' , width: 170  },
				  
				  { text: 'Regional', datafield: 'regional', filtertype: 'none', width: 90 },

				  { text: 'Cliente', datafield: 'id_cliente', filtertype: 'textbox', filtercondition: 'starts_with', width: 120 },

				  { text: 'Linea de Negocio', datafield: 'linea_negocio_id', filtertype: 'textbox', filtercondition: 'starts_with' , width: 100  },
				  
				  { text: 'Actividad', datafield: 'actividad_id', filtertype: 'textbox', filtercondition: 'starts_with' , width: 100  },

				  { text: 'Estado', datafield: 'estado', width: 90, filtertype: 'checkedlist', filteritems: ['En Ejecución', 'Facturado', 'Pendiente de Facturación']  },

                  { text: 'Fecha Inicio', datafield: 'fecha_inicio', filtertype: 'date', filtercondition: 'equal', width: 100, cellsformat: 'yyyy-MM-dd' },

                  { text: 'Fecha Final', datafield: 'fecha_final', filtertype: 'date', filtercondition: 'equal', width: 100, cellsformat: 'yyyy-MM-dd' },


                ]

            });

            $('#clearfilteringbutton').click(function () {

                $("#jqxgrid").jqxGrid('clearfilters');

            });

			$("#excelExport").click(function () {

                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Proyectos');           

            });

			

			$('#excelExport2').click(function(){

				window.open("/proyectos/proyectos/export_excel.php");

			});

        });

    </script>

    

    	<div id="cuerpo">

            <h1>PROYECTOS</h1>

           

             <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
			 <? if(in_array(113,$_SESSION['permisos'])): ?>
             <input value="Agregar Proyecto" type="button" onclick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />
             <? endif; ?>

             <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />


             <input type="button" value="Exportar Todo a Excel" id='excelExport2' class="btn_table" />                  

            </div>

            <div id="jqxgrid"></div>

            <div id="div_oculto" style="display: none;"></div>

            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

    <?php require_once "../../tpl_bottom.php"; ?>



<!--    </body>

</html>-->