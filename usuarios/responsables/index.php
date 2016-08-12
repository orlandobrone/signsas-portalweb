<?php  
	include "../../restrinccion.php";   
	require_once "../../config.php"; 

	define('URL_SECCION', URL_USUARIOS);
	define('SECCION', 	RESPONSABLES); 
	
	require_once "../../tpl_top.php"; 
?>

<script type="text/javascript">

$(document).ready(function () {

	var source =
	{
		 datatype: "json",
		 datafields: [
			 { name: 'id', type: 'number'},
			 { name: 'nombre', type: 'string'},
			 { name: 'cedula', type: 'string'},
			 { name: 'regional', type: 'string'},
			 { name: 'estado', type: 'string'},
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
	
		rendergridrows: function(obj)
		{
			 return obj.data;      
		},              
	
		columns: [
	
		  { text: 'ID', datafield: 'id', filtertype: 'number', filtercondition: 'equal', columntype: 'textbox' },
	
		  { text: '-', datafield: 'acciones', filtertype: 'none',pinned: true, width:70},
	
		  { text: 'Nombre', datafield: 'nombre', filtertype: 'textbox', filtercondition: 'starts_with' },
		  { text: 'Cedula', datafield: 'cedula', filtertype: 'textbox', filtercondition: 'starts_with' },
	
		  { text: 'Región', datafield: 'regional', filtertype: 'textbox', filtercondition: 'starts_with'},
		  { text: 'Estado', datafield: 'estado', filtertype: 'textbox', filtercondition: 'none'},
	
		]
	
	});
	
	$(".btn_table").jqxButton({ theme: theme });
	
	$('#clearfilteringbutton').click(function () {
	
		$("#jqxgrid").jqxGrid('clearfilters');
	
	});
	
	$("#excelExport").click(function () {
	
		$("#jqxgrid").jqxGrid('exportdata', 'xls', 'Beneficiarios');           
	
	});

});

</script>

    

    <div id="cuerpo"> 
        <h1>RESPONSABLES<span style="color:#FF0000; display:block;">En construcci&oacute;n</span></h1>       

         <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
		 <? if(in_array(423,$_SESSION['permisos'])): ?>
         <input value="Agregar Responsable" type="button" onclick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />
         <? endif; ?>

         <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />


        </div>
        

        <div id="jqxgrid"></div>

        <div id="div_oculto" style="display: none;"></div>

        <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

    </div>

    <?php require_once "../../tpl_bottom.php"; ?>