var tabla;

function init()
{
	
	listar();

    $("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})

}

function nuevo()
{
    $("#titulo_modal").text('Registrar gasto');
    limpiar();
    $('#mymodal').modal('show');
                           
}

function limpiar()
{
    $("#idgasto").val("");
    $("#descripcion").val("");
    
}

function listar()
    {
        tabla=$('#example1').dataTable(
        {
            "responsive": true,
            "lengthChange": false, 
            "autoWidth": false,
            dom: 'Bfrtip',
            buttons: [
                /*'copy',
                    'excel'	*/	
                
            ],
            "ajax":
            {
                url: '../ajax/gasto.php?op=listar',
                type: "get",
                dataType: "json",
                error: function(e){
                    console.log(e.responseText);
                }
            },
            "dDestroy": true,
            "iDisplayLength":10,
            "order": [[2, "asc"]]
        }).DataTable();
    }

    var icono="";
  	var msj="";
  	var mensaje="";

	function guardaryeditar(e)
	{
		e.preventDefault();
		//$("#btnGuardar").prop("productobled", true);
		var formData = new FormData($("#formulario")[0]);

		$.ajax({
			url: "../ajax/gasto.php?op=guardaryeditar",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function(datos)
                {
                    var info = JSON.parse(datos);
                    if (info.state == 1)            
                        {
                            icono='success';
                            msj='Éxito!';
                            dat='Datos Guardados';
                            Swal.fire(msj,dat,icono);

                            tabla.ajax.reload();
                            $('#mymodal').modal('hide');
                            limpiar();
                        }
                    else if (info.state == 2)
                        {
                            icono='error';
                            msj='Error!';
                            dat='Verifique nombre de gasto ya existe';
                            Swal.fire(msj,dat,icono);

                        }
                    else if (info.state == 3)
                        {
                            icono='error';
                            msj='Error!';
                            dat='Complete los datos';
                            Swal.fire(msj,dat,icono);   

                        } 
                        else
                        {
                            icono='error';
                            msj='Error!';
                            dat='No se puede completar verifique los datos ingresados';
                            Swal.fire(msj,dat,icono);   
                        } 
                } ,
                error: function (error)
                {
                    icono='error';
                    msj='Error!';
                    dat='No se puede completar verifique los datos ingresados..';
                    Swal.fire(msj,dat,icono);   
                }      
               
		});

		
	}

    function mostrar(idgasto)
	{
        $("#titulo_modal").text('Modificar gasto');

		$.post("../ajax/gasto.php?op=mostrar",{idgasto : idgasto},function(data, status)
		{
			data = JSON.parse(data);
			
			$("#descripcion").val(data.descripcion);
			$("#idgasto").val(data.idgasto);

		})
	}

	function desactivar(idgasto)
	{
		mensaje="¿Está seguro de desactivar el gasto?";
        
        Swal.fire({
            title: 'Desactivar gasto?',
            text: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/gasto.php?op=desactivar", {idgasto : idgasto}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Desactivar!',
                'El gasto se desactivo',
                'success'
              )
            }
          })

    }

	function activar(idgasto)
	{
        mensaje="¿Está seguro de activar el gasto?";
        Swal.fire({
            title: 'Activar gasto?',
            text: mensaje,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/gasto.php?op=activar", {idgasto : idgasto}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Activar!',
                'El gasto se activo',
                'success'
              )
            }
          })        
		
	}

    








init();