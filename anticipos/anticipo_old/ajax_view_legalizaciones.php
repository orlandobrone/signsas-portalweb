<div id="content_form">
	<h1>LEGALIZACIONES AMARRADOS AL ANTICIPO No: <?=$_REQUEST['ide_per']?></h1>
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
	  async: false,
	  url: 'ajax_data_list_legalizaciones.php?idanticipo=<?=$_REQUEST['ide_per']?>',
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

});

</script>





