<div id="content_form">

	<h1>Hitos Proyecto No: <?=$_REQUEST['ide_per']?></h1>

    <div style="margin-bottom:20px; clear:both;">

         <div id="jqxgrid2"></div>

    </div>
    
    <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
         <input name="cancelar" type="button" id="cancelar" value="Cerrar" onclick="fn_cerrar();"  class="btn_table" />                  
    </div>
</div>


<script type="text/javascript">
$(document).ready(function () {
		
  $(".btn_table").jqxButton({ theme: theme });
  
  var source = {
	 datatype: "json",
	 datafields: [
		 { name: 'id', type: 'integer'},
		 { name: 'id_proyecto', type: 'string'},
		 { name: 'nombre', type: 'string'},
		 { name: 'estado', type: 'string'},
		 { name: 'fecha_inicio', type: 'date'},
		 { name: 'fecha_final', type: 'date'},
		 { name: 'dias_hito', type: 'string'},
		 { name: 'fecha_inicio_ejecucion', type: 'date'},
		 { name: 'fecha_ejecutado', type: 'date'},
		 { name: 'fecha_informe', type: 'date'},
		 { name: 'fecha_liquidacion', type: 'date'},
		 { name: 'fecha_facturacion', type: 'date'},
		 { name: 'fecha_facturado', type: 'date'},					
		 { name: 'descripcion', type: 'string'},
		 { name: 'ot_cliente', type: 'string'}, /*FGR*/
		 { name: 'po', type: 'string'}, /*FGR*/
		 { name: 'gr', type: 'string'}, /*FGR*/
		 { name: 'factura', type: 'string'}, /*JOB*/
		 { name: 'po2', type: 'string'}, /*FGR*/
		 { name: 'gr2', type: 'string'}, /*FGR*/
		 { name: 'factura2', type: 'string'}, /*JOB*/
		 { name: 'valor_cotizado_hito', type: 'string'}, /*FGR*/
		 { name: 'adicion_cotizado', type: 'number'}, /*FGR*/
		 { name: 'factor', type: 'number'}, /*FGR*/
		 { name: 'acciones', type: 'string'}						 
	],				
	cache: false,
	async: false,
	url: 'ajax_data_hitos.php?idproyecto=<?=$_REQUEST['ide_per']?>',
	root: 'Rows',
	sortcolumn: 'id',
	sortdirection: 'desc',
	filter: function()
	{
		// update the grid and send a request to the server.
		$("#jqxgrid2").jqxGrid('updatebounddata', 'filter');
	},
	sort: function()
	{
		// update the grid and send a request to the server.
		$("#jqxgrid2").jqxGrid('updatebounddata', 'sort');
	},
	root: 'Rows',
	beforeprocessing: function(data) 
	{		
		if (data != null)
		{
			source.totalrecords = data[0].TotalRows;					
		}
	}};		

  var dataadapter = new $.jqx.dataAdapter(source, {
	  loadError: function(xhr, status, error)
	  {
		  alert(error);
	  }
  });
  
  var dataadapter = new $.jqx.dataAdapter(source);
  
  
  $("#jqxgrid2").jqxGrid({
	  width: '100%',
	  height: 450,
	  source: dataadapter,
	  editable: false,
	  showfilterrow: true,
	  pageable: true,
	  filterable: true,
	  theme: theme,
	  sortable: true,
	  rowsheight: 25,
	  columnsresize: true,
	  virtualmode: true,
	  rendergridrows: function(obj)
	  {
		   return obj.data;      
	  },                
	  columns: [
	  
			{ text: 'ID', datafield: 'id',  filtertype: 'textbox', filtercondition: 'equal',  width: 40,  columntype: 'textbox'  },

			{ text: 'Proyecto', datafield: 'id_proyecto', filtertype: 'textbox', width: 60 },

			{ text: 'Nombre Hito', datafield: 'nombre', filtertype: 'textbox', filtercondition: 'starts_with', width: 120 },
			{ text: 'Factor', datafield: 'factor', filtertype: 'textbox', filtercondition: 'starts_with', width: 60 },

			{ text: 'Estado', datafield: 'estado', filtertype: 'checkedlist', filtercondition: 'equal', width: 70, filteritems: ['PENDIENTE', 'EN EJECUCION', 'EJECUTADO', 'LIQUIDADO', 'INFORME ENVIADO', 'EN FACTURACION', 'FACTURADO', 'CANCELADO', 'DUPLICADO', 'PAGADO', 'ADMIN', 'COTIZADO']  },
			
			{ text: 'Adición Cotizado', datafield: 'adicion_cotizado', filtertype: 'none', width: 80, cellsformat: 'c2',cellsalign: 'right' },

			{ text: 'Fecha Inicio', datafield: 'fecha_inicio', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },

			{ text: 'Fecha Final', datafield: 'fecha_final', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },
			
			{ text: 'Días Hitos', datafield: 'dias_hito',  filtertype: 'textbox', filtercondition: 'equal',  width: 40,  columntype: 'textbox'  },

			{ text: 'Fecha Ini. Ejecución', datafield: 'fecha_inicio_ejecucion', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },

			{ text: 'Fecha Ejecutado', datafield: 'fecha_ejecutado', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },

			{ text: 'Fecha Informe', datafield: 'fecha_informe', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },

			{ text: 'Fecha Liquidación', datafield: 'fecha_liquidacion', filtertype: 'date', filtercondition: 'equal', width: 100, cellsformat: 'yyyy-MM-dd'  },

			{ text: 'Fecha Facturación', datafield: 'fecha_facturacion', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },

			{ text: 'Fecha Facturado', datafield: 'fecha_facturado', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },

			{ text: 'Descripción', datafield: 'descripcion', filtertype: 'textbox',  cellsalign: 'left',width: 80},

			{ text: 'OT Cliente', datafield: 'ot_cliente', filtertype: 'textbox',  cellsalign: 'left',width: 80}, /*FGR*/

			{ text: 'PO', datafield: 'po', filtertype: 'textbox',  cellsalign: 'left', width: 80}, /*FGR*/

			{ text: 'GR', datafield: 'gr', filtertype: 'textbox',  cellsalign: 'left', width: 80}, /*FGR*/

			{ text: 'Factura', datafield: 'factura', filtertype: 'textbox',  cellsalign: 'left', width: 80}, /*JOB*/

			{ text: 'PO2', datafield: 'po2', filtertype: 'textbox',  cellsalign: 'left', width: 80}, /*FGR*/

			{ text: 'GR2', datafield: 'gr2', filtertype: 'textbox',  cellsalign: 'left', width: 80}, /*FGR*/

			{ text: 'Factura2', datafield: 'factura2', filtertype: 'textbox',  cellsalign: 'left', width: 80}, /*JOB*/
			
			{ text: 'Valor Cotizado Hito', datafield: 'valor_cotizado_hito', filtertype: 'textbox',  cellsalign: 'left', width: 100, cellsformat: 'c2',cellsalign: 'right'}, /*FGR*/
		
	  ]
  
  });			

});

</script>





