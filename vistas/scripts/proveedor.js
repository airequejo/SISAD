var tabla;

function init()
{
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})

}

function cargar_modal()
  {
    $("#idproveedor").val("");
    $('#myModal').modal('show');
    $("#titulo_modal").text('Registrar proveedor');


  }


function limpiar()
{
	$("#idproveedor").val("");
	$("#nombrerazon").val("");
	$("#dniruc").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#celular").val("");
	$("#email").val("");
	$("#paginaweb").val("");
}

function mostrarform(flag)
{
	limpiar();
	if(flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
	}
}

	function cancelarform()
	{
		limpiar();
		//mostrarform(false);
	}

	function listar()
	{
		tabla=$('#proveedorListado').dataTable(
		{
			"responsive": true,
            "lengthChange": false, 
            "autoWidth": false,
			dom: 'Bfrtip',
			buttons: [
				/*'copyHtml5',
		            'excelHtml5',
		            'pdf'	*/		
				
			],
			"ajax":
			{
				url: '../ajax/proveedor.php?op=listar',
				type: "get",
				dataType: "json",
				error: function(e){
					console.log(e.responseText);
				}
			},
			"dDestroy": true,
			"iDisplayLength":10,
			"order": [[1, "asc"]]
		}).DataTable();
	}
	var icono="";
  	var msj="";
  	var mensaje="";

	function guardaryeditar(e)
	{
		e.preventDefault();
		$("#btnGuardar").prop("enabled", true);
		var formData = new FormData($("#formulario")[0]);

		$.ajax({
			url: "../ajax/proveedor.php?op=guardaryeditar",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,

			success: function(datos)
			{
				if(datos=="Operación Aceptada"){
				 	icono='success';
				 	msj='Éxito!'


				}
				else{
				 	icono='error';
				 	msj='Error!'
				}
				Swal.fire(msj,'Proveedor se registro',icono);
				mostrarform(false);
				tabla.ajax.reload();

				$('#myModal').modal('hide');
			}
		});
		limpiar();
	}

	function mostrar(idproveedor)
	{
        $("#titulo_modal").text('Modificar proveedor');

		$.post("../ajax/proveedor.php?op=mostrar",{idproveedor : idproveedor},function(data, status)
		{
			data = JSON.parse(data);
			//mostrarform(true);

			$('#myModal').modal('show');

			$("#nombrerazon").val(data.nombrerazon);
			$("#dniruc").val(data.dniruc);
			$("#direccion").val(data.direccion);
			$("#telefono").val(data.telefono);
			$("#celular").val(data.celular);
			$("#email").val(data.email);
			$("#paginaweb").val(data.paginaweb);
			$("#idproveedor").val(data.idproveedor);

		})
	}

	
	//Función para eliminar registros
function desactivar(idproveedor)
{
	mensaje="¿Está Seguro de desactivar al proveedor?";
	Swal.fire({
		title: 'Desactivar proveedor?',
		text: mensaje,
		icon: 'error',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Aceptar'
		}).then((result) => {
		if (result.isConfirmed) {

			$.post("../ajax/proveedor.php?op=desactivar", {idproveedor : idproveedor}, function(e){
				tabla.ajax.reload();
			});

			Swal.fire(
			'Activar!',
			'El proveedor se desactivo',
			'success'
			)
		}
	})   

}

function activar(idproveedor)
{
	mensaje="¿Está Seguro de activar al proveedor?";
	Swal.fire({
		title: 'Activar proveedor?',
		text: mensaje,
		icon: 'success',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Aceptar'
		}).then((result) => {
		if (result.isConfirmed) {

			$.post("../ajax/proveedor.php?op=activar", {idproveedor : idproveedor}, function(e){
				tabla.ajax.reload();
			});

			Swal.fire(
			'Activar!',
			'El proveedor se activo',
			'success'
			)
		}
	})   


}

init();