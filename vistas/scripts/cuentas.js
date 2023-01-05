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
    $("#titulo_modal").text('Registrar cuenta');
    limpiar();
    $('#mymodal').modal('show');
                           
}

function limpiar()
{
    $("#idcuenta").val("");
    $("#codigocuenta").val("");
    $("#descripcion").val("");
    $("#tipo").val("");
    
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
                url: '../ajax/cuentas.php?op=listar',
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
			url: "../ajax/cuentas.php?op=guardaryeditar",
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

    function mostrar(idcuenta)
	{
        $("#titulo_modal").text('Modificar cuenta');

		$.post("../ajax/cuentas.php?op=mostrar",{idcuenta : idcuenta},function(data, status)
		{
			data = JSON.parse(data);
			
            $("#codigocuenta").val(data.codigocuenta);
			$("#descripcion").val(data.descripcion);
            $("#tipo").val(data.tipo);
			$("#idcuenta").val(data.idcuenta);

		})
	}

	function desactivar(idcuenta)
	{
		mensaje="¿Está seguro de desactivar la cuenta?";
        
        Swal.fire({
            title: 'Desactivar Cuenta?',
            text: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/cuentas.php?op=desactivar", {idcuenta : idcuenta}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Desactivar!',
                'La cuenta se desactivo',
                'success'
              )
            }
          })

    }

	function activar(idcuenta)
	{
        mensaje="¿Está seguro de activar la cuenta?";
        Swal.fire({
            title: 'Activar Cuenta?',
            text: mensaje,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/cuentas.php?op=activar", {idcuenta : idcuenta}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Activar!',
                'La cuenta se activo',
                'success'
              )
            }
          })        
		
	}

    








init();