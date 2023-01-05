var tabla;
var tabla2;
var tabla3;
function init() {
 
  limpiar();

  listar();

  // listar2();

  //$("#btnGuardar").text='ddddd';

  $("#btnGuardar").html("Guardar");


  //$("#preciocompra").number(true,2,'.','');
  //$("#precioventa").number(true,2,'.','');
  // $("#porcentaje").number(true, 2, ".", "");

  /*$("#formulario").on("submit", function (e) {
    guardaryeditar(e);
  });*/

  // $("#idproducto").change(listar2);
 // $("#porcentaje").change(calcular_precio);
  //$("#preciocompra").change(calcular_precio);
}

function limpiar() {
  $("#preciocompra").val("");
  $("#precioventa").val("");
  $("#producto").val("");
  $("#idproducto").val("");
  $("#idprecio").val("");
}



function listar() {
  tabla = $("#example1")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      dom: "Bfrtip",
      buttons: [
        "copyHtml5",
        "excelHtml5" /*,
		            'pdf'	*/,
      ],
      ajax: {
        url: "../ajax/productos.php?op=listar_productos_precio",
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      dDestroy: true,
      iDisplayLength: 15,
      order: [[0, "asc"]],
    })
    .DataTable();
}

function listar2() {
  var idproducto = $("#idproducto").val();

  //alert(idproducto);
  tabla2 = $("#example12")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      paging: true,
      ordering: true,
      info: true,
      searching: true,

      dom: "Bfrtip",
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdf", "print"],
      ajax: {
        url: "../ajax/precios.php?op=listar",
        data: { idproducto: idproducto },
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      dDestroy: true,
      iDisplayLength: 7,
      order: [[0, "desc"]],
    })
    .DataTable();

  $("#example12").dataTable().fnDestroy();
}

function listar_historial() {
  var idproducto = $("#idproducto").val();

  //alert(idproducto);
  tabla3 = $("#example_historial")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      paging: true,
      ordering: true,
      info: true,
      searching: true,

      dom: "Bfrtip",
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdf", "print"],
      ajax: {
        url: "../ajax/precios.php?op=listar_historial",
        data: { idproducto: idproducto },
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      dDestroy: true,
      iDisplayLength: 7,
      order: [[0, "desc"]],
    })
    .DataTable();

  $("#example_historial").dataTable().fnDestroy();
}


var icono = "";
var msj = "";
var mensaje = "";

function guardaryeditar() {
  // e.preventDefault();

  // $("#btnGuardar").prop("categoriabled", true);
  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "../ajax/precios.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      var info = JSON.parse(datos);
      if (info.state == 1) {
        icono = "success";
        msj = "Éxito!";
        dat = "Datos Guardados";
        Swal.fire(msj, dat, icono);
        tabla2.ajax.reload();
        tabla3.ajax.reload();
       // limpiar();
      } else if (info.state == 2) {
        icono = "error";
        msj = "Error!";
        dat = "Verifique, producto ya tiene precio para ese periodo";
        Swal.fire(msj, dat, icono);
      } else if (info.state == 3) {
        icono = "error";
        msj = "Error!";
        dat = "Complete los datos";
        Swal.fire(msj, dat, icono);
      } else {
        icono = "error";
        msj = "Error!";
        dat = "No se puede completar verifique los datos ingresados";
        Swal.fire(msj, dat, icono);
      }
    },
    error: function (error) {
      icono = "error";
      msj = "Error!";
      dat = "No se puede completar verifique los datos ingresados..";
      Swal.fire(msj, dat, icono);
    },
  });
 // limpiar();
  //listar2();
  //tabla.ajax.reload();
}

// tipo   bien =0   servicio=1
// aplicamovimiento si= 1 no=0
// tipocuenta 1=ingresos 0 =egresos

//var nx;

function mostrar_producto_precio(
  idproducto,
  tipo,
  aplicamovimiento,
  tipocuenta
) {
  limpiar();

  $.post(
    "../ajax/productos.php?op=mostrar",
    {
      idproducto: idproducto,
      tipo: tipo,
      aplicamovimiento: aplicamovimiento,
      tipocuenta: tipocuenta,
    },
    function (data, status) {
      data = JSON.parse(data);

      $("#ocultar").show();
      $("#idprecio").val("");
      $("#btnGuardar").html("Guardar");

      if (tipo == 1) {
        combo_periodos();
        // $("#idperiodo option:eq(0)").prop("disabled", true);
      } else {
        combo_periodos_noaplica();

        //$("#idperiodo option:eq(0)").prop("disabled", false);
      }

      //mostrarform(true);
      $("#idproducto").val(data.idproducto);
      $("#producto").val(data.idproducto + "-" + data.descripcion);
     // $("#preciocompra").val(data.preciocompra);
     // $("#precioventa").val(data.precioventa);
      listar2();
      listar_historial();
      // calcular_precio();

      // nx=tipo;
    }
  );
  //return nx;
}

function mostrar(idprecio) {
  $("#titulo_modal").text("Modificar subcuenta");

  $.post(
    "../ajax/precios.php?op=mostrar",
    { idprecio: idprecio },
    function (data, status) {
      data = JSON.parse(data);

      $("#ocultar").hide();
      $("#btnGuardar").html("Actualizar");

      $("#preciocompra").val(data.preciocompra);
      $("#precioventa").val(data.precioventa);
      $("#idprecio").val(data.idprecio);
    }
  );
}




function calcular_precio() {
  var n1 = document.getElementById("porcentaje").value;
  var n2 = document.getElementById("preciocompra").value;
  var suma = ((parseFloat(n1) * parseFloat(n2)) / 100 + parseFloat(n2)).toFixed(
    2
  );
  $("#precioventa").val(suma);
}

function combo_periodos() {
  $.post("../ajax/periodos.php?op=select_combo_periodos", function (r) {
    $("#idperiodo").html(r);
  });
}

function combo_periodos_noaplica() {
  $.post(
    "../ajax/periodos.php?op=select_combo_periodos_noaplica",
    function (r) {
      $("#idperiodo").html(r);
    }
  );
}

init();
