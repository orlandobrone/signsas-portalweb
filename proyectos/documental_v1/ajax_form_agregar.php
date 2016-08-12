<? header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
?>

<!--Hoja de estilos del calendario -->

<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">
<!-- librería principal del calendario -->
<script type="text/javascript" src="../../calendario/calendar.js"></script>
<!-- librería para cargar el lenguaje deseado -->
<script type="text/javascript" src="../../calendario/calendar-es.js"></script>
<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>


<form action="javascript: fn_agregar();" method="post" id="frm_per">

    <table class="formulario">
        <tbody>
            <tr>
                <td>C&oacute;digo Sitio</td>
                <td><input name="codigo" type="text" id="codigo" size="40" class="required" /></td>
           </tr>
           <tr>
                <td>Actividad</td>
                <td>                	
                	<select name="actividad" id="actividad" class="required chosen-select">
                    	<option value=""></option>
                    	<option value="Suministros">Suministros</option>
                        <option value="Mantenimientos">Mantenimientos</option>
                        <option value="Instalaciones">Instalaciones</option>
                        <option value="Telecomunicaciones">Telecomunicaciones</option>
                        <option value="Instalaciones">Instalaciones</option>
                        <option value="Migraciones">Migraciones</option>                       
                    </select>
                </td>
                <td class="subcontent">Sub - Actividad</td>
                <td class="subcontent">                	
                	<select name="subactividad" id="subactividad" class="chosen-select">
                    	<option value=""></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Nombre Sitio</td>
                <td><input name="nombre_sitio" type="text" id="nombre_sitio" size="40" class="required" /></td>
          
                <td>Cliente</td>
                <td>
                	<select name="cliente" ide="cliente" class="required chosen-select">
                    	<option value=""></option>
						<?
                            $sql = "select * from cliente order by id asc";
                            $pai = mysql_query($sql);
                            while($rs_pai = mysql_fetch_assoc($pai)){
                        ?>
                            <option value="<?=$rs_pai['nombre']?>"><?=$rs_pai['nombre']?></option>
                        <? } ?>
					</select>
                
                </td>
            </tr>
            <tr>
                <td>OT, Tickets</td>
                <td><input name="ot_ticket" type="text" id="ot_ticket" size="40" class="required" /></td>
           
                <td>ID Hito</td>
                <td>
                	<div id="jqxWidget">
                        <div id="jqxdropdownbutton">
                            <div style="border-color: transparent;" id="jqxgrid_hito"></div>
                        </div>
                    </div> 
                    <input name="id_hito" type="hidden" id="id_hito" size="40" class="required" />
                </td>
            </tr>
            
            <tr>
                <td>Nombre Documentador</td>
                <td><input name="nombre_documentador" type="text" id="nombre_documentador" size="40" class="required" /></td>
           
                <td>Fecha de ejecuci&oacute;n editable</td>
                <td>
                  <input name="fecha_ejecucion_editable" type="text" id="fecha_ejecucion_editable" size="40" class="required" readonly/>
                    
                  <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />

				  <script type="text/javascript">
                      Calendar.setup({
                          inputField     :    "fecha_ejecucion_editable",      // id del campo de texto
                          ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                          button         :    "lanzador"   // el id del botón que lanzará el calendario
                      });
                  </script>
                    
                 </td>
            </tr>
            <tr>
            	<td>Detalle Actividad</td>
                <td><input name="detalle_actividad" type="text" id="detalle_actividad" size="40" class="required" /></td>
            </tr>
            
        </tbody>
        
        <tfoot>
            <tr>
                <td colspan="2">
                    <input name="agregar" type="submit" id="agregar" value="Crear" class="btn_table" />
                    <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" class="btn_table" />
                </td>
            </tr>
        </tfoot>
    </table>
    
</form>   
<div id="formUpload" style="display:none;">
   <label>Subir Archivos</label>
   <input type="button" id="upload-btn" class="btn btn-large clearfix" value="Selecione un Archivo">
   <span style="padding-left:5px;vertical-align:middle;"><i>png,png,jpeg,gif,xls,xlsx,pdf,doc,docx,ppt,pptx,dwg(10Mb tama&ntilde;o maximo)</i></span>
   <div id="errormsg" class="clearfix redtext"></div>
   <div id="pic-progress-wrap" class="progress-wrap" style="margin-top:10px;margin-bottom:10px;"></div>
   <br><br>
   <div style="border-color: transparent;" id="jqxgrid_items"></div>
</div>   


<script language="javascript" type="text/javascript">
var getItemHitosById;

$(document).ready(function(){
	
	$(".btn_table").jqxButton({ theme: theme });
	$(".chosen-select").chosen({width:"270px"});
			
	$("#frm_per").validate({
		rules:{
			usu_per:{
				required: true,
				remote: "ajax_verificar_usu_per.php"
			}
		},
		messages: {
			usu_per: "x"
		},
		onkeyup: false,
		submitHandler: function(form) {
			var respuesta = confirm('\xBFDesea realmente agregar este sitio?')
			if (respuesta)
				form.submit();
		}
	});
	
	//Grid items anticipo
	$("#jqxgrid_items").jqxGrid({
		
		width: '100%',
		height: 450,
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
		showstatusbar: false,
		rendergridrows: function(obj){
			 return obj.data;      
		},                
		columns: [
		    /*{ text: '-', datafield: 'acciones', width: 60},	*/
			{ text: 'ID Documental', datafield: 'id', filtertype: 'textbox', filtercondition: 'starts_with',  columntype: 'textbox', width: 60},	
				
			{ text: 'Nombre del Archivo', datafield: 'nombre_archivo', filtertype: 'textbox', filtercondition: 'starts_with',  columntype: 'textbox' },

			{ text: 'Tipo', datafield: 'tipo_archivo', filtertype: 'textbox', filtercondition: 'starts_with',  columntype: 'textbox', width: 150 },
			
			{ text: 'Bajar Archivo', datafield: 'ver_archivo', filtertype: 'none', width: 150, editable: false }				
		]
	});	
	
	/*Modulo de la grilla de inv de acpm por numero de identificacion*/
	getItemHitosById = function(idDoc){
	  
		var seturl = 'ajax_data_items.php?iddoc='+idDoc; 
		
		var source_items = {
			datatype: "json",
			datafields: [
				 { name: 'id', type: 'number'},
				 { name: 'nombre_archivo', type: 'string'},					 
				 { name: 'documental_id', type: 'string'},
				 { name: 'tipo_archivo', type: 'string'},
				 { name: 'acciones', type: 'string'},
				 { name: 'ver_archivo', type: 'string'}
				 	
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
				$("#jqxgrid_items").jqxGrid('updatebounddata', 'filter');
			},
			sort: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid_items").jqxGrid('updatebounddata', 'sort');
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
			$("#jqxgrid_items").jqxGrid({ source: dataadapter_items });						
	};	
	//getItemHitosById(2)
	// Grilla de anticipos select box
	var source_anticipos =
	{
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
		],
	  cache: false,
	  url: '/hitos/hitos/ajax_data.php',
	  sortcolumn: 'id',
	  sortdirection: 'desc',
	  pagesize: 7,
	  filter: function(){
		  // update the grid and send a request to the server.
		  $("#jqxgrid_hito").jqxGrid('updatebounddata', 'filter');
	  },
	  sort: function(){
		  // update the grid and send a request to the server.
		  $("#jqxgrid_hito").jqxGrid('updatebounddata', 'sort');
	  },
	  root: 'Rows',
	  beforeprocessing: function(data){		
		  if (data != null){
			  source_anticipos.totalrecords = data[0].TotalRows;					
		  }
	}};		
  
	var dataadapter_inv = new $.jqx.dataAdapter(source_anticipos, {
		loadError: function(xhr, status, error){
			alert(error);
		}
	});
	
	$("#jqxdropdownbutton").jqxDropDownButton({ width: 250, height: 25});
  	$("#jqxgrid_hito").jqxGrid({
		  width: 580,
		  height: 80,
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
		  showstatusbar: false,
		  rendergridrows: function(obj){
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
	  
	  $("#jqxgrid_hito").on('rowselect', function (event) {
		  
		  var args = event.args;
		  var row = $("#jqxgrid_hito").jqxGrid('getrowdata', args.rowindex);
		  
		  var dropDownContent = '<div style="position: relative; margin-left: 3px; margin-top: 5px;">' + row['id'] +'</div>';
		  
		  /*$("#idsalida").val(row['id']); 
		  $("#idhito").val(row['id_hito']); 
		  */		  
		  $("#id_hito").val(row['id']); 		   
		  
		  $("#jqxdropdownbutton").jqxDropDownButton('setContent', dropDownContent);
		  $("#jqxdropdownbutton").jqxDropDownButton('close');				
	  });
	  
	  var option_m = ['Visita Basica', 'Direc TV' ];
	  var option_t = ['Swap', 'Implementacion', 'MW', 'Claro', 'Access'];
	  
	  $("#actividad").change(function(){
		  	var value = $(this).val();
			var array;  
			
			
			$('#subactividad option').remove();
			
			if(value == 'Mantenimientos' || value == 'Telecomunicaciones'){
				$('#subactividad').addClass('required');
		 	 	$(".subcontent").show();
				
				if(value == 'Mantenimientos')
					array = option_m;
				else if(value == 'Telecomunicaciones')
					array = option_t;
					
				$.each(array, function (i, item) {
					$('#subactividad').append($('<option>', { 
						value: item,
						text : item 
					}));
				});
			}else{
				$('#subactividad').removeClass('required');
			}
			
			$(".chosen-select").trigger("chosen:updated");
	  });
	
});
	
</script>

<script type="text/javascript" src="uploader/SimpleAjaxUploader.js"></script>
<script>
function safe_tags( str ) {
  return String( str )
           .replace( /&/g, '&amp;' )
           .replace( /"/g, '&quot;' )
           .replace( /'/g, '&#39;' )
           .replace( /</g, '&lt;' )
           .replace( />/g, '&gt;' );
}

var btn = document.getElementById('upload-btn'),
	wrap = document.getElementById('pic-progress-wrap'),
	picBox = document.getElementById('picbox'),
	errBox = document.getElementById('errormsg');


var uploader = new ss.SimpleUpload({

        button: btn,
        url: 'upload_file.php',
        progressUrl: 'uploader/extras/uploadProgress.php',
        name: 'uploadfile',
		data: { iddocumental:localStorage.getItem('idDoc') },
        multiple: true,
        maxUploads: 1,
        maxSize: 10000,
        allowedExtensions: ['jpg','png','jpeg','gif','xls','xlsx','pdf','doc','docx','ppt','pptx','dwg'],
        hoverClass: 'btn-hover',
        focusClass: 'active',
        disabledClass: 'disabled',
        responseType: 'json',
        onExtError: function(filename, extension) {
          alert(filename + ' is not a permitted file type.'+"\n\n"+'Only '+extension);
        },
        onSizeError: function(filename, fileSize) {
          alert(filename + ' is too big. (10Mb max file size)');
        },        
        onSubmit: function(filename, ext) {            
           var prog = document.createElement('div'),
               outer = document.createElement('div'),
               bar = document.createElement('div'),
               size = document.createElement('div');

            prog.className = 'prog';
            size.className = 'size';
            outer.className = 'progress progress-striped active';
            bar.className = 'progress-bar progress-bar-success';
            
            outer.appendChild(bar);
            prog.innerHTML = '<span style="vertical-align:middle;">'+safe_tags(filename)+' - </span>';
            prog.appendChild(size);
            prog.appendChild(outer);
            wrap.appendChild(prog); // 'wrap' is an element on the page

            this.setProgressBar(bar);
            this.setProgressContainer(prog);
            this.setFileSizeBox(size);      

            errBox.innerHTML = '';
            btn.value = 'Selecione un archivo';
        },		

        startXHR: function() {

          var abort = document.createElement('button');
            wrap.appendChild(abort);
            abort.className = 'btn btn-small btn-info';
            abort.innerHTML = 'Cancel';
            this.setAbortBtn(abort, true);              

        },          

        onComplete: function(filename, response) {			

            if (!response) {

              errBox.innerHTML = 'Unable to upload file';

              return;

            }     

            if (response.success === true) {
				
				getItemHitosById(response.iddoc); 

            } else {

              if (response.msg)  {

                errBox.innerHTML = response.msg;

              } else {

                errBox.innerHTML = 'Unable to upload file';

              }

            }

          }
});

function fn_agregar(){

	var str = $("#frm_per").serialize();
	$.ajax({
		url: 'ajax_agregar.php',
		data: str,
		type: 'post',
		dataType: "json",
		success: function(data){
			if(data.estado) {			
				uploader.setData({ iddocumental:data.id });
				$('#agregar').hide();
				$('#formUpload').show();		
				$("#frm_per input").attr('disabled','disabled');		
			}
		}
	});
};
</script>			
    