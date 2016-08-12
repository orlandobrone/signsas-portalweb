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
	$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
	$.unblockUI({ 
		onUnblock: function(){
			$("#div_oculto").html("");
		}
	}); 
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

function fn_mostrar_frm_add_items(ide_per){
	
	loaderSpinner();  
	$("#div_oculto").load("ajax_form_add_items.php",  {ide_per: ide_per}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				width: '80%',
				top: '1%',
				left: '8%',
				'max-height':'645px',
				'overflow-y':'auto'
			}
		}); 
		stoploaderSpinner();
		
	});
};

function fn_mostrar_frm_modificar(ide_per){
	$("#div_oculto").load("ajax_form_modificar.php", {ide_per: ide_per}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				top: '20%'
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
	var respuesta = confirm("Desea eliminar este legalizacion?");
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

function fn_eliminar_item(ide_per, idanticipo){

	var respuesta = confirm("Desea eliminar el item selecionado del anticipo?");

	if (respuesta){
		
		$.ajax({
			url: '/anticipos/anticipo/ajax_eliminar_item.php',
			data: {id: ide_per, id_anticipo: idanticipo},
			type: 'POST',
			dataType: 'json',
			success: function(data){	

				if (data.estado == true){
				   $("#total_anticipo").val(data.total_anticipo);
				  /* $("#valor_pagar").val(data.valor_pagar);*/
				   $("#jqxgrid2").jqxGrid('updatebounddata');
				}else{
					alert(data.message);
				}
			}
		});

	}

}