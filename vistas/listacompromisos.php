
<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location: login');
} else {

    require 'header.php';
    if ($_SESSION['ctscobrar'] == 1) { ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">
              <!-- <a type="button" class="breadcrumb-item btn  btn-info btn-xs" onclick="nuevo();" >
                  <b><i class="fas fa-user-plus"></i> Nuevo producto</b></a> -->
                
              </li>
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
          <h3 class="card-title">Listado de compromisos de pago</h3>

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
            <th>#</th>
            <th>COMPROBANTE</th>
            <th>USUARIO</th>
            <th>ALUMNO</th>
            <th>Fecha COMPROMISO</th>
            <th>TOTAL COMPROBANTE</th>
            <th>TOTAL ABONO</th>
            <th>DEUDA</th>
            <th>DEUDA ACTUAL</th>
            <th>F.VENCIMIENTO</th>
            <th>ESTADO</th>
            <th>OPCIONES</th>
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
 

<?php } else {require 'noacceso.php';}

    require 'footer.php';
    ?>
  <script type="text/javascript" src="scripts/listacompromisos.js"></script>
<?php
}
ob_end_flush();
?>


