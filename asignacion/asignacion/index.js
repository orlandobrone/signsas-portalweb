// JavaScript Document



$(document).ready(function(){

	$("#grilla tbody tr").mouseover(function(){

		$(this).addClass("over");

	}).mouseout(function(){

		$(this).removeClass("over");

	});

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

				top: '1%',
				width: '45%',  
				left: '29%'

			}

		}); 

		stoploaderSpinner();

	});

};



function fn_mostrar_frm_modificar(ide_per){
	loaderSpinner();
	$("#div_oculto").load("ajax_form_modificar.php", {id: ide_per}, function(){

		$.blockUI({

			message: $('#div_oculto'),

			css:{

				top: '1%',
				width: '45%',  
				left: '29%'
				

			}

		}); 
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

	var respuesta = confirm("Desea eliminar esta asignacion?");

	if (respuesta){

		$.ajax({

			url: 'ajax_eliminar.php',

			data: 'id=' + ide_per,

			type: 'post',

			success: function(data){

				if(data!="")

					alert(data);

					//fn_buscar()

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

	$("#jqxgrid").jqxGrid('updatebounddata', 'cells');	

}