var tabla;

function init()
{
	
	combo_cliente_credito();

	$("#idcliente").select2();

	//listar();

	
	$("#idcliente").change(listar);

			
}

function combo_cliente_credito()
{
	$.post("../ajax/gestionarcompromisos.php?op=combo_cliente_credito", function(r){
            $("#idcliente").html(r);
            //$('#idproveedor').selectpicker('refresh');
});


}



	
	function listar()
	{

		$("#example").dataTable().fnDestroy();

		var idcliente = $("#idcliente").val();
		
		tabla=$('#example').dataTable(
		{
	    	
	   "responsive": true,
		"aProcessing": true,
	    "aServerSide": true,
	    "autoWidth": false,
	    
			dom: 'Bfrtip',
			language: {
                url: '../public/dist/js/Spanish.json' //Ubicacion del archivo con el json del idioma.
            },
			buttons: [
				'copyHtml5',
		            'excelHtml5'	
				
			],
			"ajax":
			{
				url: '../ajax/gestionarcompromisos.php?op=listar',
				data:{idcliente:idcliente},
				type: "get",
				dataType: "json",
				error: function(e){
					console.log(e.responseText);
				}
			},
			"dDestroy": true,
			"iDisplayLength":20,
			"order": [[0, "DESC"]]
		}).DataTable();

		//$("#example").dataTable().fnDestroy();

	}


	function mostrar_detalle_credito(idcredito)
	{
		

		$.post("../ajax/gestionarcompromisos.php?op=mostrar_detalle_credito",{idcredito : idcredito},function(data, status)
		{
			data = JSON.parse(data);

			//alert(data.comprobante);
			
			
			$("#nombres").text(data.nombre);
			$("#idcredito").val(data.idcredito);
			$("#comprobante").text(data.comprobante);
			$("#fecha_credito").text(moment(data.fecha_credito).format('DD/MM/YYYY H:mm:ss'));
			$("#totalventa").text("S/ "+data.total);
			$("#montoabonado").text("S/ "+data.montoabonado);
			$("#monto_credito").text("S/ "+data.monto_credito);
			$("#deuda_actual").text("S/ "+data.deuda_actual);
			$("#deuda_a").val(data.deuda_actual);
			$("#monto").val(data.deuda_actual);
				
		})
	}

	function mostrar_detalle_pagos(idcredito)
	{
		$("#tb_detalle_pagos").dataTable().fnDestroy();
		tabla2=$('#tb_detalle_pagos').dataTable(
				{
			    	
			   "responsive": false,
				"aProcessing": true,
			    "aServerSide": true,
			    "autoWidth": false,
			    "searching": false,
			    "info": true,
				"paging":true,
				"ordering":false,
			    		    
					dom: 'Bfrtip',
					language: {
		                url: '../public/dist/js/Spanish.json' //Ubicacion del archivo con el json del idioma.
		            },
					buttons: [/*
						'copyHtml5',
				            'excelHtml5'	*/
						
					],
					"ajax":
					{
						url: '../ajax/gestionarcompromisos.php?op=listar_detalle_pagos',
						data:{idcredito:idcredito},
						type: "get",
						dataType: "json",
						error: function(e){
							console.log(e.responseText);
						}
					},
					"dDestroy": true,
					"iDisplayLength":10
					//"order": [[1, "DESC"]]
				}).DataTable();

	}


	function recargar() {
		setTimeout(function () {
			window.location.reload(1);
		}, 500);
	}



	$("#btnGuardar_modal").click(function(e)
{
	//$("#mensajeproceso").css("display", "block");
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	//
	//
	//
	var deuda_a = $("#deuda_a").val();
	var  monto = $("#monto").val();

		if (monto > 0 ) 
		{


			var formData = new FormData($("#procesar_credito_modal")[0]);

			$.ajax({
				url: "../ajax/gestionarcompromisos.php?op=insert_credito",
			    type: "POST",
			    data: formData,
			    contentType: false,
			    processData: false,

			    success: function(response)
			    {    

			    	var info = JSON.parse(response);

			    	if (info.states == 'ok') 			    	{
			    		
			    		
			       		icono='success';
					 	msj='Bien';

					 	valor="Operación Aceptada!";

						 Swal.fire(msj,valor,icono); 


					 		tabla.ajax.reload();

					 		//$("#modal_pagar_credito_ingreso").hide();
					 		$('#modal_pagar_credito_ingreso').modal('hide');

							$("#operacion").val("");
							$("#fechaoperacion").val("");
					 		

			    	}
			    	else{
			    		
			    		icono='error';
					 	msj='Error!';
					 	valor="No se pudo completar el pago, verifique datos ingresado, verifique si tiene una caja aperturada"

					 	Swal.fire(msj,valor,icono); 
			    	} 


			     } ,
			     error: function (error)
			     {
					toastr["error"]("No se completo la operación");
			     }            
			      


			});

		

		 }

	  else
	  {

		toastr["error"]("Monto a pagar debe ser mayor a cero");
	  	$("#monto").val("");
	  }

});



function desactivar(id)
	{
		mensaje="¿Está seguro de anular pago?";
        Swal.fire({
            title: 'Anular pago',
            text: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/gestionarcompromisos.php?op=desactivar", {id : id}, function(e){
					tabla2.ajax.reload();
					tabla.ajax.reload();
				});

              Swal.fire(
                'Anular!',
                'El pago se anulo',
                'success'
              )
            }
          })


	}





	
init();