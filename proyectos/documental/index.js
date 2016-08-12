// JavaScript Document

$(document).ready(function(){
	//fn_buscar();
	/*$("#grilla tbody tr").mouseover(function(){
		$(this).addClass("over");
	}).mouseout(function(){
		$(this).removeClass("over");
	});*/
});

function fn_cerrar(){
	/*$.unblockUI({ 
		onUnblock: function(){
			$("#div_oculto").html("");
		}
	}); */
	$('#addreintegroWindow').jqxWindow('close'); 
};

function fn_mostrar_frm_agregar(){
	loaderSpinner(); 
	$("#content_form_material").load("ajax_form_agregar.php", function(){
		/*$.blockUI({
			message: $('#div_oculto'),
			css:{
				top: '5%',
				width: '55%',  
				left: '21%'
			}
		}); */
		$('#addreintegroWindow').jqxWindow('open'); 
		stoploaderSpinner();
	});
};

function fn_mostrar_frm_modificar(ide_per){
	loaderSpinner();
	$("#content_form_material").load("ajax_form_modificar.php", {ide_per: ide_per}, function(){
		/*$.blockUI({
			message: $('#div_oculto'),
			css:{
				top: '5%',
				width: '55%',  
				left: '21%',
				'overflow-y':'auto',
				'max-height':'615px'
			}
		});*/
		$('#addreintegroWindow').jqxWindow('open'); 
		stoploaderSpinner();
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
	var respuesta = confirm("Desea eliminar este proyecto?");
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

function fn_mostrar_frm_aprobar(iddoc){
	swal({   
		title: "Estas seguro?",   
		text: "Deseas aprobar ester documento, se enviara un correo a callcenter@signsas.com!",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",  
		confirmButtonText: "Si, quiero aprobarlo!",  
		cancelButtonText: "No, más tarde!",   
		closeOnConfirm: true,   
		closeOnCancel: true 
	}, function(isConfirm){   
		if (isConfirm) {     
			$.ajax({
				url: 'ajax_aprobar_doc.php',
				data: { id: iddoc },
				type: 'post',
				success: function(data){
					if(data!="")
						alert(data);
					fn_buscar()
				}
			});
		} 
	});	
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