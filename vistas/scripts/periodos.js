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
    $("#titulo_modal").text('Registrar periodo');
    limpiar();
    $('#mymodal').modal('show');
                           
}

function limpiar()
{
    $("#idperiodo").val("");
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
                url: '../ajax/periodos.php?op=listar',
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
			url: "../ajax/periodos.php?op=guardaryeditar",
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
                            dat='Verifique periodo ya existe';
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

    function mostrar(idperiodo)
	{
        $("#titulo_modal").text('Modificar periodo');

		$.post("../ajax/periodos.php?op=mostrar",{idperiodo : idperiodo},function(data, status)
		{
			data = JSON.parse(data);
			
			$("#descripcion").val(data.descripcion);
			$("#idperiodo").val(data.idperiodo);

		})
	}

	function desactivar(idperiodo)
	{
		mensaje="¿Está seguro de cerrar el perido?";
        Swal.fire({
            title: 'Cerrar periodo?',
            text: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/periodos.php?op=desactivar", {idperiodo : idperiodo}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Desactivar!',
                'El periodo se cerro',
                'success'
              )
            }
          })

    }

	function activar(idperiodo)
	{
        mensaje="¿Está seguro de activar periodo?";
        Swal.fire({
            title: 'Activar periodo?',
            text: mensaje,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/periodos.php?op=activar", {idperiodo : idperiodo}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Activar!',
                'El periodo se activo',
                'success'
              )
            }
          })        
		
	}

    








init();