var tabla;
var tabla2;

function init()
{

	listar();

    // $("#titulo_modal").text('Registro de productos');
    $("#iddivisionaria").select2(); 
    $("#idunidadmedida").select2(); 
    $("#aplicamovimiento").select2(); 
    $("#tipo").select2(); 

    select_combo_divisionarias();
    select_combo_unidadmedidas()

    $("#tipo").change(validar_tipo);

    $("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})

    $("#formulario_detalle").on("submit",function(i)
	{
		guardaryeditar_detalle_producto(i);
	})

}

function nuevo()
{
    $("#titulo_modal").text('Registro de productos');
    limpiar();
    $('#mymodal').modal('show');
                           
}

function limpiar()
{
    $("#idproducto").val("");
    $("#idunidadmedida").val("");
    $("#idunidadmedida").select2(); 
    $("#descripcion").val("");
    $("#aplicamovimiento").val("");
    $("#aplicamovimiento").select2(); 
    $("#tipo").val("");
    $("#tipo").select2(); 
    
}

function limpiar_detalle()
{
    $("#idproducto_detalle").val("");
    $("#iddivisionaria").val("");
    $("#iddivisionaria").select2(); 
}

function listar_detalle(id)
    {
        tabla2=$('#example1_detalle_producto').dataTable(
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
                url: '../ajax/productos.php?op=listar_detalle_producto',
                data:{id:id},
                type: "get",
                dataType: "json",
                error: function(e){
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength":10,
            "order": [[2, "asc"]]
        }).DataTable();
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
                url: '../ajax/productos.php?op=listar',
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
        var idproducto = $("#idproducto").val();
        var aplicamovimiento = $("#aplicamovimiento").val();
		//$("#btnGuardar").prop("productobled", true);
		var formData = new FormData($("#formulario")[0]);

		$.ajax({
			url: "../ajax/productos.php?op=guardaryeditar",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function(datos)
                {
                    var info = JSON.parse(datos);
                    if (info.state == 1)            
                        {
                            if (idproducto !== '')
                            {
                                icono='success';
                                msj='Éxito!';
                                dat='Producto: '+info.nompro+' se actualizó';
                                Swal.fire(msj,dat,icono); 

                            }
                            else
                            {
                           
                            toastr["success"]("Producto: "+info.nompro+ 'se agregado')

                                toastr.options = {
                                    "showDuration": "500",
                                    "hideDuration": "1000",
                                    "timeOut": "5000",
                                    "extendedTimeOut": "1000",
                                }

                                
                                $("#idproducto_detalle").val(info.idprod);
                                $("#nombreproducto").text(info.nompro);
                                $('#mymodaldetalle').modal('show'); 

                                limpiar();
                            }

                            tabla.ajax.reload();

                            $('#mymodal').modal('hide'); 

                            if (idproducto == "" ) 
                            {  
                            }
                                             

                        }
                    else if (info.state == 2)
                        {
                            icono='error';
                            msj='Error!';
                            dat='Verifique: el producto '+ info.nompro+' ya existe';
                            Swal.fire(msj,dat,icono);

                        }
                    else if (info.state == 3)
                        {
                            icono='error';
                            msj='Error!';
                            dat='Complete los datos';
                            Swal.fire(msj,dat,icono);   

                        } 
                        else if (info.state == 4)
                        {
                            icono='error';
                            msj='Error!';
                            dat='La unidad de medida no corresponde a un servico (Seleccione UNIDAD (SERVICIO))';
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

    function guardaryeditar_detalle_producto(i)
	{
		i.preventDefault();
		//$("#btnGuardar").prop("productobled", true);
		var formData = new FormData($("#formulario_detalle")[0]);

		$.ajax({
			url: "../ajax/productos.php?op=guardardetalleproducto",
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

                            //tabla.ajax.reload();
                            $('#mymodaldetalle').modal('hide');
                            limpiar_detalle();
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


    function mostrar(idproducto)
	{
        $("#titulo_modal").text('Modificar producto');

     

		$.post("../ajax/productos.php?op=mostrar",{idproducto : idproducto},function(data, status)
		{
			data = JSON.parse(data);
			
            $("#tipo").val(data.tipo);
            $("#tipo").select2(); 
			$("#descripcion").val(data.descripcion);           
            $("#idunidadmedida").val(data.idunidadmedida);
            $("#idunidadmedida").select2(); 
			$("#aplicamovimiento").val(data.aplicamovimiento);
            $("#aplicamovimiento").select2(); 
            $("#idproducto").val(data.idproducto);

            validar_tipo();

		})
	}

	function desactivar(idproducto)
	{
		mensaje="¿Está seguro de desactivar la producto?";
        Swal.fire({
            title: 'Desactivar Producto?',
            text: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/productos.php?op=desactivar", {idproducto : idproducto}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Desactivar!',
                'La producto se desactivo',
                'success'
              )
            }
          })

    }

	function activar(idproducto)
	{
        mensaje="¿Está seguro de activar la producto?";
        Swal.fire({
            title: 'Activar producto?',
            text: mensaje,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/productos.php?op=activar", {idproducto : idproducto}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Activar!',
                'La producto se activo',
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

    function modal_asignar(idproducto)
    {
        limpiar_detalle();

        $.post("../ajax/productos.php?op=mostrar",{idproducto : idproducto},function(data, status)
		{
			data = JSON.parse(data);
			
			$("#nombreproducto").text(data.descripcion);
            $("#idproducto_detalle").val(data.idproducto);

		})
        
        $('#mymodaldetalle').modal('show'); 
        
    }

    function select_combo_unidadmedidas()
	{
		$.post("../ajax/productos.php?op=select_combo_unidadmedidas", function(r){
		$("#idunidadmedida").html(r);
		});
	}



    function validar_tipo()
    {
      var tipo = $("#tipo").val();
      if (tipo == 1) 
        {
            $('#idunidadmedida option:eq(59)').prop('disabled',false);
            $("#idunidadmedida").val(59);
            $("#idunidadmedida").select2();
            
        }
        else{
           //  $("#idunidadmedida").prop('disabled' ,false);
            $("#idunidadmedida").val(58);
            $("#idunidadmedida").select2();
            $('#idunidadmedida option:eq(59)').prop('disabled',true);
            
  
        }
  
    }
  







init();