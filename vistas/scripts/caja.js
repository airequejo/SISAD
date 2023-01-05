var tabla;

function init()
{
	
	listar();

}


function limpiar()
{

  $("#monto_inicial").val("");
  $("#turno").val("");
}


	function cancelarform()
	{
		limpiar();
		
	}

	function listar()
	{
		tabla=$('#tbllistado').dataTable(
		{
			"aProcessing":true,
			"aServerSide":true,
			"ordering":false,
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [
		            'copyHtml5',
		            'excelHtml5'
		        ],
		"ajax":
			{
				url: '../ajax/caja.php?op=listar',
				type: "get",
				dataType: "json",
				error: function(e){
					console.log(e.responseText);
				}
			},
			"dDestroy": true,
			"iDisplayLength":10,
			"order": [[0, "desc"]]
		}).DataTable();
	}



	function inserta_caja()
	{
		
	
		var formData = new FormData($("#form_caja")[0]);

		$.ajax({
			url: "../ajax/caja.php?op=insertar_caja",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,

			success: function(datos)
			{

		      	var info = JSON.parse(datos);
		  	
		    	if (info.state == 'ok')
		    	 {
                    Swal.fire({
                        title: 'Caja se aperturo?',
                        text: "Caja aperturada",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK, ir a ventas'
                      }).then((result) => {
                        if (result.isConfirmed) {
                            location.href="venta";  
                        }
                      })                              		

		    	 }
		    	 else
		    	 {

				 	toastr["error"]("Error!", "Ya tiene una caja Aperturada!", "error");

				 	//location.href="ventas";

		    	 }
					
				
			},

			error: function (error)
			     {
			     	//bootbox.alert("Error al procesar la operación");

			     	toastr["error"]("Error!", "Error al procesar la operación!", "error");
			     } 

		});	
	}



	function mostrar(idcaja)
	{
		$.post("../ajax/caja.php?op=mostrar",{idcaja : idcaja},function(data, status)
		{
			data = JSON.parse(data);
			//mostrarform(true);
			$("#idcaja").val("");
			$("#fecha_a").text("");
			$("#turno_c").text("");
			$("#monto_i").text("S/ ");
			$("#efectivo").text("S/ ");
			$("#tarjeta").text("S/ ");
			$("#credito").text("S/ ");
			$("#gastos").text("S/ ");
			$("#total_efectivo").text("S/ ");

			$("#idcaja").val(data.idcaja);
			$("#fecha_a").text(data.fecha_a);
			$("#turno_c").text(data.turno_v);
			$("#monto_i").text("S/ "+data.monto_i);
			$("#efectivo").text("S/ "+data.efectivo);
			$("#tarjeta").text("S/ "+data.tarjeta);
			$("#credito").text("S/ "+data.credito);
			$("#gastos").text("S/ "+data.gastos);
			$("#total_efectivo").text("S/ "+data.total_efectivo);

		})
	}

    function cerrar_caja()
	{
		mensaje="¿Está seguro de cerrar caja?";
        Swal.fire({
            title: 'Cerrar caja?',
            text: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData($("#form_caja_mostrar")[0]);
                $.ajax({
                    url: "../ajax/caja.php?op=cerrar_caja",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,

                    success: function(response)
                    {    
			    	var info = JSON.parse(response);

			    	if (info.states == 'ok') 
			    	{
                        
			    		//Swal.fire('Caja cerrada')

						location.reload();
								

			    	}
			    	else
			    	{

			    		icono='error';
					 	msj='Error!';
					 	valor="No se pudo completar"

					 	Swal.fire(msj,valor,icono); 

			    	}
			     } ,
			     error: function (error)
			     {
			     	toastr["error"]("Error al procesar");
			     }        

			});

					tabla.ajax.reload();
			

              Swal.fire(
                'Desactivar!',
                'La caja se desactivo',
                'success'
              )
            }
          })

	}




    function valida_tipo_modal()
{
	// $("#idcliente").val("");
	//limpiar();
	//ver();

	$('#modal_caja').modal('show');				
}




init();
