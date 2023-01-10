/// oka
var tabla;
var tabla33;
//Función que se ejecuta al inicio
function init() {
  $("#vuelt").hide();

  /*	$('body').on("click", _.debounce(function(){
		inactivityTime();
	}, 10000)); */

  //cerrar();
  //
  $("#precio").val("0");
  combo_productos();
  combo_especialidad();
  combo_ciclos();

  $("#codigobarra").select2();

  $("#igvdesc").hide();

  mostrarform(true);

  listar();

  listar_ticket();

  listar_otrasalidas();

  listarProducto();

  cadenaAleatoria();

  $("#codigobarra").change(mostrar_stock_lotes);

  $("#idlista_index").select2();
  //$("#idcliente").select2();
  //$("#idstocklote").select2();

  $("#idlista_index").change(ver_detalle_venta_temp);

  $("#fecha_inicio").change(listar);
  $("#fecha_inicio_t").change(listar_ticket);

  $("#fecha_fin").change(listar);
  $("#fecha_fin_t").change(listar_ticket);

  $("#efectivo").keyup(calcular_vuelto);

  $("#tipoventa").change(ventas_credito);

  $("#idformapago").change(ventas_tarjeta);

  $("#monto_a").hide();
  $("#vencecredito").hide();

  //document.getElementById("idstocklote").focus();

  llenar_cliente();

  $("#idcliente").select2();

  llenar_tipocomprobante();

  

  $("#monto_op").show();
  $("#fecha_op").show();
  $("#operacion").val("");

  ventas_tarjeta();

  $("#idcliente").change(select_combo_direccion_cliente);



  $("#idserienumero").change(serie_mostrar);

  //$("#idstocklote").change(mostrar_preventa);

  cargar_lista_ventas_sin_procesar();

  $("#codigobarra").focus();

  $("#idperiodo").change(mostrar_precio_periodo);
}

function forma_pago_efectivo()
{
  $.post("../ajax/formapago.php?op=select_combo_formapago", function (r) {
    $("#idformapago").html(r);
    //$('#idproveedor').selectpicker('refresh');
  });

}

function forma_pago_credito()
{
  $.post("../ajax/formapago.php?op=select_combo_formapago_credito", function (r) {
    $("#idformapago").html(r);
    //$('#idproveedor').selectpicker('refresh');
  });

}

// combo prductos para agregar a detalle ventas

function combo_productos() {
  $.post("../ajax/productos.php?op=select_combo_productos", function (r) {
    $("#codigobarra").html(r);
  });
}

function combo_especialidad() {
  $.post("../ajax/especialidad.php?op=select_combo_especialidad", function (r) {
    $("#idespecialidad").html(r);
  });
}

function combo_ciclos() {
  $.post("../ajax/ciclos.php?op=select_combo_ciclos", function (r) {
    $("#idciclo").html(r);
  });
}

function select_combo_direccion_cliente(idcliente) {
  var idcliente = $("#idcliente").val();

  $.post(
    "../ajax/direcciones.php?op=select_combo_direccion_cliente",
    { idcliente: idcliente },
    function (r) {
      $("#iddireccion").html(r);
    }
  );
}

// datatable lista de productos para ventas  agregar a venta a detalle

function listarProducto() {
  tabla2 = $("#tblarticulos")
    .dataTable({
      autoWidth: false,
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor
      dom: "Bfrtip", //Definimos los elementos del control de tabla
      buttons: [],
      ajax: {
        url: "../ajax/productos.php?op=listarProducto",
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 10, //Paginación
      order: [[1, "asc"]], //Ordenar (columna,orden)
    })
    .DataTable();
}

// mostrar datos de producto para agregar a detalle ventas

function mostrar_codigobarra(codigobarra) {
  $("#codigobarra").val(codigobarra);
  mostrar_stock_lotes();
}

// codigo de barras equivale a iddetalleproductodivisionaria

function mostrar_stock_lotes(codigobarra) {
  var codigobarra = $("#codigobarra").val();
  
    $.post(
      "../ajax/productos.php?op=mostrar_stock_lotes",
      { codigobarra: codigobarra },
      function (data, status) {
        data = JSON.parse(data);

        $("#cantidad").val(1);
        $("#precio").val("0");
        periodo_venta(codigobarra);

        if (data.cantidad > 0) {
          $("#lote").val(data.lote);
          $("#stock").val(data.cantidad);
          $("#stock_ven").text(parseInt(data.cantidad));
          $("#des_producto").text(data.descripcion);
          $("#vencimiento").val(data.fechavencimiento);
          $("#idproducto").val(data.iddetalleproductodivisionaria);
          $("#precio_compra_promedio").val(data.precio_compra_promedio);

          // mostrar_precio_periodo(codigobarra,idperiodo);

          if (data.tipo == 1) {
            // insert_ventas_temp();
            // mostrar_precio_periodo(codigobarra,idperiodo);
            $("#cantidad").prop("readonly", true);
            $("idperiodo").focus();
          } else {
            $("#cantidad").prop("readonly", false);
            $("#idperiodo").focus();
          }
        } else {
          toastr["error"]("Producto no cuenta con stock minimo");
          $("#codigobarra").val("");
          $("#codigobarra").select2();
          $("#precio").val("");
          //$('#cantidad').val("");
        }
      }
    );
   
}

function cadenaAleatoria(longitud, caracteres) {
  var d = new Date();

  var anio = d.getFullYear();
  var mes = d.getMonth();
  var dia = d.getDay();
  var hora = d.getHours();
  var minutos = d.getMinutes();
  var segundos = d.getSeconds();
  var milisegundos = d.getTime();
  // document.write('Fecha: '+d.getDate(),'<br>Dia de la semana: '+d.getDay(),'<br>Mes (0 al 11): '+d.getMonth(),'<br>Año: '+d.getFullYear(),'<br>Hora: '+d.getHours(),'<br>Hora UTC: '+d.getUTCHours(),'<br>Minutos: '+d.getMinutes(),'<br>Segundos: '+d.getSeconds());

  longitud = longitud || 16;
  caracteres = caracteres || "0123456789abcdefghijklmnopqrstuvwxyz";

  var cadena = "";
  var max = caracteres.length - 1;
  for (var i = 0; i < longitud; i++) {
    cadena += caracteres[Math.floor(Math.random() * (max + 1))];
  }
  var idindex =
    cadena + anio + mes + dia + hora + minutos + segundos + milisegundos;

  $("#idindexx").text(idindex);
  $("#idindex").val(idindex);
  $("#idindex_venta").val(idindex);
  // $("#idcompra").val(idindex);
}

function insert_ventas_temp() {
  //	e.preventDefault();
  // $("#valida").prop("disabled", false);
  var formData = new FormData($("#productos_insert")[0]);
  var preciov = $("#precio").val();
  var cantidad = $("#cantidad").val();
  var descuento = $("#descuento").val();
  var subtv = preciov * cantidad;
  var descv = subtv - descuento;
  var prod = $("#idproducto").val();

  var idperiodo = $("#idperiodo").val();

  if (idperiodo === "-") {
	toastr["error"]("Seleccione un perido");
    $("#idperiodo").focus();
  }
  else  if (preciov > 0) {
    $.ajax({
      url: "../ajax/venta.php?op=guardaryeditar_detalle_temp",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function (datos) {
        var info = JSON.parse(datos);
        //console.log(info);

        if (info.state == "ok") {
          //	$("#valida").prop("disabled", true);

          listar_detalle_venta_temp();
          //cargar_combo_prosuctos_stock();
          cargar_lista_ventas_sin_procesar();
          calcular_totales_venta();

          //insert_ventas_temp();
          //
          //listarProducto();
          //
          toastr["success"]("Item se agrego");

          tabla2.ajax.reload();

          $("#lote").val("");
          $("#stock").val("0.00");
          $("#stock_ven").text("0.00");
          $("#idproducto").val("");
          $("#cantidad").val("1");
          $("#precio").val("");
          $("#descuento").val(0.0);
          $("#des_producto").text("Descripcion del producto");
          $("#codigobarra").val("");
          $("#codigobarra").select2();
          $("#precio_compra_promedio").val("");
          $("#codigobarra").focus();

          //tabla2.fnFilterClear();
          tabla2.search("").draw();
        } else if (info.state == "noexiste") {
          toastr["error"]("No tiene una caja aperturada");
        } else if (info.state == "itemexiste") {
          toastr["error"]("Item ya esta registrado en el detalle de venta");
          $("#codigobarra").val("");
          $("#codigobarra").select2();
        } else {
          toastr["error"]("Verifique cantidad ingresada");

          $("#cantidad").focus();
        }
      },
      error: function (datos) {
        toastr["error"]("Verifique los datos ingresados");
      },
    });
  } else {
    toastr["error"]("Seleccione un producto o servicio");
    //	$("#descuento").focus();
  }
}

function calcular_totales_venta() {
  //$('#modal_facturar').modal('show');

  var idindex = $("#idindex").val();
 

  $.post(
    "../ajax/venta.php?op=calcular_totales_venta",
    { idindex: idindex },
    function (data, status) {
      data = JSON.parse(data);

      $("#total_factura").text(data.total_con_descuento);
      $("#total_operacion").text("S/ " + data.total_con_descuento);

      //$('#modal_facturar').modal('show');
    }
  );

  //$("#codigobarra").focus();
}

///////////////////////////////////////////////

//Función limpiar
function limpiar() {
  $("#idproveedor").val("");
  $("#proveedor").val("");
  $("#serie").val("");
  $("#numero").val("");
  $("#igv").val("0");

  $("#total").val("");
  $(".filas").remove();
  $("#tot").html("0");
  $("#observacion").text("");

  //Obtenemos la fecha actual
  var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  var today = now.getFullYear() + "-" + month + "-" + day;
  //$('#fecha').val(today);

  //Marcamos el primer tipo_documento
  // $("#tipocomprobante").val("Boleta");
  //$("#tipocomprobante").selectpicker('refresh');
}

function calcular_vuelto() {
  var efectivo = $("#efectivo").val();
  var vuelto = $("#vuelto").val();
  var total_factura = $("#total_factura").text();

  var x = efectivo - total_factura;

  var n = x.toFixed(2);

  $("#vuelto").val(n);
  //$("#vuelto").number(true,2);
}

var icono = "";
var msj = "";
var mensaje = "";

//Función mostrar formulario
function mostrarform(flag) {
  limpiar();
  if (flag) {
    //location.reload();
    $("#listadoregistros").hide();
    $("#formularioregistros").show();
    $("#tablabusqueda").show();
    //$("#btnGuardar").prop("disabled",false);
    $("#btnagregar").hide();

    //	$("#btnGuardar").hide();
    $("#btnCancelar").hide();
    detalles = 0;
    $("#btnAgregarArt").show();

    cadenaAleatoria();
  } else {
    $("#listadoregistros").show();
    $("#formularioregistros").hide();
    $("#tablabusqueda").hide();

    $("#btnagregar").show();
  }
}

function llenar_cliente() {
  //Cargamos los items al select proveedor
  $.post("../ajax/cliente.php?op=select_combo_cliente", function (r) {
    $("#idcliente").html(r);
    //$('#idproveedor').selectpicker('refresh');
  });
}

//Función cancelarform
function cancelarform() {
  limpiar();
  mostrarform(false);
}

//Función Listar
function listar() {
  var fecha_inicio = $("#fecha_inicio").val();
  var fecha_fin = $("#fecha_fin").val();
  //bootbox.alert('Usted tiene pagos pendientes, el módulo de ventas se ha deshabilitado a las 00:00 del 04-08-2018');
  tabla1 = $("#tbllistado")
    .dataTable({
      responsive: true,
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true,
      autoWidth: false, //Paginación y filtrado realizados por el servidor

      dom: "Bfrtip", //Definimos los elementos del control de tabla
      buttons: ["copyHtml5", "excelHtml5"],
      ajax: {
        url: "../ajax/venta.php?op=listar",
        data: { fecha_inicio: fecha_inicio, fecha_fin: fecha_fin },
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 15, //Paginación
      order: [[0, "desc"]], //Ordenar (columna,orden)
    })
    .DataTable();
}

//Función Listar
function listar_ticket() {
  var fecha_inicio_t = $("#fecha_inicio_t").val();
  var fecha_fin_t = $("#fecha_fin_t").val();
  //bootbox.alert('Usted tiene pagos pendientes, el módulo de ventas se ha deshabilitado a las 00:00 del 04-08-2018');
  tabla3 = $("#tbllistado_ticket")
    .dataTable({
      responsive: true,
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true,
      autoWidth: false, //Paginación y filtrado realizados por el servidor
      dom: "Bfrtip", //Definimos los elementos del control de tabla
      buttons: ["copyHtml5", "excelHtml5"],
      ajax: {
        url: "../ajax/venta.php?op=listar_ticket",
        data: { fecha_inicio_t: fecha_inicio_t, fecha_fin_t: fecha_fin_t },
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 15, //Paginación
      order: [[0, "desc"]], //Ordenar (columna,orden)
    })
    .DataTable();
}

//Función Listar
function listar_otrasalidas() {
  var fecha_inicio_t = $("#fecha_inicio_t").val();
  var fecha_fin_t = $("#fecha_fin_t").val();
  //bootbox.alert('Usted tiene pagos pendientes, el módulo de ventas se ha deshabilitado a las 00:00 del 04-08-2018');
  tabla33 = $("#tbllistado_ticket_otrasalida")
    .dataTable({
      responsive: true,
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true,
      autoWidth: false, //Paginación y filtrado realizados por el servidor
      dom: "Bfrtip", //Definimos los elementos del control de tabla
      buttons: ["copyHtml5", "excelHtml5"],
      ajax: {
        url: "../ajax/venta.php?op=listar_otrasalidas",
        data: { fecha_inicio_t: fecha_inicio_t, fecha_fin_t: fecha_fin_t },
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 15, //Paginación
      order: [[0, "desc"]], //Ordenar (columna,orden)
    })
    .DataTable();
}

//Función para guardar o editar

//$("p").one("click", function(){

$("#btnGuardar_modal").click("click", function (e) {
  //$("#mensajeproceso").css("display", "block");
  e.preventDefault(); //No se activará la acción predeterminada del evento

  //$("#btnGuardar_modal").value='Procendo venta';

  //$("#btnGuardar_modal").prop("disabled",false);

  var formapago = $("#idformapago").val();
  var operacion = $("#operacion").val();
  var especialidad = $("#idespecialidad").val();
  var ciclo = $("#idciclo").val();
  var tipoventa = $("#tipoventa").val();

  var total_vtas = parseFloat($("#total_factura").text());
  var  monto_abdo = $("#montoabonado").val();

  var ma = isNaN(monto_abdo);
  

  var nFilas = $("#detalles_venta tr").length;

  if (nFilas > 1 && ma == false && total_vtas >= monto_abdo) {
     {
      var formData = new FormData($("#procesar_venta_modal")[0]);

      $.ajax({
        url: "../ajax/venta.php?op=insertar_venta",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (response) {
          var info = JSON.parse(response);

          if (info.states == "ok") {
            //var info = JSON.parse(response);

            $("[id*='btnGuardar_modal']").attr("disabled", "disabled");

            if (
              info.idtipocomprobante != "5" ||
              info.idtipocomprobante != "11"
            ) {
              // enviar_sunat_ya(info.idventa);
            }

            icono = "success";
            msj = "Operación Aceptada!";
            valor = "Imprimir comprobante " + info.comprobante + "?";

            Swal.fire({
              title: msj,
              text: valor,
              icon: "success",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Aceptar",
            }).then((result) => {
              if (result.isConfirmed) {
                imprimir_ultimo(info.idventa);
                recargar();
              } else {
                recargar();
              }
            });
          } else if (info.states == "fb") {
            icono = "error";
            msj = "Error!";
            valor = "No se puede emitir Factura a un cliente sin ruc";
            Swal.fire(msj, valor, icono);
          }else if (info.states == "valida1")
          {
            Swal.fire(
              'Error!',
              'Complete los datos correctament!',
              'warning'
            )

          } 
          else if (info.states == "valida2")
          {

            Swal.fire(
              'Error!',
              'Monto abonado en crédito no puede ser 0!',
              'warning'
            )
            
          } 
          else {
            icono = "error";
            msj = "Error!";
            valor = "No se pudo completar la venta";

            Swal.fire(msj, valor, icono);
          }
        },
        error: function (error) {
          toastr["error"]("Error al procesar la venta");
        },
      });
    }
  } else {
    toastr["error"](
      "No existe detalle para procesar la venta o monto abonado no puede ser mayo a total venta"
    );
  }

  //limpiar();
});

function recargar() {
  setTimeout(function () {
    window.location.reload(1);
  }, 500);
}

function mostrar(idventa) {
  $.post(
    "../ajax/venta.php?op=mostrar",
    { idventa: idventa },
    function (data, status) {
      data = JSON.parse(data);
      mostrarform(true);

      $("#idproveedor").val(data.idproveedor);
      $("#idproveedor").selectpicker("refresh");
      $("#tipocomprobante").val(data.tipocomprobante);
      $("#tipocomprobante").selectpicker("refresh");
      $("#serie").val(data.serie);
      $("#numero").val(data.numero);
      $("#fecha").val(data.fecha);
      $("#igv").val(data.igv);
      $("#idventa").val(data.idventa);

      //Ocultar y mostrar los botones
      //	$("#btnGuardar").hide();
      $("#btnCancelar").show();
      $("#btnAgregarArt").hide();
    }
  );

  /*$.post("../ajax/venta.php?op=listarDetalle&id="+idventa,function(r){
	        $("#detalles").html(r);
	});*/
}

function mostrar_preventa(idstocklote) {
  $("#lote").val("");
  $("#precio_compra_promedio").val();
  $("#stock").val("");
  $("#idproducto").val("");
  $("#cantidad").val(1);

  var idstocklote = $("#idstocklote").val();

  $.post(
    "../ajax/venta.php?op=mostrar_preventa",
    { idstocklote: idstocklote },
    function (data, status) {
      data = JSON.parse(data);

      $("#lote").val(data.lote);
      $("#stock").val(data.cantidad);
      $("#stock_ven").text(parseInt(data.cantidad));
      $("#vencimiento").val(data.fechavencimiento);
      $("#idproducto").val(data.idproducto);
      $("#idstocklote").val(data.idstocklote);
      $("#precio").val(data.precioventa);
    }
  );
}

function mostrar1(id) {
  location.href = "notacredito.php?id=" + id;
}

function buscar() {
  $dniruc = $("#dniruc").val();
  if ($dniruc.length == 8 || $dniruc.length == 11) {
    $.post(
      "../ajax/cliente.php?op=buscar",
      { dniruc: $dniruc },
      function (data, status) {
        data = JSON.parse(data);
        $("#idcli").val(data.idcliente);
        $("#nombrerazon").val(data.nombre);
        $("#direccion").val(data.direccion);
        $cliente = $("#idcli").val();
        if ($cliente == "") {
          alert("BUscando en sunat");
        }
      }
    );
  }
}

//Función para anular registros
function anular(idventa) {
  bootbox.confirm(
    "¿Está segur@ de anular la venta, este proceso no se puede deshacer?",
    function (result) {
      if (result) {
        $.post(
          "../ajax/venta.php?op=anular",
          { idventa: idventa },
          function (e) {
            bootbox.alert(e);
            tabla1.ajax.reload();
          }
        );
      }
    }
  );
}

//Función para anular registros
function enviar_sunat(idventasunat) {
  bootbox.confirm(
    "¿Está segur@ de enviar este comprobante a sunat?, este proceso no se puede deshacer.",
    function (result) {
      if (result) {
        $("#mensajeproceso").css("display", "block");

        $.post(
          "../ajax/venta.php?op=enviar_sunat",
          { idventasunat: idventasunat },
          function (e) {
            bootbox.alert(e);
            $("#mensajeproceso").css("display", "none");

            tabla1.ajax.reload();

            //generar_pdf(idventasunat);
          }
        );
      }
    }
  );
}

function enviar_sunat_ya(idventasunat) {
  $.post(
    "../ajax/venta.php?op=enviar_sunat",
    { idventasunat: idventasunat },
    function (e) {
      tabla1.ajax.reload();
    }
  );
}

function cargar_combo_prosuctos_stock() {
  $.post(
    "../ajax/producto.php?op=select_combo_producto_lote_stock",
    function (r) {
      $("#idstocklote").html(r);
      //$('#idproveedor').selectpicker('refresh');
    }
  );
}

function listar_detalle_venta_temp() {
  var idindex = $("#idindex").val();

  tabla1_det = $("#detalles_venta")
    .dataTable({
      autoWidth: false,
      //"responsive": true,
      aProcessing: false,
      aServerSide: false,
      paging: false,
      ordering: false,
      info: false,
      searching: false,
      dom: "Bfrtip", //Definimos los elementos del control de tabla
      buttons: [],
      ajax: {
        url: "../ajax/venta.php?op=listar_detalle_venta_temp",
        data: { idindex: idindex },
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 15, //Paginación
      order: [[0, "desc"]], //Ordenar (columna,orden)
    })
    .DataTable();

  //calcular_totales_compra();
}

function generar_pdf(idventasunat) {
  $.get("../reportes/pdf.php?id=" + idventasunat, function (e) {});
}

function imprimir_ultimo(idventa) {
  //$.post("../ajax/venta.php?op=obtener_ultimo", function(data, status)
  //{
  //data = JSON.parse(data);

  window.open("../reportes/ticketVenta.php?id=" + idventa, "_blank");

  //	});
}

function llenar_tipocomprobante() {
  var idsalida = $("#idsalida").val();

  if (idsalida == 1) {
    $.post(
      "../ajax/tipocomprobante.php?op=select_combo_tipocomprobante_salidas",
      function (r) {
        $("#idtipocomprobante").html(r);
        //$('#idproveedor').selectpicker('refresh');
      }
    );
  } else {
    $.post(
      "../ajax/tipocomprobante.php?op=select_combo_tipocomprobante",
      function (r) {
        $("#idtipocomprobante").html(r);
        //$('#idproveedor').selectpicker('refresh');
      }
    );
  }
}

function cargar_lista_ventas_sin_procesar() {
  $.post("../ajax/venta.php?op=listar_venta_proceso_temp", function (r) {
    $("#idlista_index").html(r);
    // $('#idproducto').selectpicker('refresh');
  });
}

//Función para anular registros
function eliminar_item(idproducto, idindex) {
  // bootbox.confirm("¿Está segur@ de eliminar Item del detalle, este proceso no se puede deshacer?", function(result){

  // if(result)
  // {
  $.post(
    "../ajax/venta.php?op=eliminar_item",
    { idproducto: idproducto, idindex: idindex },
    function (e) {
      toastr["success"]("Item eliminado");
      //bootbox.alert(e);
      tabla1_det.ajax.reload();
      tabla2.ajax.reload();

      cargar_lista_ventas_sin_procesar();

      calcular_totales_venta();

    }
  );
}

//Función para anular registros
function eliminar_detalle_venta_temp(idindex) {
  var idindex = $("#idindex").val();

  var idlista_index = $("#idlista_index").val();

  if (idlista_index == 0) {
    bootbox.alert("Seleccione una opción correcta");
  } else {
    bootbox.confirm(
      "¿Está segur@ de eliminar Items del detalle, este proceso no se puede deshacer?",
      function (result) {
        if (result) {
          $.post(
            "../ajax/venta.php?op=eliminar_detalle_venta_temp",
            { idindex: idindex },
            function (e) {
              bootbox.alert(e);

              tabla1_det.ajax.reload();

              //cargar_combo_prosuctos_stock();

              cargar_lista_ventas_sin_procesar();
              calcular_totales_venta();
            }
          );

          calcular_totales_venta();

          //listar_detalle_venta_temp();
          //calcular_totales_compra();

          location.reload();
        }
      }
    );
  }
}

function validar_modal() {
  var nFilas = $("#detalles_venta tr").length;

  if (nFilas > 1) {
    $("#modal_facturar").modal("show");

    calcular_totales_venta();

    select_combo_direccion_cliente();
    //$("#iddireccion").select2();
  } else {
    toastr["error"]("Agregar al menos un producto al detalle de la venta");
  }
}

function cargar_clientes() {
  $("#myModal").modal("show");
}

function ver_detalle_venta_temp() {
  var valor = $("#idlista_index").val();
  if (valor === "0") {
  } else {
    $("#idindex").val($("#idlista_index").val());
    $("#idindex_venta").val($("#idlista_index").val());
    //$("#idindexx").text($("#idlista_index").val());
  }

  listar_detalle_venta_temp();
  calcular_totales_venta();
  $("#tab_venta").trigger("click");
}

//Función Listar
function listar_detalle_venta_temp() {
  var idindex = $("#idindex").val();

  tabla1_det = $("#detalles_venta")
    .dataTable({
      autoWidth: false,
      //"responsive": true,
      aProcessing: false,
      aServerSide: false,
      paging: false,
      ordering: false,
      info: false,
      searching: false,
      dom: "Bfrtip", //Definimos los elementos del control de tabla
      buttons: [],
      ajax: {
        url: "../ajax/venta.php?op=listar_detalle_venta_temp",
        data: { idindex: idindex },
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 15, //Paginación
      order: [[0, "desc"]], //Ordenar (columna,orden)
    })
    .DataTable();

  //calcular_totales_compra();
}

function llenar_serie() {
  var idtipocomprobante = $("#idtipocomprobante").val();

  //if (($("#tipodoc").val()==1 || $("#tipodoc").val()==0 && $("#idtipocomprobante").val()==3) || $("#tipodoc").val()==6 && $("#idtipocomprobante").val()==1)
  if (
    (($("#tipodoc").val() == 0 || $("#tipodoc").val() == 1) &&
      $("#idtipocomprobante").val() == 3) ||
    $("#idtipocomprobante").val() == 5 ||
    ($("#tipodoc").val() == 6 && $("#idtipocomprobante").val() == 1)
  ) {
    $.post(
      "../ajax/venta.php?op=mostrar_serie",
      { idtipocomprobante: idtipocomprobante },
      function (r) {
        $("#idserienumero").html(r);

        $("#serie").val($("#idserienumero").val());
      }
    );
    $("#serie").val("");
  } else {
    $("#idserienumero").html("");
    //bootbox.alert("El cliente no cumple con los datos para el tipo de comprobante");
  }
}

function serie_mostrar(idserienumero) {
  var idserienumero = $("#idserienumero").val();
  $.post(
    "../ajax/venta.php?op=serie_mostrar",
    { idserienumero: idserienumero },
    function (data, status) {
      data = JSON.parse(data);
      //mostrarform(true);
      $("#serie").val(data.serie);
      $("#idserienumero").val(data.idserienumero);
    }
  );
}

function mostrar_venta(idcliente) {
  var idcliente = $("#idcliente").val();
  $.post(
    "../ajax/venta.php?op=mostrar_cliente",
    { idcliente: idcliente },
    function (data, status) {
      data = JSON.parse(data);
      //mostrarform(true);
      $("#dniru").val(data.dniruc);
      $("#nombres").val(data.nombre);
      $("#direc").val(data.direccion);
      $("#procedencia").val(data.referencia);
      $("#tipodoc").val(data.tipodocumento);
      $("#idcliente").val(data.idcliente);
    }
  );
}

function ventas_credito() {
  var tipoventa = $("#tipoventa").val();
  if (tipoventa == 2) {
    forma_pago_credito();

    $("#monto_a").show();
    $("#forma_p").show();
    $("#vencecredito").show();
   // $("#idformapago").val(5);
    $("#montoabonado").val("0.00");
    $("#fecha_op").hide();

    $("#monto_ef").hide();
    $("#monto_op").hide();
    //$("#fecha_op").hide();
  } else if (tipoventa == 1) {
    forma_pago_efectivo();

    $("#monto_a").hide();
    $("#forma_p").show();
    $("#vencecredito").hide();
    // $("#idformapago").val(1);
    $("#montoabonado").val("0.00");
    $("#fecha_op").show();
  } else {
    $("#idformapago").val("-");

  }
}

function ventas_tarjeta() {
  var formapago = $("#idformapago").val();

  // forma de pago 2 = deposito cuenta institucional
  // forma de pago 1 = contado

  if (formapago == 2) {
    $("#monto_a").hide();
    $("#monto_op").show();
    $("#fecha_op").show();
    $("#montoabonado").val("0.00");
    $("#operacion").val("");
  } else if (formapago == 5) {
    $("#monto_a").show();
    $("#monto_op").show();
    $("#fecha_op").show();
    $("#operacion").val("");
  } else {
    $("#monto_a").hide();
    $("#monto_op").hide();
    $("#fecha_op").hide();

    $("#montoabonado").val("0.00");
    $("#operacion").val("");
  }
}

function periodo_venta(idproducto) {
  $.post(
    "../ajax/periodos.php?op=select_combo_periodo_precio_producto",
    { idproducto: idproducto },
    function (r) {
      $("#idperiodo").html(r);
    }
  );

  //mostrar_precio_periodo();
}

function mostrar_precio_periodo(idproducto, idperiodo) {
  var idproducto = $("#idproducto").val();
  var idperiodo = $("#idperiodo").val();

  $.post(
    "../ajax/precios.php?op=mostrar_precio_periodo",
    { idproducto: idproducto, idperiodo: idperiodo },
    function (data, status) {
      data = JSON.parse(data);

      // $("#preciocompra").val(data.preciocompra);
      $("#precio").val(data.precioventa);
    }
  );
}

init();
