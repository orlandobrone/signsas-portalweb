<?php  
	include "../../restrinccion.php";  
	require_once "../../config.php";
	require_once "../../restrinccion.php";

	define('URL_SECCION', URL_HITOS);
	define('SECCION', HITOS);  
	
	require_once "../../tpl_top.php"; 

	$query = "SELECT COUNT(*) AS Total FROM hitos" ;
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	$rows = mysql_fetch_assoc($result);
?>
    <style>
		.money{ text-align:right; }
	</style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="/js/masknoney/jquery.maskMoney.js" type="text/javascript"></script>   
    
    <script type="text/javascript">
    $(document).ready(function () {
			
			var mainDemoContainer = $('body');	
			var offset = mainDemoContainer.offset();
			
			var n = noty({
				layout: 'topRight',
				type: 'warning',
				text: 'AVISO: El primer día de cada mes, todos los hitos con estado ADMIN cambiaran a estado CERRADO!',
				animation: {
					open: {height: 'toggle'}, // jQuery animate function property object
					close: {height: 'toggle'}, // jQuery animate function property object
					easing: 'swing', // easing
					speed: 500 // opening & closing animation speed
				}
			});

            var source =

            {

			 datatype: "json",
  
			 datafields: [
  
				 { name: 'id', type: 'integer'},
  
				 { name: 'id_proyecto', type: 'string'},
  
				 { name: 'nombre', type: 'string'},
  
				 { name: 'estado', type: 'string'},
				 
				 { name: 'autorizado', type: 'string'},
  
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
				 
				 { name: 'cliente', type: 'string'}, 
  
				 { name: 'acciones', type: 'string'}
  
			],
  
			cache: false,
			url: 'ajax_data.php',
			sortcolumn: 'id',
			sortdirection: 'desc',
			filter: function(){
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
			
			// var dataadapter = new $.jqx.dataAdapter(source);
			var nestedGrids2 = new Array();
			var initrowdetails2 = function (index, parentElement, gridElement, record) {
				
				  var id = record.uid.toString();
				  var id_anticipo = record['s.id'];
				  var grid = $($(parentElement).children()[0]);     
				            
				  nestedGrids2[index] = grid;				
		
				  var ordersSource =
				  {
					  datatype: "json",
					  datafields: [
						 { name: 'id_anticipo', type: 'number'},
						 { name: 'id_hitos', type: 'number'},
						 { name: 'acpm', type: 'number'},
						 { name: 'valor_transporte', type: 'number'},
						 { name: 'toes', type: 'number'},
						 { name: 'viaticos', type: 'number'},
						 { name: 'mular', type: 'number'},
						 { name: 'total', type: 'number'}					 
					  ],
					  cache: false,
					  url: 'ajax_items_anticipo.php?idanticipo='+id_anticipo,
					  root: 'Rows',
					  sortcolumn: 'id',
					  sortdirection: 'desc'
				  };
				  
				  var nestedGridAdapter2 = new $.jqx.dataAdapter(ordersSource, { autoBind: false });
		
				  if (grid != null) { 
		
					  grid.jqxGrid({
						  source: nestedGridAdapter2, 
						  width: '95%', 
						  height: 200,				
						  columns: [
						  	{ text: 'ID Anticipo', datafield: 'id_anticipo', width: 80 },
							{ text: 'ID Hito', datafield: 'id_hitos', width: 80 },
							{ text: 'Valor Transporte', datafield: 'valor_transporte',  width:120,cellsalign: 'right', cellsformat: 'c2'},
							{ text: 'ACPM', datafield: 'acpm',  width: 120 ,cellsalign: 'right',cellsformat: 'c2' },
							
							{ text: 'TOES', datafield: 'toes',  width: 120, cellsformat: 'c2',cellsalign: 'right' },
							{ text: 'Viaticos', datafield: 'viaticos',  width: 120 ,cellsalign: 'right',cellsformat: 'c2' },
							{ text: 'Trans. Mular', datafield: 'mular',  width: 120 ,cellsalign: 'right',cellsformat: 'c2' },
							{ text: 'Total', datafield: 'total',  width: 120, cellsformat: 'c2',cellsalign: 'right' }
						  ]		
					  });
				  }
		    }
			
			
			var nestedGrids = new Array();
			var initrowdetails = function (index, parentElement, gridElement, record) {
				  //console.log(record['id'])
				  var id = record.uid.toString();
				  var idhito = record['id'];
				  var grid = $($(parentElement).children()[0]);               
				  nestedGrids[index] = grid;				
		
				  var ordersSource =
				  {
					  datatype: "json",
					  datafields: [
						   { name: 's.id', type: 'number'},
						   { name: 's.orden_servicio_id', type: 'number'},
						   
						   { name: 's.estado', type: 'string'},
						   { name: 's.fecha', type: 'date'},
						   { name: 's.prioridad', type: 'string'},
						   { name: 's.id_ordentrabajo', type: 'string'},
						   { name: 's.nombre_responsable', type: 'string'},
						   { name: 's.cedula_responsable', type: 'number'},
						   { name: 's.id_centroscostos', type: 'string'},
						   { name: 's.v_cotizado', type: 'number'},
						   { name: 's.total_anticipo', type: 'number'},
						   { name: 's.beneficiario', type: 'string'},
						   { name: 's.num_cuenta', type: 'string'},
						   { name: 's.fecha_creacion', type: 'date'},
						   { name: 's.fecha_aprobado', type: 'date'},
						   { name: 's.valor_giro', type: 'string'},
						   { name: 'prioridad_text', type: 'string'},
						   
						   { name: 'costo_vehiculos', type: 'number'},
						   { name: 'reintegro', type: 'number'},
						   { name: 'anticipos_anteriores', type: 'number'},	
						   { name: 'costo_compra', type: 'number'},
						   { name: 'total_costo', type: 'number'}	,
						   { name: 'costo_manobra', type: 'number'},
						   { name: 'total_anticipo', type:'number'}							 
					  ],
					  cache: false,
					  url: 'ajax_data_list_anticipos.php?idhito='+idhito,
					  root: 'Rows',
					  sortcolumn: 'id',
					  sortdirection: 'desc'
				  };
				  
				  var nestedGridAdapter = new $.jqx.dataAdapter(ordersSource, { autoBind: false });
		
				  if (grid != null) { 
		
					  grid.jqxGrid({
						  source: nestedGridAdapter, 
						  width: '93%', 
						  height: 200,	
						  columnsresize: true,
						  rowdetails: true,
						  initrowdetails: initrowdetails2,
						  rowdetailstemplate: { 
							  rowdetails: "<div id='grid' style='margin: 10px;'></div>", rowdetailsheight: 220, rowdetailshidden: true 
						  },     
						  
						  rendergridrows: function(obj){
								 return obj.data;      
						  },        			
						  columns: [
						  		{ text: 'ID Anticipo', datafield: 's.id', width: 70 },
								
								{ text: 'ID OS', datafield: 's.orden_servicio_id', width: 70 },
  
								{ text: 'Estado', datafield: 's.estado',  width: 80 },
						  
								{ text: 'Fecha', datafield: 's.fecha', width: 70, cellsformat: 'yyyy-MM-dd' },
						  
								{ text: 'Prioridad', datafield: 's.prioridad', width: 50 },
						  
								{ text: 'Prioridades', datafield: 'prioridad_text', hidden: true},	
								
								{ text: 'OT', datafield: 's.id_ordentrabajo', filtertype: 'textbox', width: 70 },
								
								{ text: 'Nombre Responsable', datafield: 's.nombre_responsable', filtertype: 'textbox', width: 140 },
						  
								{ text: 'Cedula Responsable', datafield: 's.cedula_responsable', filtertype: 'textbox', width:90},
						  
								{ text: 'Centro Costo', datafield: 's.id_centroscostos', width:100 },
								
								{ text: 'Reintegro', datafield: 'reintegro', filtertype: 'none', width: 120,cellsalign: 'right',cellsformat: 'c2' },
								
								{ text: 'Costo Materiales', datafield: 'costo_compra', filtertype: 'none', width: 120,cellsalign: 'right',cellsformat: 'c2' },
						  
						  		{ text: 'Costo de Vehículos', datafield: 'costo_vehiculos', filtertype: 'none', width:120,cellsalign: 'right', cellsformat: 'c2'},

						 		{ text: 'Costo Mano Obra', datafield: 'costo_manobra', filtertype: 'none', width: 120,cellsalign: 'right',cellsformat: 'c2' },
						  
						  		{ text: 'Anticipos Aprobados', datafield: 'anticipos_anteriores', filtertype: 'none', width: 120,cellsformat: 'c2',cellsalign: 'right' },
						  
						 	 	{ text: 'Total Costos', datafield: 'total_costo', filtertype: 'none', width: 120, cellsformat: 'c2',cellsalign: 'right' },								
						  
								{ text: 'Anticipo Hito', datafield: 's.v_cotizado',cellsformat: 'c2',cellsalign: 'right', width:110},
						  
								{ text: 'Total Anticipo', datafield: 's.total_anticipo',  width:150, cellsformat: 'c2',cellsalign: 'right'},				
						  
								{ text: 'Fecha Creado', datafield: 's.fecha_creacion', width: 110, cellsformat: 'yyyy-MM-dd HH:mm:ss' },
								
								{ text: 'Fecha Aprobado', datafield: 's.fecha_aprobado', width: 110, cellsformat: 'yyyy-MM-dd HH:mm:ss' },
						  ]		
					  });
				  }
		  }



         $("#jqxgrid").jqxGrid({

                width: '95%',
				height: 500,
                source: dataadapter,
                showfilterrow: true,
                pageable: true,
                filterable: true,
                theme: theme,
				sortable: true,
                columnsresize: true,
				pagesize: 20,
				pagesizeoptions: ['<?=$rows['Total']?>', 10, 20, 50, 100, 150, 250, 500],
				virtualmode: true,
			    rowdetails: true,
			    initrowdetails: initrowdetails,
			    rowdetailstemplate: { 
					rowdetails: "<div id='grid' style='margin: 10px;'></div>", rowdetailsheight: 220, rowdetailshidden: true 
			    },     
				rendergridrows: function(obj){
					   return obj.data;      
				},            
                columns: [ 

                  { text: 'ID', datafield: 'id',  filtertype: 'textbox', filtercondition: 'equal',  width: 40,  columntype: 'textbox'  },

                  { text: 'Proyecto', datafield: 'id_proyecto', filtertype: 'textbox', width: 120 },

                  { text: 'Nombre Hito', datafield: 'nombre', filtertype: 'textbox', filtercondition: 'starts_with', width: 120 },
				  
				  { text: 'Factor', datafield: 'factor', filtertype: 'textbox', filtercondition: 'starts_with', width: 60 },

				  { text: 'Estado', datafield: 'estado', filtertype: 'checkedlist', filtercondition: 'equal', width: 70, filteritems: ['PENDIENTE', 'EN EJECUCION', 'EJECUTADO', 'LIQUIDADO', 'INFORME ENVIADO', 'EN FACTURACION', 'FACTURADO', 'CANCELADO', 'DUPLICADO', 'PAGADO', 'ADMIN', 'COTIZADO', 'AUTORIZADO']  },
				  
				  { text: 'Autorizado', datafield: 'autorizado', filtertype: 'none', filtercondition: 'starts_with', width: 60 },
				  
				  { text: 'Cliente', datafield: 'cliente', filtertype: 'none', filtercondition: 'starts_with', width: 120 },
				  
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

				  { text: '-', datafield: 'acciones', filtertype: 'none', width:152, pinned: true}

                ]

            });

            $('#clearfilteringbutton').click(function () {

                $("#jqxgrid").jqxGrid('clearfilters');

            });

			$("#excelExport").click(function () {

					$('#jqxgrid').jqxGrid('hidecolumn', 'acciones'); 

				setTimeout(function(){    

                	$("#jqxgrid").jqxGrid('exportdata', 'xls', 'Hitos');   

				},1000);

				setTimeout(function(){

					$('#jqxgrid').jqxGrid('showcolumn', 'acciones');  

				},3000);

            });

			
			$('#excelExport2').click(function(){
				
				var inicio,fin;
				
				finicio = $('#fecini2').val();
				ffin = $('#fecfin2').val();				
				
				window.open("/hitos/hitos/export_excel.php?fecini="+finicio+"&fecfin="+ffin);
			});
			
			
			$('#excelExport3').click(function(){
				
				var inicio,fin;
				
				finicio = $('#fecini2').val();
				ffin = $('#fecfin2').val();				
				
				window.open("/hitos/hitos/export_excel_estados.php?fecini="+finicio+"&fecfin="+ffin);
			});
			
			$('#closedAllhitos').click(function(){
				
				var respuesta = confirm("Desea cerrar todos los hito?");
				if (respuesta){
					$.ajax({
						url: 'ajax_closed_hitos.php',						
						type: 'post',
						success: function(data){
							$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
						}
					});
				}
			});
			
			$('#eventWindowForm').jqxWindow({
				minHeight: 150, minWidth: 400, zIndex:3500,
				resizable: true, isModal: true, modalOpacity: 0.3,autoOpen: false,
				position: { x: offset.left + 530, y: offset.top + 130}
			});
			
			$('input[name=autorizar]').change(function(){
				var value = $(this).val();
				$('.no_autorizo').val('');
				
				if(value == 2){					
					$('.no_autorizo').show();
					$('#eventWindowForm').jqxWindow('resize',400,300);
				}else{
					$('.no_autorizo').hide();
					$('#eventWindowForm').jqxWindow('resize',400,150);
				}
			});
			
			$('#cancelButton').click(function(){
				$('#eventWindowForm').jqxWindow('close');
			});
			
			$('#btnSave').click(function(){
				$.ajax({
					url: 'ajax_autorizar_hito.php',
					data: $('#form_autorizar').serialize(),
					type: 'post',
					dataType: 'json',
					success: function(data){
						if(data.estado){
							fn_cerrar();
							$('#eventWindowForm').jqxWindow('close');
						}else{
							swal("Oops...", data.mensage, "error");
						}						
					}
				});
			});

			//$('#grid').jqxGrid({ pagesizeoptions: ['10', '20', '30']}); 

    });

    </script>

    

    	<div id="cuerpo">

            <h1>HITOS <span style="color:#FF0000;display:none;">- EN MANTENIMIENTO</span></h1>
            
            <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

             <?php if(in_array(307,$_SESSION['permisos'])):?>  
             	<input value="Agregar Hito" type="button" onclick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />
             <?php endif; ?>

             <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />

           <!--  <input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" />
             
             -->
			  <label style="margin-left:5px;">Exportar desde: </label>
              <input name="fecini" type="text" id="fecini2" size="20" readonly />
    		  <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador3" />
    
                    <script type="text/javascript">
    
                        Calendar.setup({
    
                            inputField     :    "fecini2",      // id del campo de texto
    
                            ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
    
                            button         :    "lanzador3"   // el id del botón que lanzará el calendario
    
                        });
    
                    </script> 
                    
                 <label>Hasta: </label>   
                 <input name="fecfin" type="text" id="fecfin2" size="20" readonly />
    
                 <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador4" />
  
                 <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "fecfin2",      // id del campo de texto
                        ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                        button         :    "lanzador4"   // el id del botón que lanzará el calendario
                    });
                 </script>                  
             <input type="button" value="Exportar Todo a Excel" id='excelExport2' class="btn_table" />
             
             <?php if(in_array(311,$_SESSION['permisos'])):?>  
             <input type="button" value="Export Log Estados" id="excelExport3" class="btn_table" />
             <?php endif; ?>
             
             <?php if(in_array(308,$_SESSION['permisos'])):?>  
             <input type="button" value="Cerrar Hitos" id="closedAllhitos" class="btn_table" />
             <?php endif; ?>

            </div>

            <div id="jqxgrid"></div>
            
             <?php if($_SESSION['perfil'] == 5):?>  
             	<ul>
                	<li><img src="https://cdn3.iconfinder.com/data/icons/musthave/16/Cancel.png" /> Hito Amarrado a un anticipo con prioridad Girado</li>
                    <li><img src="https://cdn2.iconfinder.com/data/icons/circular%20icons/warning.png" /> Hito Amarrado con anticipos</li>
                    <li><img src="https://cdn4.iconfinder.com/data/icons/6x16-free-application-icons/16/Lock.png" /> Hito Cerrado</li>
                    <li><img src="https://cdn4.iconfinder.com/data/icons/6x16-free-application-icons/16/Unlock.png" /> Hito Abierto</li>
                    <li><img src="https://cdn0.iconfinder.com/data/icons/news-and-magazine/512/categories-16.png" />Acciones del Hito</li>
                    <li><img src="https://cdn4.iconfinder.com/data/icons/munich/16x16/check.png" />Hito Aprobado en OS</li>
                    <li><img src="https://cdn3.iconfinder.com/data/icons/files/100/236988-file_move_transfer-16.png" />Transferir Hito</li>
                    <li><img src="https://cdn2.iconfinder.com/data/icons/oxygen/16x16/apps/preferences-desktop-notification.png" />Autorizar Hito</li>
                  
                </ul>
            <?php endif ?>
            
            <div id="eventWindowForm">
               <div>
                    <img width="14" height="14" src="https://cdn0.iconfinder.com/data/icons/fatcow/16/table_add.png" alt="" />
                    Formato de Autorización
                </div>
                <div id="content_form">
                	Seleccione una acción para este Hito:
                    <br/><br/>
                    <form id="form_autorizar">
                    	<input type="hidden" name="id" id="id_hito"/>
                        <div style="margin:0 auto;width:24%;">
                            Si <input type="radio" value="1" name="autorizar">
                            No <input type="radio" value="2" name="autorizar">
                        </div>
                        <div class="no_autorizo" style="display:none;">
                            <textarea name="observaciones" cols="5" rows="8" style="width:99%"></textarea>
                        </div>
                    </form>
                    <br/><br/>
                    <div style="margin:0 auto;width:41%;">
                    	<input type="button" value="Cancelar" id="cancelButton" class="btn_table"/>
                    	<input type="button" value="Guardar"  id="btnSave" class="btn_table"/>
                    </div>
                </div>
            </div>
            

            <div id="div_oculto" style="display: none;"></div>

            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

    <?php require_once "../../tpl_bottom.php"; ?>



<!--    </body>

</html>-->