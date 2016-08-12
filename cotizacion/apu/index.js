// JavaScript Document



$(document).ready(function(){

	//fn_buscar();

	$("#grilla tbody tr").mouseover(function(){

		$(this).addClass("over");

	}).mouseout(function(){

		$(this).removeClass("over");

	});

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

	$('#btn_add_anticipo').attr('disabled', 'disabled');

	$("#div_oculto").load("ajax_form_agregar.php", function(){

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

		

		

		setTimeout(function(){$('#btn_add_anticipo').removeAttr('disabled');}, 10000);

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





function fn_importar_excel(){

	$("#div_oculto").load("/excel/form_upload.php", function(){

		$.blockUI({

			message: $('#div_oculto'),

			css:{

				width: '950px',

				top: '10%',

				left: '17%'

			}

		}); 

	});

};



function fn_eliminar(ide_per){

	var respuesta = confirm("Desea eliminar este anticipo?");

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

function fn_eliminar_item_costo(ide_per){

	var respuesta = confirm("Desea eliminar este item costo?");
	if (respuesta){
		$.ajax({
			url: 'ajax_eliminar_item_costo.php',
			data: 'id=' + ide_per,
			type: 'post',
			success: function(data){
				if(data!="")
					$("#jqxgrid2").jqxGrid('updatebounddata', 'cells');
			}
		});
	}
	
}


function fn_eliminar_item(ide_per, idanticipo, valor_hito){

	var respuesta = confirm("Desea eliminar este intem del anticipo?");

	var value1, value2, value3, value11, value22;

	if (respuesta){

		$.ajax({

			url: 'ajax_eliminar_item.php',

			data: {id: ide_per, id_anticipo: idanticipo},

			type: 'POST',

			dataType: 'json',

			success: function(data){	

				if (data.estado == true){

				   $("#total_anticipo, #test_total").val(data.total_anticipo);

				   $("#jqxgrid2").jqxGrid('updatebounddata', 'cells');

				  

				   value2 = parseInt($("#v_cotizado").val());				   

				 

				   value3 = value2-valor_hito;

				   $("#v_cotizado").val(value3);

				   

				   

				}else{

					alert(data.message);

				}

			}

		});

	}

}



function fn_export_anticipo(idanticipo){

	

		window.open("/anticipos/anticipo/email_anticipo.php?ide_per="+idanticipo);

	

		/*$.ajax({

			url: 'email_anticipo.php',

			data: {ide_per: idanticipo},

			type: 'GET',

			dataType: 'json',

			success: function(data){				

				if (data.estado == false){				

					window.open("/anticipos/anticipo/email_anticipo.php?ide_per"+idanticipo);

				}

			}

		});*/



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

	var respuesta = confirm('\xBFDesea realmente cambiar el estado a aprobado?')

	if (respuesta){		

		$.post('ajax_aprobar_anticipo.php',{id:idAnticipo},function(data){			

			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');

		});

	}

}



