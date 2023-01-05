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
    $("#titulo_modal").text('Registrar especialidad');
    limpiar();
    $('#mymodal').modal('show');
                           
}

function limpiar()
{
    $("#idespecialidad").val("");
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
                url: '../ajax/especialidad.php?op=listar',
                type: "get",
                dataType: "json",
                error: function(e){
                    console.log(e.responseText);
                }
            },
            "dDestroy": true,
            "iDisplayLength":10,
            "order": [[0, "asc"]]
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
			url: "../ajax/especialidad.php?op=guardaryeditar",
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
                            dat='Verifique código o nombre de cuenta ya existe';
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

    function mostrar(idespecialidad)
	{
        $("#titulo_modal").text('Modificar especialidad');

		$.post("../ajax/especialidad.php?op=mostrar",{idespecialidad : idespecialidad},function(data, status)
		{
			data = JSON.parse(data);
			$("#descripcion").val(data.descripcion);
			$("#idespecialidad").val(data.idespecialidad);

		})
	}

	function desactivar(idespecialidad)
	{
		mensaje="¿Está seguro de desactivar la especialidad?";
        
        Swal.fire({
            title: 'Desactivar especialidad?',
            text: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/especialidad.php?op=desactivar", {idespecialidad : idespecialidad}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Desactivar!',
                'La especialidad se desactivo',
                'success'
              )
            }
          })

    }

	function activar(idespecialidad)
	{
        mensaje="¿Está seguro de activar la especialidad?";
        Swal.fire({
            title: 'Activar especialidad?',
            text: mensaje,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/especialidad.php?op=activar", {idespecialidad : idespecialidad}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Activar!',
                'La especialidad se activo',
                'success'
              )
            }
          })        
		
	}

    








init();