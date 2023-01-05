<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location: login');
} else {

    require 'header.php';
    if ($_SESSION['accesos'] == 1) { ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">

        <div class="col-sm-12">
          <ol class="breadcrumb float-sm-right">
            <a type="button" class="breadcrumb-item btn  btn-info btn-xs" onclick="valida_tipo_modal();">
              <b><i class="fas fa-user-plus"></i> Nuevo usuario </b></a>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Listado de usuarios</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">

        <!-- INICIO AREA DE TRABAJO  -->


        <table id="tbllistado" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Opciones</th>
              <th>Nombres</th>
              <th>Tipo Documento</th>
              <th>Numero Documento</th>
              <th>Telefono</th>
              <th>Email</th>
              <th>Login</th>
              <th>Foto</th>
              <th>Opciones</th>
            </tr>
          </thead>

          <tbody>

          </tbody>

        </table>

        <!-- FIN AREA DE TRABAJO  -->


      </div>

    </div>

  </section>

</div>



<!---  INICIO MODAL   --->
<!-- Modal secondary -->
<div class="modal fade" id="mymodal" data-backdrop="static" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="titulo_modal">Titulo Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="formulario" id="formulario" method="POST">

          <div class="row">

            <div class="col-lg-6 col-xs-12">
              <div class="form-group">
                <label>NOMBRES</label>
                <input type="hidden" name="idusuario" id="idusuario">
                <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombres" required>
              </div>
            </div>

            <div class="col-lg-6 col-md-12">
              <div class="form-group">
                <label>TIPO DOCUMENTO</label>
                <select id="tipo_documento" name="tipo_documento" class="form-control" required>
                  <option value="DNI">DNI</option>
                  <option value="CARNET">CARNET EXTRANJERIA</option>
                </select>
              </div>
            </div>

            <div class="col-lg-4 col-md-12">
              <div class="form-group">
                <label>NÚMERO DE DOCUMENTO</label>
                <input type="text" class="form-control" maxlength="20" name="num_documento" id="num_documento" placeholder="Número documento" required>
              </div>
            </div>

            <div id="divdistrito" class="col-lg-4 col-md-12">
              <div class="form-group">
                <label>DIRECCIÓN</label>
                <input type="text" class="form-control" maxlength="70" name="direccion" id="direccion" placeholder="Direccion">
              </div>
            </div>

            <div id="divreferencia" class="col-lg-4 col-md-12">
              <div class="form-group">
                <label>TELEFONO</label>
                <input type="text" class="form-control" name="telefono" id="telefono" maxlength="10" placeholder="Telefono">
              </div>
            </div>

            <div id="divdireccion" class="col-lg-6 col-md-12">
              <div class="form-group">
                <label>EMAIL</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" maxlength="50">
              </div>
            </div>

            <div class="col-lg-6 col-md-12">
              <div class="form-group">
                <label>CARGO</label>
                <select name="cargo" id="cargo" class="form-control">
                  <option value="ADMINISTRADOR" selected>ADMINISTRADOR</option>
                  <option value="VENTAS">VENTAS</option>
                  <option value="SOPORTE">SOPORTE</option>
                  <option value="ALMACEN">ALMACEN</option>
                </select>
              </div>
            </div>

            <div class="col-lg-4 col-md-12">
              <div class="form-group">
                <label>USUARIO</label>
                <input type="text" class="form-control" name="login" id="login" placeholder="login" maxlength="20" required>
              </div>
            </div>

            <div class="col-lg-4 col-md-12">
              <div class="form-group">
                <label>CONTRASEÑA</label>
                <input type="password" class="form-control" name="clave" id="clave" placeholder="clave" maxlength="64" required>

              </div>
            </div>

            <div class="col-lg-4 col-md-12">
              <div class="form-group">
                <label>FOTO</label>
                <input type="file" class="form-control" name="imagen" id="imagen">
                <input type="hidden" class="form-control" name="imagenactual" id="imagenactual">
                <img src="" width="150px" height="120px" id="imagenmuestra" class="img-circle">
              </div>
            </div>

            <div class="col-lg-6 col-md-12">
              <div class="form-group">
                <label>Permisos:</label>
                <ul style="list-style: none;" id="permisos">

                </ul>
              </div>
            </div>


          </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
        <button type="button" onclick="guardaryeditar();" id="btnGuardar" id="btnGuardar" class="btn btn-info"><i class="fas fa-save"></i> Guardar</button>
      </div>

      </form>
    </div>
  </div>
</div>

<!--- FIN MODAL  -->


<?php } else {require 'noacceso.php';}

    require 'footer.php';
    ?>
  <script type="text/javascript" src="scripts/usuarios.js"></script>
<?php
}
ob_end_flush();
?>



