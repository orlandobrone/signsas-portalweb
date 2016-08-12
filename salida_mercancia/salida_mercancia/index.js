// JavaScript Document



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



function fn_mostrar_frm_modificar(ide_per){
	

	$("#content_form").load("ajax_form_modificar.php", {ide_per: ide_per}, function(){

		$('#eventWindow').jqxWindow('open');
		/*$.blockUI({

			message: $('#div_oculto'),

			css:{
				width: '93%',
				top: '5%',
				left: '2%',
				'max-height': '580px',
				'min-height': '580px',
				'overflow-y': 'scroll'	

			}

		}); */

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



function fn_aprobar_item(id_Material,rowindex,id_despacho) {
		
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
			data: {idMaterial:id_Material, type:'one', idDespacho:id_despacho},
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
		url: 'ajax_agregar_material.php',
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