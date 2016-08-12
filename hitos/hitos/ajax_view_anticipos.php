<div id="content_form">

	<h1>HITOS AMARRADOS AL ANTICIPO No: <?=$_REQUEST['ide_per']?></h1>

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
		   { name: 's.id', type: 'number'},
		   { name: 's.estado', type: 'string'},
		   { name: 's.fecha', type: 'date'},
		   { name: 's.prioridad', type: 'string'},
		   { name: 's.id_ordentrabajo', type: 'string'},
		   { name: 's.nombre_responsable', type: 'string'},
		   { name: 's.cedula_responsable', type: 'number'},
		   { name: 's.id_centroscostos', type: 'string'},
		   { name: 's.v_cotizado', type: 'string'},
		   { name: 's.total_anticipo', type: 'string'},
		   { name: 's.beneficiario', type: 'string'},
		   { name: 's.num_cuenta', type: 'string'},
		   { name: 's.fecha_creacion', type: 'date'},
		   { name: 's.fecha_aprobado', type: 'date'},
		   { name: 's.valor_giro', type: 'string'},
		   { name: 'prioridad_text', type: 'string'},
		   { name: 'acciones', type: 'string'}							 
	  ],				
	  cache: false,
	  async: false,
	  url: 'ajax_data_list_anticipos.php?idhito=<?=$_REQUEST['ide_per']?>',
	  root: 'Rows',
	  sortcolumn: 's.id',
	  sortdirection: 'desc',
	  filter: function()
	  {
		  // update the grid and send a request to the server.
		  $("#jqxgrid2").jqxGrid('updatebounddata', 'filter');
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
	  
		{ text: 'ID Anticipo', datafield: 's.id', filtertype: 'textbox', filtercondition: 'equal',  width: 80,  columntype: 'textbox' },
  
		{ text: 'Estado', datafield: 's.estado', filtertype: 'checkedlist', filtercondition: 'equal', width: 80,  filteritems: ['APROBADO', 'NO REVISADO', 'RECHAZADO', 'REVISADO'] },
  
		{ text: 'Fecha', datafield: 's.fecha', filtertype: 'date', filtercondition: 'equal', width: 70, cellsformat: 'yyyy-MM-dd' },
  
		{ text: 'Prioridad', datafield: 's.prioridad', filtertype: 'checkedlist', filtercondition: 'equal', width: 50, filteritems: ['CRITICA', 'ALTA', 'MEDIA', 'BAJA', 'VINCULADO', 'GIRADO', 'RETORNO'] },
  
		{ text: 'Prioridades', datafield: 'prioridad_text', hidden: true},	
  
		{ text: 'OT', datafield: 's.id_ordentrabajo', filtertype: 'textbox', width: 70 },
		
		{ text: 'Nombre Responsable', datafield: 's.nombre_responsable', filtertype: 'textbox',  filtercondition: 'starts_with', width: 140 },
  
		{ text: 'Cedula Responsable', datafield: 's.cedula_responsable', filtertype: 'textbox',  filtercondition: 'starts_with', width:90},
  
		{ text: 'Centro Costo', datafield: 's.id_centroscostos', filtertype: 'checkedlist', width:100, filteritems: [<?=$list?>] },
  
		{ text: 'Valor Cotizado', datafield: 's.v_cotizado', filtertype: 'none', width:80},
  
		{ text: 'Total Anticipo', datafield: 's.total_anticipo', filtertype: 'none', width:80},				
  
		{ text: 'Fecha Creado', datafield: 's.fecha_creacion', filtertype: 'date', filtercondition: 'equal', width: 110, cellsformat: 'yyyy-MM-dd HH:mm:ss' },
		
		{ text: 'Fecha Aprobado', datafield: 's.fecha_aprobado', filtertype: 'date', filtercondition: 'equal', width: 110, cellsformat: 'yyyy-MM-dd HH:mm:ss' }
		
	  ]
  
  });			

});

</script>





