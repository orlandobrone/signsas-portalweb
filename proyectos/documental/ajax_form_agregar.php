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
                        <option value="Telecomunicaciones">Telecomunicaciones</option>
                        <option value="Otros">Otros</option>
                        <!--<option value="Instalaciones">Instalaciones</option>
                        <option value="Migraciones">Migraciones</option>-->                     
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
                	<select name="cliente" id="cliente" class="required chosen-select">
                    	<option value=""></option>
						<?
                            $sql = "select * from cliente order by id asc";
                            $pai = mysql_query($sql);
                            while($rs_pai = mysql_fetch_assoc($pai)){
                        ?>
                            <option idvalue="<?=$rs_pai['id']?>" value="<?=$rs_pai['nombre']?>"><?=$rs_pai['nombre']?></option>
                        <? } ?>
					</select>
                
                </td>
            </tr>
            <tr>
                <td>OT, Tickets</td>
                <td><input name="ot_ticket" type="text" id="ot_ticket" size="40" class="required" /></td>
           
                <td>ID Hito</td>
                <td>
                	<select name="id_hito" id="id_hito" class="required chosen-select">
                    	<option value=""></option>						
					</select>                	
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
	
	
	   
	  var option_m = ['Visita Basica','Direc TV','SURVEY','IMPLEMENTACION','PREVENTIVOS','CORRECTIVOS','TBS','ESTRUCTURAL','MIGRACIONES','OTROS'];
	  var option_t = ['Swap', 'MW', 'Claro', 'Access','ENODO B','TSS SWAP','UNIFICADOS','WIRELESS CLARO','OTROS'];
	  
	  var option_i = ['RECTIFICADORES', 'BATERIAS', 'OTROS'];
	  
	  $("#actividad").change(function(){
		  	var value = $(this).val();
			var array;  			
			
			$('#subactividad option').remove();
			
			if(value == 'Mantenimientos' || value == 'Telecomunicaciones' || value == 'Instalaciones'){
				
				$('#subactividad').addClass('required');
		 	 	$(".subcontent").show();
				
				if(value == 'Mantenimientos')
					array = option_m;
				else if(value == 'Telecomunicaciones')
					array = option_t;
				else if(value == 'Instalaciones')
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
	  
	  $("#cliente").change(function(){
		  	
		  	$.ajax({
				url: 'ajax_listhitos_bycliente.php',
				data: { idcliente: $('option:selected', this).attr('idvalue') },
				type: 'post',
				dataType: "json",
				success: function(data){
					$('#id_hito option').remove();
					$.each(data, function (i, value) {
						$('#id_hito').append($('<option>', { 
							value: value.id,
							text : value.id+' - '+value.nombre 
						}));
					});
					$(".chosen-select").trigger("chosen:updated");
				}
			});		  
	  });
	
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
				fn_cerrar();	
				fn_buscar();			
				/*uploader.setData({ iddocumental:data.id });
				$('#agregar').hide();
				$('#formUpload').show();		
				$("#frm_per input").attr('disabled','disabled');*/		
			}
		}
	});
};
</script>			
    