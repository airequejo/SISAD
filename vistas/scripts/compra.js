var tabla1_det;

var tabla1;

var tabla_p;

//Función que se ejecuta al inicio
function init(){

$("#tipo_compra").hide();

listar();
mostrarform(false);



$("#lotevence").hide();
$("#preciototal").hide();

$("#moneda").hide();
$("#cambio").hide();

select_combo_actividades();


//listar_detalle_compra_temp($("#idindex").val());


  	//$("#serie").number(true);
// $("#idproducto").select2();
$("#idproveedor").select2();
$("#idlista_index").select2();
$("#idproducto").change(mostrar_detalle_producto);
$("#idlista_index").change(ver_detalle_compra_temp);

$("#montodscto").change(calcular_totales_compra);
$("#montodscto").keyup(calcular_totales_compra);
$("#igv").change(calcular_totales_compra);
$("#igv").keyup(calcular_totales_compra);
$("#precio").keyup(calcular_ganancia);

$("#precio").keyup(calcular_precio_por_uni);

//calcular_totales_compra();



$("#valor").keyup(calcular_precio_por_caja);



	listarProducto();


	

	//Cargamos los items al select proveedor

	$.post("../ajax/compra.php?op=select_combo_proveedor", function(r){
	            $("#idproveedor").html(r);
	            //$('#idproveedor').selectpicker('refresh');
	});

	$.post("../ajax/compra.php?op=select_combo_tipocomprobante", function(r){
	            $("#tipocomprobante").html(r);
	            //$('#idproveedor').selectpicker('refresh');
	});
	$.post("../ajax/formapago.php?op=select_combo_formapago_compra", function(r){
	            $("#idformapago").html(r);
	            //$('#idproveedor').selectpicker('refresh');
	});

	//    $.post("../ajax/producto.php?op=select_combo_producto", function(r){
	//              $("#idproducto").html(r);
	           // $('#idproducto').selectpicker('refresh');
	//  });

	$.post("../ajax/compra.php?op=listar_compra_proceso_temp", function(r){
	            $("#idlista_index").html(r);
	           // $('#idproducto').selectpicker('refresh');
	});

	$("#tipocompra").change(compra_credito);

	$("#idformapago").change(compra_tarjeta);

	$("#monto_a").hide();
	$("#vencecredito").hide();	

	compra_tarjeta();


	//ver_detalle_compra_temp();
}


//Función limpiar

function ver_detalle_compra_temp()
{
	var valor = $("#idlista_index").val();
	if (valor==='0')
	{

	}
	else
	{


	  $("#idindex").val($("#idlista_index").val());
	  $("#idindex_p").val($("#idlista_index").val());
	  $("#idindexx").text($("#idlista_index").val());
	 // $("#idcompra").val($("#idlista_index").val());
	}

	  listar_detalle_compra_temp();
	  calcular_totales_compra();
}



function cadenaAleatoria(longitud, caracteres) {

	var d = new Date();

	var anio=d.getFullYear();
	var mes=d.getMonth();
	var dia=d.getDay();
	var hora=d.getHours();
	var minutos=d.getMinutes();
	var segundos=d.getSeconds();
	var milisegundos=d.getTime();
// document.write('Fecha: '+d.getDate(),'<br>Dia de la semana: '+d.getDay(),'<br>Mes (0 al 11): '+d.getMonth(),'<br>Año: '+d.getFullYear(),'<br>Hora: '+d.getHours(),'<br>Hora UTC: '+d.getUTCHours(),'<br>Minutos: '+d.getMinutes(),'<br>Segundos: '+d.getSeconds());


    longitud = longitud || 16;
    caracteres = caracteres || "0123456789abcdefghijklmnopqrstuvwxyz";

    var cadena = "";
    var max = caracteres.length-1;
    for (var i = 0; i<longitud; i++) {
        cadena += caracteres[ Math.floor(Math.random() * (max+1)) ];
    }
   var idindex = cadena+anio+mes+dia+hora+minutos+segundos+milisegundos;

   $("#idindexx").text(idindex);
   $("#idindex").val(idindex);
   $("#idindex_p").val(idindex);
  // $("#idcompra").val(idindex);
}


function limpiar()
{

	$("#lote").val("");
	$("#registrosanitario").val();
	$("#vencimiento").val("");
	$("#cantidad").val("");
	$("#precio").val("");
	$("#valor").val("");
	$("#descuento").val(0.00);
	$("#precioventa").val("");

}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#tablabusqueda").show();
		//$("#btnGuardar").prop("disabled",false);
		//$("#btnagregar").hide();
		listarProducto();/*

$("#subtotal").text("S/ 0.00");

		$("#igvs").text("S/ 0.00");
		
		$("#descuentos").text("S/ 0.00");

		$("#totales").text("S/ 0.00"); */

		cadenaAleatoria();

		// listar_detalle_compra_temp();

		 $.post("../ajax/compra.php?op=listar_compra_proceso_temp", function(r){
	            $("#idlista_index").html(r);
	           // $('#idproducto').selectpicker('refresh');
	});

	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#tablabusqueda").hide();

		// $("#btnagregar").show();


	}

}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);

	
}


//Función Listar
function listar()
{

		tabla1=$('#tblistado_egresos').dataTable(
	{
		"responsive": true,
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,
		"autoWidth": false,//Paginación y filtrado realizados por el servidor
		
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5'
		        ],
		"ajax":
				{
					url: '../ajax/compra.php?op=listar',
					//data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}


//Función Listar
function listar_detalle_compra_temp()
{
	var idindex = $("#idindex").val();

	tabla1_det=$('#detalles').dataTable(
	{	

		"autoWidth": false,
		//"responsive": true,
		"aProcessing":false,
		"aServerSide":false,
		"paging":false,
		   "ordering":false,
		"info":false,
		"searching": false,
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		          
		        ],
		"ajax":
				{
					url: '../ajax/compra.php?op=listar_detalle_compra_temp',
					data:{"idindex" : idindex},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 15,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();

	//calcular_totales_compra();
}


//Función ListarArticulos
function listarProducto()
{
	tabla_p=$('#tblarticulos_compra').dataTable(
	{
	
		"autoWidth": false,
		//"responsive": true,
		"aProcessing":false,
		"aServerSide":false,
	
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		        ],
		"ajax":
				{
					url: '../ajax/productos.php?op=listar_productos_compra',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 7,//Paginación
	    "order": [[ 1, "asc" ]]//Ordenar (columna,orden)
	}).DataTable();
}


function agregar_compra_temp(idproducto)

	{
		$("#idproducto").val(idproducto);

		$('#productos_compra_lita').modal('hide');

		$("#productos_compra_insertar").modal('show');

		mostrar_detalle_producto();

		tabla_p.ajax.reload();

	    // $("#productos_lista").ajax.reload();

		
		// mostrar_stock_lotes();f

		//insert_ventas_temp();

	}


function refrescar_proveedores()
{
    
    	$.post("../ajax/compra.php?op=select_combo_proveedor", function(r){
	            $("#idproveedor").html(r);
	            //$('#idproveedor').selectpicker('refresh');
	})
}

function select_combo_actividades()
{
    
    	$.post("../ajax/actividad.php?op=select_combo_actividad", function(r){
	            $("#idactividad").html(r);
	            //$('#idproveedor').selectpicker('refresh');
	})
}

function refrescar_productos()
{
    
    listarProducto();
}

//Función para guardar o editar

function guardaryeditar()
{

	var nFilas = $("#detalles tr").length;
	var provedor = $("#idproveedor").val();
	var fecha = $("#fecha").val();
	var tipocomprobante = $("#tipocomprobante").val();
	var serie = $("#serie").val();
	var numero = $("#numero").val();
	var fechacp = $("#fechacp").val();
	var numerocp = $("#numerocp").val();
	var numerocheque = $("#numerocheque").val();
	var documentoautoriza = $("#documentoautoriza").val();

	let result = moment(fecha, 'YYYY-MM-DD',true).isValid();
	let result2 = moment(fechacp, 'YYYY-MM-DD',true).isValid();



	//alert(result+fecha);

	if (nFilas > 0 && provedor > 0 && result && tipocomprobante > 0 && serie !== "" && numero !== "" && numerocp !=="" && result2 && numerocheque !=="" && documentoautoriza!=="") 
	{

		
		// alert(nFilas);

	//$("#mensajeproceso").css("display", "block");
	//e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#procesar_compra_modal")[0]);

	$.ajax({
		url: "../ajax/compra.php?op=insertar_compra",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
			var info = JSON.parse(datos);

			if (info.state == '1')            
				{
					
			mensaje="Se registro con éxito";
        
				Swal.fire({
					title: 'Registro',
					text: mensaje,
					icon: 'success',
					//showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Aceptar'
				}).then((result) => {
					if (result.isConfirmed) {

						location.reload();
				
					}
				})	
			}
				
				else
				{
					toastr["error"]("No se pudo completar ");
				}
				

	    },
		error:function(datos){

			toastr["error"]("No se registro");
		}

	});

}
else

{
	toastr["error"]("Verifique los datos ingresados");
}

		//$("#subtotal").text("S/ 0.00");

	

}


function guardar_detalle_temp()
{

	//  $("#mensajeproceso").css("display", "block");
	// e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/compra.php?op=guardaryeditar_detalle_temp",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {      
 	 		
	 		listar_detalle_compra_temp();
	 		calcular_totales_compra();
			 toas();
	          
	    }



	});

 limpiar();

	lista_compras_sin_procesar();

	// calcular_totales_compra();

}


function lista_compras_sin_procesar()
{
	 $.post("../ajax/compra.php?op=listar_compra_proceso_temp", function(r){
	            $("#idlista_index").html(r);
	           // $('#idproducto').selectpicker('refresh');
	});
}


function calcular_totales_compra()
{
	var idindex = $("#idindex").val();

	var descuento_general = $("#montodscto").val();

	var i = $("#igv").val();

	$.post("../ajax/compra.php?op=calcular_totales_compra",{idindex : idindex}, function(data, status)
	{
		data = JSON.parse(data);	
		
		if (i == 0) {
		
			$("#total_factura").text(data.total_con_descuento - descuento_general);
			$("#total_operacion").text(data.total_con_descuento - descuento_general);
			// alert("0");
	
			} else{	
	
				var igvt =  (parseFloat(data.total_con_descuento) * parseFloat(i) / 100);
	
				var  tot = parseFloat(data.total_con_descuento) ;

				var tt_all = (tot + igvt) - descuento_general;
	
				$("#total_factura").text(tt_all);
				$("#total_operacion").text(tt_all);
	
				// console.log(tt_all);
	
			}
 	});


	 

 	
}

function mostrar(idcompra)
{
	$.post("../ajax/compra.php?op=mostrar",{idcompra : idcompra}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#idproveedor").val(data.idproveedor);
		$("#idproveedor").selectpicker('refresh');
		$("#tipocomprobante").val(data.tipocomprobante);
		$("#tipocomprobante").selectpicker('refresh');
		$("#serie").val(data.serie);
		$("#numero").val(data.numero);
		$("#fecha").val(data.fecha);
		$("#igv").val(data.igv);
		$("#idcompra").val(data.idcompra);

		//Ocultar y mostrar los botones
		//$("#btnGuardar").hide();
		//$("#btnCancelar").show();
		//$("#btnAgregarArt").hide();
 	});

 	/*$.post("../ajax/compra.php?op=listarDetalle&id="+idcompra,function(r){
	        $("#detalles").html(r);
	});*/
}

/* MOSTRAR SI EL PRODUCTO APLICA FECHA DE VENCIMIENTO */
function mostrar_detalle_producto()
{
	
	var idproducto = $("#idproducto").val();
	$("#cantidad").val("");
	$("#precio").val("");
	$("#valor").val("");

	$.post("../ajax/productos.php?op=mostrar_detalle_producto",{idproducto : idproducto}, function(data, status)
	{
		data = JSON.parse(data);

		$("#protipo").val(data.tipopro);
		$("#proexpira").val(data.fechavencimiento);
		$("#promovi").val(data.aplicamovimiento);
		
		// bien aplica vencimiento

		if(data.tipopro == 1)
		{
			$("#idescuento").hide();
			$("#precioventa").prop("readonly", true);
		}else if(data.aplicamovimiento==0)
		{
			$("#idescuento").hide();
			$("#precioventa").prop("readonly", true);
		}
		else
		{
			$("#idescuento").show();
			$("#precioventa").prop("readonly", false);
		}

		if(data.fechavencimiento=='0' && data.tipopro =='0') 
		{
			$("#iganancia").hide();
			$("#ilote").show();
			$("#iregistro").show();
			$("#ivencimiento").show();
			$("#ivalor").show();
			// $("#idescuento").hide();

			$("#valor").prop("readonly",false);
			$("#lote").prop("readonly",true);
			$("#registrosanitario").prop("readonly",true);
			$("#vencimiento").prop("readonly",true);
			$("#cantidad").prop("readonly",false);			

			$("#lote").val(data.lote);
			$("#desproducto").text(data.producto);
			$("#vencimiento").val(data.fecha);
			$("#registrosanitario").val('0');
			

			$("#lote").focus();
			

		} // bien no aplica vencimiento
		else if(data.fechavencimiento=='1' && data.tipopro =='0')
		{
			$("#iganancia").hide();
			$("#ilote").show();
			$("#iregistro").show();
			$("#ivencimiento").show();
			$("#ivalor").show();
			// $("#idescuento").show();

			$("#valor").prop("readonly",false);
			$("#lote").prop("readonly",false);			
			$("#registrosanitario").prop("readonly",false);
			$("#vencimiento").prop("readonly",false);
			$("#cantidad").prop("readonly",false);

			$("#desproducto").text(data.producto);
			$("#lote").val("");
			$("#vencimiento").val("");
			$("#lote").focus();
			$("#registrosanitario").val("0");

			$("#cantidad").focus();

		}
		else
		{
			// servicio

			$("#iganancia").hide();
			$("#ilote").hide();
			$("#iregistro").hide();
			$("#ivencimiento").hide();
			$("#ivalor").show();
			// $("#idescuento").hide();

			$("#valor").prop("readonly",true);
			$("#lote").prop("readonly",true);
			$("#registrosanitario").prop("readonly",true);
			$("#vencimiento").prop("readonly",true);
			$("#cantidad").prop("readonly",true);

			$("#lote").val(0);
			$("#desproducto").text(data.producto);
			$("#registrosanitario").val('0');		
			
			$("#cantidad").val(1);
			$("#vencimiento").val(null);
			$("#precioventa").val(0);

			


		}
	
	
		//alert(data.fechavencimiento);
 	});

}




//Función para anular registros
function anular(idcompra)
{

	mensaje="¿Está seguro de anular la compra, este proceso no se puede deshacer?";
        Swal.fire({
            title: 'Anular compra?',
            text: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {

                $.post("../ajax/compra.php?op=anular", {idcompra : idcompra}, function(e){
					tabla1.ajax.reload();
				});

              Swal.fire(
                'Anular!',
                'La compra se anulo',
                'success'
              )
            }
          })




}



//Función para anular registros
function eliminar_detalle_temp(iddetallecompra)
{
	
	$.post("../ajax/compra.php?op=eliminar_detalle_temp", {iddetallecompra : iddetallecompra}, function(e){
		toastr["success"]("Item eliminado")	;

		tabla1.ajax.reload();

		listar_detalle_compra_temp();
        calcular_totales_compra();
	

	});	


	
}


function yala()
{
	//var hoy = new Date();

	var cantidad = $("#cantidad").val();
	var producto = $("#idproducto").val();
	var precio = $("#precio").val();
	var descuento = $("#descuento").val();
	var date = moment($("#vencimiento").val());
	var lote = $("#lote").val();
	var precioventa = $("#precioventa").val();

	var val_desc = cantidad * precio;

	var now = moment();

	var protipo = $("#protipo").val();
	var proexpira = $("#proexpira").val();
	var idactividad = $("#idactividad").val();

	if (idactividad ==="")
	{

		toastr["error"]("Seleccione una actividad");
		$("#idactividad").focus();

	}else{

	if ( (proexpira == 0 || proexpira == 1) && protipo == 0 )

		if (date<=now )
			{
				toastr["error"]("Fecha de vencimiento no puede ser menor a fecha actual!!");
			}

			else if(!moment(date).isValid())
			{
				toastr["error"]("Fecha de vencimiento no es valida!!");
			}
			else if (descuento>val_desc)
			{
				toastr["error"]("El descuento no puede ser mayor al subtotal!!");
				$("#descuento").val(0.00);
			}
		else
		{
			
		}
	
		if (cantidad>0 && producto>0 && precio>=0.00 && descuento>=0.00 && descuento>=0.00 && lote!="" && parseFloat(precioventa) >= 0) {

			guardar_detalle_temp();

			calcular_totales_compra();

			$("#productos_compra_insertar").modal('hide');

			$('#productos_compra_lita').modal('show');

			}
		else
		{
			toastr["error"]("Verifique que los datos sean correctos!!");
		}

	}
	
	
			
}


function calcular_ganancia()
{
	var tipopro = $("#protipo").val();
	var promovin = $("#promovi").val();
	
	if (tipopro==1)
	{
		
		$("#precioventa").val(0);
			
		
	}
	else if(promovin==0)
	{
		
		$("#precioventa").val(0);
		
		
	}else
	{
		var precio = $("#precio").val();
		var ganancia = $("#ganancia").val();
		var pv = (((parseFloat(precio)  *  parseFloat(ganancia)) / 100)+parseFloat(precio)).toFixed(2);
		$("#precioventa").val(pv);
	
	}


}

function salir_modal()
{

	$("#lote").val("");
	$("#registrosanitario").val();
	$("#vencimiento").val("");
	$("#cantidad").val("");
	$("#precio").val("");
	$("#valor").val("");
	$("#descuento").val(0.00);
	$("#precioventa").val("");

	$("#productos_compra_insertar").modal('hide');

	$('#productos_compra_lita').modal('show');



}

function calcular_precio_por_caja()
{
	var cantidad = $("#cantidad").val();
	var valor = $("#valor").val();
	var subt = $("#precio").val();
	var calculo = (parseFloat(valor) / parseFloat(cantidad)).toFixed(6);
	$("#precio").val(calculo);

	calcular_ganancia();
	
}

function calcular_precio_por_uni()
{
	var cantidad = $("#cantidad").val();
	var valor = $("#valor").val();
	var subt = $("#precio").val();
	var calculo2 = (parseFloat(cantidad) * parseFloat(subt)).toFixed(2);
	
	$("#valor").val(calculo2);

	calcular_ganancia();
	
}

function calcular_total_valor()
{
	var subt = $("#precio").val();
	var cantidad = $("#cantidad").val();

	var tota_precio = parseFloat(cantidad) * parseFloat(subt);

	$("#valor").val(tota_precio.toFixed(4));

}

function compra_credito()
	{
		
		var tipoventa = $("#tipocompra").val();
		if (tipoventa == 2)
		 {
		 	$("#monto_a").show();
		 	$("#forma_p").hide();
		 	$("#vencecredito").show();		 	
		 //	$("#idformapago").val(5);
		 	$("#montoabonado").val("0.00");

		 	$("#monto_ef").hide();
		 	$("#monto_op").hide();

		 }
		 else if (tipoventa == 1) 
		 {

		 	$("#monto_a").hide();
		 	$("#forma_p").show();
		 	$("#vencecredito").hide();	
		 	$("#idformapago").val(1);
		 	$("#montoabonado").val("0.00");

		 	
		 }

		 else{

		 }
	}

	function compra_tarjeta()
	{
		var formapago = $("#idformapago").val();

		if (formapago == 2 )
		 {
		 	
		 	$("#monto_a").hide();
		 	$("#monto_op").show();
		 	$("#montoabonado").val("0.00");
		 	$("#operacion").val("");

		 }
		 else if (formapago == 6) 
		 {

		 	$("#monto_a").show();
		 	$("#monto_op").show();
		 	$("#operacion").val("");
		 }

		 else
		 {
		 	$("#monto_a").hide();
		 	$("#monto_op").hide();

		 	$("#montoabonado").val("0.00");
		 	$("#operacion").val("");
		 }
	}


	function toas()
	{
		var prod_new = $("#desproducto").text();

		 toastr["warning"]("Producto agregado: " + prod_new);

		 toastr.options = {
			"closeButton": false,
			"debug": false,
			"newestOnTop": false,
			"progressBar": false,
			"positionClass": "toast-bottom-center",
			"preventDuplicates": false,
			"onclick": null,
			"showDuration": "500",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		  }
	}


init();