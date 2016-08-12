// JavaScript Document
$(document).ready(function () {

  var source =
  {
	   datatype: "json",
	   datafields: [
		   { name: 'id', type: 'number'},
		   { name: 'id_salida_mercancia', type: 'number'},
		   { name: 'id_proyecto', type: 'number'},
		   { name: 'nombre_proyecto', type: 'string'},
		   { name: 'nombre_hito', type: 'string'},
		   { name: 'id_hito', type: 'number'},
		   { name: 'total_reintegro', type: 'number'},
		   { name: 'fecha_ingreso', type: 'date'},
		   { name: 'nombre_usuario', type: 'string'},
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
		  if (data != null){
			  source.totalrecords = data[0].TotalRows;					
		  }
	  }};		

	  var dataadapter = new $.jqx.dataAdapter(source, {
		  loadError: function(xhr, status, error)
		  {
			  alert(error);
		  }
	  });

  // var dataadapter = new $.jqx.dataAdapter(source);
    var nestedGrids = new Array();
	var initrowdetails = function (index, parentElement, gridElement, record) {

		  var id = record.uid.toString();
		  var idreintegro = record['id']
		  var idsalida = record['id_salida_mercancia']

		  var grid = $($(parentElement).children()[0]);               
		  nestedGrids[index] = grid;				

		  var ordersSource =
		  {
			  datatype: "json",
			  datafields: [
					 { name: 'id', type: 'number'},
					 { name: 'codigo', type: 'string'},
					 { name: 'name_material', type: 'string'},
					 
					 { name: 'cantidade', type: 'number'},
					 { name: 'cant_reintegro', type: 'number'},
					 { name: 'cant_reintegro_anterior', type: 'number'},						
					 { name: 'valor_adjudicado', type: 'number'},
					 { name: 'total_reintegro', type: 'number'}							 
			  ],
			  cache: false,
			  url: 'ajax_list_edit_materiales.php?id='+idsalida+'&idreintegro='+idreintegro,
			  root: 'Rows',
			  sortcolumn: 'id',
			  sortdirection: 'desc'
		  };
		  
		  var nestedGridAdapter = new $.jqx.dataAdapter(ordersSource, { autoBind: false });

		  if (grid != null) { 

			  grid.jqxGrid({
				  source: nestedGridAdapter, 
				  width: '95%', 
				  height: 200,				
				  columns: [
				   		{ text: 'Item', datafield: 'id' },
	   					{ text: 'C&oacute;digo', datafield: 'codigo', width:70 },
	   					{ text: 'Nombre Material', datafield: 'name_material'},
	   					{ text: 'Cant. Total Adjudicado', datafield: 'cantidade', width: 80},
	   					{ text: 'Valor Uni. Adjudicado', datafield: 'valor_adjudicado', width:120, cellsformat:'c2'},
						{ text: 'Cant. Reintegro Anteriores', datafield: 'cant_reintegro_anterior', width: 120, align: 'center' },
	   					{ text: 'Cant. Reintegro', datafield: 'cant_reintegro', width: 80 },
	   					{ text: 'Costo Total Reintegro', datafield: 'total_reintegro', cellsformat: 'c2', width: 120 }
				  ]

			  });
		  }
  }

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
	  
	  rowdetails: true,
	  initrowdetails: initrowdetails,
	  rowdetailstemplate: { 
	  		rowdetails: "<div id='grid' style='margin: 10px;'></div>", rowdetailsheight: 220, rowdetailshidden: true 
	  },
	  rendergridrows: function(obj)
	  {
		   return obj.data;      
	  },              
	  columns: [
		
		{ text: '-', datafield: 'acciones', filtertype: 'none',pinned: true,  width: 60, sortable:false},
		{ text: 'ID', datafield: 'id', filtertype: 'number', filtercondition: 'equal',   columntype: 'textbox', width: 60 },
		{ text: 'Salidad Mercancia', datafield: 'id_salida_mercancia', filtertype: 'number', filtercondition: 'equal',   columntype: 'textbox', width: 80 },
		{ text: 'OT', datafield: 'nombre_proyecto', filtertype: 'none', filtercondition: 'starts_with' },
		{ text: 'ID Hito', datafield: 'id_hito', filtertype: 'textbox', filtercondition: 'starts_with', width: 90 },
		{ text: 'Nombre Hito', datafield: 'nombre_hito', filtertype: 'none', filtercondition: 'starts_with' },
		{ text: 'Total Reintegro', datafield: 'total_reintegro', filtertype: 'none', cellsalign: 'right', cellsformat:'c2',width: 90},
		
		{ text: 'Usuario', datafield: 'nombre_usuario', filtertype: 'none', filtercondition: 'starts_with', width: 120 },
		/*{ text: 'Fecha Entrega',  datafield: 'fecha_entrega' ,filtertype: 'date', filtercondition: 'equal', cellsformat: 'yyyy-MM-dd',width: 90},*/
		{ text: 'Fecha Ingreso', datafield: 'fecha_ingreso' ,filtertype: 'date', filtercondition: 'equal', cellsformat: 'yyyy-MM-dd',width: 90}
	  ]
  });

  $(".btn_table").jqxButton({ theme: theme });

  $('#clearfilteringbutton').click(function(){
	  $("#jqxgrid").jqxGrid('clearfilters');
  });

  $("#excelExport").click(function () {
	  $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Solicitud Mercancia');           
  });

  $('#excelExport2').click(function(){
	  var fecini = $('#fecini_e').val();
	  var fecfin = $('#fecfin_e').val();
	  window.open("/reintegros/reintegro/export_excel.php?fecini="+fecini+"&fecfin="+fecfin);
  });
  
  var mainDemoContainer = $('body');
  
  var offset = mainDemoContainer.offset();
  
  $('#addreintegroWindow').jqxWindow({
		minHeight: '65%', minWidth: '80%', zIndex:18032,
		resizable: true, isModal: true, modalOpacity: 0.3,autoOpen: false
  });
  
  $('#editreintegroWindow').jqxWindow({
		minHeight: '65%', minWidth: '80%', zIndex:18032,
		resizable: true, isModal: true, modalOpacity: 0.3,autoOpen: false
  });
  
  $('#viewreintegroWindow').click(function(){
	  getsalidaById(0,'list'); 
	  
	  $("#jqxgrid_items").jqxGrid({ editable: false });
	  $("#jqxdropdownbutton").jqxDropDownButton({ disabled: false });
	  $("#jqxdropdownbutton").jqxDropDownButton('setContent', '');
	  $("#btnAprobarReintegro").hide();
	  
	  $("#jqxgrid_inv").jqxGrid('clearfilters');
	  $("#jqxgrid_inv").jqxGrid('updatebounddata', 'filter');
	  
	  $('#addreintegroWindow').jqxWindow('open');
  });
  
  // Lista de salida de mercancia
  var source_inventario =
  {
	   datatype: "json",
	   datafields: [
		   { name: 'id', type: 'string'},
		   { name: 'nombre_responsable', type: 'string'},
		   { name: 'descripcion', type: 'string'},
		   { name: 'direccion_entrega', type: 'string'},
		   { name: 'nombre_recibe', type: 'string'},
		   { name: 'fecha_solicitud', type: 'date'},
		   { name: 'fecha_entrega', type: 'date'},
		   { name: 'fecha', type: 'date'},
		   { name: 'celular', type: 'string'},
		   { name: 'acciones', type: 'string'},
		   { name: 'id_proyecto', type: 'string'},
		   { name: 'idproyecto', type: 'number'},
		   { name: 'id_hito', type: 'number'},
		   { name: 'totalizador', type: 'number'}
	  ],
	  cache: false,
	  url: 'ajax_data_salidas_aprobadas.php',
	  sortcolumn: 'id',
	  sortdirection: 'desc',
	  filter: function()
	  {
		  // update the grid and send a request to the server.
		  $("#jqxgrid_inv").jqxGrid('updatebounddata', 'filter');
	  },
	  sort: function()
	  {
		  // update the grid and send a request to the server.
		  $("#jqxgrid_inv").jqxGrid('updatebounddata', 'sort');
	  },
	  root: 'Rows',
	  beforeprocessing: function(data)
	  {		
		  if (data != null)
		  {
			  source_inventario.totalrecords = data[0].TotalRows;					
		  }
	  }};		

	  var dataadapter_inv = new $.jqx.dataAdapter(source_inventario, {
		  loadError: function(xhr, status, error)
		  {
			  alert(error);
		  }
	  });
  
  // initialize jqxGrid			
  $("#jqxdropdownbutton").jqxDropDownButton({ width: 250, height: 25});
  $("#jqxgrid_inv").jqxGrid({
	  width: 580,
	  height: 260,
	  source: dataadapter_inv,
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
	  columns: [
		{ text: 'ID', datafield: 'id', filtertype: 'number', filtercondition: 'equal',   columntype: 'textbox', width: 40 },
		{ text: 'OT', datafield: 'id_proyecto', filtertype: 'textbox', filtercondition: 'starts_with', width: 90 },
		{ text: 'ID Hito', datafield: 'id_hito', filtertype: 'textbox', filtercondition: 'starts_with', width: 90 },

		{ text: 'Nombre Responsable', datafield: 'nombre_responsable', filtertype: 'textbox', filtercondition: 'starts_with'},

		{ text: 'Dirección Entrega', datafield: 'direccion_entrega', filtertype: 'textbox',cellsalign: 'center',width: 130},
		{ text: 'Nombre Recibe', datafield: 'nombre_recibe', filtertype: 'textbox',cellsalign: 'left'},
		{ text: 'Total', datafield: 'totalizador', filtertype: 'none', cellsalign: 'right', cellsformat:'c2',width: 90},
		{ text: 'PBX/Celular', datafield: 'celular', filtertype: 'textbox',cellsalign: 'left', width: 90},
		{ text: 'Fecha Solicitud',datafield: 'fecha_solicitud' ,filtertype: 'date', filtercondition: 'equal', cellsformat: 'yyyy-MM-dd',width: 90},

		/*{ text: 'Fecha Entrega',  datafield: 'fecha_entrega' ,filtertype: 'date', filtercondition: 'equal', cellsformat: 'yyyy-MM-dd',width: 90},*/
		{ text: 'Fecha Registro', datafield: 'fecha' ,filtertype: 'date', filtercondition: 'equal', cellsformat: 'yyyy-MM-dd',width: 90}
	  ]
  });
  
  $("#jqxgrid_inv").on('rowselect', function (event) {
	  
	  var args = event.args;
	  var row = $("#jqxgrid_inv").jqxGrid('getrowdata', args.rowindex);
	  var dropDownContent = '<div style="position: relative; margin-left: 3px; margin-top: 5px;">' + row['id'] + '-' + row['id_hito'] + '</div>';
	  
	  $("#idsalida").val(row['id']); 
	  $("#idhito").val(row['id_hito']); 
	  $("#idproyecto").val(row['idproyecto']); 
	  
	  getsalidaById(row['id'],'list'); 
	  
	  $("#jqxdropdownbutton").jqxDropDownButton('setContent', dropDownContent);
	  $("#jqxdropdownbutton").jqxDropDownButton('close');				
  });
  
	  
  var tooltiprenderer = function (element) {
	  $(element).jqxTooltip({position: 'mouse', content: $(element).text() });
  }
	  
  $("#jqxgrid_items").jqxGrid({
	  width: '100%',
	  autoheight: true,
	  showfilterrow: true,
	  editable: false,
	  pageable: false,
	  filterable: true,
	  theme: theme,
	  sortable: false,
	  columnsresize: true,
	  virtualmode: true,
	  autorowheight: true,
	  showstatusbar: true,
	  statusbarheight: 50,
	  showaggregates: true,
	  //autoheight: true,
	  enabletooltips: false,
	  selectionmode: 'multiplecellsadvanced',
	  rendergridrows: function(obj)
	  {
		   return obj.data;      
	  },                
	  columns: [
	  
	  /* { text: '-', datafield: 'acciones', filtertype: 'none', pinned: true,  width: 50, sortable:false, editable: false},*/

	   { text: 'Item', datafield: 'id', filtertype: 'textbox', filtercondition: 'equal',  columntype: 'textbox', editable: false },
		
	   { text: 'C&oacute;digo', datafield: 'codigo', filtertype: 'textbox', filtercondition: 'equal',  columntype: 'textbox', editable: false, width:70 },
		
	   { text: 'Nombre Material', datafield: 'name_material', filtertype: 'textbox', filtercondition: 'equal',  columntype: 'textbox', editable: false },
		
	   { text: 'Cant. Total Adjudicado', datafield: 'cantidade', width: 80, align: 'center', cellsalign: 'right', columntype: 'numberinput', filtertype: 'none', editable: false, rendered: tooltiprenderer },
	   
	   { text: 'Valor Uni. Adjudicado', datafield: 'valor_adjudicado', filtertype: 'none', cellsalign: 'right', editable: false, width:120, cellsformat: 'c2'},
	   
		{ text: 'Cant. Reintegro Anteriores', datafield: 'cant_reintegro_anterior', width: 120, align: 'center', cellsalign: 'right', columntype: 'numberinput', filtertype: 'none', editable: false, rendered: tooltiprenderer },
		
	   { text: 'Cant. Reintegro', datafield: 'cant_reintegro', width: 80, align: 'center', cellsalign: 'right', columntype: 'numberinput', filtertype: 'none', editable: true, rendered: tooltiprenderer },
		
	   { text: 'Costo Total Reintegro', datafield: 'total_reintegro', align: 'center', cellsalign: 'right', columntype: 'numberinput', filtertype: 'none', editable: false, cellsformat: 'c2', rendered: tooltiprenderer, width: 120, aggregates: ['sum'], aggregatesrenderer: function (aggregates) {
				//console.log(aggregates)	;				  	
				var renderstring = "";
				$.each(aggregates, function (key, value) {
					var name = key == 'sum' ? 'Total' : 'Max';
					renderstring += '<div style="position: relative; margin: 4px; overflow: hidden;">' + name + ':<br/> ' + value +'</div>';
				});
				return renderstring;
			} 
		 }//fin de la columna de costo de reintegro
	  ]
  });	
  
  $("#jqxgrid_items_edit").jqxGrid({
	  
	  width: '100%',
	  autoheight: true,
	  showfilterrow: true,
	  editable: false,
	  pageable: false,
	  filterable: true,
	  theme: theme,
	  sortable: false,
	  columnsresize: true,
	  virtualmode: true,
	  autorowheight: true,
	  showstatusbar: true,
	  statusbarheight: 50,
	  showaggregates: true,
	  //autoheight: true,
	  enabletooltips: false,
	  selectionmode: 'multiplecellsadvanced',
	  rendergridrows: function(obj)
	  {
		   return obj.data;      
	  },                
	  columns: [
	  
	  /* { text: '-', datafield: 'acciones', filtertype: 'none', pinned: true,  width: 50, sortable:false, editable: false},*/

	   { text: 'Item', datafield: 'id', filtertype: 'textbox', filtercondition: 'equal',  columntype: 'textbox', editable: false },
		
	   { text: 'C&oacute;digo', datafield: 'codigo', filtertype: 'textbox', filtercondition: 'equal',  columntype: 'textbox', editable: false, width:70 },
		
	   { text: 'Nombre Material', datafield: 'name_material', filtertype: 'textbox', filtercondition: 'equal',  columntype: 'textbox', editable: false },
		
	   { text: 'Cant. Total Adjudicado', datafield: 'cantidade', width: 80, align: 'center', cellsalign: 'right', columntype: 'numberinput', filtertype: 'none', editable: false, rendered: tooltiprenderer },
	   
	   { text: 'Valor Uni. Adjudicado', datafield: 'valor_adjudicado', filtertype: 'none', cellsalign: 'right', editable: false, width:120, cellsformat: 'c2'},
	   
		{ text: 'Cant. Reintegro Anteriores', datafield: 'cant_reintegro_anterior', width: 120, align: 'center', cellsalign: 'right', columntype: 'numberinput', filtertype: 'none', editable: false, rendered: tooltiprenderer },
		
	   { text: 'Cant. Reintegro', datafield: 'cant_reintegro', width: 80, align: 'center', cellsalign: 'right', columntype: 'numberinput', filtertype: 'none', editable: true, rendered: tooltiprenderer },
		
	   { text: 'Costo Total Reintegro', datafield: 'total_reintegro', align: 'center', cellsalign: 'right', columntype: 'numberinput', filtertype: 'none', editable: false, cellsformat: 'c2', rendered: tooltiprenderer, width: 120, aggregates: ['sum'], aggregatesrenderer: function (aggregates) {
				//console.log(aggregates)	;				  	
				var renderstring = "";
				$.each(aggregates, function (key, value) {
					var name = key == 'sum' ? 'Total' : 'Max';
					renderstring += '<div style="position: relative; margin: 4px; overflow: hidden;">' + name + ':<br/> ' + value +'</div>';
				});
				return renderstring;
			} 
		 }//fin de la columna de costo de reintegro
	  ]
  });	
  
  $('#btnEditar').click(function(){
	  swal({  
		  title: "Esta seguro?",   
		  text: "Se creara un reintegro vinculado con esta salida de mercancia seleccionada!",   
		  type: "warning",   
		  showCancelButton: true,   
		  confirmButtonColor: "#DD6B55",   
		  confirmButtonText: "Si!",   
		  closeOnConfirm: false 
	  }, 
	  function(){   
		  
		  $.ajax({ 
			  type: 'GET',
			  dataType: 'json',
			  url: 'ajax_agregar.php',
			  data: $('#formReintegro').serialize(),
			  success: function(data){
			  
				  if(data.estado){
					  swal("Vinculado", "Ya esta listo para ingresar.", "success"); 
					  $("#jqxgrid_items").jqxGrid({ editable: true });
					  $("#jqxdropdownbutton").jqxDropDownButton({ disabled: true });
					  $("#idreintegro").val(data.idreintegro);
					  $("#btnAprobarReintegro").show();
				  }else
					  swal("Error", data.msj, "error");
			  }
		  });				
	  });
  });
  
  $("#jqxgrid_items").on('cellendedit', function(event) {
	   var args = event.args;
	   
	   var valorAdjudicado = $("#jqxgrid_items").jqxGrid('getcellvalue',args.rowindex, 'valor_adjudicado');
	   var cantidade = $("#jqxgrid_items").jqxGrid('getcellvalue',args.rowindex, 'cantidade');
	   var total = cantidade - $("#jqxgrid_items").jqxGrid('getcellvalue',args.rowindex, 'cant_reintegro_anterior');
	   
	   if(args.value > total ){
		  alert('No puede reintegrar esa cantidad');				
		  $("#jqxgrid_items").jqxGrid('setcellvalue',args.rowindex, 'cant_reintegro', 0);
	   }else{				 
		  var total = valorAdjudicado * args.value;									 
		  $("#jqxgrid_items").jqxGrid('setcellvalue',args.rowindex, 'total_reintegro', total);
		  
		  $.ajax({ 
			  type: 'POST',
			  dataType: 'json',
			  url: 'ajax_add_reintegro_item.php',
			  data: {	id_reintegro: $('#idreintegro').val(),
					  id_materiales: $("#jqxgrid_items").jqxGrid('getcellvalue',args.rowindex, 'id'),
					  id_inventario: $("#jqxgrid_items").jqxGrid('getcellvalue',args.rowindex, 'codigo'),
					  cantidade: cantidade,
					  
					  valor_adjudicado: valorAdjudicado,
					  cantidad_reintegro: args.value,
					  costo_reintegro: total,
					  id_temp_mercancias: $('#idsalida').val(),
			  }, 
			  success: function(data){
				  console.log(data);
				  //$("#jqxgrid_items").jqxGrid('updatebounddata', 'cells');
			  }											
		  });						
		  //saveItemReintegro(args.rowindex);
	   }				 
  });	
  
  $('#btnAprobarReintegro').click(function(){
		  swal({  
			  title: "Esta seguro?",   
			  text: "Al aprobar este reintegro cambiara las unidades del inventario!",   
			  type: "warning",   
			  showCancelButton: true,   
			  confirmButtonColor: "#DD6B55",   
			  confirmButtonText: "Si!",   
			  closeOnConfirm: false 
		  }, 
		  function(){  
		  
			  $.ajax({ 
				  type: 'POST',
				  dataType: 'json',
				  url: 'ajax_aprobar.php',
				  data: {	id_reintegro: $('#idreintegro').val() }, 
				  success: function(data){
					  swal("Realizado", "Los cambios fueron realizados exitosamente.", "success"); 
					  $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
					  $('#addreintegroWindow').jqxWindow('close');
				  }											
			  });	
		  });
  });		
});

function fn_export_mercancia(id){
	window.open("/reintegros/reintegro/export_pdf.php?ide_per="+id);
}

/*Modulo de la grilla de salida de mercancia seleccionada*/
function getsalidaById(idsalida,type,idreintegro){
		
		if(type == 'list')
			seturl = 'ajax_list_materiales.php?id='+idsalida;
		else
			seturl = 'ajax_list_edit_materiales.php?id='+idsalida+'&idreintegro='+idreintegro;
		
		var source_items =
		{
			datatype: "json",
			datafields: [
				 { name: 'id', type: 'number'},
				 { name: 'codigo', type: 'string'},
				 { name: 'name_material', type: 'string'},
				 
				 { name: 'cantidade', type: 'number'},
				 { name: 'cant_reintegro', type: 'number'},
				 { name: 'cant_reintegro_anterior', type: 'number'},						
				 { name: 'valor_adjudicado', type: 'number'},
				 { name: 'total_reintegro', type: 'number'}							 
			],
			updaterow: function (rowid, rowdata, commit) {
				// synchronize with the server - send update command
				// call commit with parameter true if the synchronization with the server is successful 
				// and with parameter false if the synchronization failder.
				commit(true);
			},
			cache: true,
			url: seturl,
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
				if (data != null){
					source_items.totalrecords = data[0].TotalRows;					
				}
			}};		

			var dataadapter_items = new $.jqx.dataAdapter(source_items, {
				loadError: function(xhr, status, error){
					alert(error);
				}
			});	
			 // update data source.
			 
			if(type == 'list')
				$("#jqxgrid_items").jqxGrid({ source: dataadapter_items });
			else
				$("#jqxgrid_items_edit").jqxGrid({ source: dataadapter_items });			
}

function fn_mostrar_frm_modificar(idsalidamercancia,id){		
	getsalidaById(idsalidamercancia,'edit',id);
	$('#editreintegroWindow').jqxWindow('open'); 
}

function saveItemReintegro(index){
	
	var save = true;
	var cantidadr = $("#jqxgrid_items").jqxGrid('getcellvalue',index, 'cant_reintegro');
	var valorAdjudicado = $("#jqxgrid_items").jqxGrid('getcellvalue',index, 'valor_adjudicado');
	var cantidade = $("#jqxgrid_items").jqxGrid('getcellvalue',index, 'cantidade');
	var total = cantidade - $("#jqxgrid_items").jqxGrid('getcellvalue',index, 'cant_reintegro_anterior');
	
	totalReintegro = cantidadr * valorAdjudicado;
		
	/*if(cantidadr <= total){
		totalReintegro = cantidadr * valorAdjudicado;
		$("#jqxgrid_items").jqxGrid('setcellvalue', index, 'total_reintegro', totalReintegro);
		save = true;
	}else{
		$("#jqxgrid_items").jqxGrid('setcellvalue', index, 'total_reintegro', totalReintegro);
		alert('La cantidad de reintegro no puede ser menor a la cantidad total entregada + cantidad reintegrada anteriormente');
	}*/
		
	if(save){				
		$.ajax({ 
			type: 'POST',
			dataType: 'json',
			url: 'ajax_add_reintegro_item.php',
			data: {	id_reintegro: $('#idreintegro').val(),
					id_material: $("#jqxgrid_items").jqxGrid('getcellvalue',index, 'codigo'),
					cantidade: cantidade,
					
					valor_adjudicado: valorAdjudicado,
					cantidad_reintegro: cantidadr,
					costo_reintegro: totalReintegro,
					id_temp_mercancias: $('#idsalida').val(),
			}, 
			success: function(data){
				$("#jqxgrid_items").jqxGrid('updatebounddata', 'cells');
			}											
		});	
	}
}


$(document).ready(function(){

	//fn_buscar();

	$("#grilla tbody tr").mouseover(function(){

		$(this).addClass("over");

	}).mouseout(function(){

		$(this).removeClass("over");

	});
	
	
});



function fn_cerrar(){

	/*$.unblockUI({ 

		onUnblock: function(){

			$("#div_oculto").html("");

		}

	}); */
	
	$('#eventWindow').jqxWindow('close');

	$("#jqxgrid").jqxGrid('updatebounddata', 'cells');

};



function fn_mostrar_frm_agregar(){

	$("#div_oculto").load("ajax_form_agregar.php", function(){

		$.blockUI({

			message: $('#div_oculto'),

			css:{

				top: '20%'

			}

		}); 

	});

};



function fn_paginar(var_div, url){

	var div = $("#" + var_div);

	$(div).load(url);

	/*

	div.fadeOut("fast", function(){

		$(div).load(url, function(){

			$(div).fadeIn("fast");

		});

	});

	*/

}



function fn_eliminar(ide_per, material){

	var respuesta = confirm("Desea eliminar esta salida de mercancia?");

	if (respuesta){

		$.ajax({

			url: 'ajax_eliminar.php',

			data: 'id=' + ide_per + '&material=' + material,

			type: 'post',

			success: function(data){

				if(data!="")

					alert(data);

				$("#jqxgrid").jqxGrid('updatebounddata', 'cells');

			}

		});

	}

}



function fn_buscar(){

	var str = $("#frm_buscar").serialize(); 

	$.ajax({

		url: 'ajax_listar.php',

		type: 'get',

		data: str,

		success: function(data){

			$("#div_listar").html(data);

		}

	});

}



function cargar_costo_unidad (idMaterial) {

	$.ajax ({

		url: 'cargar_costo_unidad.php',

		type: 'post',

		data: 'idMaterial=' + idMaterial,

		dataType: 'json',

		success: function (data) {

			$("#costo_unidad").val(data.costo);

			$("#cantidadInv").val(data.cantidad);

		}

	});

}





function fn_showMateriales(ide_per){ 

	$("#div_oculto").load("ajax_form_addmaterial.php", {ide_per: ide_per}, function(){

		$.blockUI({

			message: $('#div_oculto'),

			css:{

				top: '5%',

				width: '65%',  

				left: '19%'

			}

		}); 

	});

};



function fn_export_mercancia(id){
	window.open("/salida_mercancia/salida_mercancia/export_pdf.php?ide_per="+id);
}



/* Items */
function fn_eliminar_item(id_Material){

	$.ajax ({

		url: '/solicitud_despacho/solicitud_despacho/ajax_eliminar_item.php',

		type: 'post',

		data: {idMaterial:id_Material},

		dataType: 'json',

		success: function (data) {

			$("#jqxgrid2").jqxGrid('updatebounddata', 'cells');

		}

	});

}



function fn_aprobar_item(id_Material,rowindex) {
		
	/*var cantidadc = $("#jqxgrid2").jqxGrid('getcellvalue',rowindex, 'cantidadc');
	var costo2 = $("#jqxgrid2").jqxGrid('getcellvalue',rowindex, 'costo2');
	var cantidade = $("#jqxgrid2").jqxGrid('getcellvalue',rowindex, 'cantidade');*/ 
	
	//var ct_compra = $("#jqxgrid2").jqxGrid('getcellvalue',rowindex, 'ct_compra');
	var estado = true; 
	
	/*if( (cantidadc = null) || 
		(costo2 == null || costo2 <= 0) || 
		(cantidade == null || cantidade <= 0) ){
			estado = false;
	}*/
	
	
	if(estado){
		$.ajax ({
			url: '/solicitud_despacho/solicitud_despacho/ajax_aprobar_item.php',
			type: 'post',
			data: {idMaterial:id_Material, type:'one'},
			dataType: 'json',
			success: function (data) {
				$("#jqxgrid2").jqxGrid('updatebounddata', 'cells');
				
			}
		});
	}else{
		alert('El Costo de compra no puede estar vacio o en 0');
	}

}



function fn_aprobar_allitems(id_despacho) { 

	/*var datainformations = $("#jqxgrid2").jqxGrid('getdatainformation');
	var rowscounts = datainformations.rowscount - 1;
	var estado = true; 
	
	for(i=0; i <= rowscounts; i++){
		var cantidadc = $("#jqxgrid2").jqxGrid('getcellvalue',i, 'cantidadc');
		var costo2 = $("#jqxgrid2").jqxGrid('getcellvalue',i, 'costo2');
		var cantidade = $("#jqxgrid2").jqxGrid('getcellvalue',i, 'cantidade');
		
		if( (cantidadc == null || cantidadc <= 0) || 
			(costo2 == null || costo2 <= 0) || 
			(cantidade == null || cantidade <= 0) ){
				estado = false;
		}
	}
	
	if(estado){*/
		$.ajax ({
			url: '/solicitud_despacho/solicitud_despacho/ajax_aprobar_item.php',
			type: 'post',
			data: {idDespacho:id_despacho, type:'All'},
			dataType: 'json',
			success: function (data) {
				$("#jqxgrid2").jqxGrid('updatebounddata', 'cells');
				$('.aprobarALL').hide();
			}
		});
	/*}else{
		alert('Complete o verfique todos los campos sea mayor a 0');
	}*/

}



function fn_aprobar_allitems2(id_Material) { 

	

	var respuesta = confirm("Desea aprobar todos los materiales de la solicitud #"+id_Material+" seleccionada?");

	if (respuesta){	

		$.ajax ({

			url: '/solicitud_despacho/solicitud_despacho/ajax_aprobar_item.php',

			type: 'post',

			data: {idMaterial:id_Material, type:'All'},

			dataType: 'json',

			success: function (data) {

				$("#jqxgrid").jqxGrid('updatebounddata', 'cells');

			}

		});

	}

}



/*-------------------------------------------------------------------------------*/

function fn_agregar_material(){ 

	var str = $("#form_material").serialize();  
	$.ajax({
		url: '/solicitud_despacho/solicitud_despacho/ajax_agregar_material.php',
		data: str,
		type: 'post',
		success: function(data){
			if(data != "") {
				alert(data);
			}else{ 
				$('.alert-box').slideUp();
				$('#form_material').reset();
				$("#jqxgrid2").jqxGrid('updatebounddata');
			}
		}
	});

};