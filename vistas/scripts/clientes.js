var tabla;

function init()
{
	//mostrarform(false);
	listar();

    llenar_ubigeo();
	$('#ubigeo').select2();


	//$("#dniruc").change(validar_dni_ruc);
	/*$("#dniruc").change(valida_doc);*/

	$("#buscar_cli").click(search_document);
	$("#tipodocumento").change(val_tipo_documento);
	$("#tipodocumento").change(iniciar_tipodocumento);

//	mostrar_ocultar();

}



function valida_tipo_modal()
{
	$("#idcliente").val("");
	limpiar();
	ver();
	$('#mymodal').modal('show');				
}

function llenar_ubigeo()
{
	//Cargamos los items al select proveedor
	$.post("../ajax/ubigeo.php?op=select_combo_ubigeo", function(r){
	            $("#ubigeo").html(r);
	            
	});

	
}



function ver() {

	$("#titulo_modal").text('Registrar cliente');
	$("#divdistrito").show();
	$("#divreferencia").show();
	$("#divdireccion").show();

    /*div = document.getElementById('ocultar_update');
     div.style.display = '';*/

}

function cerrar() {
	$("#titulo_modal").text('Modificar cliente');
	$("#divdistrito").hide();
	$("#divreferencia").hide();
	$("#divdireccion").hide();
	
	/*
    div = document.getElementById('ocultar_update');
    div.style.display = 'none';*/
}



function limpiar()
{
	$("#idcliente").val("");
	$("#nombre").val("");
	//$("#tipodocumento").val("");

	$("#dniruc").val("");
	$("#direccion").val("");
	$("#referencia").val("");
	$("#celular").val("");
	$("#email").val("");
}


	function cancelarform()
	{
		limpiar();
		
	}

	function listar()
	{
		tabla=$('#clienteListado').dataTable(
		{
			"responsive": true,
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,
	    "autoWidth": false,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',
			buttons: [
				/*'copyHtml5',
		            'excelHtml5',
		            'pdf'*/

			],
			"ajax":
			{
				url: '../ajax/cliente.php?op=listar',
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

function guardaryeditar()
	{
		//e.preventDefault();
		$("#btnGuardar").prop("enabled", true);
		var formData = new FormData($("#formulario")[0]);

		$.ajax({
			url: "../ajax/cliente.php?op=guardaryeditar",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,

			success: function(datos)
			{
				var info = JSON.parse(datos);
				//console.log(info);
			
			if (info.state == 'ok')
			 {
				
				toastr["success"]("Cliente se Registro con Exito")	;
			   
			   tabla.ajax.reload();

			   $('#mymodal').modal('hide');

			   iniciar_tipodocumento();
	
			}
			else if(info.state == "existe")
			{
				toastr["error"]("Cliente ya Existe");
				
			}
				else
			{
	
					toastr["error"]("Verifique datos");
					
			}

				
			}
		});
		

	}

	function mostrar(idcliente)
	{
		cerrar();
		$.post("../ajax/cliente.php?op=mostrar",{idcliente : idcliente},function(data, status)
		{
			data = JSON.parse(data);
			
			$("#nombre").val(data.nombre);
			$("#tipodocumento").val(data.tipodocumento);
			$("#dniruc").val(data.dniruc);
			$("#direccion").val(data.direccion);
			$("#referencia").val(data.referencia);
			$("#celular").val(data.celular);
			$("#email").val(data.email);
			$("#idcliente").val(data.idcliente);

				
		})
	}

	function desactivar(idcliente)
	{
		mensaje="¿Está seguro de desactivar cliente?";
        Swal.fire({
            title: 'Desactivar cliente?',
            text: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/cliente.php?op=desactivar", {idcliente : idcliente}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Desactivar!',
                'El cliente se desactivo',
                'success'
              )
            }
          })

	}

	function activar(idcliente)
	{

		mensaje="¿Está seguro de activar cliente?";
        Swal.fire({
            title: 'Activar cliente?',
            text: mensaje,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/cliente.php?op=activar", {idcliente : idcliente}, function(e){
					tabla.ajax.reload();
				});

              Swal.fire(
                'Activar!',
                'El cliente se activo',
                'success'
              )
            }
          })   

	}


	function ValidarRUC(rucVal) {
            var regEx = /\d{11}/;
            //var ruc = new String(document.getElementById(rucVal).value);

            var ruc = new String(rucVal);

            if (ruc.length != 11) {
                bootbox.alert("¡ALERTA: El RUC " + ruc + " NO es valido!. SI NO TIENE UNO SELECCIONE DNI");
                $("#dniruc").val("");
                return 0;
            }

            if (regEx.test(ruc)) {
                var factores = new String("5432765432");
                var ultimoIndex = ruc.length - 1;
                var sumaTotal = 0, residuo = 0;
                var ultimoDigitoRUC = 0, ultimoDigitoCalc = 0;

                for (var i = 0; i < ultimoIndex; i++) {
                    sumaTotal += (parseInt(ruc.charAt(i)) * parseInt(factores.charAt(i)));
                }
                residuo = sumaTotal % 11;

                ultimoDigitoCalc = (residuo == 10) ? 0 : ((residuo == 11) ? 1 : (11 - residuo) % 10);
                ultimoDigitoRUC = parseInt(ruc.charAt(ultimoIndex));

                if (ultimoDigitoRUC == ultimoDigitoCalc) {
                    //alert("¡El RUC " + ruc + " SÍ es válido!.");
                    return 1;
                } else {
                    alert("¡ALERTA: El RUC " + ruc + " NO es valido!. SI NO TIENE UNO SELECCIONE DNI");
                    $("#dniruc").val("");
                    return 0;
                }
            } else {
                bootbox.alert("ALERTA : El RUC no es valido, debe constar de 11 caracteres numericos. SI NO TIENE UNO SELECCIONE BOLETA");
                document.getElementById("dniruc").focus();
                $("#dniruc").val("");
                return 0;
            }
        }

	function valida_doc()
	{
		var tipo_doc = $('#tipodocumento').val();
				if (tipo_doc == "6") {
					var valRUC = ValidarRUC(document.getElementById("dniruc").value);
					if (valRUC == '0') {
						return;
					}
				} else if (tipo_doc == "1" && $('#dniruc').val().length != 8) {
					toastr["error"]('El nro DNI debe tener 8 Digitos');
					$("#dniruc").val("");
					return;

				}
	}

        function iniciar_tipodocumento()
        {
        	$("#dniruc").val("");
        	$("#nombre").val("");
        	$("#direccion").val("");

			$("#ubigeo").val("");
			$('#ubigeo').select2();
        	//$("#departamento").val("");
        	//$("#provincia").val("");
        	//$("#distrito").val("");
        	$("#referencia").val("");
        	$("#celular").val("");
        	$("#email").val("");
        	
        }


        function validar_dni_ruc()

        {

	
        	
        	var tipo_doc = $('#tipodocumento').val();
        	var dniruc = $('#dniruc').val();

        	if (tipo_doc == "1" && $('#dniruc').val().length != 8)
        	{
        		toastr["error"]('El nro DNI debe tener 8 Digitos');
               	iniciar_tipodocumento();
               

             }
             else if(tipo_doc == "6" && $('#dniruc').val().length != 11)
             {
             	
				toastr["error"]('El nro RUC debe tener 11 Digitos');
               	iniciar_tipodocumento();
               	
             }else{

            $("#icon_search_document").hide();
		    $("#icon_searching_document").show();
		    $(".search_document").prop('disabled', true);

		    var tipodoc = $("#tipodocumento").val().toString();
		    var numdoc = $("#dniruc").val();
		    if(tipodoc == '6') { //RUC
			   
				//consulta_sunat_ruc();
				consulta_sunat_ruc_api_siqay();
				
		    } else if (tipodoc == '1') { //DNI
				
				consulta_reniec_dni();

		    } else {

		    }

             }
// consulta_reniec_dni();
	//consulta_sunat_ruc();
             

              

        }

        function  val_tipo_documento()
        {

        	var tipo_doc = $('#tipodocumento').val();
        	if(tipo_doc== "6" || tipo_doc=="1" )
             {
             	
             
		       	$("#buscar_cli").prop('disabled', false);
		       	$("#buscar_cli").show();
            
               	
             }
             else
             {

             	
             		$("#buscar_cli").prop('disabled', true);
             		$("#buscar_cli").hide();
            

             }

        }

        function search_document() {

        	
    validar_dni_ruc();		  
		

		}
		





/* CONSULTA RUC API SIQAY 2021 */

	function consulta_sunat_ruc_api_siqay()
	{ 
		var dniruc = $('#dniruc').val();
		$.ajax({
		url: "https://siqay.com/consulta_dni/consulta_datos_ruc.php",
		type: "POST",
		data: {dniruc:dniruc},
		//contentType: false,
	//	processData: false,

	success: function(datos)
	{

			var datos = JSON.parse(datos);

			var datos = (datos[0]);

			console.log(datos);
			

		if(Object.keys(datos).length === 0 )
		{
			
			bootbox.alert("No se encontro datos para mostrar RUC: "+dniruc);
			
			iniciar_tipodocumento();
			
			

		}else
		{
			$('#nombre').val(datos.nombre_razon_social);  
			$('#numero_ruc').val(datos.id);
			$('#condicion').val(datos.estado_contribuyente);
			$("#ubigeo").val(datos.id_ubigeo_inei);
			$('#ubigeo').select2();

			$("#icon_search_document").show();
			
			$("#icon_searching_document").hide();
			
			$(".search_document").prop('disabled', false);
			
			if(datos.ubigeo==='-')
			{
				$("#direccion").val("");
				$("#departamento").val("")
				$("#provincia").val("");
				$("#distrito").val("");
				$("#referencia").val("");
			}else
			{
				/* validar direccion  */
					
					if(datos.tipo_via.substr(0,1)=='-' && datos.tipo_via.length >=1)
					{
						var tipo_via ="";
					}else{
						var tipo_via=datos.tipo_via;
					}

					if(datos.nombre_via.substr(0,1)=='-' && datos.nombre_via.length >=1 )
					{
						var nombre_via = "";
					}else{
						var nombre_via =' '+datos.nombre_via;
					}

					if(datos.codigo_zona.substr(0,1)=='-' && datos.codigo_zona.length >=1 )
					{
						var codigo_zona = "";
					}else{
						var codigo_zona =' '+datos.codigo_zona;

						
					}

					if(datos.tipo_zona.substr(0,1)=='-' && datos.tipo_zona.length >=1 )
					{
						var tipo_zona = "";
					}else{
						var tipo_zona =' '+datos.tipo_zona;
					}

					if(datos.numero.substr(0,1)=='-' && datos.numero.length >=1 )
					{
						var numero = "";
						//console.log(numero.substr(0,1));
					}else{
						var numero =' '+datos.numero;
					}

					if(datos.interior.substr(0,1)=='-' && datos.interior.length >=1)
					{
						var interior = "";
					}else{
						var interior =' '+datos.interior;
					}

					if(datos.lote.substr(0,1)=='-' && datos.lote.length >=1 )
					{
						var lote = "";
					}else{
						var lote =' '+datos.lote;
					}

					if(datos.departamento.substr(0,1)=='-' && datos.departamento.length >=1 )
					{
						var departamento = "";
					}else{
						var departamento =' '+datos.departamento;
					}

					if(datos.manzana.substr(0,1)=='-' && datos.manzana.length >=1 )
					{
						var manzana = "";
					}else{
						var manzana =' '+datos.manzana;
					}

					if(datos.kilometro.substr(0,1)=='-' && datos.kilometro.length >=1 )
					{
						var kilometro = "";
					}else{
						var kilometro =' KM. '+datos.kilometro;
					}

					//console.log("hola"+kilometro);

					/*"tipo_via": "CAR.",
					"nombre_via": "FERNANDO BELAUNDE TERRY",
					"codigo_zona": "----",
					"tipo_zona": "BARRIO CALVARIO",
					"numero": "-",
					"interior": "-",
					"lote": "-",
					"departamento": "-",
					"manzana": "-",
					"kilometro": "504"
					*/


				/* fin validad direccion */

					$("#direccion").val(tipo_via+nombre_via+codigo_zona+tipo_zona+numero+interior+lote+departamento+manzana+kilometro+' '+datos.departamentos+'-'+datos.provincia+'-'+datos.distrito);

					$("#departamento").val(datos.departamentos)
					$("#provincia").val(datos.provincia);
					$("#distrito").val(datos.distrito);
					$("#referencia").val(datos.distrito);
			}
			
			
			$("#icon_search_document").show();
			
			$("#icon_searching_document").hide();
			
			$(".search_document").prop('disabled', false);
		}
		
		
		
	},

	error: function (error)
			{
				bootbox.alert("No se encontro datos para mostrar RUC: "+dniruc);
				
				iniciar_tipodocumento();
				
				$("#icon_search_document").show();
			
			$("#icon_searching_document").hide();
			
			$(".search_document").prop('disabled', false);

			} 

		});	
		


	}
/* FIN CONSULTA RUC APY SIQAY 2021 */

	

		
/*  CONSUTA DATOS SUNAT Y RENIEC */
	// consulta_reniec_dni();
	//consulta_sunat_ruc();
	
				


function consulta_reniec_dni()
		{ 
			var tipo_doc = $('#tipodocumento').val();

			var dniruc = $('#dniruc').val();

			let pos_nombre ='jeam';
			
			$.ajax({

			url: "https://siqay.com/consulta_dni/consulta_datos.php",
			
			type: "POST",
			
			data: {tipo_doc:tipo_doc, dniruc:dniruc, pos_nombre:pos_nombre},
			
			//contentType: false,
			//	processData: false,

		success: function(datos)
		{

			  var datos = JSON.parse(datos);

			 // console.log(datos);
			  

			if(datos.nombre=== 'error' )
			{

					// alert("error");

				bootbox.alert("No se encontro datos para mostrar DNI: "+dniruc);
			   
				//iniciar_id_tipodocumento();
				
				 $("#icon_search_document").show();
				 
				 $("#icon_searching_document").hide();
				 
				 $(".search_document").prop('disabled', false);	


				
			  

			}else
			{
				

				 $('#nombre').val(datos.nombre);  

				
				$("#icon_search_document").show();
				
				$("#icon_searching_document").hide();
				
				$(".search_document").prop('disabled', false);
			
			}
						  
			
		},

		error: function (error)
			 {
				 bootbox.alert("No se encontro datos para mostrar DNI: "+dniruc);
				 
				 //iniciar_tipodocumento();


				 
				$("#icon_search_document").show();
				
				$("#icon_searching_document").hide();
				
				$(".search_document").prop('disabled', false);

				} 

			});	
			
}




init();

