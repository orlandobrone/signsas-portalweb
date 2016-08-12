<div id="content_form">

	<h1>ACCIONES DEL HITO No: <?=$_REQUEST['ide_per']?></h1>

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
		   { name: 'id', type: 'number'},
		   { name: 'id_usuario', type: 'number'},
		   { name: 'id_hito', type: 'number'},
		   { name: 'id_anticipo', type: 'number'},
		   { name: 'monto', type: 'number'},
		   { name: 'accion', type: 'string'},
		   { name: 'fecha_estado', type: 'date'}								 
	  ],				
	  cache: false,
	  async: false,
	  url: 'ajax_data_list_pitagorahitos.php?idhito=<?=$_REQUEST['ide_per']?>',
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
	  
		{ text: 'ID', datafield: 'id', filtertype: 'textbox', filtercondition: 'equal',  width: 80,  columntype: 'textbox' },
  
		{ text: 'Accion', datafield: 'accion', filtertype: 'checkedlist', filtercondition: 'equal', width: 180,  filteritems: ['Abierto', 'Cerrado', 'Agrego'] },
  
		{ text: 'Usuario', datafield: 'id_usuario', filtertype: 'textbox' },
  
		{ text: 'ID Hito', datafield: 'id_hito', filtertype: 'textbox', width: 70 },
  
		{ text: 'ID Anticipo', datafield: 'id_anticipo', filtertype: 'textbox', width: 70 },	
  
		{ text: 'Monto', datafield: 'monto', filtertype: 'textbox', width: 170, cellsformat: 'c2',cellsalign: 'right' },		
		
		{ text: 'Fecha Accion', datafield: 'fecha_estado', filtertype: 'date', filtercondition: 'equal', width: 130, cellsformat: 'yyyy-MM-dd HH:mm:ss' }
		
	  ]
  
  });			

});

</script>





