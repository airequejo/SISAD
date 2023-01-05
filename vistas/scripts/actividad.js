var tabla;

function init()
{
	
	listar();

    select_combo_subgasto();

    select_combo_periodo();

    $("#idsubgasto").select2(); 

    $("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})

}

function nuevo()
{
    $("#titulo_modal").text('Registro de actividad');
    limpiar();
    $('#mymodal').modal('show');
    $("#idsubgasto").val("");
    $("#idsubgasto").select2(); 
                           
}

function limpiar()
{
    $("#idactividad").val("");
    $("#codigoactividad").val("");
    $("#descripcion").val("");
    $("#idsubgasto").val("");
    $("#idsubgasto").select2(); 
    
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
                url: '../ajax/actividad.php?op=listar',
                type: "get",
                dataType: "json",
                error: function(e){
                    console.log(e.responseText);
                }
            },
            "dDestroy": true,
            "iDisplayLength":10,
            "order": [[4, "asc"]]
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
			url: "../ajax/actividad.php?op=guardaryeditar",
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
                            dat='Verifique código o nombre de actividad ya existe';
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

    function mostrar(idactividad)
	{
        $("#titulo_modal").text('Modificar actividad');

		$.post("../ajax/actividad.php?op=mostrar",{idactividad : idactividad},function(data, status)
		{
			data = JSON.parse(data);
			
			$("#descripcion").val(data.descripcion);
			$("#idsubgasto").val(data.idsubgasto);
            $("#idsubgasto").select2(); //(data.idsubgasto);
            $("#idactividad").val(data.idactividad);

		})
	}

	function desactivar(idactividad)
	{
		mensaje="¿Está seguro de cerrar la actividad?";
        Swal.fire({
            title: 'Cerrar actividad?',
            text: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/actividad.php?op=desactivar", {idactividad : idactividad}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Desactivar!',
                'La actividad se cerro',
                'success'
              )
            }
          })

    }

	function activar(idactividad)
	{
        mensaje="¿Está seguro de activar la actividad?";
        Swal.fire({
            title: 'Activar actividad?',
            text: mensaje,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/actividad.php?op=activar", {idactividad : idactividad}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Activar!',
                'La actividad se activo',
                'success'
              )
            }
          })
        	
	}

    function select_combo_subgasto()
	{
		$.post("../ajax/subgasto.php?op=select_combo_subgasto", function(r){
		$("#idsubgasto").html(r);
		});
	}

    function select_combo_periodo()
	{
		$.post("../ajax/periodos.php?op=select_combo_periodos", function(r){
		$("#idperiodo").html(r);
		});
	}








init();