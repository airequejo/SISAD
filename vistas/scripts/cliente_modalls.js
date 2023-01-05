
function init()
{
	

	$("#buscar_cli").click(search_document);
	$("#tipodocumento").change(val_tipo_documento);
	$("#tipodocumento").change(iniciar_tipodocumento);
	//$("#dniruc").change(search_document);
	

llenar_ubigeo();
$('#ubigeo').select2();

}


function limpiar()
{
	$("#idclientex").val("");
	$("#nombre").val("");
	//$("#tipodocumento").val("");
	$("#ubigeo").val("");
	$("#dniruc").val("");
	$("#direccion").val("");
	$("#referencia").val("");
	$("#celular").val("");
	$("#email").val("");
}

function llenar_ubigeo()
{
	//Cargamos los items al select proveedor
	$.post("../ajax/direcciones.php?op=select_combo_ubigeo", function(r){
	            $("#ubigeo").html(r);
	           // $('#ubigeo').selectpicker('refresh');
	});
}




	

	
	var icono="";
  	var msj="";
  	var mensaje="";

	function guardaryeditar_cliente()
	{
		//e.preventDefault();
		$("#btnGuardar").prop("enabled", true);
		var formData = new FormData($("#formulario_modal")[0]);

		$.ajax({
			url: "../ajax/cliente.php?op=guardar_cliente",
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

				toastr["success"]('Cliente se Registro con Exito'+info.id_cliente);

				$.post("../ajax/cliente.php?op=select_combo_cliente", function (r) {
					$("#idcliente").html(r);
					$("#idcliente").val(info.id_cliente);
					select_combo_direccion_cliente(info.id_cliente);

				  });

				  limpiar();

				 

				 // select_combo_direccion_cliente(info.id_cliente);
				  
				 //  llenar_cliente(11);

				//$("#idcliente").val(info.id_cliente);

				$('#myModal').modal('hide');

			   iniciar_tipodocumento();

			   //toastr["success"]("My name is Inigo Montoya. You killed my father. Prepare to die!")

				
				//
			   
				
	
			}
			else if(info.state == "existe")
			{
				toastr["error"]("Cliente ya Existe");
				$("#idcliente").val(info.tem_idcli);
				$("#idcliente").select2()
				select_combo_direccion_cliente(info.tem_idcli);

				limpiar();

				$('#myModal').modal('hide');
			}
				else
			{
	
					toastr["error"]("Verifique datos");
					
			}

				
			}
		});
		
	}




	function ValidarRUC(rucVal) {
            var regEx = /\d{11}/;
            //var ruc = new String(document.getElementById(rucVal).value);

            var ruc = new String(rucVal);

            if (ruc.length != 11) {
                toastr["error"]("¡ALERTA: El RUC " + ruc + " NO es valido!. SI NO TIENE UNO SELECCIONE DNI");
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
                toastr["error"]("ALERTA : El RUC no es valido, debe constar de 11 caracteres numericos. SI NO TIENE UNO SELECCIONE BOLETA");
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
			$('#ubigeo').selectpicker('refresh');
        	// $("#departamento").val("");
        	// $("#provincia").val("");
        	// $("#distrito").val("");
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
		
		
    function buscar_dni()
    {
    	var dni = $('#dniruc').val();
    	var url = 'https://siqay.com/consulta_dni/consulta_reniec.php';
    	$.ajax({
    	type:'POST',
    	url:url,
    	data:'dni='+dni,
    	success: function(datos_dni){
    		var datos = eval(datos_dni);
    			/*$('#mostrar_dni').text(datos[0]);
    			$('#paterno').text(datos[1]);
    			$('#materno').text(datos[2]);
    			$('#nombres').text(datos[3]);*/
    
            	$('#nombre').val(datos[2]+" "+datos[3]+" "+datos[1]);    
            	
    			$("#icon_search_document").show();
        		$("#icon_searching_document").hide();
       			$(".search_document").prop('disabled', false);
    }
    	});
    	return false;
    }

        function consultar_dni(dni) {
		    $.ajax({
		        url : '../sis_facturacion/api_facturacion/consulta_sunat.php',

		        data: {num_documento: dni, tipo: 'dni'},
		        method :  'POST',
		        dataType : "json"
		    }).then(function(data){
		        if(data.respuesta == 'ok') {
		            $("#nombre").val(data.nombre);
		        } else {
		            $("#nombre").val(data.mensaje);
		        }
		        $("#icon_search_document").show();
		        $("#icon_searching_document").hide();
		       $(".search_document").prop('disabled', false);

		        console.log(data);

		    }, function(reason){
		        swal({
		            title: 'ERROR',
		            text: 'Error al conectarse a la SUNAT, recarga la página e inténtalo nuevamente!',
		            html: true,
		            type: "error",
		            confirmButtonText: "Ok",
		            confirmButtonColor: "#2196F3"
		        }, function(){
		            $("#icon_search_document").show();
		            $("#icon_searching_document").hide();
		           $(".search_document").prop('disabled', false);
		        });
		    });
		}

		function consultar_ruc(ruc) {
		    $.ajax({
		        url : '../sis_facturacion/api_facturacion/consulta_sunat.php',
		        data: {num_documento: ruc, tipo: 'ruc'},
		        method :  'POST',
		        dataType : "json"
		    }).then(function(data){
		        $("#icon_search_document").show();
		        $("#icon_searching_document").hide();
		       $(".search_document").prop('disabled', false);

		        $("#nombre").val(data.razon_social);
		        $("#direccion").val(data.direccion);
		        var dire = data.direccion;
				var ubicacion = dire.split('-');
		        $("#provincia").val(ubicacion[1]);
		        $("#distrito").val(ubicacion[2]);
		        $("#referencia").val(ubicacion[2]);
		        console.log(data);
		    }, function(reason){
		        swal({
		            title: 'ERROR',
		            text: 'Error al conectarse a la SUNAT, recarga la página e inténtalo nuevamente!',
		            html: true,
		            type: "error",
		            confirmButtonText: "Ok",
		            confirmButtonColor: "#2196F3"
		        }, function(){
		            $("#icon_search_document").show();
		            $("#icon_searching_document").hide();
		           $(".search_document").prop('disabled', false);
		        });
		    });
		}
		
		function consulta_ruc_pelon()
		{ 
		/*
		 $.getJSON("https://api.sunat.cloud/ruc/" + $("#dniruc").val(), {
			            format: "json"
			        })
			        .done(function(data) {
			            //$("#dni").val(data.numero_documento);
			            $("#numero_ruc").val(data.ruc);
			            $("#nombre").val(data.nombre);
			            $("#direccion").val(data.domicilio_fiscal);
			            ///$("#distrito").val(data.distrito);
			           /// $("#provincia").val(data.provincia);
			           /// $("#departamento").val(data.departamento);
			            ///$("#referencia").val(data.distrito);
			            //$("#ubigeo").val(data.ubigeo);
			           // $('#frm-cliente').formValidation('revalidateField', 'razon_social');
			          //  $('#frm-cliente').formValidation('revalidateField', 'direccion');
			          //  
			          //  
			           $("#icon_search_document").show();
		        		$("#icon_searching_document").hide();
		       		$(".search_document").prop('disabled', false);
			        });
*/


		
			var ruc = $('#dniruc').val();
				var url = 'https://siqay.com/consulta_dni/consultar_ruc.php';
			//	$('.ajaxgif').removeClass('hide');
				$.ajax({
				type:'POST',
				url:url,
				data:'ruc='+ruc,
				success: function(datos_dni){
					//$('.ajaxgif').addClass('hide');
					var datos = eval(datos_dni);
						var nada ='nada';
						if(datos[0]==nada){
							alert('DNI o RUC no válido o no registrado');
						    $("#icon_search_document").show();
				            $("#icon_searching_document").hide();
				            $(".search_document").prop('disabled', false);
						}else{
							$('#numero_ruc').val(datos[0]);
							$('#nombre').val(datos[1]);
							$('#fecha_actividad').val(datos[2]);
							$('#condicion').val(datos[3]);
							$('#tipo').val(datos[4]);
							$('#estado').val(datos[5]);
							$('#fecha_inscripcion').val(datos[6]);
		         			 $('#direccion').val(datos[7]);
		          			var dire = datos[7];
						  var ubicacion = dire.split('-');
				        $("#provincia").val(ubicacion[1]);
				        $("#distrito").val(ubicacion[2]);
				        $("#referencia").val(ubicacion[2]);
						$('#emision').val(datos[8]);
						 $("#icon_search_document").show();
		        		$("#icon_searching_document").hide();
		       		$(".search_document").prop('disabled', false);
						}		
				}
			});
			return false;
			
		

		}
		


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
			
			toastr["error"]("No se encontro datos para mostrar RUC: "+dniruc);
			
			iniciar_tipodocumento();
			
				$("#icon_search_document").show();
			
			$("#icon_searching_document").hide();
			
			$(".search_document").prop('disabled', false);
		}else
		{
			$('#nombre').val(datos.nombre_razon_social);  
			$('#numero_ruc').val(datos.id);
			$('#condicion').val(datos.estado_contribuyente);
			$("#ubigeo").val(datos.id_ubigeo_inei);
			$('#ubigeo').selectpicker('refresh');
			
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
				toastr["error"]("No se encontro datos para mostrar RUC: "+dniruc);
				
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
	
		
	function consulta_sunat_ruc()
			{ 
    			var dniruc = $('#dniruc').val();
    			$.ajax({
    			url: "https://siqay.com/consulta_dni/consultar_ruc.php",
    			type: "POST",
    			data: {dniruc:dniruc},
    			//contentType: false,
    		//	processData: false,

			success: function(datos)
			{

		      	var datos = JSON.parse(datos);
		      	

                if(Object.keys(datos).length === 0 )
                {
                    
                   toastr["error"]("No se encontro datos para mostrar RUC: "+dniruc);
                   
                   iniciar_tipodocumento();
                   
                   	$("#icon_search_document").show();
					
					$("#icon_searching_document").hide();
					
					$(".search_document").prop('disabled', false);
                }else
                {
                     $('#nombre').val(datos.razon_social);  
                    $('#numero_ruc').val(datos.ruc);
					$('#fecha_actividad').val(datos.fecha_actividad);
					$('#condicion').val(datos.contribuyente_estado);
    		        $("#direccion").val(datos.domicilio_fiscal);
    		        var dire = datos.domicilio_fiscal;
    				var ubicacion = dire.split('-');
    		        $("#provincia").val(ubicacion[1]);
    		        $("#distrito").val(ubicacion[2]);
    		        $("#referencia").val(ubicacion[2]);
                    
                    $("#icon_search_document").show();
                    
                    $("#icon_searching_document").hide();
                    
                    $(".search_document").prop('disabled', false);
                }
		  	
				
				
			},

			error: function (error)
			     {
			     	toastr["error"]("No se encontro datos para mostrar RUC: "+dniruc);
			     	
			     	iniciar_tipodocumento();
			     	
			     	 $("#icon_search_document").show();
                    
                    $("#icon_searching_document").hide();
                    
                    $(".search_document").prop('disabled', false);

			        } 

	        	});	
				
			
	
		}
		
		
	
	function consulta_reniec_dni_error()
			{ 
    			var dniruc = $('#dniruc').val();
    			$.ajax({
    			url: "https://siqay.com/consulta_dni/consulta_reniec.php",
    			type: "POST",
    			data: {dniruc:dniruc},
    			//contentType: false,
    		//	processData: false,

			success: function(datos)
			{

		      	var datos = JSON.parse(datos);
		      	

                if(datos.name==="00" )
                {
                    
                   toastr["error"]("No se encontro datos para mostrar DNI: "+dniruc);
                   
                   iniciar_tipodocumento();
                   
                   	$("#icon_search_document").show();
					
					$("#icon_searching_document").hide();
					
					$(".search_document").prop('disabled', false);
                }else
                {
                    $('#nombre').val(datos.name+" "+datos.first_name+" "+datos.last_name);  
                    
                    $("#icon_search_document").show();
                    
                    $("#icon_searching_document").hide();
                    
                    $(".search_document").prop('disabled', false);
                }
		  	
				
				
			},

			error: function (error)
			     {
			     	toastr["error"]("No se encontro datos para mostrar DNI: "+dniruc);
			     	
			     	iniciar_tipodocumento();
			     	
			     	 $("#icon_search_document").show();
                    
                    $("#icon_searching_document").hide();
                    
                    $(".search_document").prop('disabled', false);

			        } 

	        	});	
				
	
			}


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

				toastr["error"]("No se encontro datos para mostrar DNI: "+dniruc);
			   
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
				 toastr["error"]("No se encontro datos para mostrar DNI: "+dniruc);
				 
				 //iniciar_tipodocumento();


				 
				$("#icon_search_document").show();
				
				$("#icon_searching_document").hide();
				
				$(".search_document").prop('disabled', false);

				} 

			});	
			
}

init();
