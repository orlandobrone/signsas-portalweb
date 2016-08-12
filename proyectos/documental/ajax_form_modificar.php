<? 	header('Content-type: text/html; charset=iso-8859-1');
    session_start();
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}
	
	include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("select * from documental where id=%d",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen un SITIO con ese ID";
		exit;
	}
	
	$rs_per = mysql_fetch_assoc($per);
	
?>
<!--Hoja de estilos del calendario -->
<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">
<!-- librería principal del calendario -->
<script type="text/javascript" src="../../calendario/calendar.js"></script>

<!-- librería para cargar el lenguaje deseado -->
<script type="text/javascript" src="../../calendario/calendar-es.js"></script>

<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>

<form action="javascript: fn_modificar();" method="post" id="frm_per">
	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
    <table class="formulario">
        <tbody>
            <tr>
                <td>C&oacute;digo Sitio</td>
                <td><input name="codigo" type="text" id="codigo" size="40" class="required" value="<?=$rs_per['codigo_sitio']?>" /></td>
            </tr>
            <tr>
            	<?php
					$actividad = explode('-',$rs_per['actividad']);
					$subactividad = $actividad[1];
					$actividad = $actividad[0];
				?>
                <td>Actividad</td>
                <td>                	
                	<select name="actividad" id="actividad" class="required chosen-select">
                    	<option value=""></option>
                    	<option value="Suministros" <?=($actividad== 'Suministros')?'selected':''?>>Suministros</option>
                        <option value="Mantenimientos" <?=($actividad == 'Mantenimientos')?'selected':''?>>Mantenimientos</option>
                        
                        <option value="Telecomunicaciones" <?=($actividad == 'Telecomunicaciones')?'selected':''?>>Telecomunicaciones</option>
                        
                       <!-- <option value="Instalaciones"  <?=($actividad == 'Instalaciones')?'selected':''?>>Instalaciones</option>
                        <option value="Migraciones"  <?=($actividad == 'Migraciones')?'selected':''?>>Migraciones</option>  -->
                        
                         <option value="Otros" <?=($actividad == 'Otros')?'selected':''?>>Otros</option>
                    </select>
                </td>
                <td class="subcontent">Sub - Actividad</td>
                <td class="subcontent">                	
                	<select name="subactividad" id="subactividad" class="required chosen-select">
                    	<option value="<?=$subactividad?>"><?=$subactividad?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Nombre Sitio</td>
                <td><input name="nombre_sitio" type="text" id="nombre_sitio" size="40" class="required" value="<?=$rs_per['nombre_sitio']?>"/></td>
          
                <td>Cliente</td>
                <td>
                	<select name="cliente" ide="cliente" class="required chosen-select">
                    	<option value=""></option>
						<?
                            $sql = "select * from cliente order by id asc";
                            $pai = mysql_query($sql);
                            while($rs_pai = mysql_fetch_assoc($pai)){
                        ?>
                            <option value="<?=$rs_pai['nombre']?>" <? if($rs_pai['nombre']==$rs_per['cliente']) echo "selected='selected'";?>><?=$rs_pai['nombre']?></option>
                        <? } ?>
					</select>
                </td>
            </tr>
            <tr>
                <td>OT, Tickets</td>
                <td><input name="ot_ticket" type="text" id="ot_ticket" size="40" class="required" value="<?=$rs_per['ot_tickets']?>"/></td>
           
                	
                <td>ID Hito</td>
                <td>
                    <select name="id_hito" id="id_hito" class="required chosen-select">
                        <?php
							
							$sql = "SELECT id FROM cliente WHERE nombre = '".$rs_per['cliente']."'";
                            $resultado = mysql_query($sql) or die(mysql_error());
							$row = mysql_fetch_assoc($resultado);
							$idcliente = $row['id'];
						
                            $sql = "SELECT id FROM proyectos WHERE id_cliente = ".$idcliente;
                            $resultado = mysql_query($sql) or die(mysql_error());
                            $total = mysql_num_rows($resultado);
                            
                            if($total > 0):
                            
                                while($row = mysql_fetch_assoc($resultado)):
                                
                                    $resultado2 = mysql_query("SELECT id, nombre FROM hitos WHERE id_proyecto = ".$row['id']) or die(mysql_error());
                                    
                                    while( $row2 = mysql_fetch_assoc($resultado2) ):
                                    
                                        echo '<option value='.$row2['id'].'>'.$row2['id'].' - '.utf8_encode($row2['nombre']).'</option>';
                                        
                                    endwhile;
                                endwhile;
                            
                            endif;
                        ?>					
                    </select>                	
                </td>
                   
            </tr>
            
            <tr>
                <td>Nombre Documentador</td>
                <td><input name="nombre_documentador" type="text" id="nombre_documentador" size="40" class="required" value="<?=$rs_per['nombre_documentador']?>"/></td>
           
                <td>Fecha de ejecuci&oacute;n editable</td>
                <td>
                  <input name="fecha_ejecucion_editable" type="text" id="fecha_ejecucion_editable" size="40" class="required" value="<?=$rs_per['fecha_ejecucion_editable']?>" readonly/>
                   
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
                <td><input name="detalle_actividad" type="text" id="detalle_actividad" size="40" class="required"  value="<?=$rs_per['detalle_actividad']?>"/></td>
            </tr>
            <? if(in_array(364, $_SESSION['permisos'])): ?>
            <tr>
            	<td style="font-weight:bold;">Cambio estado:</td>
                <td>
                	<select name="cambio_estado" id="cambio_estado">
                    	<option value="0" <?=($rs_per['estado']==0)?'selected':''?>>Pendiente</option>
                        <option value="1" <?=($rs_per['estado']==1)?'selected':''?>>Eliminado</option>
                        <option value="2" <?=($rs_per['estado']==2)?'selected':''?>>Aprobado</option>
                    </select>		                
                </td>
            </tr>
            <? endif; ?>
            
        </tbody>
        
        <tfoot>
            <tr>
                <td colspan="2">
                	<?php if (in_array('361', $_SESSION['permisos']) && $row['estado'] == 0): ?>
                    <input name="agregar" type="submit" id="agregar" value="Actualizar" class="btn_table" />
                    <?php endif; ?>
                    <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" class="btn_table" />
                </td>
            </tr>
        </tfoot>
    </table>
    
</form>   

<div id="formUpload" style="display:block;">
	
    <form name="enviador" method="post" action="ftp.php" enctype="multipart/form-data" target="_blank">
        <input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
        
        Archivo: <input type="file" name="archivo[]" multiple >
        <input type="submit">
    </form>

  <!-- <label>Subir Archivos</label>
   <input type="button" id="upload-btn" class="btn btn-large clearfix" value="Selecione un Archivo">
   <span style="padding-left:5px;vertical-align:middle;"><i>png,png,jpeg,gif,xls,xlsx,pdf,doc,docx,ppt,pptx,dwg(10Mb tama&ntilde;o maximo)</i></span>
   <div id="errormsg" class="clearfix redtext"></div>
   <div id="pic-progress-wrap" class="progress-wrap" style="margin-top:10px;margin-bottom:10px;"></div>
   <br><br>-->
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
			var respuesta = confirm('\xBFDesea realmente actualizar este documental?')
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
			pagesize: 5,
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
	getItemHitosById(<?=(int)$_POST['ide_per']?>);
	
	
	  
	  var option_m = ['Visita Basica','Direc TV','SURVEY','IMPLEMENTACION','PREVENTIVOS','CORRECTIVOS','TBS','ESTRUCTURAL','MIGRACIONES','OTROS'];
	  var option_t = ['Swap', 'MW', 'Claro', 'Access','ENODO B','TSS SWAP','UNIFICADOS','WIRELESS CLARO','OTROS'];
	  
	  var option_i = ['RECTIFICADORES', 'BATERIAS', 'OTROS'];
	  
	  $("#actividad").change(function(){
		  	var value = $(this).val();
			var array;
			$('#subactividad option').remove();
			
			if(value == 'Mantenimientos' || value == 'Telecomunicaciones'){
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
			}
			
			$(".chosen-select").trigger("chosen:updated");
	  });
	
});

	
	
</script>

<script type="text/javascript" src="uploader/SimpleAjaxUploader.js"></script>
<script>
/*
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
		data: { iddocumental:<?=(int)$_POST['ide_per']?> },
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
});*/

function fn_modificar(){
	var str = $("#frm_per").serialize();
	$.ajax({
		url: 'ajax_modificar.php',
		data: str,
		type: 'post',
		success: function(data){
			if(data != "") {
				alert(data);
			}else{
				fn_cerrar();	
				fn_buscar();
			}
		}
	});
};

/*function fn_agregar(){

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
};*/
</script>	