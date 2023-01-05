<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location: login');
} else {

    require 'header.php';
    if ($_SESSION['productos'] == 1) { ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!--
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
            <a type="button" class="breadcrumb-item btn  btn-info btn-xs" onclick="nuevo();" >
                  <b><i class="fas fa-user-plus"></i> Nueva especialidad </b></a>
            </ol>
          </div>
        </div>
      </div>
    </section> -->

  <!-- Main content -->
  <section class="content">

    <div class="row mt-2 ml-2 mr-2">
      <!-- Default box -->



    </div>

  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-lg-4">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">PRODUCTO / SERVICIO</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form>
              <div class="card-body  table-responsive">
                <table id="example1" class=" table table-bordered table-striped">
                  <thead>
                    <th>Descripción de producto</th>
                    <th>Agregar</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Descripción de producto</th>

                    <th></th>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </form>
          </div>
          <!-- /.card -->



        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-8">
          <!-- Form Element sizes -->
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">REGISTRO DE PRECIOS</h3>
            </div>
            <div class="card-body">
              <form name="formulario" id="formulario" method="POST">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for="cod">NOMBRE DEL PRODUCTO / SERVICIO</label>
                      <input type="hidden" class="form-control" id="idprecio" name="idprecio">
                      <input type="hidden" class="form-control" id="idproducto" name="idproducto">
                      <textarea class="form-control" id="producto" name="producto" placeholder="Producto..." readonly="readonly"></textarea>
                      <input type="hidden" class="form-control" id="porcentaje" name="porcentaje" value="20" required placeholder="ganancia...">
                    </div>
                  </div>

                  <div id="ocultar" class="col-lg-4">
                    <div class="form-group">
                      <label for="cod">PERIODO</label>
                      <select class="form-control" id="idperiodo" name="idperiodo" required>

                      </select>
                    </div>
                  </div>

                  <div class="col-lg-4 ">
                    <div class="form-group">
                      <label for="cod">PRECIO COMPRA</label>
                      
                      <input type="text" class="form-control" id="preciocompra" name="preciocompra" required placeholder="Precio compra...">
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="cod">PRECIO VENTA</label>
                      <input type="text" class="form-control" id="precioventa" name="precioventa" required placeholder="Precio venta...">
                    </div>
                  </div>

                </div>

              </form>
            </div>
            <div class="card-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
              <button type="button" onclick="guardaryeditar();"  id="btnGuardar" class="btn btn-info"><i class="fas fa-save"></i> Guardar</button>
          
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <div class="row">
            <div class="col-lg-6">
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Precio por periodo</h3>
                </div>
                <div class="card-body">
                  <div class="row table-responsive">
                    <table id="example12" class="table table-bordered table-striped">
                      <thead>
                        <th>Fecha</th>
                        <th>Periodo</th>
                        <th>P.Compra</th>
                        <th>P.Venta</th>
                        <th>OP</th>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                      </tfoot>
                    </table>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
            <!-- /.card -->
            <div class="col-lg-6">
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Precio Histórico</h3>
                </div>
                <div class="card-body">
                  <div class="row table-responsive">
                    <table id="example_historial" class="table table-bordered table-striped">
                      <thead>
                        <th>Fecha</th>
                        <th>Periodo</th>
                        <th>P.Compra</th>
                        <th>P.Venta</th>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                      </tfoot>
                    </table>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
            <!-- /.card -->
          </div>


          <!-- /.card -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
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
          <form name="formulariox" id="formulario" method="POST">   

            <div class="row">

                <div class="col-xl-6 col-md-12">
                  <div class="form-group">
                    <label>CÓDIGO DE DIVISIONARIA</label>
                    <input type="hidden" name="iddivisionaria" id="iddivisionaria">
                    <input class="form-control" type="number" name="codigodivisionaria" id="codigodivisionaria" placeholder="Ejemplo 7011" required >
                  </div>               
                </div>

                <div class="col-xl-6 col-md-12">      
                  <div class="form-group">
                    <label>DESCRIPCIÓN DIVISIONARIA</label>
                    <input class="form-control" type="text" name="descripcion" id="descripcion" placeholder="Ingrese descripción de la divisionaria" required >
                  </div>  
                </div>

                <div class="col-xl-6  col-md-12">
                  <div class="form-group">
                    <label>SUBCUENTA</label>
                    <select class="form-control" style="width: 100%;" id="idsubcuenta" name="idsubcuenta" >
                      
                    </select>
                  </div>
                </div>

              </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
              <button type="button" onclick="guardar_precio" class="btn btn-info"><i class="fas fa-save"></i> Guardar</button>
            </div>

          </form> 
      </div>
    </div>
  </div>

<!--- FIN MODAL  -->

<?php } else {require 'noacceso.php';}

    require 'footer.php';
    ?>
  <script type="text/javascript" src="scripts/precios.js"></script>
<?php
}
ob_end_flush();
?>


