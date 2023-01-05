<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location: login');
} else {

    require 'header.php';
    if ($_SESSION['ingresos'] == 1) { ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a type="button" class="btn btn-xs btn-info" href="venta"><i class="fas fa-cart-plus "></i><b> Nueva venta</b></a></li>
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
          <h3 class="card-title">Listado de cuentas</h3>

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

             
          
                  <div class="row">
          
                    <div class="col-xl-6 col-md-12">
                      <div class="form-group">
                        <?php 
                          date_default_timezone_set("America/Lima");  
                              $fecha=date('Y-m-d');                    
                           ?>
                          <label>Fecha Inicio</label>
                          <input type="hidden" name="idsalida" id="idsalida" value='2'>
                          <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d",strtotime($fecha.'- 1 days'));?>">
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-12">
                      <div class="form-group">
                        <label>Fecha Fin</label>
                        <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d"); ?>">
                      </div>
                    </div>

                  </div>
               
     

                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>N°</th>
                            <th>Estado</th>
                            <!-- <th>Situa</th>
                            <th>Documentos</th> -->
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>DNI/RUC</th>
                            <th>Documento</th>
                            <th>Formapago</th>
                            <th>Número</th>
                            <th>Referencia</th>
                            <th>Total</th>
                            <th>Opción</th>
                            <!-- <th>Correo</th> -->
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            
                          </tfoot>
                        </table>



        <!-- FIN AREA DE TRABAJO  -->


        </div>
       
      </div>

     </section>
  
  </div>
 

  <?php } else {require 'noacceso.php';}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/ventas.js"></script>
<?php
}
ob_end_flush();
?>


