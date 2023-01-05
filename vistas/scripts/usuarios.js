var tabla;

function init() {
  mostrarform(false);
  listar();
  $("#num_documento").change(contar_usuarios);
  $("#login").change(contar_usuarios);

  $("#formulario").on("submit", function (e) {
    guardaryeditar(e);
  });

  /*$.post("../../ajax/establecimiento.php?op=select_establecimientos_activos", function(r){
		$("#idmicrored").html(r);
		$('#idmicrored').selectpicker('refresh');
	});
*/

  $("#imagenmuestra").hide();

  $.post("../ajax/usuario.php?op=permisos&id=", function (r) {
    $("#permisos").html(r);
  });
}

function limpiar() {
  $("#idusuario").val("");
  $("#nombre").val("");
  $("#num_documento").val("");
  $("#direccion").val("");
  $("#telefono").val("");
  $("#email").val("");
  // $("#cargo").val("");
  $("#login").val("");
  $("#clave").val("");
  $("#imagen").val("");
  $("#imagenmuestra").val("");
  $("#imagenmuestra").attr("src", "");
  $("#imagenactual").val("");
  $("#imagenmuestra").hide();
  $("#idusuario").val("");
}

function mostrarform(flag) {
  limpiar();
  if (flag) {
    $("#listadoregistros").hide();
    $("#formularioregistros").show();
    $("#btnGuardar").prop("disabled", false);
  } else {
    $("#listadoregistros").show();
    $("#formularioregistros").hide();
  }
}

function cancelarform() {
  limpiar();
  mostrarform(false);
}

function listar() {
  tabla = $("#tbllistado")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      dom: "Bfrtip",
      buttons: ["copyHtml5", "excelHtml5", "pdf"],
      ajax: {
        url: "../ajax/usuario.php?op=listar",
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      dDestroy: true,
      iDisplayLength: 7,
      order: [[0, "asc"]],
    })
    .DataTable();
}

function guardaryeditar() {
  // e.preventDefault();
  // $("#btnGuardar").prop("disabled", true);
  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "../ajax/usuario.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      // toastr["success"](datos);
      // mostrarform(false);
      tabla.ajax.reload();
      $("#mymodal").modal("hide");

      mensaje = "Se registro con éxito";
      Swal.fire({
        title: "Registro",
        text: mensaje,
        icon: "success",
        //showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
      }).then((result) => {
        if (result.isConfirmed) {
          location.reload();
        }
      });
    },
  });
  limpiar();
}

function mostrar(idusuario) {
  $.post(
    "../ajax/usuario.php?op=mostrar",
    { idusuario: idusuario },
    function (data, status) {
      data = JSON.parse(data);
      // mostrarform(true);

      $("#titulo_modal").text('Actualizar usuario');

      $("#nombre").val(data.nombre);
      $("#tipo_documento").val(data.tipo_documento);
      //$("#tipo_documento").selectpicker("refresh");
      $("#num_documento").val(data.num_documento);
      $("#direccion").val(data.direccion);
      $("#telefono").val(data.telefono);
      $("#email").val(data.email);
      $("#cargo").val(data.cargo);
      $("#login").val(data.login);
      //$("#clave").val(data.clave);
      $("#imagenmuestra").show();
      $("#imagenmuestra").attr("src", "../files/usuarios/" + data.imagen);
      $("#imagenactual").val(data.imagen);
      $("#idusuario").val(data.idusuario);
    }
  );

  $.post("../ajax/usuario.php?op=permisos&id=" + idusuario, function (r) {
    $("#permisos").html(r);
  });
}

function desactivar(idusuario) {
  mensaje = "¿Está seguro de desactivar usuario?";
  Swal.fire({
    title: "Desactivar usuario?",
    text: mensaje,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Aceptar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(
        "../ajax/usuario.php?op=desactivar",
        { idusuario: idusuario },
        function (e) {
          tabla.ajax.reload();
        }
      );

      Swal.fire("Desactivar!", "El usuario se desactivo", "success");
    }
  });
}

function activar(idusuario) {
  mensaje = "¿Está seguro de activar usuario?";
  Swal.fire({
    title: "Activar usuario?",
    text: mensaje,
    icon: "success",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Aceptar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(
        "../ajax/usuario.php?op=activar",
        { idusuario: idusuario },
        function (e) {
          tabla.ajax.reload();
        }
      );

      Swal.fire("Activar!", "El usuario se activo", "success");
    }
  });
}

var x = 0;

function contar_usuarios(num_documento) {
  var num_documento = $("#num_documento").val();
  var login = $("#login").val();

  $.post(
    "../ajax/usuario.php?op=contar_usuarios",
    { num_documento: num_documento, login: login },
    function (data, status) {
      data = JSON.parse(data);

      if (data.total > 0) {
        bootbox.alert(
          "Número de dni: " + num_documento + " ya existe en la base de datos"
        );
        $("#num_documento").val("");
        $("#login").val("");
      }
    }
  );
}

function valida_tipo_modal() {
  $("#idusuario").val("");
  limpiar();
  //ver();
  $("#mymodal").modal("show");
  $("#titulo_modal").text('Registrar usuario');
}

init();
