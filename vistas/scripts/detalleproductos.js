var tabla;

function init()
{
	
	listar();

  select_combo_divisionarias();
 

    $("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})

}


function limpiar()
{
   
    
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
                url: '../ajax/detalleproductos.php?op=listar',
                type: "get",
                dataType: "json",
                error: function(e){
                    console.log(e.responseText);
                }
            },
            "dDestroy": true,
            "iDisplayLength":10,
            "order": [[5, "asc"]]
        }).DataTable();
    }

var icono="";
var msj="";
var mensaje="";

function guardaryeditar(i)
{
  i.preventDefault();
  //$("#btnGuardar").prop("productobled", true);
  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "../ajax/detalleproductos.php?op=guardaryeditar",
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
                          dat='Datos Guardado: Se asigno '+info.nompro+' a la divisionaria '+info.descdivi;
                          Swal.fire(msj,dat,icono);

                          tabla.ajax.reload();
                          $('#mymodal').modal('hide');
                          //limpiar_detalle();
                      }
                  else if (info.state == 2)
                      {
                          icono='error';
                          msj='Error!';
                          dat='Verifique, el producto '+ info.nompro+' ya esta asignado a la divisionaria  '+ info.descdivi;
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



	function desactivar(iddetalleproductodivisionaria)
	{
		mensaje="¿Está seguro de desactivar el producto divisionaria?";
        Swal.fire({
            title: 'Desactivar producto divisionaria?',
            text: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/detalleproductos.php?op=desactivar", {iddetalleproductodivisionaria : iddetalleproductodivisionaria}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Desactivar!',
                'La producto divisionaria se desactivo',
                'success'
              )
            }
          })

    }

	function activar(iddetalleproductodivisionaria)
	{
        mensaje="¿Está seguro de activar el producto divisionaria?";
        Swal.fire({
            title: 'Activar producto divisionaria?',
            text: mensaje,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/detalleproductos.php?op=activar", {iddetalleproductodivisionaria : iddetalleproductodivisionaria}, function(e){
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

  function select_combo_divisionarias()
	{
		$.post("../ajax/divisionarias.php?op=select_combo_divisionarias", function(r){
		$("#iddivisionaria").html(r);
		});
	}


  function mostrar(iddetalleproductodivisionaria)
	{
    
		$.post("../ajax/detalleproductos.php?op=mostrar",{iddetalleproductodivisionaria : iddetalleproductodivisionaria},function(data, status)
		{
			data = JSON.parse(data);

          $("#nombreproducto").text(data.producto);
          $("#idproducto").val(data.idproducto);
          $("#iddivisionaria").val(data.iddivisionaria);
          $("#iddivisionaria").select2(); 
          $("#iddetalleproductodivisionaria").val(data.iddetalleproductodivisionaria);

		})
	}








init();