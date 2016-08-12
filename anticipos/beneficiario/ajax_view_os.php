<div id="content_form">

	<h1>Orden Servicio Vinculados con No. Identificaci&oacute;n: <?=$_REQUEST['ide_per']?></h1>

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
  
  var source =
  {
	   datatype: "json",
	   datafields: [
		   { name: 'id', type: 'number'},
		   { name: 'fecha_create', type: 'date'},
		   { name: 'fecha_inicio', type: 'date'},
		   { name: 'fecha_terminado', type: 'date'},
		   
		   { name: 'estado', type: 'string'},
		   
		   { name: 'id_regional', type: 'string'},
		   { name: 'nombre_responsable', type: 'string'},
		   { name: 'cedula_responsable', type: 'number'},

		   { name: 'id_centroscostos', type: 'string'},
		   { name: 'id_ordentrabajo', type: 'string'},
		   
		   { name: 'valor_total', type: 'number'}
	  ],
	  cache: false,
	  url: 'ajax_data_os.php?identificacion=<?=$_REQUEST['ide_per']?>',
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
	  }
	  };		

	  var dataadapter = new $.jqx.dataAdapter(source, {
		  loadError: function(xhr, status, error)
		  {
			  alert(error);
		  }
  });
	  

  //subgrilla	
  var nestedGrids = new Array();
  // create nested grid.
  var initrowdetails = function (index, parentElement, gridElement, record) {
	  
	  var id = record.uid.toString();
	  var id_os = record['id'];				
	  var grid = $($(parentElement).children()[0]);
	  
	  nestedGrids[index] = grid;				

	  var ordersSource = {
		  datatype: "json",
		  datafields: [
			   { name: 'i.id', type: 'number'},
			   { name: 'idHitos', type: 'string'},
			   
			   { name: 'po_ticket', type: 'string'},
			   { name: 'descripcion', type: 'string'},
			   { name: 'cantidad', type: 'number'},
			   
			   { name: 'valor_unitario', type: 'number'},
			   { name: 'total', type: 'number'},
			   { name: 'forma_pago', type: 'string'},	
		  ],
		  cache: false,
		  url: '/anticipos/ordenservicio/ajax_list_items.php?id='+id_os,
		  root: 'Rows',
		  sortcolumn: 'i.id',
		  sortdirection: 'desc'
	  };

	  var nestedGridAdapter = new $.jqx.dataAdapter(ordersSource, { autoBind: false });

	  if (grid != null) { 

		  grid.jqxGrid({

			  source: nestedGridAdapter, width: '85%', height: 200,

			  columns: [
			  	  { text: 'Hito', datafield: 'idHitos',  filtertype: 'textbox', filtercondition: 'starts_with',  width: 150, editable: false },
				  
				  /*{ text: 'p_O/Tiket', datafield: 'po_ticket', filtertype: 'none', width: 120, cellsalign: 'right'},*/
				  
				  { text: 'Descripcion', datafield: 'descripcion', filtertype: 'none', width: '80%', cellsalign: 'left'},
				  
				  /*{ text: 'Cantidad', datafield: 'cantidad', filtertype: 'none', width: 100, cellsalign: 'right',cellsformat: 'c2'},	 
				  
				  { text: 'Valor Unitario', datafield: 'valor_unitario', filtertype: 'none', width:130, cellsalign: 'right', cellsformat: 'c2' },
				  
				  { text: 'Total', datafield: 'total', filtertype: 'none', width: 130, cellsalign: 'right',cellsformat: 'c2' },
				  
				  { text: 'Forma Pago', datafield: 'forma_pago', filtertype: 'none', width: 130, cellsalign: 'right' } 	*/			

			  ]
		  });
   }};

  // var dataadapter = new $.jqx.dataAdapter(source);

  $("#jqxgrid2").jqxGrid({
	  width: '100%',
	  height: 500,
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
	  rowdetails: true,
	  initrowdetails: initrowdetails,
	  rowdetailstemplate: { 
		  rowdetails: "<div id='grid' style='margin: 10px;'></div>", 
		  rowdetailsheight: 220, 
		  rowdetailshidden: true 
	  },
	  rendergridrows: function(obj){
		   return obj.data;      
	  },                             
	  columns: [
		{ text: 'ID', datafield: 'id', filtertype: 'textbox', filtercondition: 'equal',  width: 40,  columntype: 'textbox' },
				  
		{ text: 'Estado', datafield: 'estado', filtertype: 'textbox', filtercondition: 'equal',  width: 80,  columntype: 'textbox' },

		{ text: 'Fecha Creación', datafield: 'fecha_create', filtertype: 'date', filtercondition: 'equal', width: 70, cellsformat: 'yyyy-MM-dd' },
		{ text: 'Fecha Inicio', datafield: 'fecha_inicio', filtertype: 'date', filtercondition: 'equal', width: 70, cellsformat: 'yyyy-MM-dd' },
		{ text: 'Fecha Terminado', datafield: 'fecha_terminado', filtertype: 'date', filtercondition: 'equal', width: 70, cellsformat: 'yyyy-MM-dd' },	
		
		{ text: 'Valor Total', datafield: 'valor_total', filtertype: 'none', width: 120, cellsformat: 'c2',cellsalign: 'right' },			  
		
		{ text: 'Regional', datafield: 'id_regional', filtertype: 'textbox',  filtercondition: 'starts_with', width: 140 },
		
		{ text: 'Nombre Responsable', datafield: 'nombre_responsable', filtertype: 'textbox',  filtercondition: 'starts_with', width: 140 },
		{ text: 'Cedula Responsable', datafield: 'cedula_responsable', filtertype: 'textbox',  filtercondition: 'starts_with', width:90},
		
		
		{ text: 'Centro Costo', datafield: 'id_centroscostos', filtertype: 'none', width:100},

		{ text: 'OT', datafield: 'id_ordentrabajo', filtertype: 'textbox', width: 70 },
	  ]
  });
  
  
});

</script>





