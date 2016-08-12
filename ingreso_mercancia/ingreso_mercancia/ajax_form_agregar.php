<?  
	include "../../conexion.php";
	
	/*$sql = sprintf("INSERT INTO ingreso_mercancia SELECT NULL,MAX(id_ingreso)+1,0,0,0,0,0,0,0,now(),1,0
FROM ingreso_mercancia");*/

	$sql = sprintf("INSERT INTO ingreso_mercancia (id,fecha,parent) VALUES (null,now(),1)");

 
	if(!mysql_query($sql)){

		echo "Error al insertar El material:\n$sql"; 

		exit;

	}

	
	$id_ingreso = mysql_insert_id();

?>


<div style="position:relative;"  class="box-material" >



<h1>Formato de Ingreso de Mercanc&iacute;a ID: <?=$id_ingreso?></h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_agregar();" method="post" id="frm_mat">

<input id="id_ingreso" name="id_ingreso" value="<?=$id_ingreso?>" type="hidden" />
<input id="id_proyecto" name="id_proyecto" type="hidden" />
<input id="id_hito" name="id_hito" type="hidden" />


<table>

        <tbody>

        	 <tr>

                <td>Material</td>

                <td>
                	<input type="hidden" id="material" name="id_material" class="required"/>
                    <div id="jqxWidget">
                        <div id="jqxdropdownbutton">
                            <div style="border-color: transparent;" id="jqxgrid_inv">
                            </div>
                        </div>
                    </div>  
					
					<!--<? $sqlMat = sprintf("select * from inventario order by nombre_material ASC");

							$perMat = mysql_query($sqlMat);

							$num_rs_per_mat = mysql_num_rows($perMat); ?>

                        <select name="id_material" class="required chosen-select" id="material">
    
                            <? while ($rs_per_mat = mysql_fetch_assoc($perMat)) { ?>
    
                            <option value="<? echo $rs_per_mat['id']; ?>"><?php echo $rs_per_mat['codigo'].'-'.$rs_per_mat['nombre_material']; ?></option>
    
                            <? } ?>
    
                        </select>
                    -->

                </td>
                
            </tr>
            <tr>
                
                <td>OT Administrativa</td>

                <td><? $sqlMat = sprintf("select o.id_proyecto AS id, p.nombre AS nombre from otadmin AS o, proyectos AS p WHERE p.id = o.id_proyecto order by o.id_proyecto ASC");

							$perMat = mysql_query($sqlMat);

							$num_rs_per_mat = mysql_num_rows($perMat); ?>

                	<select name="id_proyecto2" class="required chosen-select" id="id_proyecto2">
                    	<option></option>

                    	<? while ($rs_per_mat = mysql_fetch_assoc($perMat)) { ?>

                        <option value="<? echo $rs_per_mat['id']; ?>"><?php echo $rs_per_mat['nombre']; ?></option>

						<? } ?>

					</select>
                    <p id="nomproyecto" style="display:none; margin-left:20px;"></p>
                   

                </td>
                
                <td>Hitos</td>

                <td>

                	<select name="hitos" id="hitos" class="required chosen-select" ></select>
                    <p id="nomhito" style="display:none; margin-left:20px;"></p>

                </td>

          </tr>

          <tr>

                <td>Cantidad</td> 

                <td><input name="cantidad" type="text" id="cantidad" size="28" class="required" /></td>

                <td>Costo</td>

                <td><input name="costo" type="text" id="costo" size="28" class="required" alt="decimal-us"/></td>

          </tr>  
          
          <tr>

                <td>IVA</td> 

                <td><input name="iva" type="text" id="iva" size="28" class="required"/></td>

                <td>Orden de Compra</td>

                <td><input name="orden_compra" type="text" id="orden_compra" size="28" class="required"/></td>

          </tr>

           

        </tbody>

    </table>    
    
    <input name="addmaterial" type="submit" id="addmaterial" value="Agregar Material" class="btn_table" />

</form>


	<input id="refreshTable" type="button" value="refrescar" style="display:none;"/>

	

	<!--<h3>Agregar Materiales</h3>

   

   	<h4>Agregando salida de mercancia</h4>   

  	<p>Por favor rellene el siguiente formulario</p>

     <form action="javascript: fn_agregar();" method="post" id="form_material">

    	<input name="addmaterial" type="submit" id="addmaterial" value="Agregar Material" class="btn_table" />

    </form>-->

	<div id="jqxgrid2" style="margin-top:20px; margin-bottom:20px;"></div>

 

      

    <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

        <input name="modificar" type="submit" id="modificar" value="Guardar" class="btn_table" onclick="fn_guardar_todo();" />

        <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar(<?=$id_ingreso?>);"  class="btn_table"/>                   

    </div>

</div>


<link rel="stylesheet" href="/js/chosen/chosen.css">

<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 



<script type="text/javascript">

$(document).ready(function () {

            var source =
            {
                 datatype: "json",
                 datafields: [
				 	 { name: 'codigo', type: 'number'},
					 { name: 'nombre_material', type: 'string'},
					 { name: 'cantidad', type: 'number'},
					 { name: 'costo', type: 'number'},	
					 { name: 'iva', type: 'string'},	
					 { name: 'orden_compra', type: 'string'},			
					 { name: 'acciones', type: 'string'}						 
                ],
				cache: false,
			    url: 'ajax_list_materiales.php?id=<?=$id_ingreso?>',
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


            var dataadapter = new $.jqx.dataAdapter(source);

            $("#jqxgrid2").jqxGrid({

                width: '100%',
				height: 260,
                source: dataadapter,
                showfilterrow: true,
                pageable: true,
                filterable: true,
                theme: theme,
				sortable: true,
                columnsresize: true,
				virtualmode: true,
				autorowheight: true,
                autoheight: true,
				rendergridrows: function(obj)
				{
					 return obj.data;      
				},      

				//fn_aprobar_allitems          
                columns: [

				  { text: '-', datafield: 'acciones', filtertype: 'none', width:'10%', cellsalign: 'center', sortable:false, width:60 },

                  { text: 'C&oacute;digo', datafield: 'codigo', filtertype: 'textbox', filtercondition: 'equal',  columntype: 'textbox'},
                  { text: 'Material', datafield: 'nombre_material',  filtertype: 'textbox', filtercondition: 'starts_with'},
				  { text: 'Cantidad', datafield: 'cantidad', filtertype: 'none', cellsalign: 'right' },
				  { text: 'Costo', datafield: 'costo', filtertype: 'none', cellsalign: 'right', cellsformat: 'c2'},
				  { text: 'IVA', datafield: 'iva', filtertype: 'none',cellsalign: 'right'},
				  { text: 'Orden Compra', datafield: 'orden_compra', filtertype: 'none',cellsalign: 'right'}
                ]

            });		

           
				
			//$("#excelExport").jqxButton({ theme: theme });

            //$('#clearfilteringbutton').jqxButton({ height: 25, theme: theme });

           /* $('#clearfilteringbutton').click(function () {



                $("#jqxgrid2").jqxGrid('clearfilters');

            });*/

			/*$("#excelExport").click(function () {

                $("#jqxgrid2").jqxGrid('exportdata', 'xls', 'Lista Items');           

            });*/
			
			
			$('#refreshTable').click(function () {
                $("#jqxgrid2").jqxGrid('updatebounddata', 'cells');         
            });
			
			
			// Select Grid Inventario
			
			var source_inventario =
            {
                 datatype: "json",
                 datafields: [
					 { name: 'id', type: 'string'},
					 { name: 'nombre_material', type: 'string'},
					 { name: 'descripcion', type: 'string'},
					 { name: 'cantidad', type: 'string'},
					 { name: 'costo_unidad', type: 'number'},
					 { name: 'fecha', type: 'date'},
					 { name: 'ubicacion', type: 'string'},
					 { name: 'codigo', type: 'string'}
                ],
				cache: false,
			    url: '/inventario/inventario/ajax_data.php',
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
            $("#jqxgrid_inv").jqxGrid(
            {
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
                  { text: 'ID',datafield: 'id',filtertype: 'number',filtercondition: 'equal',columntype:'textbox', width: 50 },
				  { text: 'Código', datafield: 'codigo',filtertype: 'textbox', filtercondition: 'starts_with' },
				  { text: 'Ubicación', datafield: 'ubicacion', filtertype: 'textbox', filtercondition: 'starts_with' },
				  { text: 'Nombre Material', datafield: 'nombre_material', filtertype: 'number', filtercondition: 'starts_with'},
                  { text: 'Descripción', datafield: 'descripcion', filtertype: 'textbox', filtercondition: 'starts_with'},
                  { text: 'Cantidad', datafield: 'cantidad', filtertype: 'number',cellsalign: 'right'},
                  { text: 'Costo Unitario', datafield: 'costo_unidad', filtertype: 'textbox',  cellsalign: 'right', cellsformat: 'c2' ,width: 100 }
                ]
            });
			
            $("#jqxgrid_inv").on('rowselect', function (event) {
				
                var args = event.args;
                var row = $("#jqxgrid_inv").jqxGrid('getrowdata', args.rowindex);
                var dropDownContent = '<div style="position: relative; margin-left: 3px; margin-top: 5px;">' + row['codigo'] + '-' + row['ubicacion'] + '</div>';
				$("#material").val(row['id'])
				
                $("#jqxdropdownbutton").jqxDropDownButton('setContent', dropDownContent);
				$("#jqxdropdownbutton").jqxDropDownButton('close');
            });
            //$("#jqxgrid_inv").jqxGrid('selectrow', 0);

});

</script>      





<script language="javascript" type="text/javascript">

	$(document).ready(function(){

		

		$(".chosen-select").chosen({width:"220px"}); 

		$('input').setMask();	
		
		$('#iva').setMask('0.99');

		$(".btn_table").jqxButton({ theme: theme });

		

		/* Agregar Items */

		$("#material").change(function(){

			$(".solicitud").val('');

			var idMaterial = $(this).val();

			$.getJSON('/ajax/listMaterial.php',{id:idMaterial}, function (data) {

				$.each(data, function (i, v) {					

					$('#'+i).val(v);

				});

			});

		});
		
		$("#hitos").change(function(){
			
			$('#id_hito').val($(this).val());
			$('#nomhito').append($( "#hitos option:selected" ).text());
			
		});
		
		 
		$("#id_proyecto2").change(function(){
			
			$('#id_proyecto').val($('#id_proyecto2').val());
			$('#nomproyecto').append($( "#id_proyecto2 option:selected" ).text());  
			
			var proyecto = $(this).val();

				$('#hitos').empty();	

			

				$.getJSON('/anticipos/anticipo/ajax_list_hitos_orden.php', {id_proyecto:proyecto}, function (data) { 

						if(data != null){

							var options = $('#hitos');

							$('#hitos').empty();

							$('#hitos').append('<option value="">Seleccione..</option>');				

							

							$.each(data, function (i, v) { 

								options.append($("<option></option>").val(v.id).text(v.orden));

							});

							

							$("#hitos").trigger("chosen:updated");

							

						}else{ 

							alert('No se encontraron hitos para esta orden de trabajo');

							$('#hitos').empty();

							$('#hitos').append('<option value="">Seleccione..</option>');

							$("#hitos").trigger("chosen:updated");

						

						}

				});
			 
		});
 
		$('#cantidad').keyup(function(){		

						

			if($(this).val() != ''){

				

				var cantidad = parseInt($(this).val());

				var cantidadInv = parseInt($('#cantidadInv').val());

				var solicitarCompra = 0;

				

				if(cantidad <= cantidadInv){

					$('.alert-box').removeClass('warning');

					$('.alert-box').addClass('success');

					$('.alert-box').html('<span>OK:</span>&nbsp;En existencia.');

					$('.alert-box').slideDown('slow');

					$('#cantidadPendiente').val(0);

				}else{

					solicitarCompra = cantidad - cantidadInv;

					$('.alert-box').removeClass('success');

					$('.alert-box').addClass('warning');

					$('.alert-box').html('<span>Advertencia:</span>&nbsp;No hay existencia.<br/>Solicitud Compra:'+solicitarCompra);

					$('.alert-box').slideDown('slow');

					$('#cantidadPendiente').val(solicitarCompra);

				}				

				

				var costoInv = parseFloat($('#costoInv').val());			

				var costo_solicitado =  parseFloat(costoInv * cantidad);		

				$('#costo_solicitado').val(costo_solicitado);

				$('#costo_solicitado').setMask();

				

			}else{

				$('#costo_solicitado').val('');

				$('.alert-box').removeClass('success');

				$('.alert-box').addClass('warning');

				$('.alert-box').html('<span>Advertencia:</span>&nbsp;Debe ingresar una cantidad');

				$('.alert-box').slideDown('slow');

			}

			

		});

		

		/* Validacion del formulario agregar materiales */

		$("#form_material").validate({

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

					var respuesta = confirm('\xBFRealmente desea agregar este material?')

					if (respuesta)

						form.submit();		

			}

		});
		

		$('#btn_agregar_material').click(function(){

			$('.box-material').slideUp();

		 	$('.add-material').slideDown('slow');	

		});

		

		$('#btn-cancelar').click(function(){

			$('.add-material').slideUp();

		 	$('.box-material').slideDown('slow');	

		});

		

		/* Validacion del formulario agregar materiales */

		$("#frm_add_material").validate({

			rules:{

				usu_per:{

					required: true,

					remote: "/inventario/inventario/ajax_verificar_usu_per.php"

				}

			},

			messages: {

				usu_per: "x"

			},

			onkeyup: false,

			submitHandler: function(form) {

				var respuesta = confirm('\xBFDesea realmente agregar este nuevo material al Inventario?')

				if (respuesta)

					form.submit();

			}

		});

		

		

		/*--------------------------------------------------------------------------------------*/

		

		

		$('#modificar').click(function(){

			$("#frm_per").submit(); 

		});

		

		$("#frm_per").validate({

			submitHandler: function(form) {

				var respuesta = confirm('\xBFDesea realmente ingresar estos parametros?')

				if (respuesta)

					form.submit();

			}

		});

		

				

		$('#prioridad').blur(function(){

			var variable = $(this).val().toUpperCase();

			$(this).val(variable);

		})

		

		

		$('#cedula_consignar').change(function(){

			var nombre, banco, tipocuenta, numcuenta;

			$( "#cedula_consignar option:selected" ).each(function() {

			  nombre = $( this ).attr('nombre');

			  banco = $( this ).attr('entidad');

			  tipocuenta = $( this ).attr('tipocuenta');

			  numcuenta = $( this ).attr('numcuenta');

			});

			$('#beneficiario').val(nombre);

			$('#banco').val(banco);

			$('#tipo_cuenta').val(tipocuenta);

			$('#num_cuenta').val(numcuenta);

		});

		

		

		

		$('#nombre_responsable').change(function(){

			var cedula;

			$( "#nombre_responsable option:selected" ).each(function() {

			  cedula = $( this ).attr('cedula');

			});

			$('#cedula_responsable').val(cedula);

		});

		

		$('#hitos').change(function(){ 
			$('.nom_hito').val($("#hitos option:selected").html());
		});

		$('#orden_trabajo').change(function(){ 

			var orden;

			$('#hitos').empty();

			var proyecto = $( "#orden_trabajo" ).val();			

			

			$.getJSON('/anticipos/anticipo/ajax_list_hitos_orden.php', {id_proyecto:proyecto}, function (data) { 

					if(data != null){

						var options = $('#hitos');

						$('#hitos').empty();

						$('#hitos').append('<option value="">Seleccione..</option>');				

						

						$.each(data, function (i, v) { 

							options.append($("<option></option>").val(v.id).text(v.orden));

						});

						

						$("#hitos").trigger("chosen:updated");

						

					}else{ 

						alert('No se encontraron hitos para esta orden de trabajo');

						$('#hitos').empty();

						$('#hitos').append('<option value="">Seleccione..</option>');

						$("#hitos").trigger("chosen:updated");

					

					}

			});

		});

		

		var regional_actual;

		$('.var_ordenes').change(function(){ 

		

			$('#orden_trabajo').empty();

			$("#orden_trabajo").trigger("chosen:updated");

			

			$('#hitos').empty();

			$("#hitos").trigger("chosen:updated");

			

			var regional = $('#regional').val();

			var centrocosto = $('#centros_costos').val(); 

			

			

			if(regional != '0' && regional_actual != regional ){

				

				$.getJSON('/anticipos/anticipo/ajax_list_responsable.php', {id_regional:regional}, function (data) {

						var options = $('#nombre_responsable');

						$('#nombre_responsable').empty();

						$('#nombre_responsable').append('<option value="">Seleccione..</option>');				

						

						$.each(data, function (i, v) { 

							options.append($("<option></option>").val(v.nombre).text(v.nombre).attr('cedula',v.cedula));

						});

						

						$("#nombre_responsable").trigger("chosen:updated");

						regional_actual = regional;

						$('#cedula_responsable').val('');

				});

				

			}

			

			if(regional != '0' && centrocosto != '0'){

			/* Get Ordenes de trabajo   */	 

				$.getJSON('/anticipos/anticipo/ajax_list_ordenes_trabajo.php', {id_regional:regional, id_centroscostos:centrocosto}, function (data) {

						var options = $('#orden_trabajo');

						$('#orden_trabajo').empty();

						$('#orden_trabajo').append('<option value="">Seleccione..</option>');				

						

						$.each(data, function (i, v) { 

							options.append($("<option></option>").val(v.id).text(v.orden));

						});

						

						$("#orden_trabajo").trigger("chosen:updated");

				});

			}else{

				$('#mensaje').show();

			}

			

		});

		

	});

	

	

	function replaceAll( text, busca, reemplaza ){

	  while (text.toString().indexOf(busca) != -1)

		  text = text.toString().replace(busca,reemplaza);

	  return text;

	}



	

	

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

					$("#jqxgrid2").jqxGrid('updatebounddata', 'cells');

				}

			},

			error: function(err) {

				alert(err);

			}

		});

	};
	
	function fn_eliminar_item(ide_per){

		var respuesta = confirm("Desea eliminar este ingreso de mercancia?");
	
		if (respuesta){
	
			$.ajax({
	
				url: 'ajax_eliminar_item.php',
	
				data: 'id=' + ide_per,
	
				type: 'post',
	
				success: function(data){
	
					if(data!="")
	
						alert(data);
	
					$("#jqxgrid2").jqxGrid('updatebounddata', 'cells');
	
				}
	
			});
	
		}
	
	}

	

	function fn_agregar(){ 

		var str = $("#frm_mat").serialize();

		$.ajax({

			url: 'ajax_agregar_material.php',

			data: str,

			type: 'post',

			success: function(data){

				if(data != "") {

					alert(data);

				}else{ 

					$('.alert-box').slideUp();

					$('#frm_mat').reset();

					$("#jqxgrid2").jqxGrid('updatebounddata','cells');
					
					$('#refreshTable').click();
					
					$('#id_proyecto2_chosen').css('display','none');
					
					$('#hitos_chosen').css('display','none');
					
					$('#nomproyecto').css('display','block');
					
					$('#nomhito').css('display','block');
					
					//$("#material").trigger("chosen:updated");

				}

			}

		});

	};

	function fn_guardar_todo(){
		
		var str = $("#frm_mat").serialize();

		$.ajax({
			url: 'ajax_guardar_todo.php',
			data: str,
			type: 'post',
			success: function(data){
				if(data != "") {
					alert(data);
				}else{
					listChose();
					fn_cerrar();					
				}
			}
		});
	}

	function fn_agregar_material(){

		var str = $("#frm_add_material").serialize();

		$.ajax({

			url: '/inventario/inventario/ajax_agregar.php',

			data: str,

			type: 'post',

			success: function(data){

				if(data != "") {

					alert(data);

				}else{

					listChose();					

				}

			}

		});

	};

	

	function listChose(){

	

		/*$.getJSON('/ajax/choseMaterial.php', function (data) {

				var options = $('#material'); 

				$('#material').empty()

				$('#material').append('<option value="">Seleccione una opcion</option>');	

				

				$.each(data, function (i, v) {

					options.append($("<option></option>").val(v.id).text(v.label));

				});

				//$(".chosen-institucion").chosen();

				

				$("#material").trigger("chosen:updated");

				$('.add-material').slideUp();

		 		$('.box-material').slideDown('slow');

		});	*/
		
		$("#jqxgrid_inv").jqxGrid('updatebounddata','cells');// actualiza la grid del inventario 

	

	}

	jQuery.fn.reset = function () {
	  $(this).each (function() { this.reset(); });
	}


</script>

<style>
#contenttablejqxgrid2 #row0jqxgrid2 .jqx-grid-cell:first-child{
	width:60px !important;
}
</style>