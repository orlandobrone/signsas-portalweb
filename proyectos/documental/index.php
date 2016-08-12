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
	define('SECCION', DOCUMENTAL); ?>
	<?php require_once "../../tpl_top.php"; ?>
    
    <link rel="stylesheet" href="/js/chosen/chosen.css">
	<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 
    
    <script type="text/javascript">
        $(document).ready(function () {
            var source =
            {
                 datatype: "json",
                 datafields: [
					 { name: 'id', type: 'number'},
					 { name: 'fecha_creacion', type: 'date'},
					 { name: 'codigo_sitio', type: 'string'},
					 { name: 'actividad', type: 'string'},
					 { name: 'subactividad', type: 'string'},
					 { name: 'nombre_sitio', type: 'string'},
					 { name: 'cliente', type: 'string'},
					 { name: 'ot_tickets', type: 'string'},
					 { name: 'hito_id', type: 'number'},
					 { name: 'fotos', type: 'string'},
					 { name: 'pdf', type: 'string'},
					 { name: 'word', type: 'string'},
					 { name: 'excel', type: 'string'},
					 { name: 'powerpoint', type: 'string'},
					 { name: 'autocad', type: 'string'},
					 { name: 'nombre_documentador', type: 'string'},
					 { name: 'estado', type: 'string'},
					 { name: 'fecha_ejecucion_editable', type: 'string'},
					 { name: 'detalle_actividad', type: 'string'},
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
				  { text: 'Fecha Creación', datafield: 'fecha_creacion', filtertype: 'date', filtercondition: 'equal', width:100, cellsformat: 'yyyy-MM-dd'},
				  
				  { text: 'Codigo Sitio', datafield: 'codigo_sitio', filtertype: 'textbox', filtercondition: 'starts_with', width: 120 },
				  
                  { text: 'Actividad', datafield: 'actividad',  filtertype: 'textbox', filtercondition: 'starts_with',  width: 160 },
				  
				  { text: 'Sub-Actividad', datafield: 'subactividad',  filtertype: 'textbox', filtercondition: 'starts_with',  width: 160 },
				  
				  { text: 'Nombre Sitio', datafield: 'nombre_sitio', filtertype: 'textbox', filtercondition: 'starts_with' },
				  
				  { text: 'Cliente', datafield: 'cliente', filtertype: 'textbox', filtercondition: 'starts_with'},
				  
                  { text: 'OT tickets', datafield: 'ot_tickets', filtertype: 'textbox', filtercondition: 'starts_with', width: 100 },
				  
				  { text: 'ID hito', datafield: 'hito_id', filtertype: 'textbox', filtercondition: 'starts_with', width: 100 },
				  { text: 'Fotos', datafield: 'fotos', filtertype: 'textbox', filtercondition: 'starts_with', width: 100 },
				  { text: 'PDF', datafield: 'pdf', filtertype: 'textbox', filtercondition: 'starts_with', width: 100 },
				  { text: 'Word', datafield: 'word', filtertype: 'textbox', filtercondition: 'starts_with', width: 100 },
				  { text: 'Excel', datafield: 'Excel', filtertype: 'textbox', filtercondition: 'starts_with', width: 100 },
				  { text: 'PowerPoint', datafield: 'powerpoint', filtertype: 'textbox', filtercondition: 'starts_with', width: 100 },
				  { text: 'Autocad', datafield: 'autocad', filtertype: 'textbox', filtercondition: 'starts_with', width: 100 },
				  { text: 'Nombre Documentador', datafield: 'nombre_documentador', filtertype: 'textbox', filtercondition: 'starts_with', width: 100 },
				  
				  { text: 'Estado', datafield: 'estado', filtertype: 'textbox', filtercondition: 'starts_with', width: 100 },
				  { text: 'Aprobado Fecha de Ejecución Editable', datafield: 'fecha_ejecucion_editable', filtertype: 'textbox', filtercondition: 'starts_with', width: 100 },
				  
				  { text: 'Detalle de Actividad', datafield: 'detalle_actividad', filtertype: 'textbox', filtercondition: 'starts_with', width: 100 }						 			  
                ]
            });
            $('#clearfilteringbutton').click(function () {
                $("#jqxgrid").jqxGrid('clearfilters');
            });
			$("#excelExport").click(function () {
                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Sitios');           
            });		
			
			$('#addreintegroWindow').jqxWindow({
				minHeight: '60%', minWidth: '60%', zIndex:100,
				resizable: true, isModal: true, modalOpacity: 0.3,autoOpen: false
			});	
			
			$('#excelExport2').click(function(){
				window.open("/proyectos/documental/export_excel.php");
			});
			
        });
    </script>
    
    	<div id="cuerpo">
            <h1>DOCUMENTAL</h1>
            
            <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
                 <input value="Agregar Documento" type="button" onClick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />
                 <input type="button" value="Exportar a Excel" id='excelExport' class="btn_table"/>
                 <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table"/>
                 <input type="button" value="Exportar Todo a Excel" id='excelExport2' class="btn_table" />
            </div>
            
            <div id="jqxgrid"></div>
            
            <div id="addreintegroWindow">
                <div>
                    <img width="14" height="14" src="https://cdn0.iconfinder.com/data/icons/fatcow/16/table_add.png" alt="" />
                    Formulario de Ingreso Documento
                </div>
                <div id="content_form_material" style="width:90%;">
                </div>
            </div>
            
            <div id="div_oculto" style="display: none;"></div>
            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>
        </div>
    <?php require_once "../../tpl_bottom.php"; ?>

<!--    </body>
</html>-->