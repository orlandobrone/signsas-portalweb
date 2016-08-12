// JavaScript Document

$(document).ready(function(){

	/*$("#grilla tbody tr").mouseover(function(){

		$(this).addClass("over");

	}).mouseout(function(){

		$(this).removeClass("over");

	});*/

});



function fn_cerrar(){

	$.unblockUI({ 

		onUnblock: function(){

			$("#div_oculto").html("");

		}

	}); 

	$("#jqxgrid").jqxGrid('updatebounddata', 'cells');

};



function fn_mostrar_frm_agregar(){
	loaderSpinner();  
	$("#div_oculto").load("ajax_form_agregar.php", function(){

		$.blockUI({
			message: $('#div_oculto'),
			css:{
				top: '5%',
				left: '22%',
				width: '780px',
				'max-height': '85%',
				'overflow-y': 'scroll'
			}
		}); 
		stoploaderSpinner();
	});

};



function fn_mostrar_frm_modificar(ide_per){
	loaderSpinner();
	$("#div_oculto").load("ajax_form_modificar.php", {ide_per: ide_per}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				width: '780px',
				top: '2%',
				left: '24%',
				'max-height': '85%',
				'overflow-y': 'scroll'	
			}
		}); 
		stoploaderSpinner();
	});

};

function fn_mostrar_frm_transferencia(ide_per){
	loaderSpinner();
	$("#div_oculto").load("ajax_form_transferencia.php", {ide_per: ide_per}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				width: '780px',
				top: '2%',
				left: '24%',
				'max-height': '85%',
				'overflow-y': 'scroll'	
			}
		}); 
		stoploaderSpinner();
	});

};


function fn_veranticipos(ide_per){
	
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

function fn_viewpitagora(ide_per){
	
	$("#div_oculto").load("ajax_view_pitagorahitos.php", {ide_per: ide_per}, function(){
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

	var respuesta = confirm("Desea eliminar este hito?");

	if (respuesta){

		$.ajax({

			url: 'ajax_eliminar.php',

			data: 'id=' + ide_per,

			type: 'post',

			success: function(data){

				if(data!="")

					alert(data);

				fn_buscar()

			}

		});

	}

}

function fn_noeliminar(ide_per){
	alert('No se puede eliminar el hito #'+ide_per+', contiene anticipos amarrados.')
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

	$("#jqxgrid").jqxGrid('updatebounddata', 'cells');

}

function fn_lockhito(ide_per){
	
	$.ajax({
			url: 'ajax_ilimitado_hito.php',
			data: { id: ide_per, type:'lock' },
			type: 'post',
			success: function(data){
				if(data!="")
					alert(data);
				fn_buscar()
			}
	});
}

function fn_unlockhito(ide_per){
	
	
	$("#div_oculto").load("ajax_form_factor.php", {ide_per: ide_per}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				width: '450px',
				top: '2%',
				left: '32%',
				'max-height': '650px',
				'overflow-y': 'hidden'	
			}
		}); 
	});
	
	/*$.ajax({
			url: 'ajax_ilimitado_hito.php',
			data: { id: ide_per, type:'unlock' },
			type: 'post',
			success: function(data){
				if(data!="")
					alert(data);
				fn_buscar()
			}
	});*/
}

function fn_mostrar_frm_autorizar(id_hito){
	
	/*swal({   
		title: "Esta seguro?",   
		text: "Estas seguro, de autorizar el hito",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Si, autorizar",   
		closeOnConfirm: true
	},function(res){   
		if(res){
			$.ajax({
				url: 'ajax_autorizar_hito.php',
				data: { id: id_hito },
				type: 'post',
				success: function(data){
					fn_cerrar();
				}
			});
		}						
	});*/
	
	$('form#form_autorizar input[name=observaciones]').val('');
	
	$('#eventWindowForm').jqxWindow('open');
	$('form#form_autorizar #id_hito').val(id_hito);
	
}