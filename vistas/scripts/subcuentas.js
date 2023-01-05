var tabla;

function init()
{
	
	listar();

    select_combo_cuenta();

    $("#idcuenta").select2(); 

    $("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})

}

function nuevo()
{
    $("#titulo_modal").text('Registrar subcuenta');
    limpiar();
    $('#mymodal').modal('show');
                           
}

function limpiar()
{
    $("#idsubcuenta").val("");
    $("#codigosubcuenta").val("");
    $("#descripcion").val("");
    $("#idcuenta").val("");
    
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
                url: '../ajax/subcuentas.php?op=listar',
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
			url: "../ajax/subcuentas.php?op=guardaryeditar",
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
                            dat='Verifique código o nombre de subcuenta ya existe';
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

    function mostrar(idsubcuenta)
	{
        $("#titulo_modal").text('Modificar subcuenta');

		$.post("../ajax/subcuentas.php?op=mostrar",{idsubcuenta : idsubcuenta},function(data, status)
		{
			data = JSON.parse(data);
			
			$("#descripcion").val(data.descripcion);
            $("#codigosubcuenta").val(data.codigosubcuenta);
			$("#idcuenta").val(data.idcuenta);
            $("#idcuenta").select2(); 
            $("#idsubcuenta").val(data.idsubcuenta);

		})
	}

	function desactivar(idsubcuenta)
	{
		mensaje="¿Está seguro de desactivar la subcuenta?";
        Swal.fire({
            title: 'Desactivar Subcenta?',
            text: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/subcuentas.php?op=desactivar", {idsubcuenta : idsubcuenta}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Desactivar!',
                'La subcuenta se desactivo',
                'success'
              )
            }
          })

    }

	function activar(idsubcuenta)
	{
        mensaje="¿Está seguro de activar la subcuenta?";
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

                $.post("../ajax/subcuentas.php?op=activar", {idsubcuenta : idsubcuenta}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Activar!',
                'La subcuenta se activo',
                'success'
              )
            }
          })
        	
	}

    function select_combo_cuenta()
	{
		$.post("../ajax/cuentas.php?op=select_combo_cuentas", function(r){
		$("#idcuenta").html(r);
		});
	}








init();