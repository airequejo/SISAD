var tabla;

function init()
{
	mostrarform(true);
	


}


function limpiar()
{

}

function mostrarform(flag)
{
	limpiar();
	if(flag)
	{
		$("#listadoregistros").show();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").show();
	}
}

	function cancelarform()
	{
	location.href = "ventas.php";
	}

	var icono="";
  	var msj="";
  	var mensaje="";

  	$("#btnGuardar_nota_credito").click("click",function(e)
	{
	   // $("#mensajeproceso").css("display", "block");
		e.preventDefault();
		//$("#btnGuardar").prop("disabled", true);
		//$('#btnGuardar').attr("disabled", true);
		var formData = new FormData($("#formulario")[0]);

		$.ajax({
			url: "../ajax/notacredito.php?op=guardaryeditar",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,

			success: function(datos)
			{
				var info = JSON.parse(datos);

				console.log(info);

			    	if (info.states == 'ok') 
			    	{
						$("[id*='btnGuardar_nota_credito']").attr('disabled', 'disabled');

						Swal.fire({
							title: 'Operación Aceptada',
							text: "Nota de credito generada!",
							icon: 'success',
							showCancelButton: false,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'OK'
						  }).then((result) => {
							if (result.isConfirmed) {
								location.href = "ventas.php";
								tabla.ajax.reload();
							}
						  })
			    	
			    		


				}
				else
				{
				 	icono='error';
					 	msj='Error!';
					 	valor="No se pudo completar la venta"

					 	Swal.fire(msj,valor,icono);
				}

				//$("#mensajeproceso").css("display", "none");
				
			},
			 
			     error: function (error)
			     {
			     	toastr["error"]("Error al procesar la operación");
			     }  

		});
		//limpiar();
	});

	function llenar()
    {

        var y= $("#idmotivo option:selected").text();
        $("#descripcionmotivo").val(y);

    }

	function mostrar(idcategoria)
	{
		$.post("../ajax/categoria.php?op=mostrar",{idcategoria : idcategoria},function(data, status)
		{
			data = JSON.parse(data);
			mostrarform(true);
			$("#nombre").val(data.nombre);
			$("#descripcion").val(data.descripcion);
			$("#idcategoria").val(data.idcategoria);

		})
	}

	


init();