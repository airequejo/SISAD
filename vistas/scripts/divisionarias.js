var tabla;

function init()
{
	
	listar();

    select_combo_subcuenta();

    $("#idsubcuenta").select2(); 

    $("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})

}

function nuevo()
{
    $("#titulo_modal").text('Registro de divisionaria');
    limpiar();
    $('#mymodal').modal('show');
    $("#idsubcuenta").val("");
    $("#idsubcuenta").select2(); 
                           
}

function limpiar()
{
    $("#iddivisionaria").val("");
    $("#codigodivisionaria").val("");
    $("#descripcion").val("");
    $("#idsubcuenta").val("");
    $("#idsubcuenta").select2(); 
    
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
                url: '../ajax/divisionarias.php?op=listar',
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
			url: "../ajax/divisionarias.php?op=guardaryeditar",
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
                            dat='Verifique código o nombre de divisionaria ya existe';
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

    function mostrar(iddivisionaria)
	{
        $("#titulo_modal").text('Modificar divisionaria');

		$.post("../ajax/divisionarias.php?op=mostrar",{iddivisionaria : iddivisionaria},function(data, status)
		{
			data = JSON.parse(data);
			
			$("#descripcion").val(data.descripcion);
            $("#codigodivisionaria").val(data.codigodivisionaria);
			$("#idsubcuenta").val(data.idsubcuenta);
            $("#idsubcuenta").select2(); //(data.idsubcuenta);
            $("#iddivisionaria").val(data.iddivisionaria);

		})
	}

	function desactivar(iddivisionaria)
	{
		mensaje="¿Está seguro de desactivar la divisionaria?";
        Swal.fire({
            title: 'Desactivar divisionaria?',
            text: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/divisionarias.php?op=desactivar", {iddivisionaria : iddivisionaria}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Desactivar!',
                'La divisionaria se desactivo',
                'success'
              )
            }
          })

    }

	function activar(iddivisionaria)
	{
        mensaje="¿Está seguro de activar la divisionaria?";
        Swal.fire({
            title: 'Activar divisionaria?',
            text: mensaje,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/divisionarias.php?op=activar", {iddivisionaria : iddivisionaria}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Activar!',
                'La divisionaria se activo',
                'success'
              )
            }
          })
        	
	}

    function select_combo_subcuenta()
	{
		$.post("../ajax/subcuentas.php?op=select_combo_cuentas", function(r){
		$("#idsubcuenta").html(r);
		});
	}








init();