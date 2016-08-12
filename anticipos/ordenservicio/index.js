var calcularImpuesto = null;

// JavaScript Document
$(document).ready(function(){

	
});

function fn_cerrar(idanticipo){

	$.unblockUI({ 
		onUnblock: function(){
			$("#div_oculto").html("");
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		}
	}); 

	$.ajax({
		url: 'ajax_eliminar_trash.php',
		data: {id_anticipo: idanticipo},
		type: 'POST',
		dataType: 'json'		
	});

};



function fn_mostrar_frm_agregar(){

	loaderSpinner();

	$("#div_oculto").load("ajax_form_agregar.php", function(){

		$.blockUI({
			message: $('#div_oculto'),
			css:{
				width: '75%',
				top: '2%',
				left: '14%',
				'max-height': '650px',
				'overflow-y': 'scroll',
				'z-index': '998px'						
			}

		}); 

		stoploaderSpinner();

	});

};

function fn_mostrar_frm_aprobar(ide_ant){

	$("#div_oculto").load("ajax_form_aprobar.php", {ide_ant: ide_ant}, function(){

		$.blockUI({

			message: $('#div_oculto'),

			css:{

				width: '460px',

				top: '2%',

				left: '24%',

				'max-height': '580px',

				'overflow-y': 'scroll'		

			}

		}); 

	});

};


function fn_mostrar_frm_modificar(ide_per){
	
	loaderSpinner();

	$("#div_oculto").load("ajax_form_modificar.php", {ide_per: ide_per}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				width: '75%',
				top: '2%',
				left: '14%',
				'max-height': '650px',
				'overflow-y': 'scroll',
				'z-index': '998px'		
			}

		}); 
		stoploaderSpinner();
	});
};


function fn_mostrar_legalizaciones(ide_per){

	$("#div_oculto").load("ajax_view_legalizaciones.php", {ide_per: ide_per}, function(){

		$.blockUI({
			message: $('#div_oculto'),
			css:{
				width: '860px',
				top: '2%',
				left: '16%',
				'max-height': '580px',
				'overflow-y': 'scroll'		
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

	var respuesta = confirm("Desea eliminar esta OS?");

	if (respuesta){

		$.ajax({
			url: 'ajax_eliminar.php',
			data: 'id=' + ide_per,
			type: 'POST',
		 	dataType: 'json',
			success: function(data){

				if (data.estado == false){ 
					alert(data.message);
				}

				$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
			}
		});
	}
}

function fn_noeliminar(ide_per){
	alert('No se puede eliminar el anticipo #'+ide_per+', esta amarrado a una legalizacion aprobada')
}


function fn_eliminar_item(ide_per, idos){

	var respuesta = confirm("Desea eliminar el item selecionado del OS?");

	if (respuesta){
		
		$.ajax({
			url: 'ajax_eliminar_item.php',
			data: {id: ide_per},
			type: 'POST',
			dataType: 'json',
			success: function(data){	

				if (data.estado == true){
				   $("#valor_neto_total").val(data.total_neto);
				   $("#jqxgrid2").jqxGrid('updatebounddata');
				   calcularImpuesto();
				}else{
					alert(data.message);
				}
			}
		});

	}

}



function fn_export_anticipo(idanticipo){
	window.open("/anticipos/anticipo/email_anticipo.php?ide_per="+idanticipo);
}



function fn_buscar(){

	/*var str = $("#frm_buscar").serialize();

	$.ajax({

		url: 'ajax_listar.php',

		type: 'get',

		data: str,

		success: function(data){

			$("#div_listar").html(data);

		}

	});*/

}



function fn_aprobar_anticipo(idAnticipo){

	/*var respuesta = confirm('\xBFDesea realmente cambiar el estado a aprobado?')

	if (respuesta){		

		$.post('ajax_aprobar_anticipo.php',{id:idAnticipo},function(data){			

			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');

		});

	}*/ //FGR
	
	fn_mostrar_frm_aprobar(idAnticipo);

}


function fn_viewanticipos(ide_per){
	
	$("#div_oculto").load("ajax_view_anticipos.php", {ide_per: ide_per}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				width: '920px',
				top: '2%',
				left: '20%',
				'max-height': '650px',
				'overflow-y': 'hidden'	
			}
		}); 
	});
};

