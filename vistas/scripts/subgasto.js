var tabla;

function init()
{
	
	listar();

    select_combo_gasto();

   // $("#idgasto").select2(); 

    $("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})

}

function nuevo()
{
    $("#titulo_modal").text('Registrar subgasto');
    limpiar();
    $('#mymodal').modal('show');
                           
}

function limpiar()
{
    $("#idsubgasto").val("");
    $("#descripcion").val("");
    $("#idgasto").val("");
    
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
                url: '../ajax/subgasto.php?op=listar',
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
			url: "../ajax/subgasto.php?op=guardaryeditar",
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
                            dat='Verifique  el subgasto ya existe';
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

    function mostrar(idsubgasto)
	{
        $("#titulo_modal").text('Modificar subgasto');

		$.post("../ajax/subgasto.php?op=mostrar",{idsubgasto : idsubgasto},function(data, status)
		{
			data = JSON.parse(data);
			
			$("#descripcion").val(data.descripcion);
			$("#idgasto").val(data.idgasto);
           // $("#idgasto").select2(); 
            $("#idsubgasto").val(data.idsubgasto);

		})
	}

	function desactivar(idsubgasto)
	{
		mensaje="¿Está seguro de desactivar subgasto?";
        Swal.fire({
            title: 'Desactivar Subgasto?',
            text: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/subgasto.php?op=desactivar", {idsubgasto : idsubgasto}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Desactivar!',
                'Subgasto se desactivo',
                'success'
              )
            }
          })

    }

	function activar(idsubgasto)
	{
        mensaje="¿Está seguro de activar subgasto?";
        Swal.fire({
            title: 'Activar Subcuenta?',
            text: mensaje,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/subgasto.php?op=activar", {idsubgasto : idsubgasto}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Activar!',
                'Subgasto se activo',
                'success'
              )
            }
          })
        	
	}

    function select_combo_gasto()
	{
		$.post("../ajax/gasto.php?op=select_combo_gastos", function(r){
		$("#idgasto").html(r);
		});
	}








init();