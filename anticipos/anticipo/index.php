<?php  
	include "../../restrinccion.php";  
	include "../../conexion.php";

	$resultado = mysql_query("SELECT * FROM linea_negocio WHERE 1") or die(mysql_error());

	$total = mysql_num_rows($resultado);
	
	if($total > 0):
		while($row = mysql_fetch_assoc($resultado)):
			$list .= "'".$row['id'].'.'.utf8_encode($row['nombre'])."',";
		endwhile;
	endif;

	require_once "../../config.php";
	define('URL_SECCION', URL_ANTICIPOS);
	define('SECCION', ANTICIPO);  
	require_once "../../tpl_top.php"; 

	$query = "SELECT COUNT(*) AS Total FROM anticipo" ;
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	$rows = mysql_fetch_assoc($result);
	
	$obj = new TaskCurrent();
	$IVA = $obj->getValorConceptoFinanciero(20);

?>

    <script src="/js/jquery.inputmask.bundle.js" type="text/javascript"></script> 
    
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    
    <!--Hoja de estilos del calendario -->
	<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">
	<!-- librería principal del calendario -->
	<script type="text/javascript" src="../../calendario/calendar.js"></script>
	<!-- librería para cargar el lenguaje deseado -->
	<script type="text/javascript" src="../../calendario/calendar-es.js"></script>
	<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
	<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>

	<link href="/excel/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/excel/css/excel.css">

    <style>
		.jqx-grid-content{ z-index:10; }
		input[alt=porcentaje]{ text-align:right; }
	</style>

    <link rel="stylesheet" href="/js/chosen/chosen.css">

	<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 

    <script type="text/javascript">
	
	var iva = parseFloat(<?=$IVA?>);
	
    $(document).ready(function () {   

			var url = "/ajax/ajax_list_hitos.php";

			// prepare the data

			var source =

			{

				datatype: "json",

				datafields: [

					{ name: 'id' },

					{ name: 'orden' }

				],

				url: url,

				async: false

			};

			var dataAdapter = new $.jqx.dataAdapter(source);

			// Create a jqxDropDownList

			/*$("#jqxWidget").jqxDropDownList({

				selectedIndex: 0, source: dataAdapter, displayMember: "orden", valueMember: "id", width: 550, height: 25

			});

			// subscribe to the select event.

			$("#jqxWidget").on('select', function (event) {

				if (event.args) {

					var item = event.args.item;

					if (item) {

						var valueelement = $("<div></div>");

						valueelement.text("Value: " + item.value);

						var labelelement = $("<div></div>");

						labelelement.text("Label: " + item.label);

						$("#selectionlog").children().remove();

						$("#selectionlog").append(labelelement);

						$("#selectionlog").append(valueelement);

					}

				}

			});*/

	

            var source =

            {

                 datatype: "json",

                 datafields: [

					 { name: 's.id', type: 'number'},

					 { name: 's.estado', type: 'string'},
					 
					 { name: 's.int_estado', type: 'number'},

					 { name: 's.fecha', type: 'date'},

					 { name: 's.prioridad', type: 'string'},

					 { name: 's.id_ordentrabajo', type: 'string'},

					 { name: 's.nombre_responsable', type: 'string'},

					 { name: 's.cedula_responsable', type: 'number'},

					 { name: 's.id_centroscostos', type: 'string'},

					 { name: 's.v_cotizado', type: 'string'},

					 { name: 's.total_anticipo', type: 'number'},

					 { name: 's.beneficiario', type: 'string'},

					 { name: 's.num_cuenta', type: 'string'},

					 { name: 's.fecha_creacion', type: 'date'},
					 
					 { name: 's.fecha_aprobado', type: 'date'},

					 { name: 's.valor_giro', type: 'string'},

					 { name: 'prioridad_text', type: 'string'},
					 
					 { name: 's.cedula_consignar', type: 'string'},			 
					 
					 { name: 'acciones', type: 'string'}					 

                ],

				cache: false,

				async: false,

			    url: 'ajax_data.php',

				root: 'Rows',

				sortcolumn: 's.id',

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

			

			

            var ordersSource =

            {

				datatype: "json",

                datafields: [

					 { name: 'i.id', type: 'number'},

					 { name: 'id_hitos', type: 'number'},

					 { name: 'acpm', type: 'string'},

					 { name: 'valor_transporte', type: 'string'},

					 { name: 'toes', type: 'string'},	
					 
					 { name: 'anticipos_anteriores', type: 'string'},		
					 
					 { name: 'valor_cotizado_hito', type: 'string'},

					 { name: 'acciones', type: 'string'}					 

                ],

				cache: false, 	

				async: false,

			    url: 'ajax_list_items.php',

				root: 'Rows',

                sortcolumn: 'i.id',

                sortdirection: 'desc'

            };

            var ordersDataAdapter = new $.jqx.dataAdapter(ordersSource, { autoBind: false });

			

            orders = ordersDataAdapter.records;

            var nestedGrids = new Array();

            // create nested grid.

            var initrowdetails = function (index, parentElement, gridElement, record) {

                var id = record.uid.toString();
				var id_anticipo = record['s.id'];
				var num_estado = record['s.int_estado'];
				
				if(id_anticipo[0]=='<')
					id_anticipo = $(id_anticipo).text(); //FGR

                var grid = $($(parentElement).children()[0]);

			    nestedGrids[index] = grid;

                var ordersSource =
				{
					datatype: "json",
					datafields: [
						 { name: 'i.id', type: 'number'},
						 { name: 'idHitos', type: 'number'},
						 { name: 'id_hitos', type: 'number'},
						 { name: 'costo_vehiculos', type: 'number'},
						 { name: 'anticipos_anteriores', type: 'number'},	
						 { name: 'valor_cotizado_hito', type: 'number'},		
						 { name: 'costo_compra', type: 'number'},
						 { name: 'total_costo', type: 'number'}	,
						 { name: 'costo_manobra', type: 'number'},
						 { name: 'total_anticipo', type:'number'},
						 { name: 'valor_facturas', type:'number'},
						 { name: 'estado_hito', type:'string'}			 
					],
					cache: false,
					url: 'ajax_list_items.php?id='+id_anticipo+'&estadoA='+num_estado,
					root: 'Rows',
					sortcolumn: 'i.id',
					sortdirection: 'desc'
				};
                var nestedGridAdapter = new $.jqx.dataAdapter(ordersSource, { autoBind: false });

                if (grid != null) { 

                    grid.jqxGrid({

                        source: nestedGridAdapter, 
						width: '95%', 
						height: 200,
						rowdetails: true,
						initrowdetails: initrowdetails2,
						rowdetailstemplate: { rowdetails: "<div id='grid' style='margin: 10px;'></div>", rowdetailsheight: 220, rowdetailshidden: true },
                        columns: [

						 // { text: '-', datafield: 'acciones', filtertype: 'none', width:40, cellsalign: 'center', editable: false },

						  { text: 'ID Hito', datafield: 'idHitos', filtertype: 'textbox', filtercondition: 'equal', width: 50,  columntype: 'textbox', editable: false },

						  { text: 'Hito', datafield: 'id_hitos', columntype: 'dropdownlist', filtertype: 'textbox',  width: 130, editable: false },

						  /*{ text: 'Valor ACPM', datafield: 'acpm', filtertype: 'none', width: 130, cellsalign: 'right' },*/
						  { text: 'Costo Materiales', datafield: 'costo_compra', filtertype: 'none', width: 120,cellsalign: 'right',cellsformat: 'c2' },
						  
						  { text: 'Costo de Vehículos', datafield: 'costo_vehiculos', filtertype: 'none', width:120,cellsalign: 'right', cellsformat: 'c2'},

						  { text: 'Costo Mano Obra', datafield: 'costo_manobra', filtertype: 'none', width: 120,cellsalign: 'right',cellsformat: 'c2' },
						  
						  { text: 'Total Actual Anticipo', datafield: 'total_anticipo', filtertype: 'none', width: 120,cellsalign: 'right',cellsformat: 'c2' },
						  
						  { text: 'Anticipos Anteriores', datafield: 'anticipos_anteriores', filtertype: 'none', width: 120,cellsformat: 'c2',cellsalign: 'right' },
						  
						  { text: 'Total Costos', datafield: 'total_costo', filtertype: 'none', width: 120, cellsformat: 'c2',cellsalign: 'right' },
						  
						  { text: 'Valor Cotizado', datafield: 'valor_cotizado_hito', filtertype: 'none', width: 120, cellsformat: 'c2',cellsalign: 'right' },
						  
						  { text: 'Estado Hito', datafield: 'estado_hito', filtertype: 'none', width: 120, cellsalign: 'center' },
						  { text: 'Valor Facturas', datafield: 'valor_facturas', filtertype: 'none', width: 120, cellsformat: 'c2',cellsalign: 'right' }
						  
						]

                    });
                }
            }
			
		   var initrowdetails2 = function (index, parentElement, gridElement, record) {

				var id = record.uid.toString();
				var id_hito = record['idHitos'];
				
				console.log(id_hito); 
				
				var grid = $($(parentElement).children()[0]);

			    nestedGrids[index] = grid;

                var ordersSource = {
					datatype: "json",
					datafields: [
						 { name: 'id_anticipo', type: 'number'},
						 						 
						 { name: 'valor_transporte', type: 'number'},
						 { name: 'toes', type: 'number'},
						 { name: 'viaticos', type: 'number'},
						 { name: 'mular', type: 'number'},
						 { name: 'acpm', type: 'number'},
						 { name: 'cant_galones', type: 'number'},
						 { name: 'valor_galon', type: 'number'},
						 
						 { name: 'total', type: 'number'},
					],
					cache: false,
					url: 'ajax_view_hito.php?idhito='+id_hito,
					root: 'Rows',
					sortcolumn: 'i.id',
					sortdirection: 'desc'
				};
                var nestedGridAdapter = new $.jqx.dataAdapter(ordersSource, { autoBind: false });

                if (grid != null) { 

                    grid.jqxGrid({

                        source: nestedGridAdapter, 
						width: '95%', 
						height: 200,
                        columns: [
						  { text: 'ID Anticipo', datafield: 'id_anticipo', filtertype: 'none', width:120,cellsalign: 'right'},

						  { text: 'Valor Transporte', datafield: 'valor_transporte', filtertype: 'none', width:120,cellsalign: 'right', cellsformat: 'c2'},

						  { text: 'TOES', datafield: 'toes', filtertype: 'none', width: 120,cellsalign: 'right',cellsformat: 'c2' },
						  
						  { text: 'Viaticos', datafield: 'viaticos', filtertype: 'none', width: 120,cellsalign: 'right',cellsformat: 'c2' },
						  
						  { text: 'Trasn. Mular', datafield: 'mular', filtertype: 'none', width: 120,cellsalign: 'right',cellsformat: 'c2' },
						  
						   
				  		  { text: 'Valor Gal. ACPM', datafield: 'valor_galon', filtertype: 'none', width: 120, cellsalign: 'right',cellsformat: 'c2'  },
						  
						  { text: 'Cant. Galones', datafield: 'cant_galones', filtertype: 'none', width: 80, cellsalign: 'right' },
						  
						  { text: 'Total ACPM', datafield: 'acpm', filtertype: 'none', width: 120, cellsformat: 'c2',cellsalign: 'right' },
						  
						  
						  { text: 'Total', datafield: 'total', filtertype: 'none', width: 120, cellsformat: 'c2',cellsalign: 'right' },
						]

                    });
                }
		   }

			

           // var dataadapter = new $.jqx.dataAdapter(source);



            $("#jqxgrid").jqxGrid(

            {

                width: '100%',

				height: 500,

                source: dataadapter,

                showfilterrow: true,

                pageable: true,

                filterable: true,

                theme: theme,

				sortable: true,

                columnsresize: true,

				virtualmode: true,	

				pagesize: 20,

				pagesizeoptions: ['<?=$rows['Total']?>', 10, 20, 50, 100, 150, 250, 500],

				rowdetails: true,

				initrowdetails: initrowdetails,

                rowdetailstemplate: { rowdetails: "<div id='grid' style='margin: 10px;'></div>", rowdetailsheight: 220, rowdetailshidden: true },

				

				rendergridrows: function(obj)

				{

					 return obj.data;      

				},                  

                columns: [

				  { text: 'ID', datafield: 's.id', filtertype: 'textbox', filtercondition: 'equal',  width: 40,  columntype: 'textbox' },

                  { text: 'Acciones', datafield: 'acciones', filtertype: 'none', width:150, pinned: true, cellsalign: 'left' },

				  { text: 'Estado', datafield: 's.estado', filtertype: 'checkedlist', filtercondition: 'equal', width: 80,  filteritems: ['APROBADO', 'NO REVISADO', 'RECHAZADO', 'REVISADO'] },

                  { text: 'Fecha', datafield: 's.fecha', filtertype: 'date', filtercondition: 'equal', width: 70, cellsformat: 'yyyy-MM-dd' },

                  { text: 'Prioridad', datafield: 's.prioridad', filtertype: 'checkedlist', filtercondition: 'equal', width: 50, filteritems: ['CRITICA', 'ALTA', 'MEDIA', 'BAJA', 'VINCULADO', 'GIRADO', 'RETORNO', 'REINTEGRO'] },

                  { text: 'Prioridades', datafield: 'prioridad_text', hidden: true},	

				  { text: 'OT', datafield: 's.id_ordentrabajo', filtertype: 'textbox', width: 70 },
				  
				  { text: 'Nombre Responsable', datafield: 's.nombre_responsable', filtertype: 'textbox',  filtercondition: 'starts_with', width: 140 },

				  { text: 'Cedula Responsable', datafield: 's.cedula_responsable', filtertype: 'textbox',  filtercondition: 'starts_with', width:90},

				  { text: 'Centro Costo', datafield: 's.id_centroscostos', filtertype: 'checkedlist', width:100, filteritems: [<?=$list?>] },

				  /*{ text: 'Valor Cotizado', datafield: 's.v_cotizado', filtertype: 'none', width:80},*/

				  { text: 'Total Anticipo', datafield: 's.total_anticipo', columntype: 'numberinput', filtertype: 'textbox', cellsformat: 'c2',cellsalign: 'right', filtercondition: 'starts_with',width:80},
				  
				  { text: 'Cedula Beneficiario', datafield: 's.cedula_consignar', filtertype: 'textbox', filtercondition: 'starts_with', width:80},

				  { text: 'Beneficiario', datafield: 's.beneficiario', filtertype: 'textbox',  filtercondition: 'starts_with'},

				  { text: 'Banco', datafield: 's.num_cuenta', filtertype: 'textbox',  filtercondition: 'starts_with'},

				  { text: 'Valor Giro', datafield: 's.valor_giro', hidden: true},	

               	  { text: 'Fecha Creado', datafield: 's.fecha_creacion', filtertype: 'date', filtercondition: 'equal', width: 110, cellsformat: 'yyyy-MM-dd HH:mm:ss' },
				  
				  { text: 'Fecha Aprobado', datafield: 's.fecha_aprobado', filtertype: 'date', filtercondition: 'equal', width: 110, cellsformat: 'yyyy-MM-dd HH:mm:ss' }

			    ]

            });

			$(".btn_table").jqxButton({ theme: theme });

            $('#clearfilteringbutton').click(function () {

                $("#jqxgrid").jqxGrid('clearfilters');

            });

			$("#excelExport").click(function () {

					$('#jqxgrid').jqxGrid('hidecolumn', 'acciones'); 

					$('#jqxgrid').jqxGrid('showcolumn', 's.valor_giro');  

				setTimeout(function(){    

                	$("#jqxgrid").jqxGrid('exportdata', 'xls', 'Anticipos_<?=date('m-d-Y')?>');   

				},1000);

				setTimeout(function(){

					$('#jqxgrid').jqxGrid('showcolumn', 'acciones');

					/*$('#jqxgrid').jqxGrid('hidecolumn', 'prioridad_text');  

					$('#jqxgrid').jqxGrid('hidecolumn', 's.valor_giro'); */  

				},3000);

            });

			

			// builds and applies the filter.

            var applyFilter = function (datafield) {

                //$("#jqxgrid").jqxGrid('clearfilters');

				 var filtergroup = new $.jqx.filter();

				 var filter_or_operator = 1;

				 var filtervalue = datafield;

				 var filtercondition = 'equal';

				 var filter1 = filtergroup.createfilter('numericfilter', filtervalue, filtercondition);

				 filtergroup.addfilter(filter_or_operator, filter1);
				 // add the filters.
				 $("#jqxgrid").jqxGrid('addfilter', 's.total_anticipo', filtergroup);
				 // apply the filters.
				 $("#jqxgrid").jqxGrid('applyfilters');
            }

			$('#jqxWidget').on('change', function (event) { 
                var dataField = $("#jqxWidget").jqxDropDownList('getSelectedItem').value;
                applyFilter(dataField);
            });

			$('#excelExport2').click(function(){				
				var fecini = $('#fecini_e').val();
				var fecfin = $('#fecfin_e').val();
				window.open("/anticipos/anticipo/export_excel.php?fecini="+fecini+"&fecfin="+fecfin);
			});
			
			$('#excelExport3').click(function(){
				var fecini = $('#fecini_e').val();
				var fecfin = $('#fecfin_e').val();
				window.open("/anticipos/anticipo/export_excel_all.php?fecini="+fecini+"&fecfin="+fecfin);
			});
    });

    </script>
	
    <div id="eventWindow">
       <div>
            <img width="14" height="14" src="https://cdn0.iconfinder.com/data/icons/fatcow/16/table_add.png"/>
            Formulario de Ingreso
        </div>
        <div class="content_form">
        	<form>
                 <table>
                      <tr class="content_acpm">                 
                          <td>Galones:</td>
                          <td>
                          	<input type="text" name="galones" id="galones" value="0" alt="integer" class="valor_total_galon"/>
                          </td>
                      </tr>
                      <tr class="content_acpm">
                          <td>V. Gal&oacute;n:</td>
                          <td>
                          	<input type="text" name="valor_galon" id="valor_galon" value="0" alt="integer" class="valor_total_galon"/>
                          </td> 
                      </tr> 
                      <tr>  
                          <td>Bruto Total:</td>
                          <td>
                            <input type="text" id="valor_neto_total" name="valor_neto_total" alt="integer" value="0" onkeyup="calcularImpuesto()">
                          </td>
                      </tr>
                      <tr>           	 
                          <td>Tipo Impuesto:</td>
                          <td colspan="3">
                              <input type="checkbox" class="checktipo iva" name="tipoimp[]" value="iva"/> IVA.
                              <input type="checkbox" class="checktipo ica" name="tipoimp[]" value="ica"/> ICA.
                              <input type="checkbox" class="checktipo rtefuente" name="tipoimp[]" value="rtefuente"/> RteFuente.
                          </td>
                      </tr>  
                      <tr class="content_iva" style="display:none;">
                          <td>IVA:</td>
                          <td><input type="text" name="iva" value="0" readonly alt="integer"> X 100</td>
                      </tr>
                      <tr class="content_ica" style="display:none;">
                          <td>ICA:</td>
                          <td><input type="text" name="ica" value="0.00" onkeyup="calcularImpuesto()"> X 1000</td>
                      </tr>
                      <tr class="content_rtefuente" style="display:none;">
                          <td>RteFuente:</td>
                          <td><input type="text" name="rtefuente" value="0.00" alt="porcentaje" onkeyup="calcularImpuesto()">X 100</td>
                      </tr>                  
                      <tr>
                          <td>Total:</td>
                          <td><input type="text" name="totalconimpuesto" value="0" readonly alt="integer"></td>
                      </tr>
                  </table>               
              </form> 
              
              <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:250px; margin-top:20px;">
                   <!-- <input name="calcular" type="button" id="calcular" value="Calcular" class="btn_table" />-->
                    
                    <input type="button" id="colocar" value="Colocar" class="btn_table" />
                    <input name="cancelar" type="button" id="cancelarImp" value="Cancelar" class="btn_table"/>                   
                
              </div>
        </div>
    </div>
    
    <div id="eventWindowForm">
       <div>
            <img width="14" height="14" src="https://cdn0.iconfinder.com/data/icons/fatcow/16/table_add.png" alt="" />
        	Formato de Solicitud de Anticipo
        </div>
    	<div id="content_form"></div>
    </div>
	    
    <div id="cuerpo">

            <h1>ANTICIPOS <span style="color:#FF0000; display:none;">En matenimiento</span></h1>           

            <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

                 <? if(in_array(183,$_SESSION['permisos'])): ?>
                 <input value="Agregar Anticipo" type="button" id="btn_add_anticipo" onclick="javascript: fn_mostrar_frm_agregar();" class="btn_table"/>
                 <? endif; ?>

                 <!--<input type="button" value="Importar de Excel" onclick="fn_importar_excel()" class="btn_table" />
				 
                 <input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" /> -->
                 <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />
           
                 <label style="margin-left:5px;">Exportar desde: </label>
                 <input name="fecini" type="text" id="fecini_e" size="9" readonly />
    
                    <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador_e" />
    
                    <script type="text/javascript">
    
                        Calendar.setup({
    
                            inputField     :    "fecini_e",      // id del campo de texto
    
                            ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
    
                            button         :    "lanzador_e"   // el id del botón que lanzará el calendario
    
                        });
    
                    </script> 
                    
                 <label>Hasta: </label>   
                 <input name="fecfin" type="text" id="fecfin_e" size="9" readonly />
    
                    <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2_e" />
     
                    <script type="text/javascript">
     
                        Calendar.setup({
    
                            inputField     :    "fecfin_e",      // id del campo de texto
    
                            ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
    
                            button         :    "lanzador2_e"   // el id del botón que lanzará el calendario
    
                        });
    
                    </script> 
                    
                 <input type="button" value="Exportar a Excel Anticipos e Hitos" id="excelExport2" class="btn_table" />
                 <input type="button" value="Exportar a Excel Todos Anticipos" id="excelExport3" class="btn_table" />
                 
                 <!--<br />

                 <h3>Filtro de Hitos:</h3>

                 <div id="jqxWidget"></div>-->

            </div>
             

            <div id="jqxgrid"></div>


            <div id="div_oculto" style="display: none;"></div>

			<p align="left">Modulo Anticipos Ver. 1.1.0</p> 
            
            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

    </div>

    <?php require_once "../../tpl_bottom.php"; ?>
    
    
