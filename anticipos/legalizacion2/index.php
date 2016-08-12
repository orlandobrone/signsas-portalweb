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

	define('URL_SECCION', URL_ANTICIPOS); 

	define('SECCION', LEGALIZACION); ?> 

	<?php require_once "../../tpl_top.php"; ?>

    <script src="/js/jquery.printarea.js" type="text/javascript"></script> 

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

    <script src="/js/masknoney/jquery.maskMoney.js" type="text/javascript"></script>
    
    <!--Hoja de estilos del calendario -->
	<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">

	<!-- librería principal del calendario -->
	<script type="text/javascript" src="../../calendario/calendar.js"></script>

	<!-- librería para cargar el lenguaje deseado -->
	<script type="text/javascript" src="../../calendario/calendar-es.js"></script>

	<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
	<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>

    <script type="text/javascript">

        $(document).ready(function () {            

            var source =

            {

                 datatype: "json",

                 datafields: [

					 { name: 'id', type: 'number'},

					 { name: 'responsable', type: 'string'},

					 { name: 'fecha', type: 'date'},

					 { name: 'id_anticipo', type: 'number'},

					 { name: 'valor_fondo', type: 'string'},

					 { name: 'valor_legalizado', type: 'string'},

					 { name: 'valor_pagar', type: 'string'},

					 { name: 'legalizacion', type: 'string'},

					 { name: 'estado', type: 'string'},

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



            $("#jqxgrid").jqxGrid(

            {

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

                  { text: 'ID', datafield: 'id', filtertype: 'textbox', filtercondition: 'equal', width: 40,  columntype: 'textbox' },

                  { text: '-', datafield: 'acciones', filtertype: 'none', width:40, pinned: true, cellsalign: 'center' },

				  { text: 'Responsable', datafield: 'responsable', filtertype: 'textbox', filtercondition: 'starts_with'},

                  { text: 'Fecha', datafield: 'fecha', filtertype: 'date', filtercondition: 'equal', width: 90, cellsformat: 'yyyy-MM-dd'  },

				  { text: 'ID Anticipo', datafield: 'id_anticipo', filtertype: 'textbox', filtercondition: 'equal', width: 80, cellsalign: 'center' },

				  { text: 'Estados', datafield: 'estado', filtertype: 'checkedlist', filtercondition: 'equal', width:100, filteritems: ['APROBADO', 'NO REVISADO']},

                  { text: 'Valor Fondo', datafield: 'valor_fondo', filtertype: 'none', width: 110 },

				  { text: 'Valor Legalizado', datafield: 'valor_legalizado', filtertype: 'none', width:120},

				  { text: 'Valor Pagar', datafield: 'valor_pagar', filtertype: 'none', width:100},

				  { text: 'Reintegro', datafield: 'legalizacion', filtertype: 'none', width:100}				 			  

                ]

            });

            $('#clearfilteringbutton').jqxButton({ height: 25, theme: theme });

            $('#clearfilteringbutton').click(function () {

                $("#jqxgrid").jqxGrid('clearfilters');

            });

			$("#excelExport").click(function () {

                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Anticipos');           

            });

			

			

			$('#excelExport2').click(function(){
				var inicio,fin;
				finicio = $('#fecini').val();
				ffin = $('#fecfin').val();
				
				if(finicio == '' || ffin == '')
					alert('Debe escoger rango de fecha antes de exportar todo');
				else
					window.open("/anticipos/legalizacion/export_excel.php?fecini="+finicio+"&fecfin="+ffin);

			});

			

        });

    </script>

     

    	<div id="cuerpo">

            <h1>LEGALIZACIÓN</h1>

           

            <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

                <!-- <input value="Agregar Anticipo" type="button" onClick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />-->

                 <input type="button" value="Exportar a Excel" id='excelExport'  class="btn_table"/>  

                 <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button"  class="btn_table"/>
                 
                 <label style="margin-left:90px;">Exportar desde: </label>
                 <input name="fecini" type="text" id="fecini" size="20" readonly="readonly" />
    
                    <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />
    
                    <script type="text/javascript">
    
                        Calendar.setup({
    
                            inputField     :    "fecini",      // id del campo de texto
    
                            ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
    
                            button         :    "lanzador"   // el id del botón que lanzará el calendario
    
                        });
    
                    </script> 
                    
                 <label>Hasta: </label>   
                 <input name="fecfin" type="text" id="fecfin" size="20" readonly="readonly" />
    
                    <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2" />
     
                    <script type="text/javascript">
     
                        Calendar.setup({
    
                            inputField     :    "fecfin",      // id del campo de texto
    
                            ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
    
                            button         :    "lanzador2"   // el id del botón que lanzará el calendario
    
                        });
    
                    </script> 
                 
                 <input style="margin-left:10px;" type="button" value="Exportar Todo a Excel" id='excelExport2' class="btn_table" />

            </div>

            

            <div id="jqxgrid"></div>

           

            <div id="div_oculto" style="display: none;"></div>

            <p align="right">Desarrollado por: <strong>Ingecall SAS</strong><br /><a href="http://www.ingecall.com" target="_blank">www.ingecall.com</a></p>

        </div>

    <?php require_once "../../tpl_bottom.php"; ?>

    <!--</body>

</html>-->