<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location: login');
} else {

    require 'header.php';
    if ($_SESSION['actividades'] == 1) { ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">
              <a type="button" class="breadcrumb-item btn  btn-info btn-xs" onclick="nuevo();" >
                  <b><i class="fas fa-user-plus"></i> Nueva actividad</b></a>
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
          <h3 class="card-title">Listado de actividades</h3>

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

             
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ESTADO</th>
              <th>#</th>
              <th>GASTO</th>
              <th>SUBGASTO</th>
              <th>DESCRIPCIÓN ACTIVIAD</th>
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
 


<!---  INICIO MODAL   --->
 
<!-- Modal secondary -->
  <div class="modal fade" id="mymodal" data-backdrop="static"  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

                <div class="col-lg-6  col-md-12">
                  <div class="form-group">
                    <label>SUBGASTO</label>
                    <select class="form-control" style="width: 100%;" id="idsubgasto" name="idsubgasto" >
                      
                    </select>
                  </div>
                </div>

                <div class="col-lg-3  col-md-12">
                    <?php 
                      date_default_timezone_set("America/Lima");    
                      $fecha=date('Y-m-d');                                              
                    ?>
                  <div class="form-group">
                    <label>FECHA ACTIVIDAD</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo $fecha; ?>">
                  </div>
                </div>

                <div class="col-lg-3  col-md-12">
                  <div class="form-group">
                    <label>PERIODO</label>
                    <select class="form-control" style="width: 100%;" id="idperiodo" name="idperiodo" >
                      
                    </select>
                  </div>
                </div>

                <div class="col-lg-12 col-md-12">      
                  <div class="form-group">
                    <label>DESCRIPCIÓN ACTIVIDAD</label>
                    <input type="hidden" name="idactividad" id="idactividad">
                    <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="3" placeholder="Ingrese descripción de la actividad" onkeyup = "this.value=this.value.toUpperCase()" required>
                  </textarea>

                  </div>  
                </div>

               

              

              </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
              <button type="submit" id="btnGuardar" class="btn btn-info"><i class="fas fa-save"></i> Guardar</button>
            </div>

          </form> 
      </div>
    </div>
  </div>

<!--- FIN MODAL  -->


<?php } else {require 'noacceso.php';}

    require 'footer.php';
?>
<script type="text/javascript" src="scripts/actividad.js"></script>
<?php
}
ob_end_flush();
?>

