// JavaScript Document

$(document).ready(function(){
	fn_buscar();
	$("#grilla tbody tr").mouseover(function(){
		$(this).addClass("over");
	}).mouseout(function(){
		$(this).removeClass("over");
	});
});

function fn_cerrar(iddespacho){
	
	if(iddespacho!=''){
		$.ajax({
			url: 'ajax_eliminar_trash.php',
			data: {id_despacho: iddespacho},
			type: 'POST',
			dataType: 'json'		
		});	
	}
	$.unblockUI({ 
		onUnblock: function(){
			$("#div_oculto").html("");
		}
	}); 
	
	$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
};

function fn_mostrar_frm_agregar(){
	$("#div_oculto").load("ajax_form_agregar.php", function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				width: '660px',
				top: '2%',
				left: '24%',
				'max-height': '580px',
				'min-height': '580px',
				'overflow-y': 'scroll'				
			}
		});
		 
	});
};

function fn_mostrar_frm_modificar(ide_per){
	$("#div_oculto").load("ajax_form_modificar.php", {ide_per: ide_per}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				width: '660px',
				top: '2%',
				left: '24%',
				'max-height': '580px',
				'overflow-y': 'scroll'				
			}
		}); 
	});
};


function fn_addmateriales(ide_per){
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

function fn_eliminar(ide_per){
	var respuesta = confirm("Desea eliminar la solicitud de despacho seleccionada?");
	if (respuesta){
		$.ajax({
			url: 'ajax_eliminar.php',
			data: 'id=' + ide_per,
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
		url: '/salida_mercancia/salida_mercancia/cargar_costo_unidad2.php',
		type: 'post',
		data: 'idMaterial=' + idMaterial,
		dataType: 'json',
		success: function (data) {
			$("#costo_unidad").val(data.costo);
			$("#cantidadInv").val(data.cantidad);
		}
	});
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

function fn_aprobar_item(id_Material) {
	$.ajax ({
		url: '/solicitud_despacho/solicitud_despacho/ajax_aprobar_item.php',
		type: 'post',
		data: {idMaterial:id_Material, type:'one'},
		dataType: 'json',
		success: function (data) {
			$("#jqxgrid2").jqxGrid('updatebounddata', 'cells');
		}
	});
}


function fn_aprobar_allitems(id_Material) { 
	$.ajax ({
		url: '/solicitud_despacho/solicitud_despacho/ajax_aprobar_item.php',
		type: 'post',
		data: {idMaterial:id_Material, type:'All'},
		dataType: 'json',
		success: function (data) {
			$("#jqxgrid2").jqxGrid('updatebounddata', 'cells');
		}
	});
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

function fn_showMateriales(ide_per, id_pro){ 
	$("#div_oculto").load("ajax_list_material.php", {ide_per: ide_per, id_proyecto: id_pro}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				top: '5%',
				width: '46%',
				left: '25%'
			}
		}); 
	});
};