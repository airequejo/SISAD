<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location: login');
} else {

    require 'header.php';
    if ($_SESSION['caja'] == 1) { ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
            <a type="button" class="breadcrumb-item btn  btn-info btn-xs" onclick="valida_tipo_modal();" >
                  <b><i class="fas fa-user-plus"></i> Nueva caja</b></a>
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
          <h3 class="card-title">Listado de cajas</h3>

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

             
        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>#</th>
                            <th>Turno</th>
                            <th>fecha_Ape</th>
                            <th>Monto_Inicial</th>
                            <th>Ingresos efectivo</th>
                            <th>Ingreso depósito CTA</th>
                            <th>Compromiso pago</th>
                            <th>Total_Efectivo</th>
                            <th>Fecha_Cierre</th>
                            <th>Estado</th>
                            <th>Upciones</th>
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
  <div class="modal fade" id="modal_caja" data-backdrop="static"  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content ">
        <div class="modal-header bg-info"> 
          <h5 class="modal-title" id="titulo_modal">Aperturar Nueva Caja</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form name="form_caja" id="form_caja" method="POST">  

            <div class="row">    

                <div class="col-lg-12">      
                  <div class="form-group">
                  <h3 class="text-red"><strong>USUARIO : <?php echo $_SESSION[
                      'nombre'
                  ]; ?></strong></h3>
                  </div>  
                </div>

              

                <div id="divreferencia"  class="col-lg-6">
                  <div class="form-group">
                  <label for="dd">Turno:</label>
                  <select name="turno" id="turno" class="form-control" required style="width:100%;">
                    <option value="1">MAÑANA</option>
                    <option value="2">TARDE</option>
                    <option value="3">NOCHE</option>
                  </select>
                  </div>
                </div>

              <div id="divdireccion" class="col-lg-6">
                <div class="form-group">
                  <label for="yy">Monto Inicial:</label>
                  <input type="decimal" id="monto_inicial" name="monto_inicial" class="form-control" value="0.00" required>
                </div>
              </div>

              </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
              <button type="button"  onclick="inserta_caja();" id="btnGuardar" id="btnGuardar" class="btn btn-info"><i class="fas fa-save"></i> Guardar</button>
            </div>

          </form> 
      </div>
    </div>
  </div>

  <!--- FIN MODAL  -->

  
<!---  INICIO MODAL   ---> 
<!-- Modal secondary -->
<div class="modal fade" id="mostrar_modal_caja" data-backdrop="static"  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-header bg-info"> 
          <h5 class="modal-title" id="titulo_modal">Reporte caja</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form name="form_caja_mostrar" id="form_caja_mostrar" method="POST">  

            <div class="row">    

                <div class="col-lg-4">      
                  <div class="form-group">
                  <label for="dd">Usuario:</label>
                  <input type="hidden" name="idcaja" id="idcaja" readonly >

                  <h4><strong class="text-green"><?php echo $_SESSION[
                      'login'
                  ]; ?></strong></h4>

                  </div>  
                </div>

              

                <div id="divreferencia"  class="col-lg-4">
                  <div class="form-group">
                  <label for="dd">Turno:</label>

                  <h4><strong class="text-green" id="turno_c"></strong></h4>
                  </div>
                </div>

              <div id="divdireccion" class="col-lg-4">
                <div class="form-group">
                <label for="dd">Fecha Apertura:</label>
                  <h4><strong class="text-green" id="fecha_a"></strong></h4>
                </div>
              </div>

              <!-- <div id="divdireccion" class="col-lg-4">
                <div class="form-group">
                <label for="yy">Monto Inicial:</label>  
                  <h4><strong class="text-red" id="monto_i"></strong></h4>
                </div>
              </div>

              <div id="divdireccion" class="col-lg-4">
                <div class="form-group">
                <label for="yy">Ingreso en efectivo:</label> 
                  <h4><strong class="text-blue" id="efectivo"></strong></h4>  
                </div>
              </div> -->

              <div id="divdireccion" class="col-lg-4">
                <div class="form-group">
                <label for="yy">Ingreso deposito en CTA:</label>  
                  <h4><strong class="text-blue" id="tarjeta"></strong></h4> 
                </div>
              </div>

              <div id="divdireccion" class="col-lg-4">
                <div class="form-group">
                <label for="yy">Compromiso de pago :</label>  
                <h4><strong class="text-blue" id="credito"></strong></h4> 
                </div>
              </div>


              <!--  <div id="divdireccion" class="col-lg-4">
                <div class="form-group">
                <label for="yy">Gastos:</label> 
                  <h4><strong class="text-blue" id="gastos"></strong></h4> 
                </div>
              </div>


              <div id="divdireccion" class="col-lg-4">
                <div class="form-group">
                <label for="yy">TOTAL EFECTIVO:</label> 
                  <h4><strong class="text-red" id="total_efectivo"></strong></h4> 
                </div>
              </div>-->

              </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
              <button type="button" onclick="cerrar_caja();" id="btn_cerrar_caja" id="btn_cerrar_caja" class="btn btn-info"><i class="fas fa-save"></i> Cerrar caja</button>
            </div>

          </form> 
      </div>
    </div>
  </div>

  <!--- FIN MODAL  -->

<?php } else {require 'noacceso.php';}

    require 'footer.php';
    ?>
  <script type="text/javascript" src="scripts/caja.js"></script>
<?php
}
ob_end_flush();
?>



